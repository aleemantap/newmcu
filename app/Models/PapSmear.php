<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PapSmear extends Model
{
    protected $table = 'pap_smear';

    public $timestamps = false;

    protected $fillable = [
        'tgl_terima','tgl_selesai', 'bahan_pemeriksaan','makroskopik','mikroskopik','kesimpulan_pap_smear', 'mcu_id','process_id'
    ];
}
