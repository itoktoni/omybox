<?php

namespace Modules\Procurement\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Modules\Procurement\Dao\Repositories\UnitRepository;

class UnitController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new UnitRepository();
        }
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $unit = Helper::createOption((new UnitRepository()));
        $product = Helper::createOption((new UnitRepository()));
        $operator = [
            '' => 'Choose Operation',
            '/' => 'Pembagian',
            '*' => 'Perkalian',
            '+' => 'Penambahan',
            '-' => 'Pengurangan',
        ];

        $view = [
            'key'       => self::$model->getKeyName(),
            'unit'      => $unit,
            'operator'      => $operator,
            'product'   => $product,
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

            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
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
