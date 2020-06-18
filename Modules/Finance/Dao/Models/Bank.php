<?php

namespace Modules\Finance\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
  protected $table = 'finance_bank';
  protected $primaryKey = 'finance_bank_id';
  protected $fillable = [
    'finance_bank_id',
    'finance_bank_name',
    'finance_bank_account_name',
    'finance_bank_account_number',
    'finance_bank_branch',
    'finance_bank_description',
    'finance_bank_created_at',
    'finance_bank_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'finance_bank_name' => 'required|min:3',
  ];

  const CREATED_AT = 'finance_bank_created_at';
  const UPDATED_AT = 'finance_bank_created_by';
  public $searching = 'finance_bank_name';
  public $datatable = [
    'finance_bank_id'             => [false => 'ID'],
    'finance_bank_name'           => [true => 'Name'],
    'finance_bank_account_number' => [true => 'Account Number'],
    'finance_bank_account_name'   => [true => 'Account Name'],
    'finance_bank_branch'         => [true => 'Branch'],
    'finance_bank_created_at'     => [false => 'Created At'],
    'finance_bank_created_by'     => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
