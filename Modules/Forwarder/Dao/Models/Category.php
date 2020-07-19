<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'forwarder_category';
  protected $primaryKey = 'forwarder_category_id';
  protected $fillable = [
    'forwarder_category_id',
    'forwarder_category_name',
    'forwarder_category_description',
    'forwarder_category_created_at',
    'forwarder_category_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'forwarder_category_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_category_created_at';
  const UPDATED_AT = 'forwarder_category_created_by';

  public $searching = 'forwarder_category_name';
  public $datatable = [
    'forwarder_category_id'          => [false => 'ID'],
    'forwarder_category_name'        => [true => 'Name'],
    'forwarder_category_description' => [true => 'Description'],
    'forwarder_category_created_at'  => [false => 'Created At'],
    'forwarder_category_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
