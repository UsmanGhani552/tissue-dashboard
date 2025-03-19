<?php

namespace App\Http\Controllers;

use App\Models\Sheet1;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SheetImport;

class Sheet1Controller extends Controller
{
    public function index()
    {
        $sheet1s = Sheet1::all();
        return view('sheet-1.index', compact('sheet1s'));
    }

    public function import(Request $request)
    {
        dd('ads');
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls',
            ]);
    
            $file = $request->file('file');
            $fileName = explode('.',$file->getClientOriginalName());
            $records = Excel::toArray(new SheetImport, $file);
            dd($records);
            // Get all existing submitter_ids from the Sheet1 table
            // $existingSubmitterIds = Sheet1::pluck('submitter_id')->toArray();
    
            // dd($records[0]);
            foreach ($records[0] as $key => $record) {
                // Skip the first row if it contains headers
                if ($key === 0) {
                    continue;
                }
                if (is_null($record[0]) && is_null($record[1]) && is_null($record[2]) && is_null($record[3])) {
                    continue; // Skip this record
                }
                // Skip records where submitter_id already exists in the database
                // if (in_array($record[0], $existingSubmitterIds)) {
                //     continue;
                // }
                $dataToStore[] = [
                    'submitter_id' => $record[0],
                    'received_by' => $record[1],
                    'tracking' => $record[2],
                    'received_date' => $this->convertToDate($record[3])->toDateString(),
                ];
            }
            if (!empty($dataToStore)) {
                Sheet1::create([
                    'name' => $fileName[0],
                    'data' => json_encode($dataToStore),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            return redirect()->back()->withSuccess('Data Uploaded successfully');
        }catch (\Exception $e) {    
            return redirect()->back()->withError($e->getMessage());
            // return redirect()->back()->withError('Error Uploading Sheet (May be due to wrong sheet format)');

        }

        
    }

    public function convertToDate($dateValue) {
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


    public function show(Sheet1 $sheet1){
        $sheet1Data = json_decode($sheet1->data);
        return view('sheet-1.show', compact('sheet1Data'));
    }

    public function delete(Sheet1 $sheet1){
        $sheet1->delete();
        return redirect()->back()->withSuccess('Receiving Deleted Successfully');
    }
}
