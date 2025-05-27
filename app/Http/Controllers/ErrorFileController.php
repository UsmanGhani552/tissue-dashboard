<?php

namespace App\Http\Controllers;

use App\Helpers\QueueManager;
use App\Jobs\ProcessDriveFileJob;
use App\Models\ErrorFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class ErrorFileController extends Controller
{
    public function errorFiles()
    {
        $error_files = ErrorFile::all();
        return view('error-files.index', [
            'error_files' => $error_files,
            'count' => $error_files->count(),
        ]);
    }

    public function retry() {
        try {
            DB::beginTransaction(); 
            //code...
            if(Queue::size() > 0){
                $this->startQueue();
                return response()->json([
                    'success' => false,
                    'message' => 'Queue is currently processing existing files.'
                ]);
            }
            $deleteFiles = ErrorFile::all();
            foreach ($deleteFiles as $file) {
                $orignalfile = [
                    'id' => $file->file_id,
                    'name' => $file->file_name,
                    'mimeType' => $file->mime_type,
                    'createdTime' => now(),
                    'modifiedTime' => now(),
                ];
                ProcessDriveFileJob::dispatch($orignalfile, $file->folder_id);
            }
            DB::commit();
            QueueManager::startQueueWorker();
            return response()->json([
                'success' => true,
                'message' => 'Import jobs queued successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to queue import jobs: ' . $th->getMessage()
            ], 500);
        }
    }

    public function startQueue()
    {
        try {
            QueueManager::startQueueWorker();
            return response()->json(['queue_size' => QueueManager::queueSize(), 'message' => 'Queue count retrieved successfully']);
        } catch (\Throwable $th) {
            return response()->json('Couldn\'t recieve queue count due to: ' . $th->getMessage());
        }
    }
}
