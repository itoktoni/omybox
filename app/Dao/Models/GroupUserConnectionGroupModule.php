<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GroupUserConnectionGroupModule extends Model
{
	protected $table = 'core_group_user_connection_group_module';
	protected $primaryKey = 'conn_gu_group_module';
	public $foreignKey = 'conn_gu_group_user';
	protected $fillable = [
		'conn_gu_group_module',
		'conn_gu_group_user',

	];
	public $incrementing = false;
	public $timestamps = false;	
}
