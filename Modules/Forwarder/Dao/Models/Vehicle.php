<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
  protected $table = 'forwarder_vehicle';
  protected $primaryKey = 'forwarder_vehicle_id';
  protected $fillable = [
    'forwarder_vehicle_id',
    'forwarder_vehicle_code',
    'forwarder_vehicle_name',
    'forwarder_vehicle_weight',
    'forwarder_vehicle_dimension',
    'forwarder_vehicle_capacity',
    'forwarder_vehicle_type',
    'forwarder_vehicle_description',
    'forwarder_vehicle_created_at',
    'forwarder_vehicle_created_by',
  ];

  public $timestamps = true;
  public $incrementing = faltruese;
  public $rules = [
    'forwarder_vehicle_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_vehicle_created_at';
  const UPDATED_AT = 'forwarder_vehicle_created_by';

  public $searching = 'forwarder_vehicle_name';
  public $datatable = [
    'forwarder_vehicle_id'          => [false => 'ID'],
    'forwarder_vehicle_code'        => [true => 'Code'],
    'forwarder_vehicle_name'        => [true => 'Name'],
    'forwarder_vehicle_weight'        => [true => 'Weight'],
    'forwarder_vehicle_dimension'        => [true => 'Dimension'],
    'forwarder_vehicle_type'        => [true => 'Type'],
    'forwarder_vehicle_capacity'        => [true => 'Capacity'],
    'forwarder_vehicle_description' => [false => 'Description'],
    'forwarder_vehicle_created_at'  => [false => 'Created At'],
    'forwarder_vehicle_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
