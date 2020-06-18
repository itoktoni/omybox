<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Incoterm extends Model
{
  protected $table = 'forwarder_incoterm';
  protected $primaryKey = 'forwarder_incoterm_id';
  protected $fillable = [
    'forwarder_incoterm_id',
    'forwarder_incoterm_code',
    'forwarder_incoterm_name',
    'forwarder_incoterm_description',
    'forwarder_incoterm_created_at',
    'forwarder_incoterm_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'forwarder_incoterm_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_incoterm_created_at';
  const UPDATED_AT = 'forwarder_incoterm_created_by';

  public $searching = 'forwarder_incoterm_name';
  public $datatable = [
    'forwarder_incoterm_id'          => [false => 'ID'],
    'forwarder_incoterm_code'        => [true => 'Code'],
    'forwarder_incoterm_name'        => [true => 'Name'],
    'forwarder_incoterm_description' => [true => 'Description'],
    'forwarder_incoterm_created_at'  => [false => 'Created At'],
    'forwarder_incoterm_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
