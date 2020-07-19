<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  protected $table = 'item_tax';
  protected $primaryKey = 'item_tax_id';
  protected $fillable = [
    'item_tax_id',
    'item_tax_code',
    'item_tax_name',
    'item_tax_type',
    'item_tax_value',
    'item_tax_description',
    'item_tax_created_at',
    'item_tax_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_tax_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_tax_created_at';
  const UPDATED_AT = 'item_tax_created_by';

  public $searching = 'item_tax_name';
  public $datatable = [
    'item_tax_id'          => [false => 'ID'],
    'item_tax_code'        => [true => 'Code'],
    'item_tax_name'        => [true => 'Name'],
    'item_tax_type'        => [true => 'Type'],
    'item_tax_value'        => [true => 'Value'],
    'item_tax_description' => [true => 'Description'],
    'item_tax_created_at'  => [false => 'Created At'],
    'item_tax_created_by'  => [false => 'Updated At'],
  ];

  public $optionType = [
    '1' => ['Percent', 'primary'],
    '0' => ['Value', 'danger'],
  ];
}
