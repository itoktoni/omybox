<?php

namespace Modules\Sales\Dao\Repositories\report;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Stock;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class ReportPenjualanRepository extends Stock implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'Sales ID',
            'Create Date',
            'Customer',
            'Email',
            'Phone',
            'Product ID',
            'Product Name',
            'Color',
            'Size',
            'SKU',
            'Qty Order',
            'Qty Prepare',
            'Price Order',
            'Tax Name',
            'Tax Value',
            'Total Order',
            'Discount',
            'Jasa Pengiriman',
            'Ongkir',
        ];
    }

    public function collection()
    {
        $query = DB::table('view_sales_order')
            ->where('sales_order_detail_qty_prepare', '>', 0)
            ->select(['sales_order_id', 'sales_order_date', 'sales_order_rajaongkir_name', 'sales_order_email', 'sales_order_rajaongkir_phone', 'item_product_id', 'item_product_name', 'item_color_name', 'sales_order_detail_item_size', 'sales_order_detail_option', 'sales_order_detail_qty_order', 'sales_order_detail_qty_prepare', 'sales_order_detail_price_order',  'sales_order_detail_tax_name', 'sales_order_detail_tax_value', 'sales_order_detail_total_order', 'sales_order_detail_discount', 'sales_order_rajaongkir_service', 'sales_order_rajaongkir_ongkir']);
        if ($product = request()->get('product')) {
            $query->where('item_product_id', $product);
        }
        if ($color = request()->get('color')) {
            $query->where('sales_order_detail_item_color', $color);
        }
        if ($size = request()->get('size')) {
            $query->where('sales_order_detail_item_size', $size);
        }
        return $query->get();
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
