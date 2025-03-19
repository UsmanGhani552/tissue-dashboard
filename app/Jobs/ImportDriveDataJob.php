<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\DriveTokenService;
use App\Models\PersonalisBsm2;
use App\Models\PersonalisBsm2Sheet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ImportDriveDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $folderId;

    /**
     * Create a new job instance.
     */
    public function __construct($folderId)
    {
        $this->folderId = $folderId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            // Get last modified time from database
            $lastModifiedFile = PersonalisBsm2Sheet::orderBy('created_at', 'desc')->first();
            $lastModifiedTime = $lastModifiedFile ? $lastModifiedFile->created_at->toIso8601String() : null;
            $drive_data = DriveTokenService::getDriveData($this->folderId,$lastModifiedTime); 
            $file_ids = PersonalisBsm2Sheet::pluck('sheet_id')->toArray();
            foreach ($drive_data as $records) {
                $fileId = $records['id'];
                $fileName = $records['name'];
                if(in_array($fileId,$file_ids)){
                    continue;
                }

                $newRecords = collect();
                foreach ($records['content'][0] as $key => $record) {
                    if ($key === 0 || (is_null($record[0]) && is_null($record[1]) && is_null($record[2]) && is_null($record[3]))) {
                        continue;
                    }

                    $newRecords->push([
                        'submitter_id' => $record[0],
                        'tracking_id' => $record[10],
                        'ship_date' => convertToDate2($record[11]) ?? '',
                    ]);
                }

                if ($newRecords->isNotEmpty()) {
                    $bsm_sheet = PersonalisBsm2Sheet::create(['sheet_id' => $fileId , 'name' => $fileName]);

                    $newRecords = $newRecords->map(function ($record) use ($bsm_sheet) {
                        $record['bsm2_id'] = $bsm_sheet->id;
                        return $record;
                    });

                    PersonalisBsm2::insert($newRecords->toArray());
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Drive Import Failed: " . $e->getMessage());
        }
    }
}
