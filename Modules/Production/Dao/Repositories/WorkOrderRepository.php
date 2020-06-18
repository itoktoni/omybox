<?php

namespace Modules\Production\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Production\Dao\Models\Vendor;
use Modules\Production\Dao\Models\WorkOrder;
use App\Dao\Interfaces\MasterInterface;

class WorkOrderRepository extends WorkOrder implements MasterInterface
{
    public static $vendor;
    public function dataRepository()
    {
        if (self::$vendor == null) {
            self::$vendor = new Vendor();
        }

        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->leftJoin(self::$vendor->getTable(), self::$vendor->getKeyName(), 'production_work_order_production_vendor_id');
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

    public function dataProduct($id)
    {
        return DB::table($this->table . '_product')->where($this->table . '_product_vendor_id', $id)->get();
    }

    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function getDetail($id)
    {
        return $this->where($this->getKeyName(), $id)
            ->join('production_vendor_product', 'production_vendor_id', 'production_vendor_product_vendor_id')
            ->join('item_product', 'item_product_id', 'production_vendor_product_product_id');
    }

    public function getDetailBySalesOrder($id)
    {
        return $this->where($this->reference_key, $id)
            ->select([
                'production_work_order_detail_item_product_id',
                DB::raw('sum(production_work_order_detail_qty_order) as total')
            ])
            ->join('production_work_order_detail', 'production_work_order_detail_production_work_order_id', 'production_work_order_id')
            ->groupBy('production_work_order_sales_order_id', 'production_work_order_detail_item_product_id');
    }
}
