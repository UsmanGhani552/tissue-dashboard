<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SheetImport;

use Illuminate\Http\Request;

class ExcelImportController extends Controller
{
    public function import(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $array = Excel::toArray(new SheetImport, $file);

        dd($array[0]);
    }
}
