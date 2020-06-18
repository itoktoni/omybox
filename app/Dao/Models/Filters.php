<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Filters extends Model
{
	protected $table = 'core_filters';
	protected $primaryKey = 'key';
	protected $fillable = [
		'key',
		'name',
		'module',
		'custom',
		'field',
		'function',
		'operator',
		'value',
	];
	public $incrementing = false;
	public $timestamps = false;
}
