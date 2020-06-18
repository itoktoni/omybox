<?php

namespace Modules\Forwarder\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Modules\Forwarder\Dao\Models\Tax;
use Modules\Product\Models\Currency;
use Modules\Forwarder\Dao\Models\Product;
use Modules\Forwarder\Dao\Models\Category;
use App\Dao\Interfaces\MasterInterface;

class ProductRepository extends Product implements MasterInterface
{
    public $searching = 'forwarder_product_name';
    private static $tax;
    private static $category;
    private static $currency;

    public static function getCategory()
    {
        if (self::$category == null) {
            self::$category = new Category();
        }

        return self::$category;
    }

    public static function getCurrency()
    {
        if (self::$currency == null) {
            self::$currency = new Currency();
        }

        return self::$currency;
    }

    public static function getTax()
    {
        if (self::$tax == null) {
            self::$tax = new Tax();
        }

        return self::$tax;
    }

    public static function boot()
    {
        parent::boot();
        parent::saving(function ($model) {
            $model->forwarder_product_created_by = auth()->user()->username;
            $model->forwarder_product_updated_by = auth()->user()->username;
        });
    }

    public function dataRepository()
    {
        $category = self::getCategory();
        $currency = self::getCurrency();
        $tax = self::getTax();
        $list = Helper::dataColumn($this->datatable, $this->primaryKey);
        $query = $this->select($list)
            ->leftJoin($category->getTable(), $category->getKeyName(), 'forwarder_product_category_id')
            ->leftJoin($currency->getTable(), $currency->getKeyName(), 'forwarder_product_currency_id')
            ->leftJoin($tax->getTable(), $tax->getKeyName(), 'forwarder_product_tax_id')
            ->orderBy($this->searching, 'asc');

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

    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }
}
