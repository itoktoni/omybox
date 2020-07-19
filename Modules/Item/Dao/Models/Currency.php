<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
  protected $table = 'item_currency';
  protected $primaryKey = 'item_currency_id';
  protected $fillable = [
    'item_currency_id',
    'item_currency_code',
    'item_currency_name',
    'item_currency_symbol',
    'item_currency_description',
    'item_currency_created_at',
    'item_currency_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_currency_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_currency_created_at';
  const UPDATED_AT = 'item_currency_created_by';

  public $searching = 'item_currency_name';
  public $datatable = [
    'item_currency_id'          => [false => 'ID'],
    'item_currency_code'        => [true => 'Code'],
    'item_currency_name'        => [true => 'Name'],
    'item_currency_symbol'        => [true => 'Symbol'],
    'item_currency_description' => [true => 'Description'],
    'item_currency_created_at'  => [false => 'Created At'],
    'item_currency_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
