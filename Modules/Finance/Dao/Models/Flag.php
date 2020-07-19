<?php

namespace Modules\Finance\Dao\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
  protected $table = 'finance_flag';
  protected $primaryKey = 'finance_flag_name';
  protected $fillable = [
    'finance_flag_name',
  ];

  public $timestamps = false;
  public $incrementing = false;
  public $rules = [
    'finance_flag_name' => 'required|min:3|unique:finance_flag',
  ];

  const CREATED_AT = 'finance_flag_created_at';
  const UPDATED_AT = 'finance_flag_created_by';
  public $searching = 'finance_flag_name';
  public $datatable = [
    'finance_flag_name' => [true => 'Name'],
  ];

  public $status = [
    '1' => ['IN', 'success'],
    '0' => ['OUT', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {
      $model->finance_flag_name = Str::snake($model->finance_flag_name);
    });
  }
}
