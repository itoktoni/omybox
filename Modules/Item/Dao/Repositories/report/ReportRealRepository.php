<?php

namespace Modules\Item\Dao\Repositories\report;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Modules\Item\Dao\Repositories\StockRepository;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportRealRepository extends Stock implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'Product ID',
            'Product Name',
            'Product',
            'Color',
            'Size',
            'Barcode',
            'Qty',
        ];
    }

    public function collection()
    {
        $model = new StockRepository();
        $query = $model->dataRealRepository()->where('item_stock_qty', '>', 0)
        ->select(['item_stock_option', 'item_product_name', 'item_product_id', 'item_color_name', 'item_stock_size', 'item_stock_barcode', 'item_stock_qty']);
        if ($product = request()->get('product')) {
            $query->where('item_stock_product', $product);
        }
        if ($color = request()->get('color')) {
            $query->where('item_stock_color', $color);
        }
        if ($size = request()->get('size')) {
            $query->where('item_stock_size', $size);
        }
        return $query->get();
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
