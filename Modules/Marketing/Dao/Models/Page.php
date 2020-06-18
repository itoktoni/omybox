<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  protected $table = 'marketing_page';
  protected $primaryKey = 'marketing_page_id';
  protected $fillable = [
    'marketing_page_id',
    'marketing_page_name',
    'marketing_page_slug',
    'marketing_page_status',
    'marketing_page_description',
    'marketing_page_created_at',
    'marketing_page_updated_at',
    'marketing_page_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_page_name' => 'required|min:3|unique:marketing_page',
  ];

  const CREATED_AT = 'marketing_page_created_at';
  const UPDATED_AT = 'marketing_page_updated_at';

  public $searching = 'marketing_page_name';
  public $datatable = [
    'marketing_page_id'          => [true => 'ID'],
    'marketing_page_name'        => [true => 'Name'],
    'marketing_page_slug'        => [true => 'Slug'],
    'marketing_page_description'        => [false => 'Description'],
    'marketing_page_created_at'  => [true => 'Created At'],  
    'marketing_page_created_by'  => [true => 'Created By'],  
    'marketing_page_status'        => [true => 'Status'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      $model->marketing_page_created_by = auth()->user()->username;
      if ($model->marketing_page_name && empty($model->marketing_page_slug)) {
        $model->marketing_page_slug = Str::slug($model->marketing_page_name);
      }

      if (Cache::has('marketing_page_api')) {
        Cache::forget('marketing_page_api');
      }
    });
  }
}
