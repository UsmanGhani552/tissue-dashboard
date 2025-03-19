<?php

namespace App\Http\Controllers;

use App\Exports\RecompilationExport;
use App\Models\Sheet1;
use App\Models\Sheet2;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\NotIn;
use Maatwebsite\Excel\Facades\Excel;

class RecompilationController extends Controller
{
    
    // Method for reusing logic to fetch and process data
    private function getRecompiledData()
    {
        // Fetch the newest record from both tables
        $sheetDataA = Sheet1::latest()->first();
        $sheetDataB = Sheet2::latest()->first();

        // Decode JSON data
        $recordsA = $sheetDataA ? json_decode($sheetDataA->data, true) : [];
        $recordsB = $sheetDataB ? json_decode($sheetDataB->data, true) : [];

        // Extract submitter_ids and barcode_ids
        $submitterIds = array_column($recordsA, 'submitter_id');
        $barcodeIds = array_column($recordsB, 'barcode');

        // Group submitter IDs by family
        $submitterFamilies = [];
        foreach ($submitterIds as $submitterId) {
            $family = explode('.', $submitterId)[0];
            if (!isset($submitterFamilies[$family])) {
                $submitterFamilies[$family] = [];
            }
            $submitterFamilies[$family][] = $submitterId;
        }

        // Group barcode IDs by family
        $barcodeFamilies = [];
        foreach ($barcodeIds as $barcodeId) {
            $family = explode('.', $barcodeId)[0];
            if (!isset($barcodeFamilies[$family])) {
                $barcodeFamilies[$family] = [];
            }
            $barcodeFamilies[$family][] = $barcodeId;
        }

        // Initialize the result array
        $results = [];
        $receivingMatched = [];
        foreach ($barcodeFamilies as $familyKey => $family) {
            if (isset($submitterFamilies[$familyKey])) {
                $array_of_merge_families = array_unique(array_merge($submitterFamilies[$familyKey], $family));

                $rackId = null;
                $casefileId = null;
                foreach ($array_of_merge_families as $value) {
                    foreach ($recordsB as $recordB) {
                        if ($recordB['barcode'] == $value) {
                            $casefileId = $recordB['casefile_id'];
                            if ($recordB['rack_id'] !== null) {
                                $rackId = $recordB['rack_id'];
                                break;
                            }
                        }
                    }
                    if ($rackId != null) break;
                }

                if ($rackId != null) {
                    foreach ($array_of_merge_families as $value) {
                        $results[] = ['submitter_id' => $value, 'rack_id' => $rackId , 'casefile_id' => $casefileId];
                    }
                } else {
                    foreach ($array_of_merge_families as $value) {
                        $results[] = ['submitter_id' => $value, 'rack_id' => "No Rack Id Found" , 'casefile_id' => $casefileId];
                    }
                }

                $receivingMatched[] = $familyKey;
            }
        }

        foreach ($submitterFamilies as $familyKey => $value) {
            if (!in_array($familyKey, $receivingMatched)) {
                foreach ($value as $id) {
                    $results[] = ['submitter_id' => $id, 'rack_id' => "Not in archive", 'casefile_id' => 'Not in archive'];
                }
            }
        }

        return $results;
    }

    // View method for displaying data
    public function recompile()
    {
        $results = $this->getRecompiledData();

        return view('recompilation.index', [
            'results' => $results,
        ]);
    }

    // Export method
    public function exportToExcel()
    {
        $results = $this->getRecompiledData();

        return Excel::download(new RecompilationExport($results), 'recompiled_data.xlsx');
    }

}
