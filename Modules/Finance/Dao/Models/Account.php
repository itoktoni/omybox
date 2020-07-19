<?php

namespace Modules\Finance\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  protected $table = 'finance_account';
  protected $primaryKey = 'finance_account_id';
  protected $fillable = [
    'finance_account_id',
    'finance_account_name',
    'finance_account_description',
    'finance_account_created_at',
    'finance_account_created_by',
    'finance_account_type',
    'finance_account_flag',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'finance_account_name' => 'required|min:3',
  ];

  const CREATED_AT = 'finance_account_created_at';
  const UPDATED_AT = 'finance_account_created_by';
  public $searching = 'finance_account_name';
  public $datatable = [
    'finance_account_id'             => [false => 'ID'],
    'finance_account_name'           => [true => 'Name'],
    'finance_account_description' => [true => 'Description'],
    'finance_account_type'         => [true => 'Type'],
    'finance_account_flag'         => [true => 'Flag'],
    'finance_account_created_at'     => [false => 'Created At'],
    'finance_account_created_by'     => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['IN', 'success'],
    '0' => ['OUT', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {
      if (request()->has('flag')) {
        $model->finance_account_flag = json_encode(request()->get('flag'));
      }
    });
  }
}
