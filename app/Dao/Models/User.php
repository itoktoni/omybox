<?php

namespace App;

use Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'users'; //nama table
    protected $primaryKey = 'id'; //nama primary key
    protected $fillable    = [
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
        'location',
        'postcode',
        'token',
    ];
    public $timestamps    = true; //timestamp will true
    public $incrementing  = true; //make creating id use lastcode
    public $rules         = [ //validasi https://laravel.com/docs/5.5/validation
        'username'  => 'required|min:3',
        'email'      => 'required|email',
        'group_user' => 'required',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $searching     = 'name'; //searching default
    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Pasive', 'danger'],
    ];

    public $datatable = [
        'id'            => [false => 'ID User'],
        'username'      => [true => 'Username'],
        'name'      => [true => 'Name'],
        'email'         => [true => 'Email'],
        'group_user'    => [true => 'Group User'],
        'active'        => [true => 'Active'],
    ];

    public function scopeById($query, $id)
    {
        return $query->where($this->primaryKey, $id);
    }

}
