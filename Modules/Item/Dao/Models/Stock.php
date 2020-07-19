<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Dao\Models\Location;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{

  use SoftDeletes;
  protected $table = 'item_stock';
  protected $primaryKey = 'item_stock_id';
  protected $fillable = [
    'item_stock_id',
    'item_stock_barcode',
    'item_stock_type',
    'item_stock_product',
    'item_stock_option',
    'item_stock_size',
    'item_stock_color',
    'item_stock_location',
    'item_stock_qty',
    'item_stock_batch',
    'item_stock_updated_at',
    'item_stock_created_at',
    'item_stock_deleted_at',
    'item_stock_updated_by',
    'item_stock_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_stock_product' => 'required',
  ];
  protected $keyType = 'int';

  public $with = ['color', 'location', 'location.warehouse', 'product'];

  const CREATED_AT = 'item_stock_updated_at';
  const UPDATED_AT = 'item_stock_updated_at';
  const DELETED_AT = 'item_stock_deleted_at';

  public $searching = 'item_product_name';
  public $order = 'qty';

  public $datatable = [
    'item_product_id'        => [true => 'ID'],
    'item_product_name'        => [true => 'Full Name'],
    'item_color_name' => [true => 'Color'],
    'size' => [true => 'Size'],
    'qty' => [true => 'Qty'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public function color()
  {
    return $this->hasOne(Color::class, 'item_color_id', 'item_stock_color');
  }

  public function location()
  {
    return $this->hasOne(Location::class, 'inventory_location_id', 'item_stock_location');
  }

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'item_stock_product');
  }

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      $model->item_stock_created_by = Auth::user()->username;
      $model->item_stock_updated_by = Auth::user()->username;

      $model->item_stock_option = $model->item_stock_product . $model->item_stock_size . $model->item_stock_color;
    });

    parent::creating(function ($model) {
      $model->item_stock_barcode = Helper::autoNumber($model->getTable(), 'item_stock_barcode', 'B'.date('Ymd'), config('website.autonumber'));
    });
  }
}
