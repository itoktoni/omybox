<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Sosmed extends Model
{
  protected $table = 'marketing_sosmed';
  protected $primaryKey = 'marketing_sosmed_id';
  protected $fillable = [
    'marketing_sosmed_id',
    'marketing_sosmed_name',
    'marketing_sosmed_icon',
    'marketing_sosmed_link',
    'marketing_sosmed_created_at',
    'marketing_sosmed_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_sosmed_name' => 'required|min:3',
    'marketing_sosmed_link' => 'url',
  ];

  const CREATED_AT = 'marketing_sosmed_created_at';
  const UPDATED_AT = 'marketing_sosmed_created_by';

  public $searching = 'marketing_sosmed_name';
  public $datatable = [
    'marketing_sosmed_id'          => [false => 'ID'],
    'marketing_sosmed_name'        => [true => 'Name'],
    'marketing_sosmed_link'        => [false => 'Link'],
    'marketing_sosmed_icon'        => [false => 'Icon'],
    'marketing_sosmed_created_by'  => [false => 'Updated At'],  
  ];
}
