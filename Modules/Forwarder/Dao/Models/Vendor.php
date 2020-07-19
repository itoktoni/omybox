<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
  protected $table = 'forwarder_vendor';
  protected $primaryKey = 'forwarder_vendor_id';
  protected $fillable = [
    'forwarder_vendor_id',
    'forwarder_vendor_name',
    'forwarder_vendor_description',
    'forwarder_vendor_created_at',
    'forwarder_vendor_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'forwarder_vendor_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_vendor_created_at';
  const UPDATED_AT = 'forwarder_vendor_created_by';

  public $searching = 'forwarder_vendor_name';
  public $datatable = [
    'forwarder_vendor_id'          => [false => 'ID'],
    'forwarder_vendor_name'        => [true => 'Name'],
    'forwarder_vendor_description' => [true => 'Description'],
    'forwarder_vendor_created_at'  => [false => 'Created At'],
    'forwarder_vendor_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
