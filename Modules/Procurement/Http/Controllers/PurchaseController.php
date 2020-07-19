<?php

namespace Modules\Procurement\Http\Controllers;

use PDF;
use Plugin\Helper;
use Plugin\Alert;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\TransactionService;
use Modules\Inventory\Dao\Models\Location;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Inventory\Dao\Repositories\LocationRepository;
use Modules\Procurement\Dao\Repositories\VendorRepository;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;
use Modules\Procurement\Dao\Repositories\PurchaseDetailRepository;
use Modules\Procurement\Dao\Repositories\PurchasePrepareRepository;
use Modules\Procurement\Dao\Repositories\PurchaseReceiveRepository;

class PurchaseController extends Controller
{
    public $template;
    public $folder;
    public static $model;
    public static $detail;
    public static $prepare;
    public static $receive;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new PurchaseRepository();
        }
        if (self::$detail == null) {
            self::$detail = new PurchaseDetailRepository();
        }
        if (self::$prepare == null) {
            self::$prepare = new PurchasePrepareRepository();
        }
        if (self::$receive == null) {
            self::$receive = new PurchaseReceiveRepository();
        }
        $this->folder = 'procurement';
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $product = Helper::createOption((new ProductRepository()), false, true);
        $vendor = Helper::createOption((new VendorRepository()));
        $color = Helper::createOption((new ColorRepository()));
        $size = Helper::createOption((new SizeRepository()), false);
        $status = Helper::shareStatus(self::$model->status);
        $view = [
            'product' => $product,
            'vendor' => $vendor,
            'color' => $color,
            'size' => $size,
            'status' => $status,
            'key' => self::$model->getKeyName(),
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function create(TransactionService $service)
    {
        if (request()->isMethod('POST')) {
            $post = $service->setPrefix('PO')->save(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'data_product' => [],
            'model' => self::$model,
            'status' => [1 => 'Create']
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
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function prepare(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$prepare);
            if ($post['data']['purchase_status'] == '3') {
                return redirect()->back();
            }
            return Response::redirectBackWithInput();
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            $collection = collect(self::$model->status);
            $status = $collection->forget([1, 4, 5])->toArray();
            $vendor = Helper::createOption((new VendorRepository()), false, true)->where('procurement_vendor_email', Auth::user()->email)->pluck('procurement_vendor_name', 'procurement_vendor_id');
            return view(Helper::setViewForm($this->template, 'prepare', $this->folder))->with($this->share([
                'model'        => $data,
                'vendor'        => $vendor,
                'status' => Helper::shareStatus($status),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function receive(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->setRules([
                'purchase_detail_qty_receive.*' => 'required',
                'purchase_detail_location_id.*' => 'required',
            ])->update(self::$receive);

            if ($post['data']['purchase_status'] == 4) {
                return redirect()->back();
            }
            return Response::redirectBackWithInput();
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            $collection = collect(self::$model->status);
            $status = $collection->forget([1, 2, 3, 5])->toArray();
            $location = Helper::shareOption((new LocationRepository()), false, true, false)->mapWithKeys(function ($data) {
                return [$data->inventory_location_id => $data->inventory_location_name . ' - ' . $data->inventory_warehouse_name];
            });
            $location->prepend('- Select Location -', '');
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model'        => $data,
                'location'        => $location,
                'status' => Helper::shareStatus($status),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function print_order(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product', 'detail.color']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'vendor' => $data->vendor,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), $pasing);
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
        }
    }

    public function print_receive(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product', 'detail.color']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'vendor' => $data->vendor,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint('print_receive', $this->folder), $pasing);
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
        }
    }

    public function print_delivery(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'detail.product', 'detail.color']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint('print_delivery_order', $this->folder), $pasing);
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
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
        $data_table = self::$model->datatable;
        if (Auth::user()->group_user == 'warehouse') {
            $data_table = array_merge($data_table, ['purchase_total' => [false => 'Total']]);
        }

        $datatable = self::$model->datatable;
        if (request()->isMethod('POST')) {

            $datatable = $service
                ->setRaw(['purchase_status', 'purchase_total', 'purchase_paid'])
                ->datatable(self::$model);
            $datatable->editColumn('purchase_status', function ($field) {
                return Helper::createStatus([
                    'value'  => $field->purchase_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->editColumn('purchase_date', function ($field) {
                return $field->purchase_date->toDateString();
            });
            $datatable->editColumn('purchase_total', function ($field) {
                return Helper::createNumber($field->purchase_total);
            });
            $datatable->editColumn('purchase_paid', function ($field) {
                return Helper::createStatus([
                    'value'  => $field->purchase_paid,
                    'status' => self::$model->paid,
                ]);
            });

            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData($data_table),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['payment']);
            return view(Helper::setViewShow($this->template, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
