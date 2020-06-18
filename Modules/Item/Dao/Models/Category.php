<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'item_category';
  protected $primaryKey = 'item_category_id';
  protected $fillable = [
    'item_category_id',
    'item_category_slug',
    'item_category_name',
    'item_category_image',
    'item_category_flag',
    'item_category_status',
    'item_category_homepage',
    'item_category_description',
    'item_category_created_at',
    'item_category_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_category_name' => 'required|min:3|unique:item_category',
    'item_product_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
  ];

  const CREATED_AT = 'item_category_created_at';
  const UPDATED_AT = 'item_category_created_by';

  public $searching = 'item_category_name';
  public $datatable = [
    'item_category_id'          => [false => 'ID'],
    'item_category_name'        => [true => 'Name'],
    'item_category_flag'        => [true => 'Flag'],
    'item_category_slug'        => [false => 'Slug'],
    'item_category_image'        => [true => 'Images'],
    'item_category_homepage'        => [true => 'Homepage'],
    'item_category_status'        => [true => 'Status'],
    'item_category_description' => [false => 'Description'],
    'item_category_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      $file = 'item_category_file';
      if (request()->has($file)) {
        $image = $model->item_category_image;
        if ($image) {
          // Helper::removeImage($image, Helper::getTemplate(__CLASS__));
        }

        $file = request()->file($file);
        $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
        $model->item_category_image = $name;
      }

      if ($model->item_category_name && empty($model->item_category_slug)) {
        $model->item_category_slug = Str::slug($model->item_category_name);
      }

      if (Cache::has('item_category_api')) {
        Cache::forget('item_category_api');
      }
    });

    parent::deleting(function ($model) {
      if (request()->has('id')) {
        $data = $model->getDataIn(request()->get('id'));
        if ($data) {
          Cache::forget('item_category_api');
          foreach ($data as $value) {
            if ($value->item_category_image) {
              Helper::removeImage($value->item_category_image, Helper::getTemplate(__CLASS__));
            }
          }
        }
      }
    });
  }
}
