<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Product;

class PurchaseDetail extends Model
{
  protected $table = 'procurement_purchase_detail';
  protected $primaryKey = 'purchase_detail_purchase_id';
  public $foreignKey = 'purchase_detail_item_product_id';

  protected $fillable = [
    'purchase_detail_purchase_id',
    'purchase_detail_item_product_id',
    'purchase_detail_qty_order',
    'purchase_detail_price_order',
    'purchase_detail_total_order',
    'purchase_detail_option',
    'purchase_detail_color_id',
    'purchase_detail_size',
    'purchase_detail_qty_prepare',
    'purchase_detail_price_prepare',
    'purchase_detail_total_prepare',
    'purchase_detail_qty_receive',
    'purchase_detail_location_id',
    'purchase_detail_barcode',
  ];

  protected $with = ['product', 'color'];

  public $timestamps = false;
  public $incrementing = false;
  public $keyType = 'string';

  public $rules = [
    // 'purchase_procurement_vendor_id' => 'required',
  ];

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'purchase_detail_item_product_id');
  }

  public function color()
  {
    return $this->hasOne(Color::class, 'item_color_id', 'purchase_detail_color_id');
  }


  // const CREATED_AT = 'purchase_created_at';
  // const UPDATED_AT = 'purchase_updated_at';
  // const DELETED_AT = 'purchase_deleted_at';

  // public $order = 'purchase_created_at';
  // public $searching = 'procurement_vendor_name';

}
