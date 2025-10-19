<?php

namespace App\Exports;

use App\Models\VendorCustomer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    public function headings(): array
    {
        return [
            'ID', 'Vendor', 'Customer'
        ];
    }

    public function map($project): array
    {

        return [
            $project->id,
            $project->customer->name,
            $project->vendor->name
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return VendorCustomer::with(['customer', 'vendor']);
    }

}
