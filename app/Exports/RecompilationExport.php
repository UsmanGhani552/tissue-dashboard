<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class RecompilationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $results;

    public function __construct(array $results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return collect($this->results);
    }

    public function headings(): array
    {
        return [
            'Submitter ID',
            'Rack ID',
            'Casefile ID',
        ];
    }

    public function map($row): array
    {
        return [
            $row['submitter_id'],
            $row['rack_id'],
            $row['casefile_id'],
        ];
    }
}
