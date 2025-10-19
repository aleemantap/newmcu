<?php

namespace App\Exports;

use App\Models\Icd10;
use Maatwebsite\Excel\Concerns\FromCollection;

class IcdExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Icd10::all();
    }
}
