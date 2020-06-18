<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
  protected $table = 'item_material';
  protected $primaryKey = 'item_material_id';
  protected $fillable = [
    'item_material_id',
    'item_material_name',
    'item_material_description',
    'item_material_created_at',
    'item_material_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_material_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_material_created_at';
  const UPDATED_AT = 'item_material_created_by';

  public $searching = 'item_material_name';
  public $datatable = [
    'item_material_id'          => [false => 'ID'],
    'item_material_name'        => [true => 'Name'],
    'item_material_description' => [true => 'Description'],
    'item_material_created_at'  => [false => 'Created At'],
    'item_material_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
