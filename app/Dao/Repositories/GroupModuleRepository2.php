<?php

namespace App\Dao\Repositories;

use Plugin\Notes;
use Helper;
use App\Dao\Models\GroupModule;
use App\Dao\Models\GroupModuleConnectionModule;
use App\Dao\Models\GroupUserConnectionGroupModule;
use App\Dao\Models\Module;
use App\Dao\Models\ModuleConnectionAction;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;

class GroupModuleRepository2 extends GroupModule implements MasterInterface
{
    public static $group_module_connection_module;
    public static $group_user_connection_group_module;
    public static $module;
    public static $module_connection_action;

    public function __construct()
    {
        if (self::$group_module_connection_module == null) {
            self::$group_module_connection_module = new GroupModuleConnectionModule();
        }

        if (self::$module == null) {
            self::$module = new Module();
        }

        if (self::$group_user_connection_group_module == null) {
            self::$group_user_connection_group_module = new GroupUserConnectionGroupModule();
        }

        if (self::$module_connection_action == null) {
            self::$module_connection_action = new ModuleConnectionAction();
        }
    }

    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->create($request);
            if ($activity->getAttributes()) {
                return Notes::create($activity);
            }
            return Notes::error('data not saved !');
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            $activity = $this->findOrFail($id)->update($request);
            return Notes::update($activity);
        } catch (QueryExceptionAlias $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function getGroupByModule($module)
    {
        $select = DB::table($this->table);
        $select->join(self::$group_module_connection_module->getTable(), $this->getKeyName(), '=', 'conn_gm_group_module');
        $select->where('conn_gm_module', $module);
        return $select;
    }

    public function getGroupByUser($user)
    {
        $select = DB::table($this->table);
        $select->join(self::$group_user_connection_group_module->getTable(), $this->getKeyName(), '=', 'conn_gu_group_module');
        $select->where('conn_gu_group_user', $user);
        return $select;
    }

    public function scopeJoinAction($query)
    {
        $query->join(self::$module->getTable(), 'module_folder', '=', 'group_module_folder');
        $query->join(self::$module_connection_action->getTable(), 'module_code', '=', 'conn_ma_module');
        return $query;
    }

    public function scopeModuleActive($query)
    {
        $query->join(self::$module, 'module_folder', '=', 'group_module_folder')->where('module_enable', 1);
        return $query;
    }


    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }
}
