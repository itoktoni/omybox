<?php

namespace Modules\Production\Http\Controllers;

use PDF;
use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Services\TransactionService;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Production\Dao\Models\WorkOrderDetailProgress;
use Modules\Production\Dao\Repositories\VendorRepository;
use Modules\Production\Dao\Repositories\WorkOrderCreateRepository;
use Modules\Production\Dao\Repositories\WorkOrderProgressRepository;
use Modules\Production\Dao\Repositories\WorkOrderRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Http\Services\WorkOrderService;

class WorkOrderController extends Controller
{
    public $template;
    public $folder;
    public static $model;
    public static $detail;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new WorkOrderRepository();
        }
        if (self::$detail == null) {
            self::$detail = new WorkOrderCreateRepository();
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
        $order = (new OrderRepository())->getStatusCreate();
        $vendor = Helper::createOption((new VendorRepository()));
        $product = Helper::createOption((new ProductRepository()), false, true);

        $view = [
            'key'       => self::$model->getKeyName(),
            'order'      => $order,
            'vendor'  => $vendor,
            'product'  => $product,
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

    public function detail()
    {
        return true;
    }

    public function update(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            dd(request()->all());
            $post = $service->update(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product']);
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'detail'        => $data->detail,
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
            $datatable = $service
                ->setRaw(['production_work_order_status'])
                ->setAction(
                    [
                        'update' => ['primary', 'edit'],
                        'show'   => ['success', 'show'],
                    ]
                )
                ->datatable(self::$model);
            $datatable->editColumn('production_work_order_status', function ($field) {
                return Helper::createStatus([
                    'value'  => $field->production_work_order_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->editColumn('production_work_order_date', function ($field) {
                return $field->production_work_order_date->toDateString();
            });
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['vendor', 'sales_order', 'detail', 'detail.product']);
            return view(Helper::setViewShow($this->template, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'detail'  => $data->detail,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }

    public function survey(WorkOrderService $service)
    {
        $progress = new WorkOrderProgressRepository();
        if (request()->isMethod('POST')) {

            $post = $service->save($progress);
            if ($post['status']) {
                return Response::redirectBack();
            }
            return Response::redirectBackWithInput();
        }

        if (request()->has('code') && request()->has('detail')) {
            $data = $service->show($progress);
            $detail = $service->progress($progress);
            $status = $progress->getModel()->status;
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'detail'   => $detail,
                'status'   => $status,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }

    public function print_order(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['vendor', 'sales_order', 'detail', 'detail.product']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'vendor' => $data->vendor,
                'sales_order' => $data->sales_order,
                'detail' => $data->detail,
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_order', $this->folder), $pasing);
            return $pdf->download($id . '.pdf');
        }
    }
}
