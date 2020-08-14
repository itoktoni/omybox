<?php

namespace Modules\Item\Http\Controllers;

use App\User;
use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use Modules\Item\Dao\Repositories\BrandRepository;

class BrandController extends Controller
{
    public $template;
    public $folder;

    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new BrandRepository();
        }
        $this->folder = 'Item';
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $user = User::all();
        $user->where('email', 'itok.toni@gmail.com');
        if (Auth::user()->group_user == 'partner') {
           
           $user = $user->where('email', Auth::user()->email);
        }
        $filter = $user->pluck('name', 'email')->prepend('- Select User Login -', '');
        $view = [
            'template' => $this->template,
            'user' => $filter,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model);
        }
        return view(Helper::setViewCreate($this->template, $this->folder))->with($this->share());
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);

            return view(Helper::setViewUpdate($this->template, $this->folder))->with($this->share([
                'model'        => $data,
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
            return view(Helper::setViewShow($this->template, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
