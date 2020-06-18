<?php

namespace Modules\Production\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Production\Dao\Models\Vendor;
use App\Dao\Interfaces\MasterInterface;

class VendorRepository extends Vendor implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->orderBy($this->order, 'desc');
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

    public function detail($id)
    {
        return $this->where($this->getKeyName(), $id)
        ->join('production_vendor_product', 'production_vendor_id', 'production_vendor_product_vendor_id')
        ->join('item_product','item_product_id', 'production_vendor_product_product_id');
    }
}
