<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
  protected $table = 'procurement_packaging';
  protected $primaryKey = 'procurement_packaging_id';
  protected $fillable = [

    'procurement_packaging_id',
    'procurement_packaging_unit_from',
    'procurement_packaging_unit_to',
    'procurement_packaging_product_id',
    'procurement_packaging_qty_from',
    'procurement_packaging_qty_to',
    'procurement_packaging_name',
    'procurement_packaging_description',
    'procurement_packaging_created_at',
    'procurement_packaging_created_by',

  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'procurement_packaging_name' => 'required|min:3',
  ];

  const CREATED_AT = 'procurement_packaging_created_at';
  const UPDATED_AT = 'procurement_packaging_created_by';

  public $searching = 'procurement_packaging_name';
  private static $unit;

  public $datatable = [
    'procurement_packaging_id'          => [false => 'ID'],
    'procurement_packaging_qty_to'        => [true => 'Qty Package'],
    'procurement_packaging_name'        => [true => 'Name'],
    'procurement_packaging_qty_from'        => [true => 'To Qty Unit'],
    'item_unit_name'        => [true => 'Unit'],
    'procurement_packaging_description' => [false => 'Description'],
    'procurement_packaging_created_at'  => [false => 'Created At'],
    'procurement_packaging_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
