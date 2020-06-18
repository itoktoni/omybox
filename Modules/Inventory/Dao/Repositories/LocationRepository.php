<?php

namespace Modules\Inventory\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Modules\Inventory\Dao\Models\Location;
use Modules\Inventory\Dao\Models\Warehouse;
use App\Dao\Interfaces\MasterInterface;

class LocationRepository extends Location implements MasterInterface
{
    private static $warehouse;

    public static function getWarehouse()
    {
        if (self::$warehouse == null) {
            self::$warehouse = new Warehouse();
        }

        return self::$warehouse;
    }

    public function dataRepository()
    {
        $warehouse = self::getWarehouse();
        $list = Helper::dataColumn($this->datatable, $this->primaryKey);
        return $this->select($list)->leftJoin($warehouse->getTable(), $warehouse->getKeyName(), 'inventory_location_warehouse_id');
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
}
