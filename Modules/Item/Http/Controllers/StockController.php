<?php

namespace Modules\Item\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use PDF;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Inventory\Dao\Repositories\LocationRepository;

class StockController extends Controller
{
    public $template;
    public $folder;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new StockRepository();
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
        $product = Helper::shareOption((new ProductRepository()));
        $size = Helper::shareOption((new SizeRepository()));
        $color = Helper::shareOption((new ColorRepository()));
        $location = new LocationRepository();
        $data_location = $location->dataRepository()->get()->mapWithKeys(function ($item) {
            return [$item->inventory_location_id => 'Loc ' . $item->inventory_location_name . ' - WH : ' . $item->inventory_warehouse_name];
        });

        $view = [
            'template' => $this->template,
            'product'      => $product,
            'size'         => $size,
            'color'        => $color,
            'location'     => $data_location,
        ];

        return array_merge($view, $data);
    }

    public function print_barcode()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            $check = self::$model->barcodeRepository($code);
            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), [
                'data' => $check
            ])->setPaper('A7');
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
        }
    }

    public function print_multibarcode()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            $check = self::$model->multibarcodeRepository($code);
            $pdf = PDF::loadView(Helper::setViewPrint(__FUNCTION__, $this->folder), [
                'data' => $check
            ])->setPaper('A7');
            return $pdf->stream();
            // return $pdf->download($id . '.pdf');
        }
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $check = $service->save(self::$model);
            if ($check['status']) {
                return redirect()->refresh();
            }
        }
        return view(Helper::setViewCreate())->with($this->share([
            'barcode' => Helper::autoNumber(self::$model->getTable(), 'item_stock_barcode', date('Ymd'), config('website.autonumber')),
        ]));
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

            $datatable = $service->setRaw(['item_stock_product'])->datatable(self::$model);
            $datatable->editColumn('item_stock_product', function ($select) {
                return $select->product;
            });
            $module = $this->getModule();
            $datatable->editColumn('action', function ($select) use ($module) {
                return $html = '<p align="center"><a id="linkMenu" href="' . route($module . '_show', ['code' => $select->item_product_id]) . '" class="btn btn-xs btn-success">show</a></p>';
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
            $code = request()->get('code');
            $check = self::$model->stockRepository($code);
            $stock = $data = false;
            if ($check) {
                $product = new ProductRepository();
                $data = $product->showRepository($check->product_id);
                $stock = self::$model->stockDetailRepository($check->product, $check->color, $check->size);
            }

            return view('Item::page.stock.show')->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'stock'   => $stock,
                'key' => 'item_product_id',
            ]));
        }
    }
}
