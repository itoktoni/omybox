<?php

namespace App\Http\Controllers;

use Helper;
use Plugin\Response;
use App\Http\Services\MasterService;
use App\Dao\Repositories\GroupModuleRepository;
use App\Dao\Repositories\ModuleActionRepository;
use App\Http\Services\CoreService;

class GroupModuleController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new GroupModuleRepository();
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
            'key' =>    self::$model->getKeyName(),
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $service->save(self::$model);
            Response::redirectBack();
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(CoreService $service, ModuleActionRepository $module_action)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model);
            $service->saveConnectionModuleAction($module_action);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            return view(Helper::setViewUpdate(config('module')))->with($this->share([
                'model'       => $data,
                'list_module' => $service->getGroupModuleModule($data),
                'data_module' => $service->getGroupModuleModuleActive($data),
                'list_action' => $service->getGroupModuleAction($data),
                'controller'  => $service->getGroupModuleController($data),
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['group_module_enable'])->datatable(self::$model);
            $datatable->editColumn('group_module_enable', function ($select) {
                return Helper::createStatus([
                    'value'  => $select->group_module_enable,
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
