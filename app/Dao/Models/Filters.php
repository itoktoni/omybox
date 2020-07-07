<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Filters extends Model
{
	protected $table = 'core_filters';
	protected $primaryKey = 'filter';
	protected $fillable = [
		'filter',
		'name',
		'module',
		'custom',
		'field',
		'function',
		'operator',
		'val',
	];
	public $incrementing = false;
	public $timestamps = false;
}
