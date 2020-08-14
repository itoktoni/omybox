<?php

namespace Modules\Sales\Dao\Repositories\report;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Order;
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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;

class ReportSummaryOrderRepository extends Order implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping
{
    public $model;
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
            'Ongkir',
            'Total Data',
        ];
    }


    public function __construct()
    {
        $this->model = new OrderRepository();
    }

    public function collection()
    {

        $query = $this->model
            ->select(['sales_order_id', 'sales_order_date','sales_order_status', 'sales_order_rajaongkir_name', 'sales_order_email', 'sales_order_rajaongkir_phone', 'sales_order_total', 'sales_order_marketing_promo_code', 'sales_order_marketing_promo_name' , 'sales_order_marketing_promo_value', 'sales_order_rajaongkir_ongkir']);
        
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
        return $query->get();
    }

    public function map($data): array
    {
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
           ($data->sales_order_total - $data->sales_order_rajaongkir_ongkir) - $data->sales_order_marketing_promo_value
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'F' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
            'J' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}