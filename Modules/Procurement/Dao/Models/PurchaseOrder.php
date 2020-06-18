<?php

namespace Modules\Procurement\Dao\Models;

use Modules\Sales\Dao\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Modules\Procurement\Dao\Models\Vendor;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Procurement\Dao\Models\PurchaseOrderDetail;

class PurchaseOrder extends Model
{
  use SoftDeletes;
  protected $table = 'procurement_work_order';
  protected $primaryKey = 'procurement_work_order_id';
  public $detail_table = 'procurement_work_order_detail';
  public $parent_key = 'procurement_work_order_detail_procurement_work_order_id';
  public $foreign_key = 'procurement_work_order_detail_item_product_id';
  public $reference_key = 'procurement_work_order_sales_order_id';

  protected $fillable = [
    'procurement_work_order_id',
    'procurement_work_order_sales_order_id',
    'procurement_work_order_delivery',
    'procurement_work_order_invoice',
    'procurement_work_order_date',
    'procurement_work_order_prepare_date',
    'procurement_work_order_delivery_date',
    'procurement_work_order_invoice_date',
    'procurement_work_order_attachment',
    'procurement_work_order_note',
    'procurement_work_order_procurement_vendor_id',
    'procurement_work_order_status',
    'procurement_work_order_updated_at',
    'procurement_work_order_created_at',
    'procurement_work_order_updated_by',
    'procurement_work_order_created_by',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $rules = [
    'procurement_work_order_date' => 'required',
    'procurement_work_order_procurement_vendor_id' => 'required',
  ];

  // public $with = ['detail', 'detail.product'];
  public $order = 'procurement_work_order_date';
  public $prefix = 'WO';

  const CREATED_AT = 'procurement_work_order_created_at';
  const UPDATED_AT = 'procurement_work_order_updated_at';
  const DELETED_AT = 'procurement_work_order_deleted_at';

  public $searching = 'procurement_work_order_id';
  public $datatable = [
    'procurement_work_order_id'             => [true => 'ID'],
    'procurement_work_order_date'           => [true => 'Order Date'],
    'procurement_work_order_sales_order_id'           => [true => 'Sales Order'],
    'procurement_vendor_name'           => [true => 'Vendor Name'],
    'procurement_work_order_status'           => [true => 'Status'],
    'procurement_work_order_created_at'     => [false => 'Created At'],
    'procurement_work_order_created_by'     => [false => 'Updated At'],
  ];

  protected $dates = [
    'procurement_work_order_created_at',
    'procurement_work_order_updated_at',
    'procurement_work_order_date',
    'procurement_work_order_prepare_date',
    'procurement_work_order_delivery_date',
    'procurement_work_order_invoice_date',
  ];

  public $status = [
    '0' => ['CANCEL', 'danger'],
    '1' => ['CREATE', 'warning'],
    '2' => ['PREPARE', 'success'],
    '3' => ['PRODUCTION', 'info'],
    '4' => ['DELIVER', 'primary'],
  ];

  public $customMessages = [
    'procurement_work_order_procurement_vendor_id.required' => 'Vendor Data Require',
  ];

  public function detail()
  {
    return $this->hasMany(PurchaseOrderDetail::class, 'procurement_work_order_detail_procurement_work_order_id', 'procurement_work_order_id');
  }

  public function vendor()
  {
    return $this->hasOne(Vendor::class, 'procurement_vendor_id', 'procurement_work_order_procurement_vendor_id');
  }
  public function sales_order()
  {
    return $this->hasOne(Order::class, 'sales_order_id', 'procurement_work_order_sales_order_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::creating(function ($model) {
      $model->procurement_work_order_created_by = auth()->user()->username;
      $model->procurement_work_order_status = 2;
    });
  }
}
