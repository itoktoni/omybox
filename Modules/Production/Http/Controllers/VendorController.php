<?php

namespace Modules\Production\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Production\Dao\Repositories\VendorDetailRepository;
use Modules\Production\Dao\Repositories\VendorRepository;
use App\Http\Services\TransactionService;

class VendorController extends Controller
{
    public $template;
    public $folder;
    public static $model;
    public static $detail;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new VendorRepository();
        }
        if (self::$detail == null) {
            self::$detail = new VendorDetailRepository();
        }
        $this->folder = 'production';
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $product = Helper::createOption((new ProductRepository()), false, true);

        $view = [
            'product' => $product,
            'key' => self::$model->getKeyName(),
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function create(TransactionService $service)
    {
        if (request()->isMethod('POST')) {
            $post = $service->save(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'data_product' => [],
            'model' => self::$model,
        ]));
    }

    public function update(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            $detail = self::$model->detail($data->{$data->getKeyName()});
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'detail'        => self::$model->detail($data->{$data->getKeyName()})->get(),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete(TransactionService $service)
    {
        $check = $service->delete(self::$detail);
        if ($check['data'] == 'master') {
            return Response::redirectBack();
        }
        return Response::redirectToRoute(config('module') . '_update', ['code' => request()->get('code')]);
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
