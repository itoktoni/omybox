<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Helper;

class GroupUser extends Model
{
    protected $table      = 'core_group_users';
    protected $primaryKey = 'group_user_code';
    protected $fillable = [
        'group_user_code',
        'group_user_name',
        'group_user_description',
        'group_user_visible',
        'group_user_level',
        'group_user_dashboard',
    ];
    public $timestamps   = false;
    public $incrementing = false;
    public $rules        = [
        'group_user_code' => 'required|min:3|unique:core_group_users',
        'group_user_name' => 'required|min:3',
    ];

    protected $keyType = 'string';

    public function scopeById($query, $id)
    {
        return $query->where('group_user_code', $id);
    }

    public $datatable = [
        'group_user_code'        => [true => 'Code'],
        'group_user_name'        => [true => 'Name'],
        'group_user_dashboard'   => [true => 'Dashboard'],
        'group_user_description' => [true => 'Description'],
    ];

    public $searching     = 'group_user_name'; //searching default

}
