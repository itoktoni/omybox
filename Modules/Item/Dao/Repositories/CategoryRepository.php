<?php

namespace Modules\Item\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Str;
use Modules\Item\Dao\Models\Product;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Dao\Models\Category;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Repositories\ProductRepository;

class CategoryRepository extends Category implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
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
        } catch (QueryExceptionAlias $ex) {
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
            return $this->with($relation)->where('item_category_slug', $slug)->firstOrFail();
        }
        return $this->where('item_category_slug', $slug)->firstOrFail();
    }


    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function getDataIn($in)
    {
        return $this->whereIn($this->getKeyName(), $in)->get();
    }

    public function Product(){
        return $this->hasMany(Product::class, 'item_product_item_category_id');
        // return $this->leftJoin((new Product())->getTable(), 'item_product_item_category_id', 'item_category_id');
    }
}
