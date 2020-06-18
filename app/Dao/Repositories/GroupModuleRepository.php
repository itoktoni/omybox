<?php

namespace App\Dao\Repositories;

use Plugin\Notes;
use Helper;
use App\Dao\Models\Module;
use App\Dao\Models\GroupModule;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use App\Dao\Models\ModuleConnectionAction;
use App\Dao\Models\GroupModuleConnectionModule;
use App\Dao\Models\GroupUserConnectionGroupModule;

class GroupModuleRepository extends GroupModule implements MasterInterface
{
   
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->create($request);
            return Notes::create($activity);
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

    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function getGroupByModule($module)
    {
        $select = DB::table($this->table);
        $select->join((new GroupModuleConnectionModule())->getTable(), $this->getKeyName(), '=', 'conn_gm_group_module');
        $select->where('conn_gm_module', $module);
        return $select;
    }

    public function getGroupByUser($user)
    {
        $select = DB::table($this->table);
        $select->join((new GroupUserConnectionGroupModule())->getTable(), $this->getKeyName(), '=', 'conn_gu_group_module');
        $select->where('conn_gu_group_user', $user);
        return $select;
    }

    public function scopeJoinAction($query)
    {
        $query->join((new Module())->getTable(), 'module_folder', '=', 'group_module_folder');
        $query->join((new ModuleConnectionAction())->getTable(), 'module_code', '=', 'conn_ma_module');
        return $query;
    }

    public function scopeModuleActive($query)
    {
        $query->join((new Module())->getTable(), 'module_folder', '=', 'group_module_folder')->where('module_enable', 1);
        return $query;
    }
}
