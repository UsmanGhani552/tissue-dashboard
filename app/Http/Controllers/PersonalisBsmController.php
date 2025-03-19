<?php

namespace App\Http\Controllers;

use App\Imports\SheetImport;
use App\Models\PersonalisBsm;
use App\Models\PersonalisBsmResult;
use App\Models\PersonlisBsmSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PersonalisBsmController extends Controller
{
    public function index()
    {
        $personalis_bsm_sheets = PersonlisBsmSheet::all();
        // dd($personalis_bsm_sheets);
        return view('personalis_bsm.index', compact('personalis_bsm_sheets'));
    }
    // public function create(){
    //     return view('personalis_bsm.create');
    // }

    public function import(Request $request)
    {
        // PersonalisBsm::truncate();
        // PersonalisBsmResult::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // PersonlisBsmSheet::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // dd('ada');
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        try {
            DB::beginTransaction();
            $file = $request->file('file');
            $records = Excel::toArray(new SheetImport, $file);
            dd($records[0]);
            
            // Get all existing submitter_ids from the receiving table
            $existingSubmitterIds = PersonalisBsm::pluck('submitter_id')->toArray();
            $currentYear = Carbon::now()->year;
            $newRecords = collect();
            foreach ($records[0] as $key => $record) {
                // Skip the first row if it contains headers
                if ($key === 0) {
                    continue;
                }
                if (is_null($record[0]) && is_null($record[1]) && is_null($record[2]) && is_null($record[3])) {
                    continue;
                }
                // Skip records where submitter_id already exists in the database
                if (in_array($record[0], $existingSubmitterIds)) {
                    continue;
                }

                $newRecords->push([
                    'submitter_id' => $record[0],
                    'letter' => $record[5],
                    'commentor' => $record[6],
                    'shipped_by' => $record[9],
                    'ship_date' => convertToDate2($record[11]) ?? '',
                ]);
            }
            // dd($newRecords);

            if ($newRecords->isNotEmpty()) {
                $bsm_sheet = PersonlisBsmSheet::create([
                    'name' => $file->getClientOriginalName()
                ]);

                // Assign the bsm_id to each new record
                $newRecords = $newRecords->map(function ($record) use ($bsm_sheet) {
                    $record['bsm_id'] = $bsm_sheet->id;
                    return $record;
                });
            
                // Other logic like updating counts
                PersonalisBsm::insert($newRecords->toArray());
                $this->updateCount($newRecords, 'letter');
                $this->updateCount($newRecords, 'commentor');
                $this->updateCount($newRecords, 'shipped_by');
            } else {
                // Handle the case where no new records are added
                return redirect()->back()->withError('No new records to upload. All records were duplicates.');
            }

            DB::commit();
            return redirect()->back()->withSuccess('Data Uploaded successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->withError($e->getMessage());
            // return redirect()->back()->withError('Error Uploading Sheet (May be due to wrong sheet format)');

        }
    }

    private function updateCount($newRecords, $type)
    {
        $letterCounts = $newRecords->filter(function ($item) use ($type) {
            // Ensure ship_date and letter are defined
            return isset($item['ship_date']) && isset($item[$type]);
        })->groupBy(function ($item) use ($type) {
            // Group by a unique key combining ship_date and letter
            return $item['ship_date'] . '-' . $item[$type];
        })->map(function ($group) use ($type) {
            // Since $group is now a collection of items, we can safely extract the first item
            $firstItem = $group->first();
            // dd($firstItem);
            return [
                'ship_date' => $firstItem['ship_date'] ?? null,
                $type => $firstItem[$type] ?? null,
                $type . '_count' => $group->count(),
                'bsm_id' => $firstItem['bsm_id'],
            ];
        })->values()->toArray();
        // dd($letterCounts);

        $letterResults = [];
        foreach ($letterCounts as $letter) {
            $letterResults[] = [
                'name' => $letter[$type],
                'type' => $type,
                'count' => $letter[$type . '_count'],
                'ship_date' => $letter['ship_date'],
                'bsm_id' => $letter['bsm_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        // dd($letterCounts);
        // Insert all letter results at once
        PersonalisBsmResult::insert($letterResults);
    }

    public function show(Request $request)
    {
        // Fetch search inputs from request
        $name = $request->input('name');
        $date = $request->input('date');
        // $date = $date ? Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y') : '';
        $from_date = $request->input('from_date');
        // dd($from_date);
        $to_date = $request->input('to_date');
        // Convert from and to dates to start and end of the day for proper range filtering
        // $from_date = $from_date ? Carbon::createFromFormat('Y-m-d', $from_date)->format('d/m/Y') : null;
        // $to_date = $to_date ? Carbon::createFromFormat('Y-m-d', $to_date)->format('d/m/Y') : null;
        // dd($from_date);
        // Define the query filter function
        $applyFilters = function ($query) use ($name, $date, $from_date, $to_date) {
            return $query->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
                ->when($date, function ($query, $date) {
                    return $query->where('ship_date', $date);
                })
                ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                    return $query->whereBetween('ship_date', [$from_date, $to_date]);
                });
        };

        // Fetch records and counts by applying filters
        $letters = PersonalisBsmResult::where('type', 'letter')
            ->where($applyFilters)
            ->get();

        $commentors = PersonalisBsmResult::where('type', 'commentor')
            ->where($applyFilters)
            ->get();

        $shippedBys = PersonalisBsmResult::where('type', 'shipped_by')
            ->where($applyFilters)
            ->get();

        // Fetch counts
        $letterCount = PersonalisBsmResult::where('type', 'letter')
            ->where($applyFilters)
            ->sum('count');

        $commentorCount = PersonalisBsmResult::where('type', 'commentor')
            ->where($applyFilters)
            ->sum('count');

        $shippedByCount = PersonalisBsmResult::where('type', 'shipped_by')
            ->where($applyFilters)
            ->sum('count');

        // Return view with filtered data
        return view('personalis_bsm.show', compact('letters', 'commentors', 'shippedBys', 'letterCount', 'commentorCount', 'shippedByCount'));
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            PersonalisBsm::where('bsm_id',$id)->delete();
            PersonalisBsmResult::where('bsm_id',$id)->delete();
            PersonlisBsmSheet::findOrFail($id)->delete();
            DB::commit();
            return redirect()->back()->withSuccess('Data Deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }

    }
}
