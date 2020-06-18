<?php

namespace Modules\Sales\Http\Services;

use Plugin\Alert;
use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Emails\OrderEmail;
use App\Http\Services\TransactionService;
use App\Dao\Interfaces\MasterInterface;

class WorkOrderService extends TransactionService
{
    public function save(MasterInterface $repository)
    {
        // save to database
        $model = $repository->getModel();
        $check = $this->setRules($model->rules)->validate($repository)->saveRepository($this->data);
        // check if status status success or failed
        if ($check['status']) {
            Alert::create();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }

    public function show(MasterInterface $repository, $relation = false)
    {
        $id   = request()->get('code');
        $detail   = request()->get('detail');
        return $repository->showProgressRepository($id, $detail, $relation);
    }

    public function progress(MasterInterface $repository, $relation = false)
    {
        $id   = request()->get('code');
        $detail   = request()->get('detail');
        return $repository->progressRepository($id, $detail, $relation);
    }
    
}
