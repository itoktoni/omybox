<?php

namespace Modules\Procurement\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Finance\Dao\Models\Payment;
use Modules\Procurement\Dao\Models\PurchaseDetail;

class Purchase extends Model
{
  use SoftDeletes;
  protected $table = 'procurement_purchase';
  protected $detail_table = 'procurement_purchase_detail';
  protected $primaryKey = 'purchase_id';
  protected $keyType = 'string';

  protected $fillable = [
    'purchase_id',
    'purchase_reff',
    'purchase_delivery',
    'purchase_invoice',
    'purchase_date',
    'purchase_prepare_date',
    'purchase_delivery_date',
    'purchase_total',
    'purchase_total_prepare',
    'purchase_total_receive',
    'purchase_invoice_date',
    'purchase_attachment',
    'purchase_notes',
    'purchase_notes_vendor',
    'purchase_status',
    'purchase_paid',
    'purchase_updated_at',
    'purchase_created_at',
    'purchase_updated_by',
    'purchase_created_by',
    'purchase_deleted_at',
    'purchase_procurement_vendor_id',
  ];

  public $timestamps = true;
  public $incrementing = false;
  protected $with = ['detail'];
  public $prefix = 'PO';

  public $rules = [
    'purchase_procurement_vendor_id' => 'required',
  ];

  const CREATED_AT = 'purchase_created_at';
  const UPDATED_AT = 'purchase_updated_at';
  const DELETED_AT = 'purchase_deleted_at';

  public $order = 'purchase_created_at';
  public $searching = 'purchase_id';
  public $datatable = [
    'purchase_id'          => [true => 'ID'],
    'purchase_date'        => [true => 'Date'],
    'procurement_vendor_name'        => [true => 'Vendor'],
    'procurement_vendor_email'        => [false => 'Email'],
    'purchase_notes'        => [true => 'Notes'],
    'purchase_total'        => [true => 'Total'],
    'purchase_date'        => [true => 'Date'],
    'purchase_date'        => [true => 'Date'],
    'purchase_status'      => [true => 'Status'],
    'purchase_paid'      => [true => 'Paid'],
  ];
  public $action  = [
    'update' => ['primary', 'edit'],
    'prepare'   => ['primary', 'prepare'],
    'show'   => ['success', 'show'],
    'print_receive'   => ['danger', 'print'],
    'receive'   => ['primary', 'receive'],
  ];
  
  public $status = [
    '1' => ['Create', 'warning'],
    '2' => ['Prepare', 'primary'],
    '3' => ['Deliver', 'success'],
    '4' => ['Receive', 'danger'],
    '5' => ['Done', 'secondary'],
  ];

  public $paid = [
    '1' => ['Yes', 'success'],
    '0' => ['No', 'danger'],
  ];

  protected $dates = [
    'purchase_date',
    'purchase_prepare_date',
    'purchase_delivery_date',
    'purchase_updated_at',
    'purchase_created_at',
    'purchase_deleted_at',
    'purchase_sent_date',
  ];

  public function vendor()
  {
    return $this->hasOne(Vendor::class, 'procurement_vendor_id', 'purchase_procurement_vendor_id');
  }

  public function detail()
  {
    return $this->hasMany(PurchaseDetail::class, 'purchase_detail_purchase_id', 'purchase_id');
  }

  public function payment()
  {
    return $this->hasMany(Payment::class, 'finance_payment_reference', 'purchase_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      if ($model->purchase_status == 1) {
        $model->purchase_total = request()->get('total');
      }
      if ($model->purchase_status == 3 || $model->puchase_status == 4) {
        $model->purchase_total_prepare = request()->get('total');
      }
    });
  }
}
