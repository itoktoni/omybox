<?php

namespace Modules\Sales\Http\Controllers;

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
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Dao\Repositories\report\ReportPenjualanRepository;
use Modules\Sales\Dao\Repositories\report\ReportSummaryOrderRepository;

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
        $promo = Helper::shareOption(new PromoRepository(), false, true)->pluck('marketing_promo_name', 'marketing_promo_code')->prepend('Select All Promo', '');
        $status = Helper::shareStatus((new OrderRepository())->status)->prepend('All Status', '');


        $view = [
            'promo' => $promo,
            'product' => $product,
            'status' => $status,
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function order_summary()
    {
        if (request()->isMethod('POST')) {
            $name = 'report_sales_order_out_' . date('Y_m_d') . '.xlsx';
            ;
            return $this->excel->download(new ReportSummaryOrderRepository(), $name);
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }

    
    public function order_detail()
    {
        if (request()->isMethod('POST')) {
            $name = 'report_sales_order_out_' . date('Y_m_d') . '.xlsx';
            ;
            return $this->excel->download(new ReportPenjualanRepository(), $name);
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }
}
