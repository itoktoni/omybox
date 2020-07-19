<?php

namespace Modules\Procurement\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
  protected $table = 'procurement_work_order_detail';
  protected $primaryKey = 'procurement_work_order_detail_procurement_work_order_id';
  // protected $with = ['product'];
  protected $fillable = [
    'procurement_work_order_detail_procurement_work_order_id',
    'procurement_work_order_detail_item_product_id',
    'procurement_work_order_detail_qty_order',
    'procurement_work_order_detail_price_order',
    'procurement_work_order_detail_total_order',
    'procurement_work_order_detail_qty_prepare',
    'procurement_work_order_detail_price_prepare',
    'procurement_work_order_detail_total_prepare',
    'procurement_work_order_detail_qty_delivery',
    'procurement_work_order_detail_price_delivery',
    'procurement_work_order_detail_total_delivery',
    'procurement_work_order_detail_qty_invoice',
    'procurement_work_order_detail_price_invoice',
    'procurement_work_order_detail_total_invoice',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'procurement_work_order_detail_item_product_id');
  }
}
