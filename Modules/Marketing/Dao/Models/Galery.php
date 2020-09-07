<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
  protected $table = 'marketing_galery';
  protected $primaryKey = 'marketing_galery_id';
  protected $fillable = [
    'marketing_galery_id',
    'marketing_galery_description',
    'marketing_galery_link',
    'marketing_galery_image',
    'marketing_galery_order',
    'marketing_galery_tag',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'marketing_galery_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
    'marketing_galery_link' => 'url',
  ];

  const CREATED_AT = 'marketing_galery_created_at';
  const UPDATED_AT = 'marketing_galery_created_by';

  public $searching = 'marketing_galery_order';
  public $datatable = [
    'marketing_galery_id'          => [true => 'ID'],
    'marketing_galery_link'        => [false => 'Link'],
    'marketing_galery_order'        => [true => 'Sort'],
    'marketing_galery_tag'        => [true => 'Tag'],
    'marketing_galery_description'        => [true => 'Content Text'],
    'marketing_galery_image'        => [true => 'Images'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
