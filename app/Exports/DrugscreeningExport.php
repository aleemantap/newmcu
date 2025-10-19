<?php

namespace App\Exports;

use App\Models\DrugScreeningDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class DrugScreeningExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
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
            'ID', 'Id Pasien', 'Tgl. Pemeriksaan', 'Status Pemeriksaan', 'Parameter', 'Hasil', 'Tgl. Input', 'Id Perusahaan'
        ];
    }

    public function map($drugScreening): array 
    {
        
        return [
            $drugScreening->id,
            (int) substr($drugScreening->mcu_id, 12, 8),
            $drugScreening->tgl_pemeriksaan,
            $drugScreening->status_pemeriksaan,
            $drugScreening->parameter,
            $drugScreening->hasil,
            substr($drugScreening->mcu_id, 0, 4).'-'.substr($drugScreening->mcu_id, 4, 2).'-'.substr($drugScreening->mcu_id, 6, 2),
            (int) substr($drugScreening->mcu_id, 8, 4),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query() 
    {
        $ds = DrugScreeningDetail::where('mcu_id', '!=' , null);
        
        // Filter Id Perusahaan
        if(!empty($this->idPerusahaan)) {
            $idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
            $ds->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }
        
        // Filter Date
        if(!empty($this->startDate)) {
            $startDate = date('Ymd', strtotime($this->startDate));
            $ds->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        
        if(!empty($this->endDate)) {
            $endDate = date('Ymd', strtotime($this->endDate));
            $ds->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }
        
        return $ds;
    }

}
