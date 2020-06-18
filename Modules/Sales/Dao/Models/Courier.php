<?php

namespace Modules\Sales\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
  protected $table = 'rajaongkir_courier';
  protected $primaryKey = 'rajaongkir_courier_code';
  protected $fillable = [
    'rajaongkir_courier_code',
    'rajaongkir_courier_name',
    'rajaongkir_courier_active',
  ];

  public $timestamps = false;
  public $incrementing = true;
  protected $keyType = 'string';
  public $rules = [
    'rajaongkir_courier_name' => 'required|min:3',
  ];

  public $searching = 'rajaongkir_courier_name';
  public $datatable = [
    'rajaongkir_courier_code'             => [true => 'ID'],
    'rajaongkir_courier_name'           => [true => 'Name'],
    'rajaongkir_courier_active'           => [true => 'Active'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
