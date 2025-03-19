<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;

class SheetImport implements ToArray
{
    /**
    * @param Array $array
    */
    public function array(array $array)
    {
        return $array;
    }
}
