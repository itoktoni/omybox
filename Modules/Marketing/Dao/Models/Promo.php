<?php

namespace Modules\Marketing\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Modules\Marketing\Emails\PromoEmail;

class Promo extends Model
{
  protected $table = 'marketing_promo';
  protected $primaryKey = 'marketing_promo_id';
  protected $fillable = [
    'marketing_promo_id',
    'marketing_promo_name',
    'marketing_promo_slug',
    'marketing_promo_description',
    'marketing_promo_page',
    'marketing_promo_image',
    'marketing_promo_created_at',
    'marketing_promo_created_by',
    'marketing_promo_default',
    'marketing_promo_status',
    'marketing_promo_code',
    'marketing_promo_matrix',
    'marketing_promo_user_json',
    'marketing_promo_start_date',
    'marketing_promo_end_date',
    'marketing_promo_minimal',
    'marketing_promo_maximal',
    'marketing_promo_type',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_promo_name' => 'required|min:3|unique:marketing_promo',
    'marketing_promo_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
    'marketing_promo_start_date' => 'required|date_format:Y-m-d',
    'marketing_promo_end_date' => 'required|date_format:Y-m-d|after:marketing_promo_start_date',
    'marketing_promo_matrix' => 'required',
    'marketing_promo_matrix' => 'required',
  ];

  const CREATED_AT = 'marketing_promo_created_at';
  const UPDATED_AT = 'marketing_promo_created_by';

  public $searching = 'marketing_promo_name';
  public $datatable = [
    'marketing_promo_id'          => [false => 'ID'],
    'marketing_promo_name'        => [true => 'Name'],
    'marketing_promo_default'        => [true => 'Default'],
    'marketing_promo_slug'        => [false => 'Slug'],
    'marketing_promo_description' => [true => 'Description'],
    'marketing_promo_image'        => [true => 'Images'],
    'marketing_promo_status'        => [true => 'Status'],
    'marketing_promo_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public $default = [
    '0' => ['Not Active', 'warning'],
    '1' => ['Active', 'success'],
  ];

  public $type = [
    '1' => ['Promo', 'success'],
    '2' => ['Voucher', 'primary'],
  ];


  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      $file = 'marketing_promo_file';
      if (request()->has($file)) {
        $image = $model->marketing_promo_image;
        if ($image) {
          Helper::removeImage($image, Helper::getTemplate(__CLASS__));
        }

        $file = request()->file($file);
        $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
        $model->marketing_promo_image = $name;
      }

      if ($model->marketing_promo_name && empty($model->marketing_promo_slug)) {
        $model->marketing_promo_slug = Str::slug($model->marketing_promo_name);
      }

      $model->marketing_promo_code = strtoupper(trim(request()->get('marketing_promo_code')));

      if ($model->marketing_promo_default == '1') {
        DB::table($model->getTable())
          ->where('marketing_promo_id', '<>', $model->marketing_promo_id)
          ->update(['marketing_promo_default' => 0]);
      }

      $model->marketing_promo_default = request()->get('marketing_promo_default');

      if (empty(request()->get('marketing_promo_start_date'))) {
        $model->marketing_promo_start_date = null;
      }

      if (empty(request()->get('marketing_promo_end_date'))) {
        $model->marketing_promo_end_date = null;
      }

      if (Cache::has('marketing_promo_api')) {
        Cache::forget('marketing_promo_api');
      }

      if (request()->has('emails')) {
        foreach (request()->get('emails') as $user) {
          if ($user) {
            $data['data'] = $model;
            $data['user'] = $user;
            Mail::to($user)->send(new PromoEmail($data));
          }
        }
      }
    });

    parent::deleting(function ($model) {
      if (request()->has('id')) {
        $data = $model->getDataIn(request()->get('id'));
        if ($data) {
          foreach ($data as $value) {
            if ($value->marketing_promo_image) {
              Helper::removeImage($value->marketing_promo_image, Helper::getTemplate(__CLASS__));
            }
          }
        }
      }
    });
  }
}
