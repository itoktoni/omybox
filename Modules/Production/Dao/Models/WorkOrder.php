<?php

namespace Modules\Production\Dao\Models;

use Modules\Sales\Dao\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Modules\Production\Dao\Models\Vendor;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Production\Dao\Models\WorkOrderDetail;

class WorkOrder extends Model
{
  use SoftDeletes;
  protected $table = 'production_work_order';
  protected $primaryKey = 'production_work_order_id';
  public $detail_table = 'production_work_order_detail';
  public $parent_key = 'production_work_order_detail_production_work_order_id';
  public $foreign_key = 'production_work_order_detail_item_product_id';
  public $reference_key = 'production_work_order_sales_order_id';

  protected $fillable = [
    'production_work_order_id',
    'production_work_order_sales_order_id',
    'production_work_order_delivery',
    'production_work_order_invoice',
    'production_work_order_date',
    'production_work_order_prepare_date',
    'production_work_order_delivery_date',
    'production_work_order_invoice_date',
    'production_work_order_attachment',
    'production_work_order_note',
    'production_work_order_production_vendor_id',
    'production_work_order_status',
    'production_work_order_updated_at',
    'production_work_order_created_at',
    'production_work_order_updated_by',
    'production_work_order_created_by',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $rules = [
    'production_work_order_date' => 'required',
    'production_work_order_production_vendor_id' => 'required',
  ];

  // public $with = ['detail', 'detail.product'];
  public $order = 'production_work_order_date';
  public $prefix = 'WO';

  const CREATED_AT = 'production_work_order_created_at';
  const UPDATED_AT = 'production_work_order_updated_at';
  const DELETED_AT = 'production_work_order_deleted_at';

  public $searching = 'production_work_order_id';
  public $datatable = [
    'production_work_order_id'             => [true => 'ID'],
    'production_work_order_date'           => [true => 'Order Date'],
    'production_work_order_sales_order_id'           => [true => 'Sales Order'],
    'production_vendor_name'           => [true => 'Vendor Name'],
    'production_work_order_status'           => [true => 'Status'],
    'production_work_order_created_at'     => [false => 'Created At'],
    'production_work_order_created_by'     => [false => 'Updated At'],
  ];

  protected $dates = [
    'production_work_order_created_at',
    'production_work_order_updated_at',
    'production_work_order_date',
    'production_work_order_prepare_date',
    'production_work_order_delivery_date',
    'production_work_order_invoice_date',
  ];

  public $status = [
    '0' => ['CANCEL', 'danger'],
    '1' => ['CREATE', 'warning'],
    '2' => ['PREPARE', 'success'],
    '3' => ['PRODUCTION', 'info'],
    '4' => ['DELIVER', 'primary'],
  ];

  public $customMessages = [
    'production_work_order_production_vendor_id.required' => 'Vendor Data Require',
  ];

  public function detail()
  {
    return $this->hasMany(WorkOrderDetail::class, 'production_work_order_detail_production_work_order_id', 'production_work_order_id');
  }

  public function vendor()
  {
    return $this->hasOne(Vendor::class, 'production_vendor_id', 'production_work_order_production_vendor_id');
  }
  public function sales_order()
  {
    return $this->hasOne(Order::class, 'sales_order_id', 'production_work_order_sales_order_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::creating(function ($model) {
      $model->production_work_order_created_by = auth()->user()->username;
      $model->production_work_order_status = 2;
    });
  }
}
