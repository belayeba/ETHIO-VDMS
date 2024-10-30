<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilteredReportExport implements FromCollection, WithHeadings
{
    protected $dailkms;

    public function __construct($dailkms)
    {
        $this->dailkms = $dailkms;
    }

    public function collection()
    {
        return $this->dailkms;
    }

    public function headings(): array
    {
        return [
            'Vehicle', 'Driver', 'Date', 'Morning KM', 'Afternoon KM', 'Registered By',
        ];
    }
}
