<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
  protected $table = 'procurement_unit';
  protected $primaryKey = 'procurement_unit_id';
  public $detail_table = 'procurement_unit_unit';
  public $parent_key = 'procurement_unit_unit_unit_id';
  public $foreign_key = 'procurement_unit_unit_unit_id';

  protected $fillable = [
    'procurement_unit_id',
    'procurement_unit_code',
    'procurement_unit_name',
    'procurement_unit_operator',
    'procurement_unit_value',
    'procurement_unit_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'procurement_unit_name' => 'required|min:3',
  ];

  const CREATED_AT = 'procurement_unit_created_at';
  const UPDATED_AT = 'procurement_unit_created_by';

  public $order = 'procurement_unit_created_at';
  public $searching = 'procurement_unit_name';
  public $datatable = [
    'procurement_unit_id'          => [false => 'ID'],
    'procurement_unit_code'        => [true => 'Code'],
    'procurement_unit_name'        => [true => 'Name'],
    'procurement_unit_operator'        => [true => 'Operator'],
    'procurement_unit_value'        => [true => 'Value'],
    'procurement_unit_description'        => [true => 'Description'],
  ];
  
  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
