<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'forwarder_product';
  protected $primaryKey = 'forwarder_product_id';
  protected $fillable = [

    'forwarder_product_id',
    'forwarder_product_code',
    'forwarder_product_name',
    'forwarder_product_price',
    'forwarder_product_tax',
    'forwarder_product_category_id',
    'forwarder_product_currency_id',
    'forwarder_product_description',
    'forwarder_product_updated_at',
    'forwarder_product_created_at',
    'forwarder_product_updated_by',
    'forwarder_product_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'forwarder_product_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_product_created_at';
  const UPDATED_AT = 'forwarder_product_updated_at';

  public $datatable = [
    'forwarder_product_id'          => [false => 'ID'],
    'forwarder_product_code'        => [true => 'Code'],
    'forwarder_category_name'        => [true => 'Category'],
    'forwarder_product_name'        => [true => 'Name'],
    'forwarder_product_price'        => [true => 'Price'],
    'forwarder_tax_name'        => [true => 'Tax'],
    'agent_currency_code'        => [true => 'Rate'],
    'forwarder_product_description' => [false => 'Description'],
    'forwarder_product_created_at'  => [false => 'Created At'],
    'forwarder_product_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
