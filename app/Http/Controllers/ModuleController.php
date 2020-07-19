<?php

namespace App\Http\Controllers;

use Helper;
use Plugin\Response;
use App\Dao\Repositories\ModuleRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Services\MasterService;
use App\Dao\Repositories\GroupModuleRepository;
use App\Dao\Repositories\ModuleActionRepository;
use App\Http\Services\CoreService;

class ModuleController extends Controller
{
    public $template;
    public $render;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ModuleRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
        $this->render    = 'page.' . $this->template . '.';
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

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model);
            Response::redirectBack();
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service, GroupModuleRepository $group, CoreService $core, ModuleActionRepository $module_action)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model);
            $core->saveConnectionAction($module_action);
            $core->saveGroupModule($module_action);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $id   = request()->get('code');
            $data = $service->show(self::$model);

            $controller = $data->module_controller;

            if (!empty($data->module_folder)) {
                $parse = Helper::getMethod($controller, $data->module_folder);
            } else {
                $parse = Helper::getMethod($controller);
            }
            foreach ($parse as $c) {

                $status = $module_action->checkModuleConnectionAction($id . '_' . $c, $id);
                $item[] = [
                    'code'   => $c,
                    'status' => $status,
                ];
            }

            return view($this->render . __FUNCTION__)->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName(),
                'data_group' => $group->getGroupByModule($id)->get(),
                'list_group' => $group->dataRepository()->get(),
                'controller' => $controller,
                'act'        => $item,
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
            return $service->datatable(self::$model)->make(true);
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
