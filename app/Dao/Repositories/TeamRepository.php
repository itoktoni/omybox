<?php

namespace App\Dao\Repositories;

use App\User;
use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Inventory\Dao\Models\Branch;

class TeamRepository extends User implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
    }

    public function saveRepository($request)
    {
        try {
            unset($request['_token']);
            if (!empty($request['password'])) {
                $request['password'] =  bcrypt($request['password']);
            } else {
                unset($request['password']);
            }
            
            $activity = DB::table($this->getTable())->insert($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            if (!empty($request['password'])) {
                $request['password'] =  bcrypt($request['password']);
            } else {
                unset($request['password']);
            }
            
            unset($request['code']);
            unset($request['_token']);
            $activity = DB::table($this->getTable())
              ->where($this->getKeyName(), $id)
              ->update($request);

            $activity = $this->find($id)->update($request);
            return Notes::update($request);
        } catch (QueryException $ex) {
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

    public function showRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }
}
