<?php

namespace App\Http\Controllers;

use Helper;
use Plugin\Alert;
use Plugin\Notes;
use Plugin\Response;
use App\Dao\Models\GroupUser;
use App\Http\Services\CoreService;
use App\Http\Services\MasterService;
use App\Dao\Repositories\GroupUserRepository;
use App\Dao\Repositories\GroupModuleRepository;

class GroupUserController extends Controller
{
    public $template;
    public $render;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new GroupUserRepository();
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
        $group = Helper::createOption((new GroupModuleRepository()), false, true, false)
            ->pluck('group_module_name', 'group_module_code')
            ->prepend('- Select Group -', '');

        $view = [
            'key'       => self::$model->getKeyName(),
            'template'  => $this->template,
            'group'     => $group,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $request = request()->all();
            request()->validate(self::$model->rules);
            $data = GroupUser::create($request);
            // $data = $service->save(self::$model);
            Response::redirectBack();
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(CoreService $service)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model);
            $service->saveGroupModuleWithUser(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $id   = request()->get('code');
            $data = $service->show(self::$model);

            return view($this->render . __FUNCTION__)->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName(),
                'group_module'  => self::$model->getGroupByUser($id)->get()->pluck('group_module_code')->toArray(),
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
