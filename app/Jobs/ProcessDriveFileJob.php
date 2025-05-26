<?php

namespace App\Jobs;

use App\Models\ErrorFile;
use App\Models\PersonalisBsm2;
use App\Models\PersonalisBsm2Sheet;
use App\Models\TrackingErrorFile;
use App\Services\DriveTokenService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessDriveFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $folder_id;

    /**
     * Create a new job instance.
     */
    public function __construct($file, $folder_id)
    {
        $this->file = $file;
        $this->folder_id = $folder_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $fileData = DriveTokenService::processFile($this->file);
            DB::beginTransaction();

            $fileName = $fileData['name'];
            $fileId = $fileData['id'];
            $mimeType = $this->file['mimeType'];
            $dataToStore = [];
            $isFailed = false;
            Log::info("Processing file: {$fileName} with ID: {$fileId} and MIME type: {$mimeType}");
            foreach ($fileData['content'] as $sheetkey => $record) {
                $data = $this->pageData($sheetkey, $record);
                if (is_string($data)) {
                    $isFailed = true;
                    $dataToStore = [];
                    $dataToStore[] = $data;
                    break;
                }
                $dataToStore[] = $data;
            }

            if (!empty($dataToStore) && !$isFailed) {
                $bsm_sheet = PersonalisBsm2Sheet::create([
                    'sheet_id' => $fileId,
                    'name' => $fileName
                ]);

                $newRecords = array_map(function ($record) use ($bsm_sheet) {
                    $record['bsm2_id'] = $bsm_sheet->id;
                    return $record;
                }, $dataToStore[0]);

                PersonalisBsm2::insert($newRecords);

                $existingFile = ErrorFile::where('file_id', $fileId)->first();
                if ($existingFile) { 
                    $existingFile->delete();
                }
            } else {
                Log::info($mimeType);
                ErrorFile::updateOrCreate(
                    [
                        'file_id' => $fileId,
                    ],
                    [
                    'folder_id' => $this->folder_id,
                    'file_name' => $fileName,
                    'mime_type' => $mimeType,
                    'page_message' => json_encode($dataToStore),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File Processing Failed: " . $e->getMessage());
        }
    }

    public function pageData($sheetkey, $records)
    {
        try {
            // finding header
            $keys = [];
            $rowIndex = -1;
            foreach ($records as $keyRowIndex => $record) {
                foreach ($record as $key => $recordValue) {
                    $value = Str::upper($recordValue);
                    if (Str::contains($value, ['SUBMITTER ID', 'NTRA_SAMPLE_ID'])) {
                        $keys[0] = $key;
                    } elseif (Str::contains($value, ['RECIEVED', 'RECEIVED', 'Recieved'])) {
                        $keys[1] = $key;
                    } elseif (Str::contains($value, ['TRACKING'])) {
                        $keys[2] = $key;
                    } elseif (Str::contains($value, ['SHIP DATE'])) {
                        $keys[3] = $key;
                    }
                }
                if (count($keys) > 3) {
                    $rowIndex = $keyRowIndex;
                    break;
                }
            }
            if (!isset($keys[0], $keys[1], $keys[2], $keys[3])) {
                $keynotfound = '';
                if (!isset($keys[0]))
                    $keynotfound .= 'SUBMITTER ID, ';
                if (!isset($keys[1]))
                    $keynotfound .= 'RECIEVED, ';
                if (!isset($keys[2]))
                    $keynotfound .= 'TRACKING, ';
                if (!isset($keys[3]))
                    $keynotfound .= 'SHIP DATE, ';
                // dd($keynotfound);
                return 'Error Uploading Sheet (May be due to wrong sheet format). keynotfound: ' . $keynotfound;
            }

            // finding values
            $dataToStore = [];

            foreach ($records as $key => $record) {
                // Skip the first row if it contains headers
                if ($key <= $rowIndex) {
                    continue;
                }

                if (empty($record) || is_null(value: $record[$keys[0]])) {
                    continue; // Skip this record
                }

                $dataToStore[] = [
                    'submitter_id' => $record[$keys[0]],
                    'tracking_id' => $record[$keys[2]] ?? '',
                    'ship_date' => isset($record[$keys[3]]) && $record[$keys[3]] ? $this->convertToDate($record[$keys[3]])->toDateString() : null,
                ];
            }
            return $dataToStore;
        } catch (\Throwable $th) {
            return 'Error Uploading Sheet (May be due to wrong sheet format): error: ' . $th->getMessage();
        }
    }

    public function convertToDate($dateValue)
    {
        if (is_numeric($dateValue)) {
            // Excel date system starts on January 1, 1900
            $baseDate = Carbon::createFromDate(1900, 1, 1);

            // Excel incorrectly treats 1900 as a leap year, so we subtract 1 day for dates after Feb 28, 1900
            if ($dateValue > 59) {
                $dateValue -= 1;
            }

            // Add the serial days to the base date
            return $baseDate->addDays($dateValue - 1); // Subtract 1 because the base date is already day 1
        } else {
            // If it's already in date format, use it directly
            return Carbon::parse($dateValue);
        }
    }
}
