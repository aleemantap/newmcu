<?php

namespace App\Exports;

use App\Models\Mcu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class McuExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $idPerusahaan;

    public function __construct($startDate = '', $endDate = '', $idPerusahaan = '')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->idPerusahaan = $idPerusahaan;
    }

    public function headings(): array
    {
        return [
            'ID', 'Id Pasien', 'Jenis Foto', 'Parameter', 'Temuan', 'Tgl. Input', 'Id Perusahaan'
        ];
    }

    public function map($rontgen): array
    {

        return [
            $rontgen->id,
            (int) substr($rontgen->mcu_id, 12, 8),
            $rontgen->jenis_foto,
            $rontgen->parameter,
            $rontgen->temuan,
            substr($rontgen->mcu_id, 0, 4).'-'.substr($rontgen->mcu_id, 4, 2).'-'.substr($rontgen->mcu_id, 6, 2),
            (int) substr($rontgen->mcu_id, 8, 4),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $r = Mcu::where('mcu_id', '!=' , null);

        // Filter Id Perusahaan
        if(!empty($this->idPerusahaan)) {
            $idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
            $r->whereRaw('substring(id, 9, 4) = '.$idPerusahaan);
        }

        // Filter Date
        if(!empty($this->startDate)) {
            $startDate = date('Ymd', strtotime($this->startDate));
            $r->whereRaw('substring(id, 1, 8) >= '.$startDate);
        }

        if(!empty($this->endDate)) {
            $endDate = date('Ymd', strtotime($this->endDate));
            $r->whereRaw('substring(id, 1, 8) <= '.$endDate);
        }

        return $r;
    }

}
