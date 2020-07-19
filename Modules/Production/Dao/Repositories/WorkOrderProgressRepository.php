<?php

namespace Modules\Production\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Production\Dao\Models\Vendor;
use Modules\Production\Dao\Models\WorkOrder;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Production\Dao\Models\WorkOrderDetailProgress;

class WorkOrderProgressRepository extends WorkOrderRepository implements MasterInterface
{
    public $progress;
    public $modelProgress;
    public $product;

    public function getModel()
    {
        if ($this->modelProgress == null) {

            return $this->modelProgress = new WorkOrderDetailProgress();
        }
        return $this->modelProgress;
    }

    public function progressRepository($id, $detail, $relation)
    {
        $data =  DB::table($this->getModel()->getTable())->where([$this->getModel()->parentKey => $id, $this->getModel()->foreignKey => $detail]);
        return $data->get();
    }

    public function showProgressRepository($id, $detail, $relation)
    {
        $this->product = new ProductRepository();
        $data =  DB::table($this->detail_table)->leftJoin($this->product->getTable(), $this->product->getKeyName(), $this->foreign_key)->where([$this->parent_key => $id, $this->foreign_key => $detail]);
        return $data->first();
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->getModel()->create($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->getModel()->Destroy($data);
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
