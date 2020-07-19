<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ModuleConnectionAction extends Model
{
	protected $table = 'core_module_connection_action';
	protected $primaryKey = 'conn_ma_module';
	public $foreignKey = 'conn_ma_action';
	protected $fillable = [
		'conn_ma_module',
		'conn_ma_action',
	];
}
