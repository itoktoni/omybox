<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  protected $table = 'marketing_slider';
  protected $primaryKey = 'marketing_slider_id';
  protected $fillable = [
    'marketing_slider_id',
    'marketing_slider_name',
    'marketing_slider_slug',
    'marketing_slider_description',
    'marketing_slider_page',
    'marketing_slider_link',
    'marketing_slider_button',
    'marketing_slider_image',
    'marketing_slider_created_at',
    'marketing_slider_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_slider_name' => 'required|min:3|unique:marketing_slider',
    'marketing_slider_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
    'marketing_slider_link' => 'url',
  ];

  const CREATED_AT = 'marketing_slider_created_at';
  const UPDATED_AT = 'marketing_slider_created_by';

  public $searching = 'marketing_slider_name';
  public $datatable = [
    'marketing_slider_id'          => [false => 'ID'],
    'marketing_slider_name'        => [true => 'Name'],
    'marketing_slider_button'        => [false => 'Button'],
    'marketing_slider_link'        => [false => 'Link'],
    'marketing_slider_slug'        => [false => 'Slug'],
    'marketing_slider_description' => [true => 'Description'],
    'marketing_slider_image'        => [true => 'Images'],
    'marketing_slider_created_by'  => [false => 'Updated At'],  
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
