<?php

namespace App\Exports;

use App\Models\PersonalisBsm2;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PersonalisBsm2Export implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $name = $this->filters['name'] ?? null;
        $date = $this->filters['date'] ?? null;
        $from_date = $this->filters['from_date'] ?? null;
        $to_date = $this->filters['to_date'] ?? null;

        return PersonalisBsm2::query()
            ->select('submitter_id', 'tracking_id', 'ship_date')
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
