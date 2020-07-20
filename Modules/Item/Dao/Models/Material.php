<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Procurement\Dao\Models\Product;

class Material extends Model
{
  protected $table = 'item_material';
  protected $primaryKey = 'item_material_id';
  protected $with = ['product'];
  protected $fillable = [
    'item_material_id',
    'item_material_value',
    'item_material_item_product_id',
    'item_material_procurement_product_id',
    'item_material_description',
    'item_material_created_at',
    'item_material_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_material_value' => 'required',
    'item_material_procurement_product_id' => 'required',
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


  public function product()
  {
    return $this->hasOne(Product::class, 'procurement_product_id', 'item_material_procurement_product_id');
  }
}
