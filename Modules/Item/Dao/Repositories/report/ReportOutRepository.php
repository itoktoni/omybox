<?php

namespace Modules\Item\Dao\Repositories\report;

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

class ReportOutRepository extends Stock implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'Sales ID',
            'Date',
            'Product Name',
            'Product ID',
            'Color',
            'Size',
            'SKU',
            'Qty',
        ];
    }

    public function collection()
    {
        $query = DB::table('view_sales_order')
            ->where('sales_order_detail_qty_prepare', '>', 0)
            ->select(['sales_order_id', 'sales_order_date', 'item_product_name', 'item_product_id', 'item_color_name', 'sales_order_detail_item_size', 'sales_order_detail_option', 'sales_order_detail_qty_prepare']);

        if ($from = request()->get('from')) {
            $query->where('sales_order_date', '>=', $from);
        }

        if ($to = request()->get('to')) {
            $query->where('sales_order_date', '<=', $to);
        }

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
