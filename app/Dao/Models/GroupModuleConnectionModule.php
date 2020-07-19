<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GroupModuleConnectionModule extends Model
{
	protected $table = 'core_group_module_connection_module';
	protected $primaryKey = 'conn_gm_group_module';
	public $foreignKey = 'conn_gm_module';
	protected $fillable = [
		'conn_gm_group_module',
		'conn_gm_module',
	];
	public $incrementing = false;
	public $timestamps = false;
}
