<?php

namespace Modules\Sales\Dao\Repositories;

use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Models\Stock;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Sales\Dao\Models\OrderDelivery;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Repositories\OrderRepository;

class OrderPrepareRepository extends OrderRepository implements MasterInterface
{
    public $data;
    public $mapping  = [
        'primary' => 'so_delivery_order',
        'foreign' => 'so_delivery_barcode',
        'detail' => [
            'so_delivery_order' => 'temp_order',
            'so_delivery_barcode' => 'temp_barcode',
            'so_delivery_qty' => 'temp_stock',
            'order' => 'temp_qty',
            'ori' => 'temp_ori',
            'so_delivery_option' =>  'temp_option',
        ]
    ];
    public $grouping = [];

    public function updateDetailRepository($id, array $data)
    {
        try {
            $where = [
                $this->mapping['primary'] => $id,
                $this->mapping['foreign'] => $data[$this->mapping['foreign']],
            ];
            $item = [];
            $order = $data['so_delivery_order'];
            $barcode = $data['so_delivery_barcode'];
            $stock = $data['so_delivery_qty'];
            $qty = $data['order'];
            $ori = $data['ori'];
            $option = $data['so_delivery_option'];
            if (!empty($stock)) {

                if ($ori == $stock) {
                    $exist = OrderDelivery::where('so_delivery_order', $order)->where('so_delivery_barcode', $barcode)->first();
                    if (!$exist) {

                        $delivery = OrderDelivery::where('so_delivery_order', $order)->where('so_delivery_option', $option)->get();
                        $total = $delivery->sum('so_delivery_qty') + $stock;
                        if ($qty >= $total) {

                            $item['so_delivery_order'] = $order;
                            $item['so_delivery_barcode'] = $barcode;
                            $item['so_delivery_qty'] = $stock;
                            $item['so_delivery_option'] = $option;

                            $check = OrderDelivery::updateOrInsert($where, $item);
                            $check = OrderDetail::where(
                                'sales_order_detail_sales_order_id',
                                $order
                            )->where('sales_order_detail_option', $option)->update([
                                'sales_order_detail_qty_prepare' => $total
                            ]);

                            Stock::where('item_stock_barcode', $barcode)->update(['item_stock_qty' => '0']);
                        } else {
                            return Notes::error('Stock Prepare more than Order');
                        }
                    }
                } else {
                    return Notes::error('Stock and Input not match');
                }
            }

            return Notes::create('true');
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
