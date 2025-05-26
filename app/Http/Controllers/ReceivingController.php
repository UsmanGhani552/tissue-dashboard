<?php

namespace App\Http\Controllers;

use App\Imports\SheetImport;
use App\Models\Receiving;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls',
            ]);
    
            $file = $request->file('file');
            $fileName = explode('.',$file->getClientOriginalName());
            $records = Excel::toArray(new SheetImport, $file);
    
            // Get all existing submitter_ids from the receiving table
            // $existingSubmitterIds = Receiving::pluck('submitter_id')->toArray();
    
            // dd($records[0]);
            foreach ($records[0] as $key => $record) {
                // Skip the first row if it contains headers
                if ($key === 0) {
                    continue;
                }
                if (is_null($record[0]) && is_null($record[1]) && is_null($record[2]) && is_null($record[3])) {
                    continue; // Skip this record
                }
                // // Skip records where submitter_id already exists in the database
                // if (in_array($record[0], $existingSubmitterIds)) {
                //     continue;
                // }
                // $receiving = new Receiving();
                // $receiving->submitter_id = $record[0];
                // $receiving->received_by = $record[1];
                // $receiving->tracking = $record[2];
                // $receiving->date = $this->convertToDate($record[3])->toDateString();
                // $receiving->created_at = Carbon::now();
                // $receiving->updated_at = Carbon::now();
                // $receiving->save();
                $dataToStore[] = [
                    'submitter_id' => $record[0],
                    'received_by' => $record[1],
                    'tracking' => $record[2],
                    'received_date' => $this->convertToDate($record[3])->toDateString(),
                ];
            }
            if (!empty($dataToStore)) {
                // dd($dataToStore);
                Receiving::create([
                    'name' => $fileName[0],
                    'data' => json_encode($dataToStore),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return redirect()->back()->withSuccess('Data Uploaded successfully');
            
            }
        } catch (\Exception $e) {
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
    public function show(Receiving $receiving){
        $receivingData = json_decode($receiving->data);
        return view('receiving.show', compact('receivingData'));
    }

    public function delete(Receiving $receiving){
        $receiving->delete();
        return redirect()->back()->withSuccess('Receiving Deleted Successfully');
    }
}
