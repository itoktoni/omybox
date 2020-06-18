<?php

namespace Modules\Agent\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
  protected $table = 'agent_packaging';
  protected $primaryKey = 'agent_packaging_id';
  protected $fillable = [

    'agent_packaging_id',
    'agent_packaging_unit_from',
    'agent_packaging_unit_to',
    'agent_packaging_product_id',
    'agent_packaging_qty_from',
    'agent_packaging_qty_to',
    'agent_packaging_name',
    'agent_packaging_description',
    'agent_packaging_created_at',
    'agent_packaging_created_by',

  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'agent_packaging_name' => 'required|min:3',
  ];

  const CREATED_AT = 'agent_packaging_created_at';
  const UPDATED_AT = 'agent_packaging_created_by';

  public $searching = 'agent_packaging_name';
  private static $unit;

  public $datatable = [
    'agent_packaging_id'          => [false => 'ID'],
    'agent_packaging_qty_to'        => [true => 'Qty Package'],
    'agent_packaging_name'        => [true => 'Name'],
    'agent_packaging_qty_from'        => [true => 'To Qty Unit'],
    'item_unit_name'        => [true => 'Unit'],
    'agent_packaging_description' => [false => 'Description'],
    'agent_packaging_created_at'  => [false => 'Created At'],
    'agent_packaging_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
