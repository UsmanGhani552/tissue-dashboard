<?php

namespace App\Http\Controllers;

use App\Exports\PersonalisBsm2Export;
use App\Helpers\QueueManager;
use App\Imports\SheetImport;
use App\Jobs\ImportDriveDataJob;
use App\Jobs\ProcessDriveFileJob;
use App\Models\ErrorFile;
use App\Models\Folder;
use App\Models\PersonalisBsm2;
use App\Models\PersonalisBsm2Sheet;
use App\Models\TrackingErrorFile;
use App\Services\DriveTokenService;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PersonalisBsm2Controller extends Controller
{
    public function deleteAll()
    {
        try {
            DB::beginTransaction();
            PersonalisBsm2::truncate();
            PersonalisBsm2Sheet::truncate();
            DB::commit();
            return redirect()->back()->withSuccess('Data Deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function index()
    {
        $personalis_bsm_2_sheets = PersonalisBsm2Sheet::all();
        return view('personalis_bsm2.index', [
            'personalis_bsm_2_sheets' => $personalis_bsm_2_sheets,
        ]);
    }

    public function import(Request $request)
    {
        try {
            if (Queue::size() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Queue is currently processing existing files.'
                ]);
            }
            // Reset processed jobs counter
            Cache::put('jobs_processed', 0);
            Cache::put('total_jobs', 0);
            Cache::put('imported_data', []);

            DB::beginTransaction();
            $folder = Folder::select('id', 'name')
                ->where('name', 'tracking')
                ->with('driveFolders')
                ->first();

            $time = now();
            $jobCount = 0;

            foreach ($folder->driveFolders as $drive_folder) {
                ImportDriveDataJob::dispatch($drive_folder->drive_folder_id, $time);
                $jobCount++;
            }
            DB::commit();
            QueueManager::startQueueWorker($request->_token);

            // Store total jobs count
            Cache::put('total_jobs', $jobCount);

            return response()->json([
                'success' => true,
                'message' => "{$jobCount} import jobs have been queued.",
                'queue_size' => $jobCount
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to queue import jobs: ' . $th->getMessage()
            ], 500);
        }
    }

    public function startQueue(Request $request)
    {
        try {
            QueueManager::startQueueWorker($request->_token);
            return response()->json(['queue_size' => QueueManager::queueSize(), 'message' => 'Queue count retrieved successfully']);
        } catch (\Throwable $th) {
            return response()->json('Couldn\'t recieve queue count due to: ' . $th->getMessage());
        }
    }

    public function queueStatus()
    {
        return response()->json([
            'size' => Queue::size(),
            'processed' => Cache::get('jobs_processed', 0),
            'total' => Cache::get('total_jobs', 0)
        ]);
    }

    public function processQueue()
    {
        try {
            // First retry any failed jobs
            Artisan::call('queue:retry', ['id' => 'all']);

            // Process multiple jobs at once
            $exitCode = Artisan::call('queue:work', [
                '--max-jobs' => 10, // Process up to 10 jobs per call
                '--stop-when-empty' => true,
                '--queue' => 'high,default',
                '--tries' => 3,
                '--timeout' => 120, // 2 minutes per job
            ]);

            return response()->json([
                'success' => $exitCode === 0,
                'processed' => Cache::increment('jobs_processed', 10) // Approximate count
            ]);
        } catch (\Throwable $th) {
            Log::error('Queue processing failed: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Queue processing failed: ' . $th->getMessage()
            ], 500);
        }
    }

    public function failedJobs()
    {
        $failed = DB::table('failed_jobs')->get();
        return response()->json(['failed_jobs' => $failed]);
    }

    public function retryFailedJobs()
    {
        Artisan::call('queue:retry', ['id' => 'all']);
        return response()->json(['message' => 'All failed jobs have been retried']);
    }
    public function export()
    {
        return Excel::download(new PersonalisBsm2Export(), 'productivity_data.xlsx');
    }

    public function show(Request $request)
    {
        // Fetch search inputs from request
        $name = $request->input('name');
        $date = $request->input('date');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        $personalisBsm2s = PersonalisBsm2::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($date, function ($query, $date) {
                return $query->where('ship_date', $date);
            })
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                return $query->whereBetween('ship_date', [$from_date, $to_date]);
            })
            ->get();

        // Total count of filtered items
        $totalCount = $personalisBsm2s->count();

        // Count of items with non-null tracking_id in the filtered set
        $shippedCount = $personalisBsm2s->whereNotNull('tracking_id')->count();

        // Calculate the percentage based on the filtered data
        $shippedPercentage = ($totalCount > 0) ? ($shippedCount / $totalCount) * 100 : 0;
        // dd($shippedPercentage);

        return view('personalis_bsm2.show', compact('personalisBsm2s', 'shippedPercentage'));
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            PersonalisBsm2::where('bsm2_id', $id)->delete();
            PersonalisBsm2Sheet::findOrFail($id)->delete();
            DB::commit();
            return redirect()->back()->withSuccess('Data Deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
