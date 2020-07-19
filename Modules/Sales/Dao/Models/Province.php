<?php

namespace Modules\Sales\Dao\Models;

use Modules\Sales\Dao\Models\City;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
  protected $table = 'rajaongkir_provinces';
  protected $primaryKey = 'rajaongkir_province_id';
  protected $fillable = [
    'rajaongkir_province_id',
    'rajaongkir_province_name',
  ];

  public $timestamps = false;
  public $incrementing = true;
}
