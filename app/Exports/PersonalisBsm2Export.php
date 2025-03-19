<?php

namespace App\Exports;

use App\Models\PersonalisBsm2;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PersonalisBsm2Export implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PersonalisBsm2::select('submitter_id','tracking_id','ship_date')->get();
    }

    public function headings(): array
    {
        return [
            'Submitter ID',
            'Tracking',
            'Ship Date',
        ];
    }

    public function map($row): array
    {
        return [
            $row->submitter_id,  // Note that you should use object properties when accessing the data
            $row->tracking_id,
            $row->ship_date,
        ];
    }
}
