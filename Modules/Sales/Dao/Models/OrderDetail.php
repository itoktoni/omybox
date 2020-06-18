<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Dao\Models\OrderDelivery;

class OrderDetail extends Model
{
  protected $table = 'sales_order_detail';
  protected $primaryKey = 'sales_order_detail_sales_order_id';
  // protected $with = ['product'];
  protected $fillable = [
    'sales_order_detail_sales_order_id',
    'sales_order_detail_item_product_id',
    'sales_order_detail_qty_order',
    'sales_order_detail_price_order',
    'sales_order_detail_total_order',
    'sales_order_detail_qty_prepare',
    'sales_order_detail_option',
    'sales_order_detail_item_color',
    'sales_order_detail_item_size',
    'sales_order_detail_gram',
    'sales_order_detail_discount',
    'sales_order_detail_price_real',
    'sales_order_detail_tax_name',
    'sales_order_detail_tax_value',
    'sales_order_detail_notes'
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function detail()
  {
    return $this->belongsTo(Order::class, 'sales_order_detail_sales_id', 'sales_order_id');
  }

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'sales_order_detail_item_product_id');
  }

  public function color()
  {
    return $this->hasOne(Color::class, 'item_color_id', 'sales_order_detail_item_color');
  }

  public function delivery()
  {
    return $this->hasMany(OrderDelivery::class, 'item_product_id', 'sales_order_detail_item_product_id');
  }
}
