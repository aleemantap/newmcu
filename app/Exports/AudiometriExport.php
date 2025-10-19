<?php

namespace App\Exports;

use App\Models\AudiometriDetail;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class AudiometriExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
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
            'ID', 'Id Pasien', 'Frekuensi', 'Kiri', 'Kanan', 'Tgl. Input', 'Id Perusahaan'
        ];
    }

    public function map($audiometri): array 
    {
        
        return [
            $audiometri->id,
            (int) substr($audiometri->mcu_id, 12, 8),
            $audiometri->frekuensi,
            $audiometri->kiri,
            $audiometri->kanan,
            substr($audiometri->mcu_id, 0, 4).'-'.substr($audiometri->mcu_id, 4, 2).'-'.substr($audiometri->mcu_id, 6, 2),
            (int) substr($audiometri->mcu_id, 8, 4),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query() 
    {
        $a = AudiometriDetail::where('mcu_id', '!=' , null);
        
        // Filter Id Perusahaan
        if(!empty($this->idPerusahaan)) {
            $idPerusahaan = str_pad($this->idPerusahaan, 4, 0, 0);
            $a->whereRaw('substring(mcu_id, 9, 4) = '.$idPerusahaan);
        }
        
        // Filter Date
        if(!empty($this->startDate)) {
            $startDate = date('Ymd', strtotime($this->startDate));
            $a->whereRaw('substring(mcu_id, 1, 8) >= '.$startDate);
        }
        
        if(!empty($this->endDate)) {
            $endDate = date('Ymd', strtotime($this->endDate));
            $a->whereRaw('substring(mcu_id, 1, 8) <= '.$endDate);
        }
        
        return $a;
    }

}
