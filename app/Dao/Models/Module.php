<?php

namespace App\Dao\Models;

use App\Models\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Module extends Model
{
	protected $table = 'core_modules';
	protected $primaryKey = 'module_code';
	protected $fillable = [
		'module_code',
		'module_name',
		'module_description',
		'module_link',
		'module_controller',
		'module_filters',
		'module_sort',
		'module_visible',
		'module_enable',
		'module_module',
		'module_folder',
	];
	public $incrementing = false;
	public $timestamps = false;
	public $rules = [
		'module_code' => 'required|unique:core_modules|min:3',
		'module_name' => 'required|min:3',
		'module_controller' => 'required|min:3',
	];

	public $searching = 'module_name';

	public $datatable = [
		'module_code'           => [true => 'Code'],
		'module_name'           => [true => 'Name'],
		'module_link'           => [false => 'Link'],
		'module_controller'     => [true => 'Controller'],
		'module_folder'       => [true => 'Folder'],
	];

	public $status = [
		'1' => ['Active', 'primary'],
		'0' => ['Not Active', 'danger'],
	];

	public function actions()
	{
		return $this->hasMany(Action::class, 'action_module', 'module_code');
	}

	public static function boot()
	{
		parent::boot();
		parent::saving(function($model){
			if(empty($model->module_sort)){
				$model->module_sort = 0;
			}
		});
	}
}
