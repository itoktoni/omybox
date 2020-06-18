<?php

namespace Modules\Production\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Models\Color;

class WorkOrderDetail extends Model
{
  protected $table = 'procurement_purchase_detail';
  protected $primaryKey = 'purchase_detail_purchase_id';
  protected $with = ['product', 'color'];
  protected $fillable = [
    'purchase_detail_purchase_id',
    'purchase_detail_item_product_id',
    'purchase_detail_qty_order',
    'purchase_detail_price_order',
    'purchase_detail_total_order',
    'purchase_detail_option',
    'purchase_detail_color_id',
    'purchase_detail_size',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'purchase_detail_item_product_id');
  }

  public function color()
  {
    return $this->hasOne(Color::class, 'item_color_id', 'purchase_detail_color_id');
  }
}
