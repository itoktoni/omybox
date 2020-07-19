<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Models\Color;

class OrderDelivery extends Model
{
  protected $table = 'sales_order_delivery';
  protected $primaryKey = 'so_delivery_id';
  // protected $with = ['product'];
  protected $fillable = [
    'so_delivery_id',
    'so_delivery_sales_order',
    'so_delivery_barcode',
    'so_delivery_qty',
    'so_delivery_option',
  ];

  public $timestamps = false;
  public $incrementing = true;

}
