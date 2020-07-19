<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  protected $table = 'forwarder_tax';
  protected $primaryKey = 'forwarder_tax_id';
  protected $fillable = [
    'forwarder_tax_id',
    'forwarder_tax_code',
    'forwarder_tax_name',
    'forwarder_tax_type',
    'forwarder_tax_value',
    'forwarder_tax_description',
    'forwarder_tax_created_at',
    'forwarder_tax_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'forwarder_tax_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_tax_created_at';
  const UPDATED_AT = 'forwarder_tax_created_by';

  public $searching = 'forwarder_tax_name';
  public $datatable = [
    'forwarder_tax_id'          => [false => 'ID'],
    'forwarder_tax_code'        => [true => 'Code'],
    'forwarder_tax_name'        => [true => 'Name'],
    'forwarder_tax_type'        => [true => 'Type'],
    'forwarder_tax_value'        => [true => 'Value'],
    'forwarder_tax_description' => [true => 'Description'],
    'forwarder_tax_created_at'  => [false => 'Created At'],
    'forwarder_tax_created_by'  => [false => 'Updated At'],
  ];

  public $optionType = [
    '1' => ['Percent', 'primary'],
    '0' => ['Value', 'danger'],
  ];
}
