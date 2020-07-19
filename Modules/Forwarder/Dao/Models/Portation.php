<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Portation extends Model
{
  protected $table = 'forwarder_portation';
  protected $primaryKey = 'forwarder_portation_lacode';
  protected $fillable = [
    'forwarder_portation_lacode',
    'forwarder_portation_country_code',
    'forwarder_portation_country_name',
    'forwarder_portation_port_code',
    'forwarder_portation_port_name',
    'forwarder_portation_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'forwarder_portation_country_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_portation_created_at';
  const UPDATED_AT = 'forwarder_portation_created_by';

  public $searching = 'forwarder_portation_country_name';
  public $datatable = [
    'forwarder_portation_lacode'        => [true => 'Code'],
    'forwarder_portation_country_code'   => [true => 'Country Code'],
    'forwarder_portation_country_name'        => [true => 'Country Name'],
    'forwarder_portation_port_code' => [true => 'Port Code'],
    'forwarder_portation_port_name' => [true => 'Port Name'],
    'forwarder_portation_description' => [false => 'Description'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
