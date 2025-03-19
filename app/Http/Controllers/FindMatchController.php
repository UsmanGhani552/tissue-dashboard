<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use App\Models\Receiving;

use Illuminate\Http\Request;

class FindMatchController extends Controller
{
    public function compareSubmitters()
    {
        try {
            // Fetch all records from both tables
            $sheetDataA = Receiving::latest()->first();
            $sheetDataB = Manifest::latest()->first();

            $recordsA = $sheetDataA ? json_decode($sheetDataA->data, true) : [];
            $recordsB = $sheetDataB ? json_decode($sheetDataB->data, true) : [];

            // Extract submitter_ids
            // $submitterIdsA = $recordsA->pluck('submitter_id')->toArray();
            // $submitterIdsB = $recordsB->pluck('submitter_id')->toArray();

            $submitterIdsA = array_column($recordsA, 'submitter_id');
            $submitterIdsB = array_column($recordsB, 'submitter_id');
            // dd($submitterIdsB);

            // Find matches
            $matchedIds = array_intersect($submitterIdsA, $submitterIdsB);
            // dd($matchedIds);

            // Find extra records
            $extraInA = array_diff($submitterIdsA, $submitterIdsB);
            $extraInB = array_diff($submitterIdsB, $submitterIdsA);
            // dd($extraInB);

            // Calculate percentage of matched ids
            $totalIds = count($submitterIdsA) + count($submitterIdsB);
            $matchedPercentage = ($totalIds > 0) ? (count($matchedIds) * 2 / $totalIds) * 100 : 0;

            // Fetch extra records
            // $extraRecordsA = Receiving::whereIn('submitter_id', $extraInA)->get();
            // $extraRecordsB = Manifest::whereIn('submitter_id', $extraInB)->get();
            $extraRecordsA = array_filter($recordsA, function ($record) use ($extraInA) {
                return in_array($record['submitter_id'], $extraInA);
            });

            $extraRecordsB = array_filter($recordsB, function ($record) use ($extraInB) {
                return in_array($record['submitter_id'], $extraInB);
            });

            // Pass data to view
            return view('find-match.index', [
                'matchedPercentage' => $matchedPercentage,
                'matchedIds' => $matchedIds,
                'extraRecordsA' => $extraRecordsA,
                'extraRecordsB' => $extraRecordsB,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
