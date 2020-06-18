<?php

namespace Modules\Sales\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  protected $table = 'rajaongkir_areas';
  protected $primaryKey = 'rajaongkir_area_id';
  protected $fillable = [
    'rajaongkir_area_id',
    'rajaongkir_area_province_id',
    'rajaongkir_area_province_name',
    'rajaongkir_area_city_id',
    'rajaongkir_area_city_name',
    'rajaongkir_area_type',
    'rajaongkir_area_name',
  ];

  public $timestamps = false;
  public $incrementing = true;
}
