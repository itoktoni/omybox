<?php

namespace Modules\Item\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Brand;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Category;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Production\Dao\Models\Vendor;

class ProductRepository extends Product implements MasterInterface
{
    private static $brand;
    private static $category;

    public static function getBrand()
    {
        if (self::$brand == null) {
            self::$brand = new Brand();
        }

        return self::$brand;
    }

    public static function getCategory()
    {
        if (self::$category == null) {
            self::$category = new Category();
        }

        return self::$category;
    }

    public function dataRepository()
    {
        $brand = self::getBrand();
        $category = self::getCategory();
        $list = Helper::dataColumn($this->datatable, $this->primaryKey);
        $query = $this->select($list)
            ->leftJoin('item_wishlist', 'item_wishlist_item_product_id', 'item_product_id')
            ->leftJoin($brand->getTable(), $brand->getKeyName(), 'item_product_item_brand_id')
            ->leftJoin($category->getTable(), $category->getKeyName(), 'item_product_item_category_id');
        return $query;
    }

    public function stockRepository()
    {
        $brand = self::getBrand();
        $category = self::getCategory();
        $color = new ColorRepository();

        $list = Helper::dataColumn($this->stock, $this->primaryKey);
        $query = $this->select($list)
            ->leftJoin('view_stock_product', 'product', 'item_product_id')
            ->leftJoin($brand->getTable(), $brand->getKeyName(), 'item_product_item_brand_id')
            ->leftJoin($color->getTable(), $color->getKeyName(), 'color')
            ->leftJoin($category->getTable(), $category->getKeyName(), 'item_product_item_category_id')
            ->orderBy('item_product_created_at', 'DESC')->orderBy('item_product_name', 'ASC');
        return $query;
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

    public function deleteImageDetail($id)
    {
        return DB::table('item_product_image')->where('item_product_image_file', $id)->delete();
    }

    public function getImageDetail($id)
    {
        return DB::table('item_product_image')->where('item_product_image_item_product_id', $id)->get();
    }

    public function saveImageDetail($id, $image)
    {
        DB::table('item_product_image')->insert([
            'item_product_image_item_product_id' => $id,
            'item_product_image_file' => $image,
        ]);
    }

    public function slugRepository($slug, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->where('item_product_slug', $slug)->firstOrFail();
        }
        return $this->where('item_product_slug', $slug)->firstOrFail();
    }

    public function showRepository($id, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function getBestSeller(){
        return $this->where('item_product_display', '1')->limit(6);
    }
}
