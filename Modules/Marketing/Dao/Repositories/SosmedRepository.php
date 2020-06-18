<?php

namespace Modules\Marketing\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Modules\Marketing\Dao\Models\Sosmed;
use App\Dao\Interfaces\MasterInterface;

class SosmedRepository extends Sosmed implements MasterInterface
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
            return $this->with($relation)->where('marketing_sosmed_slug', $slug)->firstOrFail();
        }
        return $this->where('marketing_sosmed_slug', $slug)->firstOrFail();
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

    public static function boot()
    {
        parent::boot();

        parent::saving(function ($model) {
            if (Cache::has('marketing_sosmed_api')) {
                Cache::forget('marketing_sosmed_api');
            }
        });

        parent::deleting(function ($model) {
            if (Cache::has('marketing_sosmed_api')) {
                Cache::forget('marketing_sosmed_api');
            }
        });
    }
}
