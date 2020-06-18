<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
  protected $table = 'item_size';
  protected $primaryKey = 'item_size_code';
  protected $fillable = [
    'item_size_code',
    'item_size_name',
    'item_size_description',
    'item_size_created_at',
    'item_size_created_by',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $rules = [
    'item_size_name' => 'required|min:3',
  ];

  const CREATED_AT = 'item_size_created_at';
  const UPDATED_AT = 'item_size_created_by';

  public $searching = 'item_size_name';
  public $datatable = [
    'item_size_code'       => [true => 'Code'],
    'item_size_name'        => [true => 'Name'],
    'item_size_description' => [true => 'Description'],
    'item_size_created_at'  => [false => 'Created At'],
    'item_size_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

}
