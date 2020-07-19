<?php

namespace Modules\Production\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Production\Dao\Repositories\WorkOrderRepository;

class WorkOrderCreateRepository extends WorkOrderRepository implements MasterInterface
{
    public $data;
    public $mapping  = [
        'primary' => 'production_work_order_detail_production_work_order_id',
        'foreign' => 'production_work_order_detail_item_product_id',
        'detail' => [
            'production_work_order_detail_item_product_id' =>  'temp_id',
            'production_work_order_detail_qty_order' => 'temp_qty',
            'production_work_order_detail_price_order' => 'temp_price',
        ]
    ];
    public $grouping = [
        'key' => 'temp_vendor_id',
        'group' => 'production_work_order_production_vendor_id',
        'detail' => [
            'production_work_order_detail_item_product_id' =>  'temp_id',
            'production_work_order_detail_qty_order' => 'temp_qty',
            'production_work_order_detail_price_order' => 'temp_price',
        ]
    ];

    public $sales_order = [
        'table' => 'sales_order_detail',
        'primary' => 'sales_order_detail_sales_order_id',
        'foreign' => 'sales_order_detail_item_product_id',
        'product' => 'production_work_order_detail_item_product_id',
        'detail' => [
            'sales_order_detail_qty_prepare' => 'production_work_order_detail_qty_order',
        ]
    ];

    public function saveDetailRepository($id, array $data)
    {
        if (!$this->detail_table) {
            return Notes::error('table detail not set');
        }
        try {
            $data[$this->mapping['primary']] = $id;
            $data['production_work_order_detail_total_order'] = $data['production_work_order_detail_qty_order'] * $data['production_work_order_detail_price_order'];
            DB::table($this->detail_table)->insert($data);
            return Notes::create();
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateSalesDetailRepository($id, array $data)
    {
        try {
            $where = [
                $this->sales_order['primary'] => $id,
                $this->sales_order['foreign'] => $data[$this->sales_order['product']],
            ];
            $sales_detail = $this->where($where);
            $key = key($this->sales_order['detail']);
            $value = $this->sales_order['detail'][$key];
            $qty = $sales_detail->first()->{$key} ?? 0;
            $update = [$key => ($qty + floatval($data[$value]))];
            $sales_detail->update($update);
            return Notes::create();
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateDetailRepository($id, array $data)
    {
        try {
            $where = [
                $this->mapping['primary'] => $id,
                $this->mapping['foreign'] => $data[$this->mapping['foreign']],
            ];
            $data['production_work_order_detail_total_order'] = $data['production_work_order_detail_qty_order'] * $data['production_work_order_detail_price_order'];
            $check = DB::table($this->detail_table)->updateOrInsert($where, $data);

            return Notes::create();
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteDetailRepository($id, $foreign = false)
    {
        try {
            if ($foreign) {
                DB::table($this->detail_table)->where([$this->mapping['primary'] => $id, $this->mapping['foreign'] => $foreign])->delete();
                return Notes::delete('detail');
            } else {
                DB::table($this->detail_table)->whereIn($this->mapping['primary'], $id)->delete();
                DB::table($this->getTable())->whereIn($this->getKeyName(), $id)->delete();
                return Notes::delete('master');
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
