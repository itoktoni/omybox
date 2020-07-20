<?php

namespace Modules\Sales\Dao\Repositories;

use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Inventory\Dao\Repositories\LocationRepository;

class OrderCreateRepository extends OrderRepository implements MasterInterface
{
    public $data;
    public $mapping  = [
        'primary' => 'sales_order_detail_sales_order_id',
        'foreign' => 'sales_order_detail_item_product_id',
        'detail' => [
            'sales_order_detail_item_product_id' =>  'temp_id',
            'sales_order_detail_qty_order' => 'temp_qty',
            'sales_order_detail_qty_prepare' => 'temp_prepare',
            'sales_order_detail_notes' => 'temp_notes',
            'sales_order_detail_price_order' => 'temp_price',
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
            $check = DB::table($this->detail_table)->insert($data);
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

            if (request()->get('sales_order_status') == 5) {
                $model_location = new LocationRepository();
                $location = $model_location->dataRepository()->where('inventory_warehouse_brand_id', Auth::user()->brand)->get();
                $data_location = $location->pluck('inventory_location_id')->toArray();


                $product = Product::find($data['sales_order_detail_item_product_id']);
                $material = $product->material ?? false;
                if ($material) {
                    foreach ($material as $materi) {
                        $stock = new Stock();
                        $pesanan = $data['sales_order_detail_qty_prepare'] * $materi->item_material_value;
                        $cek_stock = $stock->where('item_stock_product', $materi->item_material_procurement_product_id)->whereIn('item_stock_location', $data_location)->orderBy('item_stock_qty', 'DESC');
                        $single_stock = $cek_stock->first();
                        if ($single_stock) {
                            $jumlah = $cek_stock->sum('item_stock_qty');
                            if ($single_stock->item_stock_qty >= $pesanan) {
                                $pengurangan = $single_stock->item_stock_qty - $pesanan;
                            } elseif ($jumlah >= $pesanan) {
                                $pengurangan = $jumlah - $pesanan;
                                $stock->where('item_stock_product', $materi->item_material_procurement_product_id)->update(['item_stock_qty' => 0]);
                            } else {
                                $pengurangan = $jumlah - $pesanan;
                                $stock->where('item_stock_product', $materi->item_material_procurement_product_id)->update(['item_stock_qty' => 0]);
                            }
                            $stock->find($single_stock->item_stock_id)->update(['item_stock_qty' => $pengurangan]);
                        }
                    }
                }
            }
            
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
