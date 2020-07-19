<?php

namespace Modules\Marketing\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use App\Http\Services\MasterService;
use App\User;

class PromoController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new PromoRepository();
        }
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $user = User::where('group_user', 'customer')->get();
        $view = [
            'template' => $this->template,
            'status' => Helper::shareStatus(self::$model->status),
            'default' => Helper::shareStatus(self::$model->default),
            'type' => Helper::shareStatus(self::$model->type),
            'user' => $user->pluck('name','email')->all(),
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $service->save(self::$model);
        }
        return view(Helper::setViewCreate())->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $data = $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);

            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['marketing_promo_image', 'marketing_promo_status', 'marketing_promo_default'])->datatable(self::$model);
            $datatable->editColumn('marketing_promo_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->marketing_promo_image);
            });
            $datatable->editColumn('marketing_promo_default', function ($data) {
                return Helper::createStatus([
                    'value'  => $data->marketing_promo_default,
                    'status' => self::$model->default,
                ]);
            });
            $datatable->editColumn('marketing_promo_status', function ($data) {
                return Helper::createStatus([
                    'value'  => $data->marketing_promo_status,
                    'status' => self::$model->status,
                ]);
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
