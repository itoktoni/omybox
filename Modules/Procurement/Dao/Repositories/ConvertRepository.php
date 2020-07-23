<?php

namespace Modules\Procurement\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Procurement\Dao\Models\Convert;
use App\Dao\Interfaces\MasterInterface;

class ConvertRepository extends Convert implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select(['procurement_convert.*', DB::raw('a.procurement_unit_name as unit_from'),DB::raw('b.procurement_unit_name as unit_to')])->leftJoin(DB::raw('procurement_unit as a'), 'a.procurement_unit_id', 'procurement_convert_from')
        ->leftJoin(DB::raw('procurement_unit as b'), 'b.procurement_unit_id', 'procurement_convert_to');
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

    public function detail($id)
    {
        return $this->where($this->getKeyName(), $id)
        ->join('procurement_vendor_product', 'procurement_vendor_id', 'procurement_vendor_product_vendor_id')
        ->join('item_product','item_product_id', 'procurement_vendor_product_product_id');
    }
}
