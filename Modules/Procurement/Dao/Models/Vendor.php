<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
  protected $table = 'procurement_vendor';
  protected $primaryKey = 'procurement_vendor_id';
  public $detail_table = 'procurement_vendor_product';
  public $parent_key = 'procurement_vendor_product_vendor_id';
  public $foreign_key = 'procurement_vendor_product_product_id';

  protected $fillable = [
    'procurement_vendor_id',
    'procurement_vendor_name',
    'procurement_vendor_description',
    'procurement_vendor_created_at',
    'procurement_vendor_created_by',
    'procurement_vendor_email',
    'procurement_vendor_address',
    'procurement_vendor_phone',

  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'procurement_vendor_name' => 'required|min:3',
    'procurement_vendor_contact' => 'required|min:3',
    'procurement_vendor_phone' => 'required|min:3',
  ];

  const CREATED_AT = 'procurement_vendor_created_at';
  const UPDATED_AT = 'procurement_vendor_created_by';

  public $order = 'procurement_vendor_created_at';
  public $searching = 'procurement_vendor_name';
  public $datatable = [
    'procurement_vendor_id'          => [false => 'ID'],
    'procurement_vendor_name'        => [true => 'Name'],
    'procurement_vendor_email'        => [true => 'Email'],
    'procurement_vendor_phone'        => [true => 'Phone'],
    'procurement_vendor_address' => [true => 'Address'],
    'procurement_vendor_created_at'  => [false => 'Created At'],
    'procurement_vendor_created_by'  => [false => 'Updated At'],
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
