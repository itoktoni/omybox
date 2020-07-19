<?php

namespace App\Dao\Repositories;

use Plugin\Notes;
use Helper;
use App\Dao\Models\Module;
use App\Dao\Models\GroupUser;
use App\Dao\Models\GroupModule;
use Illuminate\Support\Facades\DB;
use App\Dao\Models\ModuleConnectionAction;
use App\Dao\Models\GroupModuleConnectionModule;
use App\Dao\Interfaces\MasterInterface;
use App\Dao\Models\GroupUserConnectionGroupModule;

class GroupUserRepository extends GroupUser implements MasterInterface
{
    public static $group_module;
    public static $group_user_connection_group_module;

    public function __construct()
    {
        if (self::$group_module == null) {
            self::$group_module = new GroupModule();
        }
        
        if (self::$group_user_connection_group_module == null) {
            self::$group_user_connection_group_module = new GroupUserConnectionGroupModule();
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

    public function getGroupByUser($user)
    {
        $select = DB::table(self::$group_module->getTable());
        $select->join(self::$group_user_connection_group_module->getTable(), 'group_module_code', '=', 'conn_gu_group_module');
        $select->where('conn_gu_group_user', $user)->orderBy('conn_gu_group_user', 'asc');
        return $select;
    }

    public function saveConnectionModule($code, $data)
    {
        try {
            DB::beginTransaction();
            DB::table(self::$group_user_connection_group_module->getTable())->where('conn_gu_group_user', '=', $code)->delete();
            if (!empty($data)) {
                foreach ($data as $group_module) {
                    $insert[] = [
                        'conn_gu_group_module' => $group_module,
                        'conn_gu_group_user' => $code
                    ];
                }
            }
            DB::table(self::$group_user_connection_group_module->getTable())->insert($insert);
            DB::commit();
            return Notes::create($insert);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
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
}
