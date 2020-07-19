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
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Item\Dao\Repositories\StockRepository;

class ReportStockRepository extends Stock implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Product ID',
            'Product Name',
            'Product',
            'Color',
            'Size',
            'Qty',
        ];
    }

    public function collection()
    {
        $model = new StockRepository();
        $query = $model->dataRepository()->select(['item_product_id', 'item_product_name', 'product', 'hex', 'size', 'qty']);
        if ($product = request()->get('product')) {
            $query->where('product', $product);
        }
        if ($color = request()->get('color')) {
            $query->where('color', $color);
        }
        if ($size = request()->get('size')) {
            $query->where('size', $size);
        }
        return $query->get();
    }
}
