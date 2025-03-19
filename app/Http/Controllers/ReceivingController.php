<?php

namespace App\Http\Controllers;

use App\Imports\SheetImport;
use App\Models\Receiving;
use App\Services\DriveTokenService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class ReceivingController extends Controller
{
    public function index()
    {
        $receivings = Receiving::all();
        return view('receiving.index', compact('receivings'));
    }

    public function import(Request $request)
    {
        try {
            // $folderId = \Config('services.google.tracking_1');
            $folderId = '1I4E4KYXBEYkHvEwop5DbeP_ohM9dBnEq';
            $drive_data = DriveTokenService::getDriveData($folderId);
            $this->readFile($drive_data);

            return redirect()->back()->withSuccess('Data Uploaded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
            // return redirect()->back()->withError('Error Uploading Sheet (May be due to wrong sheet format)');

        }
    }

    public function readFile($drive_data_file)
    {
        foreach ($drive_data_file as $records) {
            // dd($records);

            $fileName = $records['name'];
            $dataToStore = [];
            foreach ($records['content'] as $sheetkey => $record) {
                $dataToStore[] = $this->pageData($sheetkey, $records);
            }
            

            dd($dataToStore);
            if (!empty($dataToStore)) {
                // dd($dataToStore);
                Receiving::create([
                    'name' => $fileName,
                    'data' => json_encode($dataToStore),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                
            }
        }
    }

    public function pageData($sheetkey, $records)
    {
        // finding header
        $keys = [];
        $rowIndex = 0;
        foreach ($records['content'][$sheetkey] as $keyRowIndex => $record) {
            foreach ($record as $key => $recordValue) {
                // dd($recordValue);
                if (strcasecmp($recordValue, string2: 'SUBMITTER ID') === 0) {
                    $keys[0] = $key;
                } elseif (strcasecmp($recordValue, 'RECIEVED') === 0 || strcasecmp($recordValue, 'RECEIVED') === 0) {
                    $keys[1] = $key;
                } elseif (strcasecmp($recordValue, 'TRACKING') === 0) {
                    $keys[2] = $key;
                } elseif (strcasecmp($recordValue, 'SHIP DATE') === 0) {
                    $keys[3] = $key;
                }
            }
            if (count($keys) > 0) {
                $rowIndex = $keyRowIndex;
                break;
            }
        }
        // dd($keys);
        // dd($keys);
        if (!isset($keys[0], $keys[1], $keys[2], $keys[3])) {
            $keynotfound = '';
            if(!isset($keys[0]))
                $keynotfound .= 'SUBMITTER ID, ';
            if(!isset($keys[1]))
                $keynotfound .= 'RECIEVED, ';
            if(!isset($keys[2]))
                $keynotfound .= 'TRACKING, ';
            if(!isset($keys[3]))
                $keynotfound .= 'SHIP DATE, ';
            return 'Error Uploading Sheet (May be due to wrong sheet format). keynotfound: '.$keynotfound;
        }

        // finding values
        $dataToStore = [];
        foreach ($records['content'][$sheetkey] as $key => $record) {
            // Skip the first row if it contains headers
            if ($key <= $rowIndex) {
                continue;
            }
            if (is_null($record[$keys[0]]) && is_null($record[$keys[1]])) {
                continue; // Skip this record
            }
            $dataToStore[] = [
                'submitter_id' => $record[$keys[0]],
                'received_by' => $record[$keys[1]],
                'tracking' => $record[$keys[2]],
                'received_date' => $this->convertToDate($record[$keys[3]])->toDateString(),
            ];
        }
        return $dataToStore;
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
    public function show(Receiving $receiving)
    {
        $receivingData = json_decode($receiving->data);
        return view('receiving.show', compact('receivingData'));
    }

    public function delete(Receiving $receiving)
    {
        $receiving->delete();
        return redirect()->back()->withSuccess('Receiving Deleted Successfully');
    }
}
