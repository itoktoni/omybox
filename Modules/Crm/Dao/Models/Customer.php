<?php

namespace Modules\Crm\Dao\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'id';
  protected $fillable = [
    'id',
    'name',
    'email',
    'password',
    'username',
    'photo',
    'group_user',
    'remember_token',
    'address',
    'birth',
    'place_birth',
    'notes',
    'phone',
    'deleted_at',
    'created_at',
    'updated_at',
    'active',
    'api_token',
    'province',
    'city',
    'district',
    'postcode',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'name' => 'required|min:3',
  ];

  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';

  public $searching = 'name';
  public $datatable = [
    'id'          => [false => 'ID'],
    'name'        => [true => 'Name'],
    'email' => [true => 'Email'],
    'phone' => [true => 'Phone'],
    'email' => [true => 'Email'],
    'address' => [true => 'Address'],
    'created_at'  => [false => 'Created At'],
    'updated_at'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot(){
    parent::boot();

    parent::saving(function($model){
      if(Cache::has($model->getTable().'_api')){
        Cache::forget($model->getTable() . '_api');
      }
    });
  }
}
