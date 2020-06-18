<?php

namespace Modules\Sales\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  protected $table = 'rajaongkir_cities';
  protected $primaryKey = 'rajaongkir_city_id';
  protected $fillable = [
    'rajaongkir_city_id',
    'rajaongkir_city_province_id',
    'rajaongkir_city_province_name',
    'rajaongkir_city_type',
    'rajaongkir_city_name',
    'rajaongkir_city_postal_code',
  ];

  public $timestamps = false;
  public $incrementing = true;

}
