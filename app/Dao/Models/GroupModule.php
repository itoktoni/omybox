<?php

namespace App\Dao\Models;

use App\Dao\Models\Module;
use Illuminate\Database\Eloquent\Model;

class GroupModule extends Model
{
    protected $table = 'core_group_modules';
    protected $primaryKey = 'group_module_code';
    protected $fillable = [
        'group_module_code',
        'group_module_name',
        'group_module_link',
        'group_module_sort',
        'group_module_visible',
        'group_module_enable',
        'group_module_modular',
        'group_module_folder',
        'group_module_description',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'group_module_code' => 'required|min:3|unique:core_group_modules',
        'group_module_name' => 'required|min:3',
    ];

    public $searching = 'group_module_name';
    public $status    = [
        '1' => ['Enable', 'primary'],
        '0' => ['Disable', 'danger'],
    ];

    protected $casts = [
        'group_module_code' => 'string',
        'group_module_sort' => 'integer'
    ];

    public $datatable = [
        'group_module_code'        => [true => 'Code'],
        'group_module_name'        => [true => 'Name'],
        'group_module_link'        => [false => 'Link'],
        'group_module_description' => [true => 'Description'],
        'group_module_folder'      => [true => 'Folder'],
        'group_module_enable'      => [true => 'Active'],
    ];

    public static function boot()
    {
        parent::boot();
        parent::saving(function ($model) {

            if(request()->get('group_module_code')){
                $model->group_module_code = request()->get('group_module_code');
            }
            if (empty($model->group_module_sort)) {
                $model->group_module_sort = 0;
            }
            if ($model->group_module_folder) {
                $model->group_module_modular = 1;
            }
            $model->group_module_folder = ucfirst($model->group_module_folder);
            $model->group_module_name = strtoupper($model->group_module_name);
            $model->group_module_link = $model->group_module_code;
        });
    }

    public function modules()
    {
        // return $this->leftJoin((new Module())->getTable(),'module_folder', 'group_module_folder')
        return $this->hasMany(Module::class, 'module_folder', 'group_module_folder');
    }

    public function scopeActive()
    {
        return $this->modules()->where('module_enable', 1);
    }
}
