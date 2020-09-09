<?php

namespace Modules\Marketing\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Modules\Marketing\Dao\Models\Galery;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;

class GaleryRepository extends Galery implements MasterInterface
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
            return $this->with($relation)->where('marketing_galery_slug', $slug)->firstOrFail();
        }
        return $this->where('marketing_galery_slug', $slug)->firstOrFail();
    }

    public function showRepository($id, $relation = null)
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

            $file = 'marketing_galery_file';
            if (request()->has($file)) {
                $image = $model->marketing_galery_image;
                if ($image) {
                    Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                }

                $file = request()->file($file);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
                $model->marketing_galery_image = $name;
            }

             if (request()->has('tag_json')) {
                    $model->marketing_galery_tag = json_encode(request()->get('tag_json'));
                }


        });
    }
}
