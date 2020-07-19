<?php

namespace Modules\Procurement\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class PurchaseDetailRepository extends PurchaseRepository implements MasterInterface
{
    public static $detail;
    public $data;
    public $mapping  = [
        'primary' => 'purchase_detail_purchase_id',
        'foreign' => 'purchase_detail_option',
        'detail' => [
            'purchase_detail_item_product_id' =>  'temp_product',
            'purchase_detail_qty_order' => 'temp_qty',
            'purchase_detail_price_order' => 'temp_price',
            'purchase_detail_option' => 'temp_id',
            'purchase_detail_color_id' => 'temp_color',
            'purchase_detail_size' => 'temp_size',
            'purchase_detail_total_order' => 'temp_total',
        ]
    ];

    public function PurchaseDetailRepository()
    {
        if (self::$detail == null) {
            self::$detail = new PurchaseDetailRepository();
        }
    }

    public function saveDetailRepository($id, array $data)
    {
        try {
            $data[$this->mapping['primary']] = $id;
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
