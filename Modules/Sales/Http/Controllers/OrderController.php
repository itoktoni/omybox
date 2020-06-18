<?php

namespace Modules\Sales\Http\Controllers;

use PDF;
use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\TransactionService;
use Modules\Sales\Http\Services\OrderService;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Finance\Dao\Repositories\AccountRepository;
use Modules\Sales\Dao\Repositories\OrderCreateRepository;
use Modules\Production\Dao\Repositories\WorkOrderCreateRepository;
use Modules\Forwarder\Dao\Repositories\VendorRepository as ForwarderRepository;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Production\Dao\Repositories\VendorRepository as ProductionRepository;
use Modules\Sales\Dao\Models\OrderDelivery;
use Modules\Sales\Dao\Repositories\OrderDeliveryRepository;
use Modules\Sales\Dao\Repositories\OrderPrepareRepository;

class OrderController extends Controller
{
    public $template;
    public $folder;
    public static $model;
    public static $detail;
    public static $prepare;
    public static $delivery;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new OrderRepository();
        }
        if (self::$detail == null) {
            self::$detail = new OrderCreateRepository();
        }
        if (self::$prepare == null) {
            self::$prepare = new OrderPrepareRepository();
        }
        if (self::$delivery == null) {
            self::$delivery = new OrderDeliveryRepository();
        }
        $this->folder = 'sales';
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $customer = Helper::createOption((new CustomerRepository()));
        $forwarder = Helper::createOption((new ForwarderRepository()));
        $product = Helper::createOption((new ProductRepository()), false, true);
        $account = Helper::createOption((new AccountRepository()));
        $bank = Helper::createOption((new BankRepository()));
        $status = Helper::shareStatus(self::$model->status);

        $view = [
            'key'       => self::$model->getKeyName(),
            'customer'      => $customer,
            'forwarder'  => $forwarder,
            'product'  => $product,
            'account'  => $account,
            'bank'  => $bank,
            'status'  => $status,
        ];

        return array_merge($view, $data);
    }

    public function create(OrderService $service)
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
            'customer' => [0 => 'Customer Cash'],
            'model' => self::$model,
        ]));
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {

            $data = $service->show(self::$model, ['detail', 'detail.product', 'province', 'city', 'area']);
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'detail'       => $data->detail,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function prepare(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$prepare);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model, ['detail', 'detail.product', 'province', 'city', 'area']);
            $stock = new StockRepository();
            $product = $data->detail->pluck('sales_order_detail_option')->toArray();
            $data_stock = $stock->dataStockRepository($product)->get();

            $collection = collect(self::$model->status);
            $status = $collection->forget([1, 2, 4, 0])->toArray();

            $delivery = OrderDelivery::whereIn('so_delivery_option', $product)->where('so_delivery_order', request()->get('code'))->get();
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model'        => $data,
                'stock'        => $data_stock,
                'detail'       => $data->detail,
                'delivery'       => $delivery,
                'status' => Helper::shareStatus($status),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function print_prepare_do(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product']);

            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), $pasing);
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
        }
    }

    public function print_do(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'forwarder' => $data->forwarder,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint('print_do', $this->folder), $pasing);
            return $pdf->stream();

            // return $pdf->download($id . '.pdf');
        }
    }

    public function do(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            request()->validate([
                'sales_order_rajaongkir_waybill' => 'required'
            ], [
                'sales_order_rajaongkir_waybill.required' => 'Masukan No Resi'
            ]);
            $post = $service->update(self::$delivery);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {

            $data = $service->show(self::$model, ['detail', 'detail.product', 'province', 'city', 'area']);
            $collection = collect(self::$model->status);
            $status = $collection->forget([1, 2, 0])->toArray();

            return view(Helper::setViewForm($this->template, 'delivery', $this->folder))->with($this->share([
                'model'        => $data,
                'detail'       => $data->detail,
                'status' => Helper::shareStatus($status),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function show_do(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            return view(Helper::setViewShow($this->template, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'detail'  => $data->detail,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }

    public function payment(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {

            $data = $service->show(self::$model, ['payment', 'payment.account']);
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model'        => $data,
                'detail'        => $data->payment,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function print_payment(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'forwarder' => $data->forwarder,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint('print_order', $this->folder), $pasing);
            return $pdf->download($id . '.pdf');
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
                ->setRaw(['sales_order_status', 'sales_order_total', 'sales_order_rajaongkir_service'])
                ->setAction(
                    [
                        'payment' => ['success', 'payment'],
                        'work_order' => ['primary', 'prepare'],
                    ]
                )
                ->datatable(self::$model);
            $datatable->editColumn('sales_order_status', function ($field) {
                return Helper::createStatus([
                    'value'  => $field->sales_order_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->editColumn('sales_order_date', function ($field) {
                return $field->sales_order_date->toDateString();
            });
            $datatable->editColumn('sales_order_rajaongkir_service', function ($field) {
                return 'Courier ' . strtoupper($field->sales_order_rajaongkir_courier) . ' <br> ' . str_replace(') ', ' ', $field->sales_order_rajaongkir_service) . ' <br> Weight ' . number_format(floatval($field->sales_order_rajaongkir_weight)) . ' g';
            });
            $datatable->editColumn('sales_order_total', function ($field) {
                if (!Auth::user()->group_user == 'warehouse') {
                    return Helper::createTotal($field->sales_order_total);
                }
            });
            $module = $this->getModule();
            $datatable->editColumn('action', function ($select) use ($module) {

                $header = '<div class="action text-center">';
                if (Auth::user()->group_user == 'warehouse') {
                    $print = '<a target="_blank" class="btn btn-danger btn-xs" href="' . route($module . '_print_prepare_do', ['code' => $select->sales_order_id]) . '">print</a> ';
                    $prepare = '<a class="btn btn-success btn-xs" href="' . route($module . '_prepare', ['code' => $select->sales_order_id]) . '">prepare</a>';
                    $do = '<a class="btn btn-primary btn-xs" href="' . route($module . '_do', ['code' => $select->sales_order_id]) . '">delivery</a>';

                    $html = $header . $print . $prepare . $do . '</div>';
                } else {

                    $payment = '<a target="_blank" class="btn btn-success btn-xs" href="' . route('finance_payment_update', ['so' => $select->sales_order_id]) . '">payment</a> ';
                    $update = '<a class="btn btn-primary btn-xs" href="' . route($module . '_update', ['code' => $select->sales_order_id]) . '">update</a>';
                    $html = $header . $payment . $update . '</div>';
                }
                return $html;
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
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            return view(Helper::setViewShow($this->template, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'detail'  => $data->detail,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }

    public function print_order(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'detail' => $data->detail,
            ];

            // return view(Helper::setViewPrint('print_sales_order', $this->folder))->with($pasing);

            $pdf = PDF::loadView(Helper::setViewPrint('print_sales_order', $this->folder), $pasing);
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
        }
    }

    public function work_order(OrderService $service, WorkOrderCreateRepository $work_order)
    {
        if (request()->isMethod('POST')) {
            $post = $service->saveWo($work_order);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {
            $code = request()->get('code');
            $data = $service->show(self::$model);
            $detail = self::$model->split($code)->get();
            $sales_order = $work_order->getDetailBySalesOrder($code)->get();
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model'        => $data,
                'production'   => Helper::createOption((new ProductionRepository()), false, true),
                'detail'       => $detail,
                'sales_order'  => $sales_order,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }
}
