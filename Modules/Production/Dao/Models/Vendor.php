<?php

namespace Modules\Production\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
  protected $table = 'production_vendor';
  protected $primaryKey = 'production_vendor_id';
  public $detail_table = 'production_vendor_product';
  public $parent_key = 'production_vendor_product_vendor_id';
  public $foreign_key = 'production_vendor_product_product_id';

  protected $fillable = [
    'production_vendor_id',
    'production_vendor_name',
    'production_vendor_description',
    'production_vendor_created_at',
    'production_vendor_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'production_vendor_name' => 'required|min:3',
    'production_vendor_description' => 'required|min:3',
  ];

  const CREATED_AT = 'production_vendor_created_at';
  const UPDATED_AT = 'production_vendor_created_by';

  public $order = 'production_vendor_created_at';
  public $searching = 'production_vendor_name';
  public $datatable = [
    'production_vendor_id'          => [false => 'ID'],
    'production_vendor_name'        => [true => 'Name'],
    'production_vendor_description' => [true => 'Description'],
    'production_vendor_created_at'  => [false => 'Created At'],
    'production_vendor_created_by'  => [false => 'Updated At'],
  ];

  public $custom_message = [
    'temp_id.required' => 'Product must be input',
    'temp_price.required' => 'Product Price must be Inputed',
    'temp_min.required' => 'Product Min must be Inputed',
    'temp_max.required' => 'Product Max must be Inputed',
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
