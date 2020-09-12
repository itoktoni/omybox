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

class ReportInRepository extends PurchaseRepository implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'Purchase ID',
            'Date',
            'Vendor Name',
            'Product ID',
            'Product Name',
            'Qty',
        ];
    }

    public function collection()
    {
        $query = DB::table($this->getTable())
            ->leftJoin('procurement_purchase_detail', 'purchase_detail_purchase_id', $this->getKeyName())
            ->leftJoin('procurement_vendor', 'procurement_vendor_id', 'purchase_procurement_vendor_id')
            ->leftJoin('procurement_product', 'purchase_detail_item_product_id', 'procurement_product_id')
            ->where('purchase_detail_qty_receive', '>', 0)
            ->select(['purchase_id', 'purchase_date', 'procurement_vendor_name', 'procurement_product_id', 'procurement_product_name',  'purchase_detail_qty_receive']);

        if ($from = request()->get('from')) {
            $query->where('purchase_date', '>=', $from);
        }

        if ($to = request()->get('to')) {
            $query->where('purchase_date', '<=', $to);
        }
        
        if ($product = request()->get('product')) {
            $query->where('procurement_product_id', $product);
        }

        if ($purchase = request()->get('purchase')) {
            $query->where('purchase_id', $purchase);
        }
        
        return $query->get();
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DMYSLASH,
            'F' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
