<?php

namespace App\Http\Controllers;

use App\Exports\PersonalisBsm2Export;
use App\Imports\SheetImport;
use App\Jobs\ImportDriveDataJob;
use App\Models\Folder;
use App\Models\PersonalisBsm2;
use App\Models\PersonalisBsm2Sheet;
use App\Services\DriveTokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PersonalisBsm2Controller extends Controller
{
    public function index()
    {
        $personalis_bsm_2_sheets = PersonalisBsm2Sheet::all();
        return view('personalis_bsm2.index',[
            'personalis_bsm_2_sheets' => $personalis_bsm_2_sheets,
        ]);
    }

    public function import(Request $request)
    {
        $folder = Folder::select('id','name')->where('name','tracking')->with('driveFolders')->first();
        $folderIds = $folder->driveFolders->pluck('drive_folder_id')->toArray();
        foreach ($folderIds as $folderId) {
            ImportDriveDataJob::dispatch($folderId)->onQueue('drive_import');
        }
        return redirect()->back()->withSuccess('Drive import started. Check logs for progress.');
       
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
