<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Procurement\Dao\Models\Unit;

class Product extends Model
{
  protected $table = 'procurement_product';
  protected $primaryKey = 'procurement_product_id';
  public $detail_table = 'procurement_product_product';
  public $parent_key = 'procurement_product_product_product_id';
  public $foreign_key = 'procurement_product_product_product_id';

  protected $fillable = [
    'procurement_product_id',
    'procurement_product_name',
    'procurement_product_buy',
    'procurement_product_sell',
    'procurement_product_description',
    'procurement_product_unit_id',
    'procurement_product_unit_display',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'procurement_product_name' => 'required|min:3',
  ];

  const CREATED_AT = 'procurement_product_created_at';
  const UPDATED_AT = 'procurement_product_created_by';

  public $order = 'procurement_product_created_at';
  public $searching = 'procurement_product_name';
  public $datatable = [
    'procurement_product_id'          => [false => 'ID'],
    'procurement_product_name'        => [true => 'Name'],
    'procurement_product_buy'        => [true => 'Buy'],
    'procurement_product_sell'        => [true => 'Sell'],
    'procurement_product_description'        => [true => 'Description'],
    'procurement_unit_name'        => [true => 'Unit'],
  ];
  
  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public function Unit()
  {
    return $this->hasOne(Unit::class, 'procurement_unit_id', 'procurement_product_unit_id');
  }

  public function Display()
  {
    return $this->hasOne(Unit::class, 'procurement_unit_id', 'procurement_product_unit_display');
  }
}
