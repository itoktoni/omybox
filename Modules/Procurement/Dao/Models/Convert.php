<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Convert extends Model
{
  protected $table = 'procurement_convert';
  protected $primaryKey = 'procurement_convert_id';

  protected $fillable = [
    'procurement_convert_id',
    'procurement_convert_from',
    'procurement_convert_to',
    'procurement_convert_value',
    'procurement_convert_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'procurement_convert_from' => 'required',
    'procurement_convert_to' => 'required',
    'procurement_convert_value' => 'required',
  ];

  const CREATED_AT = 'procurement_convert_created_at';
  const UPDATED_AT = 'procurement_convert_created_by';

  public $searching = 'convert_name';
  public $datatable = [
    'procurement_convert_id'          => [false => 'ID'],
    'unit_from'        => [true => 'Unit From'],
    'unit_to'        => [true => 'Unit To'],
    'procurement_convert_value'        => [true => 'Value'],
    'procurement_convert_description'        => [true => 'Description'],
  ];
  
  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
