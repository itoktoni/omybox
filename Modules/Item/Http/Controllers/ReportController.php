<?php

namespace Modules\Item\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ReportRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\report\ReportInRepository;
use Modules\Item\Dao\Repositories\report\ReportOutRepository;
use Modules\Item\Dao\Repositories\report\ReportRealRepository;
use Modules\Item\Dao\Repositories\report\ReportStockRepository;

class ReportController extends Controller
{
    public $template;
    public $folder;
    public $excel;
    public static $model;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $product = Helper::shareOption(new ProductRepository());
        $color = Helper::shareOption(new ColorRepository());
        $size = Helper::shareOption(new SizeRepository());

        $view = [
            'product' => $product,
            'color' => $color,
            'size' => $size,
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function stock()
    {
        if (request()->isMethod('POST')) {
            $name = 'report_stock_' . date('Y_m_d') . '.xlsx';
            return $this->excel->download(new ReportStockRepository(), $name);
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }

    public function real()
    {
        if (request()->isMethod('POST')) {
            $name = 'report_real_' . date('Y_m_d') . '.xlsx';;
            return $this->excel->download(new ReportRealRepository(), $name);
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }

    public function in()
    {
        if (request()->isMethod('POST')) {
            $name = 'report_purchase_stock_in_' . date('Y_m_d') . '.xlsx';;
            return $this->excel->download(new ReportInRepository(), $name);
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }

    public function out()
    {
        if (request()->isMethod('POST')) {
            $name = 'report_sales_order_out_' . date('Y_m_d') . '.xlsx';;
            return $this->excel->download(new ReportOutRepository(), $name);
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }
}
