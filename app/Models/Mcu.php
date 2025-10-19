<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Mcu extends Model
{
    protected $table = 'mcu';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    'id','no_nip', 'no_paper','tgl_input','nama_pasien','tgl_lahir', 'jenis_kelamin','bagian','paket_mcu','tgl_kerja','email','telepon','client','vendor_customer_id','kesan_rontgen','kesimpulan_drug_screening','catatan','saran','published','mcu_id_encript','process_id'
    ];

    public function antrovisus()
    {
        return $this->hasOne('App\Models\Antrovisus');
    }

    public function audiometri()
    {
        return $this->hasOne('App\Models\Audiometri');
    }

    public function audiometriDetail()
    {
        return $this->hasMany('App\Models\AudiometriDetail');
    }

    public function vendorCustomer()
    {
        return $this->belongsTo('App\Models\VendorCustomer', 'vendor_customer_id');
    }

    public function drugScreening()
    {
        return $this->hasOne('App\Models\DrugScreening');
    }

    public function drugScreeningDetail()
    {
        return $this->hasMany('App\Models\DrugScreeningDetail');
    }

    public function ekg()
    {
        return $this->hasOne('App\Models\Ekg');
    }

    public function feses()
    {
        return $this->hasOne('App\Models\Feses');
    }

    public function fisik()
    {
        return $this->hasOne('App\Models\Fisik');
    }

    public function hematologi()
    {
        return $this->hasOne('App\Models\Hematologi');
    }

    public function kimia()
    {
        return $this->hasOne('App\Models\Kimia');
    }

    public function oae()
    {
        return $this->hasOne('App\Models\Oae');
    }

    public function papSmear()
    {
        return $this->hasOne('App\Models\PapSmear');
    }

    public function rectalSwab()
    {
        return $this->hasOne('App\Models\RectalSwab');
    }

    public function riwayat()
    {
        return $this->hasOne('App\Models\Riwayat');
    }

    public function rontgen()
    {
        return $this->hasOne('App\Models\Rontgen');
    }

    public function rontgenDetail()
    {
        return $this->hasMany('App\Models\RontgenDetail');
    }

    public function serologi()
    {
        return $this->hasOne('App\Models\Serologi');
    }

    public function spirometri()
    {
        return $this->hasOne('App\Models\Spirometri');
    }

    public function treadmill()
    {
        return $this->hasOne('App\Models\Treadmill');
    }

    public function umum()
    {
        return $this->hasOne('App\Models\Umum');
    }

    public function urin()
    {
        return $this->hasOne('App\Models\Urin');
    }

    public function diagnosis()
    {
        return $this->hasMany('App\Models\Diagnosis');
    }

    public function diagnosisOrderByWorkHealth()
    {
        return $this->hasMany('App\Models\Diagnosis')->orderBy('recommendation.workHealth.sequence');
    }
	
	public function reportsendwa()
    {
        return $this->hasOne('App\Models\Reportsendwa');
    }
}
