<?php

namespace Modules\Production\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
  protected $table = 'production_packaging';
  protected $primaryKey = 'production_packaging_id';
  protected $fillable = [

    'production_packaging_id',
    'production_packaging_unit_from',
    'production_packaging_unit_to',
    'production_packaging_product_id',
    'production_packaging_qty_from',
    'production_packaging_qty_to',
    'production_packaging_name',
    'production_packaging_description',
    'production_packaging_created_at',
    'production_packaging_created_by',

  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'production_packaging_name' => 'required|min:3',
  ];

  const CREATED_AT = 'production_packaging_created_at';
  const UPDATED_AT = 'production_packaging_created_by';

  public $searching = 'production_packaging_name';
  private static $unit;

  public $datatable = [
    'production_packaging_id'          => [false => 'ID'],
    'production_packaging_qty_to'        => [true => 'Qty Package'],
    'production_packaging_name'        => [true => 'Name'],
    'production_packaging_qty_from'        => [true => 'To Qty Unit'],
    'item_unit_name'        => [true => 'Unit'],
    'production_packaging_description' => [false => 'Description'],
    'production_packaging_created_at'  => [false => 'Created At'],
    'production_packaging_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
