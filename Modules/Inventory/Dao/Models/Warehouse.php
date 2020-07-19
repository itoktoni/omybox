<?php

namespace Modules\Inventory\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
  protected $table = 'inventory_warehouse';
  protected $primaryKey = 'inventory_warehouse_id';
  protected $fillable = [
    'inventory_warehouse_id',
    'inventory_warehouse_name',
    'inventory_warehouse_description',
    'inventory_warehouse_created_at',
    'inventory_warehouse_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'inventory_warehouse_name' => 'required|min:3',
  ];

  const CREATED_AT = 'inventory_warehouse_created_at';
  const UPDATED_AT = 'inventory_warehouse_created_by';

  public $searching = 'inventory_warehouse_name';
  public $datatable = [
    'inventory_warehouse_id'          => [false => 'ID'],
    'inventory_warehouse_name'        => [true => 'Name'],
    'inventory_warehouse_description' => [true => 'Description'],
    'inventory_warehouse_created_at'  => [false => 'Created At'],
    'inventory_warehouse_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
