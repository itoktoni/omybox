<?php

namespace Modules\Production\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Modules\Item\Dao\Models\Unit;
use Modules\Production\Dao\Models\Packaging;
use App\Dao\Interfaces\MasterInterface;

class PackagingRepository extends Packaging implements MasterInterface
{
    private static $unit;
    
    public static function getUnit()
    {
        if (self::$unit == null) {
            self::$unit = new Unit();
        }

        return self::$unit;
    }

    public function dataRepository()
    {
        $unit = self::getUnit();
        $list = Helper::dataColumn($this->datatable, $this->primaryKey);
        return $this->select($list)->leftJoin($unit->getTable(), $unit->getKeyName(), 'production_packaging_unit_from');
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
