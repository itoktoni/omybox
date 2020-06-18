<?php

namespace Modules\Procurement\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Procurement\Dao\Models\Purchase;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Product;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Modules\Procurement\Dao\Models\Vendor;

class PurchaseRepository extends Purchase implements MasterInterface
{
    public function dataRepository()
    {
        $vendor = new Vendor();
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        $sql = $this->select($list)->join($vendor->getTable(), $vendor->getKeyName(), 'purchase_procurement_vendor_id');
        return $sql;
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
            return Notes::update(collect($request));
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

    public function dataProduct($id)
    {
        return DB::table($this->table . '_product')->where($this->table . '_product_vendor_id', $id)->get();
    }

    public function showRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function show_detail($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->find($id)->first();
        }
        return $this->find($id)->first();
    }
}
