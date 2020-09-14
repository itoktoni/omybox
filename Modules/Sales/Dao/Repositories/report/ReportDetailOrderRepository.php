<?php

namespace Modules\Sales\Dao\Repositories\report;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Brand;
use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Stock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Sales\Dao\Models\Order;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Category;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Modules\Sales\Dao\Models\OrderDetail;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class ReportDetailOrderRepository extends Order implements FromView, ShouldAutoSize
{
    public $model;
    public $detail;
    public $product;
    public $brand;
    public $key = [];

    public function __construct()
    {
        $this->model = new OrderRepository();
        $this->detail = new OrderDetail();
        $this->product = new Product();
        $this->category = new Category();
        $this->brand = new Brand();
    }

    public function view(): View
    {
        $query = $this->model
        ->leftJoin($this->detail->getTable(), $this->model->getKeyName(), $this->detail->getKeyName())
        ->leftJoin($this->product->getTable(), 'sales_order_detail_item_product_id', $this->product->getKeyName())
        ->leftJoin($this->category->getTable(), 'item_product_item_category_id', $this->category->getKeyName())
        ->leftJoin($this->brand->getTable(), 'item_product_item_brand_id', $this->brand->getKeyName())
            ->select([
                'sales_order_id',
                'sales_order_date',
                'sales_order_status',
                'sales_order_rajaongkir_name',
                'sales_order_email',
                'sales_order_rajaongkir_phone',
                'sales_order_total',
                'sales_order_marketing_promo_code',
                'sales_order_marketing_promo_name' ,
                'sales_order_marketing_promo_value',
                'item_brand_id',
                'item_brand_name',
                'sales_order_detail_ongkir',
                'sales_order_detail_waybill',
                'item_category_name',
                'item_product_id',
                'item_product_name',
                'item_product_sell',
                'item_product_discount_value',
                'item_product_discount_type',
                'item_product_flag',
                'sales_order_detail_qty_order',
                'sales_order_detail_price_order',
                'sales_order_detail_total_order',
                'sales_order_detail_qty_prepare',
                'sales_order_detail_notes',
            ]);

        if ($promo = request()->get('promo')) {
            $query->where('sales_order_marketing_promo_code', $promo);
        }
        if ($status = request()->get('status')) {
            $query->where('sales_order_status', $status);
        }
        if ($from = request()->get('from')) {
            $query->where('sales_order_date', '>=', $from);
        }
        if ($to = request()->get('to')) {
            $query->where('sales_order_date','<=', $to);
        }

        $query = $query->orderBy($this->model->getKeyName(), 'ASC')->orderBy('item_brand_id', 'ASC');
        return view('Sales::page.report.export_detail', [
            'export' => $query->get()
        ]);
    }
}
