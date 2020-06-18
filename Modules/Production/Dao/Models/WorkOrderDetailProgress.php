<?php

namespace Modules\Production\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;

class WorkOrderDetailProgress extends Model
{
  protected $table = 'production_work_order_detail_progress';
  protected $primaryKey = 'production_work_order_detail_progress_id';
  public $parentKey = 'production_work_order_detail_progress_work_order_id';
  public $foreignKey = 'production_work_order_detail_progress_item_product_id';
  protected $fillable = [
    'production_work_order_detail_progress_id',
    'production_work_order_detail_progress_work_order_id',
    'production_work_order_detail_progress_item_product_id',
    'production_work_order_detail_progress_notes',
    'production_work_order_detail_progress_date',
    'production_work_order_detail_progress_status',
    'production_work_order_detail_progress_updated_at',
    'production_work_order_detail_progress_created_at',
    'production_work_order_detail_progress_updated_by',
    'production_work_order_detail_progress_created_by',
  ];

  public $rules = [
    'production_work_order_detail_progress_date' => 'required',
    'production_work_order_detail_progress_notes' => 'required',
  ];

  public $status = [
    '1' => ['PROGRESS', 'success'],
    '0' => ['DELAY', 'warning'],
    '2' => ['FINISH', 'primary'],
  ];

  public $timestamps = true;
  public $incrementing = false;

  const CREATED_AT = 'production_work_order_detail_progress_created_at';
  const UPDATED_AT = 'production_work_order_detail_progress_updated_at';

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'production_work_order_detail_item_product_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::creating(function ($model) {
      $model->production_work_order_detail_progress_created_by = auth()->user()->username;
    });
  }
}
