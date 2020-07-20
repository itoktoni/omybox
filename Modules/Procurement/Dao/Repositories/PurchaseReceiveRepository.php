<?php

namespace Modules\Procurement\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class PurchaseReceiveRepository extends PurchaseRepository implements MasterInterface
{
    public static $detail;
    public $data;
    public $mapping  = [
        'primary' => 'purchase_detail_purchase_id',
        'foreign' => 'purchase_detail_item_product_id',
        'detail' => [
            'purchase_detail_item_product_id' => 'temp_id',
            'purchase_detail_location_id' => 'purchase_detail_location_id',
            'purchase_detail_qty_receive' => 'temp_receive',
        ]
    ];

    public function updateDetailRepository($id, array $data)
    {
        $check = false;
        try {
            $where = [
                $this->mapping['primary'] => $id,
                $this->mapping['foreign'] => $data[$this->mapping['foreign']],
            ];
            $item = [];
            if (request()->all()['purchase_status'] == 2 && !request()->get('action')) {
                $stock = new StockRepository();
                $number = 0;
                $batch = Helper::autoNumber($stock->getTable(), 'item_stock_batch', 'G' . date('Ymd'), config('website.autonumber'));
                foreach ($data as $key => $value) {
                    if ($key == 'purchase_detail_item_product_id') {
                        $item['item_stock_product'] = $value;
                    } elseif ($key == 'purchase_detail_location_id') {
                        if (!empty($value)) {
                            $item['item_stock_location'] = $value;
                        }
                    } elseif ($key == 'purchase_detail_qty_receive') {
                        $item['item_stock_qty'] = $value;
                    }
                    $item['item_stock_batch'] = $batch;
                }

               
                // dd($item);
                $check = $stock->saveRepository($item);
                // if ($check_stock['status'] && isset($check_stock['data']->item_stock_barcode)) {
                //     $data['purchase_detail_barcode'] = $check_stock['data']->item_stock_barcode;
                // }
            }

            // for ($i = 0; $i < $data['purchase_detail_qty_receive']; $i++) {
            //     $item['item_stock_qty'] = 1;
            //     $check_stock = $stock->saveRepository($item);
            // }

            // dd(DB::table($this->getTable())->find($id));
            $check = DB::table($this->detail_table)->updateOrInsert($where, $data);

            $update = ['purchase_status' => 3];
            DB::table($this->getTable())->where($this->getKeyName(), $id)->update($update);
            return Notes::create($check);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
