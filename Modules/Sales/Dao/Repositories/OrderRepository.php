<?php

namespace Modules\Sales\Dao\Repositories;

use App\User;
use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Order;
use Illuminate\Support\Facades\Auth;
use Modules\Crm\Dao\Models\Customer;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Forwarder\Dao\Models\Vendor;

class OrderRepository extends Order implements MasterInterface
{
    public $data;
    public static $customer;
    public static $vendor;

    public function dataRepository()
    {
        if (self::$customer == null) {
            self::$customer = new User();
        }
        if (self::$vendor == null) {
            self::$vendor = new Vendor();
        }
    
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        $query = $this->select($list)->join('sales_order_detail', 'sales_order_detail_sales_order_id', 'sales_order_id')
            ->join('item_product', 'item_product_id', 'sales_order_detail_item_product_id')
            ->leftJoin('item_brand', 'item_brand_id', 'item_product_item_brand_id');

        if (empty(Auth::user()->brand)) {
            $query->groupBy('sales_order_detail_sales_order_id');
        } else {
            $query->groupBy('sales_order_detail_sales_order_id', 'item_product_item_brand_id');
        }

        return $query;
    }

    public function userRepository($id)
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        unset($list[13]);
        return $this->select($list)->where('sales_order_rajaongkir_phone', $id);
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
            if (isset($request['sales_order_rajaongkir_ongkir'])) {
                $request['sales_order_rajaongkir_ongkir'] = Helper::filterInput($request['sales_order_rajaongkir_ongkir']);
            }
            $activity = $this->findOrFail($id)->update($request);
            return Notes::update($activity);
        } catch (QueryException $ex) {
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

    public function findRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->find($id);
        }
        return $this->find($id);
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

    public function deleteDetailRepository($data)
    {
        try {
            $activity = $this->detail()->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function split($id)
    {
        $query = DB::table($this->getTable())->where('sales_order_detail_sales_order_id', $id)
            ->select([
                'sales_order_detail.*',
                'item_product_id',
                'item_product_name',
                'production_vendor_id',
                'production_vendor_name',
            ])
            ->join('sales_order_detail', 'sales_order_detail_sales_order_id', 'sales_order_id')
            ->join('item_product', 'item_product_id', 'sales_order_detail_item_product_id')
            ->leftJoin('production_vendor', 'production_vendor_id', 'item_product_production_vendor_id')
            ->groupBy('sales_order_detail_sales_order_id', 'sales_order_detail_item_product_id');

        return $query;
    }

    public function getStatusCreate()
    {
        return $this->statusCreate()->get()->pluck($this->getRouteKeyName(), $this->getRouteKeyName())->prepend('- Select Sales Order -', '');
    }
}
