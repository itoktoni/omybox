<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  protected $table = 'item_tag';
  protected $primaryKey = 'item_tag_id';
  protected $fillable = [
    'item_tag_id',
    'item_tag_name',
    'item_tag_slug',
    'item_tag_description',
    'item_tag_created_at',
    'item_tag_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_tag_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_tag_created_at';
  const UPDATED_AT = 'item_tag_created_by';

  public $searching = 'item_tag_name';
  public $datatable = [
    'item_tag_id'          => [false => 'ID'],
    'item_tag_name'        => [true => 'Name'],
    'item_tag_slug'        => [true => 'Slug'],
    'item_tag_description' => [true => 'Description'],
    'item_tag_created_at'  => [false => 'Created At'],
    'item_tag_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];


  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      if ($model->item_tag_name && empty($model->item_tag_slug)) {
        $model->item_tag_slug = Str::slug($model->item_tag_name);
      }

      if (Cache::has('item_tag_api')) {
        Cache::forget('item_tag_api');
      }
    });
  }
}
