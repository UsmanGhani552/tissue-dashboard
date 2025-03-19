<?php

namespace App\Http\Controllers;

use App\Imports\SheetImport;
use App\Models\Manifest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManifestController extends Controller
{
    public function index(){
        $manifests = Manifest::all();
        return view('manifest.index',compact('manifests'));
    }

    public function import(Request $request){
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv',
            ]);
            
            $file = $request->file('file');
            $fileName = explode('.',$file->getClientOriginalName());
            // dd($fileName[0]);
            // dd($file);
            $records = Excel::toArray(new SheetImport, $file);
            // Get all existing submitter_ids from the Sheet1 table
            // $existingSubmitterIds = Manifest::pluck('submitter_id')->toArray();
            // dd($records[0]);
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
                // dd($record);
                // Assuming your $record is an associative array with column names as keys
                // $manifest = new Manifest();
                // $manifest->submitter_id = $record[0];
                // $manifest->vendor_id = $record[1];
                // $manifest->received = $record[2];
                // $manifest->checked_out = $record[3];
                // $manifest->letter = $record[4];
                // $manifest->commentor = $record[5];
                // $manifest->comment = $record[6];
                // $manifest->shipped_by = $record[7];
                // $manifest->tracking = $record[8];
                // $manifest->date = convertToDate($record[9])->toDateString();
                // $manifest->created_at = Carbon::now();
                // $manifest->updated_at = Carbon::now();
                // $manifest->save();
                $dataToStore[] = [
                    'submitter_id'=> $record[0],
                    'vendor_id'=> $record[1],
                    'received'=> $record[2],
                    'checked_out'=> $record[3],
                    'letter'=> $record[4],
                    'commentor'=> $record[5],
                    'comment'=> $record[6],
                    'shipped_by'=> $record[7],
                    'tracking'=> $record[8],
                    'date'=> $this->convertToDate($record[9])->toDateString(),
                ];
            }
            if(!empty($dataToStore)){
                Manifest::create([
                    'name' => $fileName[0],
                    'data'=>json_encode($dataToStore),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return redirect()->back()->withSuccess('Data Uploaded successfully');
            }
        }catch (\Exception $e){
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

    public function show(Manifest $manifest){
        $manifestData = json_decode($manifest->data);
        return view('manifest.show', compact('manifestData'));
    }

    public function delete(Manifest $manifest){
        $manifest->delete();
        return redirect()->back()->withSuccess('Manifest Deleted Successfully');
    }
}
