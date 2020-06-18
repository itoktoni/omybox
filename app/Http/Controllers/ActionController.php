<?php

namespace App\Http\Controllers;

use Helper;
use Plugin\Response;
use App\Dao\Repositories\ActionRepository;
use App\Http\Services\CoreService;

class ActionController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ActionRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $view = [
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function create(CoreService $service)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model);
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(CoreService $service)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model);
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

    public function delete(CoreService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(CoreService $service)
    {
        if (request()->isMethod('POST')) {
            $service->raw = ['action_visible'];
            $datatable = $service->datatable(self::$model);
            $datatable->editColumn('action_visible', function ($select) {
                return Helper::createStatus([
                    'value'  => $select->action_visible,
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

    public function show(CoreService $service)
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
