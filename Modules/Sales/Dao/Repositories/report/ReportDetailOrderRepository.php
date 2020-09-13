<?php

namespace Modules\Sales\Dao\Repositories\report;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Brand;
use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Stock;
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

class ReportDetailOrderRepository extends Order implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public $model;
    public $detail;
    public $product;
    public $brand;

    public function headings(): array
    {
        return [
            'Sales ID',
            'Create Date',
            'Customer',
            'Email',
            'Phone',
            'Status',
            'Total Order',
            'Promo Code',
            'Promo Name',
            'Discount',
            'Total Ongkir',
            'Total Data',
            'Branch',
            'Ongkir / Branch',
            'Waybill',
            'Category Name',
            'Product ID',
            'Product Name',
            'Product Price',
            'Product Discount',
            'Product Flag',
            'Qty Order',
            'Price Order',
            'Total Order',
            'Prepare Order',
            'Notes',
        ];
    }

    public function __construct()
    {
        $this->model = new OrderRepository();
        $this->detail = new OrderDetail();
        $this->product = new Product();
        $this->category = new Category();
        $this->brand = new Brand();
    }

    public function collection()
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
        if ($product = request()->get('product')) {
            $query->where('item_product_id', $product);
        }
        
        return $query->orderBy($this->model->getKeyName(), 'ASC')->get();
    }

    public function map($data): array
    {
        $diskon = 0;
        if($data->item_product_discount_value){
            $diskon = $data->item_product_discount_type == 1 ? $data->item_product_sell - ($data->item_product_discount_value * $data->item_product_sell) : $data->item_product_sell - $data->item_product_discount_value;
        }
        return [
           $data->sales_order_id,
           $data->sales_order_date ? $data->sales_order_date->format('Y-m-d') : '',
           $data->sales_order_rajaongkir_name,
           $data->sales_order_email,
           $data->sales_order_rajaongkir_phone,
           $data->status[$data->sales_order_status][0] ?? '',
           $data->sales_order_total,
           $data->sales_order_marketing_promo_code,
           $data->sales_order_marketing_promo_name ,
           $data->sales_order_marketing_promo_value,
           $data->sales_order_rajaongkir_ongkir ,
           ($data->sales_order_total - $data->sales_order_rajaongkir_ongkir) - $data->sales_order_marketing_promo_value ,
            $data->item_brand_name,
            $data->sales_order_detail_ongkir,
            $data->sales_order_detail_waybill,
            $data->item_category_name,
            $data->item_product_id,
            $data->item_product_name,
            $data->item_product_sell,
            $diskon,
            $data->item_product_flag,
            $data->sales_order_detail_qty_order,
            $data->sales_order_detail_price_order,
            $data->sales_order_detail_total_order,
            $data->sales_order_detail_qty_prepare,
            $data->sales_order_detail_notes,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
