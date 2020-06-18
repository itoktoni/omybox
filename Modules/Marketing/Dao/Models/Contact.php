<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  protected $table = 'marketing_contact';
  protected $primaryKey = 'marketing_contact_id';
  protected $fillable = [
    'marketing_contact_id',
    'marketing_contact_name',
    'marketing_contact_email',
    'marketing_contact_subject',
    'marketing_contact_phone',
    'marketing_contact_address',
    'marketing_contact_date',
    'marketing_contact_message',
    'marketing_contact_created_at',
    'marketing_contact_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_contact_name' => 'required',
    'marketing_contact_email' => 'required|email',
    // 'marketing_contact_subject' => 'required',
    'marketing_contact_phone' => 'required',
    'marketing_contact_message' => 'required',
  ];

  const CREATED_AT = 'marketing_contact_created_at';
  const UPDATED_AT = 'marketing_contact_created_by';

  public $searching = 'marketing_contact_name';
  public $datatable = [
    'marketing_contact_id'          => [false => 'ID'],
    'marketing_contact_name'        => [true => 'Name'],
    'marketing_contact_email'        => [true => 'Email'],
    'marketing_contact_phone'        => [false => 'Phone'],
    'marketing_contact_subject'        => [true => 'Subject'],
    'marketing_contact_message'        => [false => 'Message'],
    'marketing_contact_address'        => [false => 'Address'],
    'marketing_contact_date'        => [false => 'Date'],
    'marketing_contact_created_by'  => [false => 'Updated At'],  
  ];
}
