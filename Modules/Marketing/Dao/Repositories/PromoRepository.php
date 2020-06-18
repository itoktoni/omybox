<?php

namespace Modules\Marketing\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Modules\Marketing\Dao\Models\Promo;
use App\Dao\Interfaces\MasterInterface;

class PromoRepository extends Promo implements MasterInterface
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
            return $this->with($relation)->where('marketing_promo_slug', $slug)->firstOrFail();
        }
        return $this->where('marketing_promo_slug', $slug)->firstOrFail();
    }

    public function codeRepository($code)
    {
        $date = date('Y-m-d');
        return $this->where([
            ['marketing_promo_code', '=', $code],
            ['marketing_promo_status', '=', 1],
            ['marketing_promo_start_date', '<=', $date],
            ['marketing_promo_end_date', '>=', $date],
        ])->first();
    }

    public function showRepository($id, $relation = false)
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
}
