<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serologi extends Model
{
    protected $table = 'serologi';

    public $timestamps = false;

    protected $fillable = [
        'hbsag','anti_hbs', 'tuberculosis','igm_salmonella','igg_salmonella','salmonela_typhi_o', 'salmonela_typhi_h','salmonela_parathypi_a_o','salmonela_parathypi_a_h','salmonela_parathypi_b_o','salmonela_parathypi_b_h','salmonela_parathypi_c_o','salmonela_parathypi_c_h','hcg','psa','afp','cea','igm_toxo','igg_toxo','ckmb_serologi','myoglobin','troponin_i','mcu_id','process_id'
    ];
}
