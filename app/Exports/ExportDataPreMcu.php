<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExportDataPreMcu implements FromCollection, WithHeadings
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
					'Pasien ID'=> $data->id_pasien,
					'No NIP'=> $data->no_nip,
					'No Paper'=> $data->no_paper,
					'Nama Pasien'=> $data->nama_pasien,
                    'Tanggal Lahir'=> $data->tgl_lahir,
					'Jenis Kelamin'=> $data->jenis_kelamin,
                    'Bagian'=> $data->bagian,                   
                    'Client'=> $data->client,
                    'Paket MCU'=> $data->paket_mcu,
                    'Tanggal Kerja'=> $data->tgl_kerja,
					'Email'=> $data->email,
					'Telepon'=> $data->telepon,
                    'Project Id'=> $data->project_id
					];
			
		} 
		return collect($a1);
    }

    public function headings(): array
    {
        return [
            'Pasien ID',
            'No NIP',
            'No Paper',
            'Nama Pasien',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Bagian',
            'Client',
            'Paket MCU',
            'Tanggal Kerja',
            'Email',
            'Telepon',
            'Project Id'
           
        ];
    }
	
	

}

?>