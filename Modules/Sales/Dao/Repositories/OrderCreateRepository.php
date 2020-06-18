<?php

namespace Modules\Sales\Dao\Repositories;

use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Sales\Dao\Repositories\OrderRepository;

class OrderCreateRepository extends OrderRepository implements MasterInterface
{
    public $data;
    public $mapping  = [
        'primary' => 'sales_order_detail_sales_order_id',
        'foreign' => 'sales_order_detail_item_product_id',
        'detail' => [
            'sales_order_detail_item_product_id' =>  'temp_id',
            'sales_order_detail_qty_order' => 'temp_qty',
            'sales_order_detail_price_order' => 'temp_price',
            // 'sales_order_detail_total_order' => 'temp_total',
        ]
    ];
    public $grouping = [];

    public function saveDetailRepository($id, array $data)
    {
        if (!$this->detail_table) {
            return Notes::error('table detail not set');
        }
        try {
            $data[$this->mapping['primary']] = $id;
            $data['sales_order_detail_total_order'] = $data['sales_order_detail_qty_order'] * $data['sales_order_detail_price_order'];
            DB::table($this->detail_table)->insert($data);
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
            $data['sales_order_detail_total_order'] = $data['sales_order_detail_qty_order'] * $data['sales_order_detail_price_order'];
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
