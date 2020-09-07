<?php

namespace Modules\Marketing\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Marketing\Dao\Repositories\GaleryRepository;

class GaleryController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new GaleryRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $tag = Helper::shareTag((new TagRepository()), 'item_tag_slug');

        $view = [
            'template' => $this->template,
            'tag' => $tag,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model);
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);
            $tag = [];
            $a = 'How are you?';

            if (strpos($data->marketing_galery_tag, '[') !== false) {
                $tag = json_decode($data->marketing_galery_tag);
            }
            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'data_tag'     => $tag,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();
        ;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['marketing_galery_image', 'marketing_galery_order'])->datatable(self::$model);
            $datatable->editColumn('marketing_galery_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->marketing_galery_image);
            });
            $datatable->editColumn('marketing_galery_order', function ($select) {
                return Helper::createNumber($select->marketing_galery_order);
            });
            $datatable->editColumn('marketing_galery_tag', function ($select) {
                return Helper::createTag($select->marketing_galery_tag);
            });
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
