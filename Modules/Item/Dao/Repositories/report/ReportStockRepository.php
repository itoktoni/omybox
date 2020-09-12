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
            'Unit',
            'Qty',
        ];
    }

    public function collection()
    {
        $model = new StockRepository();
        $query = $model->dataRepository();
        if ($product = request()->get('product')) {
            $query->where('item_stock_product', $product);
        }
        
        return $query->get();
    }
}
