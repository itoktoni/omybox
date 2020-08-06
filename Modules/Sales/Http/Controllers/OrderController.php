<?php

namespace Modules\Sales\Http\Controllers;

use PDF;
use Plugin\Helper;
use Plugin\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use Modules\Finance\Dao\Models\Payment;
use App\Http\Services\TransactionService;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Models\OrderDelivery;
use Modules\Sales\Http\Services\OrderService;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Finance\Dao\Repositories\AccountRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Sales\Dao\Repositories\OrderCreateRepository;
use Modules\Sales\Dao\Repositories\OrderPrepareRepository;
use Modules\Sales\Dao\Repositories\OrderDeliveryRepository;
use Modules\Production\Dao\Repositories\WorkOrderCreateRepository;
use Modules\Forwarder\Dao\Repositories\VendorRepository as ForwarderRepository;
use Modules\Production\Dao\Repositories\VendorRepository as ProductionRepository;

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
        $promo = Helper::createOption((new PromoRepository()), false, true);
        // dd($promo);
        $status = Helper::shareStatus(self::$model->status);

        $view = [
            'key'       => self::$model->getKeyName(),
            'customer'      => $customer,
            'forwarder'  => $forwarder,
            'product'  => $product,
            'account'  => $account,
            'promo'  => $promo,
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
                return Response::redirectToRoute($this->getModule() . '_update', ['code' => $post['data']->sales_order_id]);
            }
            return Response::redirectBackWithInput();
        }

        $collection = collect(Helper::shareStatus(self::$model->status));
        $status = $collection->only([1])->toArray();

        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'data_product' => [],
            'customer' => [0 => 'Customer Cash'],
            'model' => self::$model,
            'status' => $status,
        ]));
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $post = $service->update(self::$detail);
            foreach (request()->get('detail') as $value) {
                $parse = request()->get('brand');
                $brand_id = $value['temp_brand_id'];
                $update = [
                    'sales_order_detail_ongkir' => isset($parse[$brand_id]) ? Helper::filterInput($parse[$brand_id]['temp_brand_ongkir']) : 0,
                    'sales_order_detail_waybill' => isset($parse[$brand_id]) ? $parse[$brand_id]['temp_brand_waybill'] : '',
                ];
                DB::table(self::$model->detail_table)->where([
                    'sales_order_detail_sales_order_id' => $value['temp_order_id'],
                    'sales_order_detail_item_product_id' => $value['temp_product_id'],
                ])->update($update);
            }

            $total_ongkir = 0;
            foreach (request()->get('brand') as $ongkir) {
                $brand_ongkir = Helper::filterInput($ongkir['temp_brand_ongkir']);
                $total_ongkir = $total_ongkir + $brand_ongkir;
            }
            OrderRepository::find(request()->get('code'))->update([
                'sales_order_rajaongkir_ongkir' => $total_ongkir
            ]);

            if (request()->get('paid') == 1 && request()->get('sales_order_status') == 2) {
                DB::table((new Payment())->getTable())->updateOrInsert([
                'finance_payment_from' => 'Automatic',
                'finance_payment_to' => 'Automatic',
                'finance_payment_sales_order_id' => request()->get('code'),
                'finance_payment_account_id' => '1',
                'finance_payment_date' => date('Y-m-d'),
                'finance_payment_person' => request()->get('sales_order_rajaongkir_name'),
                'finance_payment_phone' => request()->get('sales_order_rajaongkir_phone'),
                'finance_payment_amount' => request()->get('total') + $total_ongkir,
                'finance_payment_description' => 'Automatic Paid From Create Order',
                'finance_payment_approve_amount' => request()->get('total') + $total_ongkir,
                'finance_payment_status' => '1',
                'finance_payment_paid' => '1',
                'finance_payment_voucher' => Helper::autoNumber('finance_payment', 'finance_payment_voucher', 'VC' . date('Ym'), 13),
                ]);

                OrderRepository::find(request()->get('code'))->update([
                    'sales_order_status' => 3
                ]);

                return redirect()->back();
            }


            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if ($code = request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product','detail.product.brand']);
            $brands = self::$model->brand()->where(self::$model->getKeyName(), request()->get('code'))->groupBy('item_brand_id')->get();
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'brands'        => $brands,
                'model'        => $data,
                'detail'       => $data->detail,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function prepare(TransactionService $service)
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
            $stock = new StockRepository();
            $product = $data->detail->pluck('sales_order_detail_option')->toArray();
            $data_stock = $stock->dataStockRepository($product)->get();

            $collection = collect(self::$model->status);
            $status = $collection->forget([1, 2, 3, 0])->toArray();

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
            $total = $data->detail->count();
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'detail' => $data->detail,
            ];

            if(!empty(config('website.header'))){

                $dom = new \DomDocument();
                $dom->loadHtml(config('website.header'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $paragrap = $dom->getElementsByTagName('p');
                $total = $total + ($paragrap->length ?? 0);

            }

            // return view(Helper::setViewPrint(__FUNCTION__, $this->folder))->with($this->share($pasing));
            $total = ($total * 15) + 450;

            $pdf = PDF::loadView(Helper::setViewPrint('thermal', $this->folder), $pasing)->setPaper(array( 0 , 0 , 226.77 , $total ));
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
            $module = $this->getModule();
            $datatable->editColumn('action', function ($select) use ($module) {
                $header = '<div class="action text-center">';
                if (Auth::user()->group_user == 'partner') {
                    $print = '<a target="_blank" class="btn btn-danger btn-xs" href="' . route($module . '_print_prepare_do', ['code' => $select->sales_order_id]) . '">print</a> ';
                    $prepare = '<a class="btn btn-success btn-xs" href="' . route($module . '_prepare', ['code' => $select->sales_order_id]) . '">prepare</a>';
                    
                    $html = $header . $print . $prepare . '</div>';
                } else {
                    $print = '<a target="_blank" class="btn btn-danger btn-xs" href="' . route($module . '_print_prepare_do', ['code' => $select->sales_order_id]) . '">print</a> ';
                    // $payment = '<a target="_blank" class="btn btn-success btn-xs" href="' . route('finance_payment_update', ['so' => $select->sales_order_id]) . '">payment</a> ';
                    $update = '<a class="btn btn-primary btn-xs" href="' . route($module . '_update', ['code' => $select->sales_order_id]) . '">update</a>';
                    $html = $header . $print . $update . '</div>';
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
