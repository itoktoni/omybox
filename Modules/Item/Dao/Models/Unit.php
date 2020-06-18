<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
  protected $table = 'item_unit';
  protected $primaryKey = 'item_unit_id';
  protected $fillable = [
    'item_unit_id',
    'item_unit_name',
    'item_unit_description',
    'item_unit_created_at',
    'item_unit_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_unit_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_unit_created_at';
  const UPDATED_AT = 'item_unit_created_by';

  public $searching = 'item_unit_name';
  public $datatable = [
    'item_unit_id'          => [false => 'ID'],
    'item_unit_name'        => [true => 'Name'],
    'item_unit_description' => [true => 'Description'],
    'item_unit_created_at'  => [false => 'Created At'],
    'item_unit_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
