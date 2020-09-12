<?php

namespace Modules\Procurement\Dao\Repositories\report;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Modules\Procurement\Dao\Models\Order;
use Modules\Procurement\Dao\Models\Vendor;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Procurement\Dao\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Procurement\Dao\Models\Purchase;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\OrderRepository;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class ReportPurchaseOrderRepository extends PurchaseRepository implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public $model;
    public $detail;
    public $product;
    public $vendor;

    public function headings(): array
    {
        return [
            'Procurement ID',
            'Create Date',
            'Status',
            'Total Order',
            'Vendor',
            'Product ID',
            'Product Name',
            'Product Price',
            'Qty Order',
            'Price Order',
            'Total Order',
        ];
    }

    public function __construct()
    {
        $this->model = new Purchase();
        $this->detail = new PurchaseDetail();
        $this->product = new Product();
        $this->vendor = new Vendor();
    }

    public function collection()
    {
        $query = $this->model
        ->leftJoin('procurement_purchase_detail', 'purchase_detail_purchase_id', $this->getKeyName())
            ->leftJoin('procurement_vendor', 'procurement_vendor_id', 'purchase_procurement_vendor_id')
            ->leftJoin('procurement_product', 'purchase_detail_item_product_id', 'procurement_product_id')
                ->select([
                'purchase_id',
                'purchase_date',
                'purchase_status',
                'purchase_total',
                'procurement_vendor_name',
                'procurement_product_id',
                'procurement_product_name',
                'procurement_product_buy',
                'purchase_detail_qty_order',
                'purchase_detail_price_order',
                'purchase_detail_total_order',
                ]);

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

        
        return $query->orderBy($this->model->getKeyName(), 'ASC')->get();
    }

    public function map($data): array
    {
        return [
           $data->purchase_id,
           $data->purchase_date ? $data->purchase_date->format('Y-m-d') : '',
           $data->status[$data->purchase_status][0] ?? '',
           $data->purchase_total,
            $data->procurement_vendor_name,
            $data->procurement_product_id,
            $data->procurement_product_name,
            $data->procurement_product_buy,
            $data->purchase_detail_qty_order,
            $data->purchase_detail_price_order,
            $data->purchase_detail_total_order,
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
