<?php

namespace App\Http\Controllers;

use App\Dao\Repositories\GroupUserRepository;
use Helper;
use Plugin\Response;
use App\Dao\Repositories\TeamRepository;
use App\Http\Services\MasterService;

class TeamController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new TeamRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $status = Helper::shareStatus(self::$model->status)->prepend('- Select Status -', '');
        $group = Helper::shareOption((new GroupUserRepository()));
        $view = [
            'key'      => self::$model->getKeyName(),
            'template' => $this->template,
            'status' => $status,
            'group' => $group,
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

    public function update(MasterService $service)
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

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['active'])->datatable(self::$model);
            $datatable->editColumn('active', function ($select) {
                return Helper::createStatus([
                    'value'  => $select->active,
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
