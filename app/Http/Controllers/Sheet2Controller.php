<?php

namespace App\Http\Controllers;

use App\Imports\SheetImport;
use App\Models\Sheet2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Sheet2Controller extends Controller
{

    public function index(){
        $sheet2s = Sheet2::all();
        return view('sheet-2.index',compact('sheet2s'));
    }

    public function import(Request $request){
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv',
            ]);
    
            $file = $request->file('file');
            $fileName = explode('.',$file->getClientOriginalName());
            // dd($file);
            $records = Excel::toArray(new SheetImport, $file);
            // Get all existing submitter_ids from the Sheet1 table
            // $existingSubmitterIds = Sheet2::pluck('submitter_id')->toArray();
    
            // dd($records[0]);
            foreach ($records[0] as $key => $record) {
                // Skip the first row if it contains headers
                if ($key === 0) {
                    continue;
                }
                if (is_null($record[0])) {
                    continue; // Skip this record
                }
                // Skip records where submitter_id already exists in the database
                // if (in_array($record[0], $existingSubmitterIds)) {
                //     continue;
                // }
                $dataToStore[] = [
                    'casefile_id'=> $record[0],
                    'barcode'=> $record[1],
                    'notesontube'=> $record[2],
                    'ship_destination_type'=> $record[3],
                    'rack_id'=> $record[4],
                    'name'=> $record[5],
                    'closing_notes'=> $record[6],
                    'closed'=> $this->convertToDate($record[7])->toDateString(),
                ];
            }
            // dd($dataToStore);
            if(!empty($dataToStore)){
                Sheet2::create([
                    'name' => $fileName[0],
                    'data'=>json_encode($dataToStore),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            return redirect()->back()->withSuccess('Data Uploaded successfully');
        } catch (\Exception $e) {   
            return redirect()->back()->withError('Error Uploading Sheet (May be due to wrong sheet format)');
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

    public function show(Sheet2 $sheet2){
        // dd('ada');
        $sheet2Data = json_decode($sheet2->data);
        return view('sheet-2.show', compact('sheet2Data'));
    }

    public function delete(Sheet2 $sheet2){
        $sheet2->delete();
        return redirect()->back()->withSuccess('Archive Deleted Successfully');
    }
}
