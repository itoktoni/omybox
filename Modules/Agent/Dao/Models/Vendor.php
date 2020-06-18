<?php

namespace Modules\Agent\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
  protected $table = 'agent_vendor';
  protected $primaryKey = 'agent_vendor_id';
  protected $fillable = [
    'agent_vendor_id',
    'agent_vendor_name',
    'agent_vendor_description',
    'agent_vendor_created_at',
    'agent_vendor_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'agent_vendor_name' => 'required|min:3',
  ];

  const CREATED_AT = 'agent_vendor_created_at';
  const UPDATED_AT = 'agent_vendor_created_by';

  public $searching = 'agent_vendor_name';
  public $datatable = [
    'agent_vendor_id'          => [false => 'ID'],
    'agent_vendor_name'        => [true => 'Name'],
    'agent_vendor_description' => [true => 'Description'],
    'agent_vendor_created_at'  => [false => 'Created At'],
    'agent_vendor_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
