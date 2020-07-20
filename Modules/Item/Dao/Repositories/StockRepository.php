<?php

namespace Modules\Item\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Procurement\Dao\Repositories\UnitRepository;
use Modules\Procurement\Dao\Repositories\ProductRepository;

class StockRepository extends Stock implements MasterInterface
{
    public function dataRepository($product = null)
    {
        $product = new ProductRepository();
        $unit = new UnitRepository();

        $list = [
            'item_stock_product',
            'procurement_product_name',
            'item_stock_barcode',
            'procurement_unit_name',
            DB::raw('sum(item_stock_qty) as qty'),
        ];
        $table = $this->select($list)
            ->leftJoin($product->getTable(), 'item_stock_product', 'procurement_product_id')
            ->leftJoin($unit->getTable(), $unit->getKeyName(), 'procurement_product_unit_id')
            ->groupBy('item_stock_product');
        // ->orderBy('item_stock_qty', 'DESC');
        return $table;
    }

    public function dataRealRepository()
    {
        $table = $this->leftJoin('item_product', 'item_product_id', 'item_stock_product')
            ->leftJoin('item_color', 'item_stock_color', 'item_color_id')->orderBy('item_stock_qty', 'DESC');
        return $table;
    }

    public function dataStockRepository($product = [])
    {
        $table = $this->select(['item_stock.*', 'item_color_name', 'item_product_name', 'item_product_name'])
            ->join('item_product', 'item_product_id', 'item_stock_product')
            ->leftJoin('item_color', 'item_stock_color', 'item_color_id');
        if ($product) {
            if (is_array($product)) {
                $table->whereIn('item_stock_option', $product);
            } elseif (is_string($product)) {
                $table->where('item_stock_option', $product);
            }
        }
        return $table->orderBy('item_stock_qty', 'ASC');
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
        } catch (QueryException $ex) {
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

    public function slugRepository($slug, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->where('item_brand_slug', $slug)->firstOrFail();
        }
        return $this->where('item_brand_slug', $slug)->firstOrFail();
    }


    public function showRepository($id, $relation = null)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function stockRepository($id)
    {
        return $this->where(['item_stock_product' => $id])->first();
    }

    public function barcodeRepository($id, $relation = null)
    {
        return $this->where('item_stock_barcode', $id)->first();
    }

    public function multibarcodeRepository($id, $relation = null)
    {
        return $this->where('item_stock_batch', $id)->get();
    }

    public function stockDetailRepository($product)
    {
        $data = $this->where('item_stock_product', $product);
        return $data->get();
    }
}
