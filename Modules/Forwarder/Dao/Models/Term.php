<?php

namespace Modules\Forwarder\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
  protected $table = 'forwarder_term';
  protected $primaryKey = 'forwarder_term_id';
  protected $fillable = [
    'forwarder_term_id',
    'forwarder_term_code',
    'forwarder_term_name',
    'forwarder_term_day',
    'forwarder_term_description',
    'forwarder_term_created_at',
    'forwarder_term_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'forwarder_term_name' => 'required|min:3',
  ];

  const CREATED_AT = 'forwarder_term_created_at';
  const UPDATED_AT = 'forwarder_term_created_by';

  public $searching = 'forwarder_term_name';
  public $datatable = [
    'forwarder_term_id'          => [false => 'ID'],
    'forwarder_term_code'        => [true => 'Code'],
    'forwarder_term_name'        => [true => 'Name'],
    'forwarder_term_day'        => [true => 'Day'],
    'forwarder_term_description' => [true => 'Description'],
    'forwarder_term_created_at'  => [false => 'Created At'],
    'forwarder_term_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
