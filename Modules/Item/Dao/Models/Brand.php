<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  protected $table = 'item_brand';
  protected $primaryKey = 'item_brand_id';
  protected $fillable = [
    'item_brand_id',
    'item_brand_name',
    'item_brand_slug',
    'item_brand_image',
    'item_brand_email',
    'item_brand_description',
    'item_brand_created_at',
    'item_brand_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_brand_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_brand_created_at';
  const UPDATED_AT = 'item_brand_created_by';
  public $searching = 'item_brand_name';
  public $datatable = [
    'item_brand_id'             => [false => 'ID'],
    'item_brand_name'           => [true => 'Name'],
    'item_brand_description'    => [true => 'Description'],
    'item_brand_slug'           => [false => 'Slug'],
    'item_brand_email'           => [true => 'Email'],
    'item_brand_created_at'     => [false => 'Created At'],
    'item_brand_created_by'     => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      if ($model->item_brand_name && empty($model->item_brand_slug)) {
        $model->item_brand_slug = Str::slug($model->item_brand_name);
      }

      if (Cache::has('item_brand_api')) {
        Cache::forget('item_brand_api');
      }
    });
  }
}
