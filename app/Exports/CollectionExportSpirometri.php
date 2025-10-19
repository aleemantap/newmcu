<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CollectionExportSpirometri implements FromCollection, WithHeadings
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
			
			//if($data->rontgen->kesan_rontgen === 'Dalam batas normal') {
				//$r =  'Normal';
			//} else {
				//$r ='Abnormal';
			//}
			
			$a1[]= [
						'id'=> $data->id,
						'No Nip'=> $data->no_nip,
						'Nama Pasien'=> $data->nama_pasien,
						'Tgl Lahir'=> $data->tgl_lahir,
						'JK'=> $data->jenis_kelamin,
						'Bagian'=> $data->bagian,
						'Tgl MCU'=> $data->tgl_input, 
						'FEV'=> $data->spirometri->fev,
						'FVC'=> $data->spirometri->fvc,
						'PEF'=> $data->spirometri->pef, 
						'Kesimpulan Spirometri'=> $data->spirometri->kesimpulan_spirometri 
					];
			
		} 
		return collect($a1);
    }

    public function headings(): array
    {
        return [
            'ID',
            'NIP',
            'NAME',
            'TGL. LAHIR',
            'L/P',
            'BAGIAN',
            'TGL.MCU',
            'FEV',
            'FVC',
            'PEF',
            'Kesimpulan Spirometri',
           
        ];
    }
	
	

}

?>