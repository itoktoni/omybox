<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $table = 'item_image';
  protected $primaryKey = 'item_image_id';
  protected $fillable = [
    'item_image_id',
    'item_image_code',
    'item_image_name',
    'item_image_warehouse_id',
    'item_image_description',
    'item_image_created_at',
    'item_image_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_image_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_image_created_at';
  const UPDATED_AT = 'item_image_created_by';

  public $searching = 'item_image_name';
  private static $warehouse;
  public $datatable = [
    'item_image_id'          => [false => 'ID'],
    'item_image_name'        => [true => 'Name'],
    'item_warehouse_name'       => [true => 'Warehouse'],
    'item_image_description' => [true => 'Description'],
    'item_image_created_at'  => [false => 'Created At'],
    'item_image_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public function warehouse()
  {
    return $this->hasOne('Modules\Item\Models\Warehouse', 'item_warehouse_id', 'item_image_warehouse_id');
  }
}
