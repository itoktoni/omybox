<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
  protected $table = 'item_color';
  protected $primaryKey = 'item_color_id';
  protected $fillable = [
    'item_color_id',
    'item_color_code',
    'item_color_name',
    'item_color_slug',
    'item_color_created_at',
    'item_color_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_color_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_color_created_at';
  const UPDATED_AT = 'item_color_created_by';

  public $searching = 'item_color_name';
  public $datatable = [
    'item_color_code'        => [true => 'Color'],
    'item_color_name'        => [true => 'Name'],
    'item_color_slug'        => [false => 'Slug'],
    'item_color_created_at'  => [false => 'Created At'],
    'item_color_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      if ($model->item_color_name && empty($model->item_color_slug)) {
        $model->item_color_slug = Str::slug($model->item_color_name);
      }

      if (Cache::has('item_color_api')) {
        Cache::forget('item_color_api');
      }
    });
  }
}
