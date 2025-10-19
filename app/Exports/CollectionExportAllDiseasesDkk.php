<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CollectionExportAllDiseasesDkk implements FromCollection, WithHeadings
{
    use Exportable;
	
	
	
	private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
	
	
    public function collection()
    {
        $kp = $this->data;
		$a1 = array();
		$k = 0;
		
		foreach($kp as $data){
			
			$a1[]= [
					'CODE'=> $data->code,
					'Diagnosis'=> $data->name,
					'Prevalensi'=> $data->total,
					'Laki'=> $data->TL,
					'Perempuan'=> $data->TP,
					'bawah_tigapuluh'=> $data->bawah_tigapuluh,
					'tigapuluh_sd_empatpuluh'=> $data->tigapuluh_sd_empatpuluh,
					'atas_empatpuluh'=> $data->atas_empatpuluh
					
					];
			
		} 
		return collect($a1);
    }

    public function headings(): array
    {
        return [
            'CODE',
            'Diagnosis',
            'Prevalensi',
            'Laki',
            'Perempuan',
            '< 30',
            '30 - 40',
            '> 40'
            
           
        ];
    }
	
	

}

?>