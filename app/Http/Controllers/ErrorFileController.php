<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDriveFileJob;
use App\Models\ErrorFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class ErrorFileController extends Controller
{
    public function errorFiles()
    {
        $error_files = ErrorFile::all();
        return view('error-files.index', [
            'error_files' => $error_files,
        ]);
    }

    public function retry() {
        if(Queue::size() > 0){
            return redirect()->back()->withSuccess('Queue is currently processing exisiting files.');
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
        return redirect()->back()->withSuccess('Retry started. Check logs for progress.');
    }
}
