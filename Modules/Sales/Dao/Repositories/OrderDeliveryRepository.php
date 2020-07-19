<?php

namespace Modules\Sales\Dao\Repositories;

use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Sales\Dao\Models\OrderDelivery;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Repositories\OrderRepository;

class OrderDeliveryRepository extends OrderRepository implements MasterInterface
{
    public $data;
    public $mapping  = [
        'primary' => 'so_delivery_order',
        'foreign' => 'so_delivery_option',
        'detail' => [
            'so_delivery_order' => 'temp_order',
            'so_delivery_option' => 'temp_option',
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

            $delivery = OrderDelivery::where($where)->get();
            foreach ($delivery as $value) {
                $barcode = $value->so_delivery_barcode;
            }

            return Notes::create('true');
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
