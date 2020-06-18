<?php

namespace Modules\Item\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Item\Dao\Models\Product;

class StockRepository extends Stock implements MasterInterface
{
    public function dataRepository()
    {
        $product = new ProductRepository();
        $table = $product->select([DB::raw('IFNULL(view_stock_product.id, item_product.item_product_id) AS item_product_id'), 'item_color_name', 'item_product_name', 'view_stock_product.*'])
            ->leftJoin('view_stock_product', 'product', 'item_product_id')
            ->leftJoin('item_color', 'color', 'item_color_id')->orderBy('qty', 'DESC');
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
        return DB::table('view_stock')->where(['item_product_id' => $id])->first();
    }

    public function barcodeRepository($id, $relation = null)
    {
        return $this->where('item_stock_barcode', $id)->first();
    }

    public function multibarcodeRepository($id, $relation = null)
    {
        return $this->where('item_stock_batch', $id)->get();
    }

    public function stockDetailRepository($product, $color = null, $size = null)
    {
        if ($color && $size) {
            $data = $this->where([
                'item_stock_product' => $product,
                'item_stock_color' => $color,
                'item_stock_size' => $size,
            ]);
        } else if ($color && !$size) {
            $data = $this->where([
                'item_stock_product' => $product,
                'item_stock_color' => $color,
            ]);
        } else if (!$color && $size) {
            $data = $this->where([
                'item_stock_product' => $product,
                'item_stock_size' => $size,
            ]);
        } else {
            $data = $this->where('item_stock_product', $product)->where('item_stock_size', '!=', '')->where('item_stock_color', '!=', '');
        }
        return $data->get();
    }
}
