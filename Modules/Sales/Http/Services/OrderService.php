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
use Illuminate\Support\Facades\Validator;

class OrderService extends TransactionService
{
    public function save(MasterInterface $repository)
    {

        $check = $this->saveDetail($repository);
        // $send = $check['data'];
        // $data = $repository->showRepository($send->{$repository->getKeyName()}, ['customer', 'forwarder', 'detail', 'detail.product']);
        // Mail::to(auth()->user()->email)->send(new OrderEmail($data));

        if ($check['status']) {
            Alert::create();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }

    public function saveDetail(MasterInterface $repository){

        DB::beginTransaction();
        $check = $this->setRules(array_merge($repository->rules, ['temp_id' => 'required']))->validate($repository);
        $check->saveRepository($this->data);
        
        if ($check['status']) {
            $id = !DB::getPDO()->lastInsertId() ? $check['data']->{$repository->getKeyName()} : DB::getPDO()->lastInsertId();
        }

        foreach ($this->mapping($repository) as $value) {
            $check_detail = $repository->saveDetailRepository($id, $value);
            if (!$check_detail['status']) {
                DB::rollback();
                Notes::error($check_detail['data']);
            }
        }

        DB::commit();
    }

    public function saveWo(MasterInterface $repository)
    {
        $check = $this->split($repository);
        $send = $check['data'];

        if ($check['status']) {
            Alert::create();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }

    public function grouping(MasterInterface $repository)
    {
        $detail = [];
        $count = $repository->grouping['key'];
        for ($i = 0; $i < count($this->data[$count]); $i++) {
            $group = $this->data[$count][$i];
            $collect = $repository->mapping['detail'];
            foreach ($collect as $key => $val) {
                $detail[$group][$i][$key] = Helper::filterInput($this->data[$val][$i]);
            }
        }

        return $detail;
    }


    public function split(MasterInterface $repository)
    {
        $code = request()->get('code');
        $rules = [
            'temp_vendor_id.*' => 'required'
        ];
        $message = [
            'temp_vendor_id.*.required' => 'Vendor "Product" :attribute must be choose !'
        ];

        $this->data = request()->all();
        $this->rules = $rules;
        Validator::make($this->data, $this->rules, $message)->validate();
        $grouping = $this->grouping($repository);
        DB::beginTransaction();
        foreach ($grouping as $vendor => $value) {
            $grouping_id = $repository->grouping['group'];
            $reference_id = $repository->reference_key;
            $date = $repository->order;
            $master[$grouping_id] = $vendor;
            $master[$reference_id] = $code;
            $master[$date] = date('Y-m-d');
            $check_master = $this->setData($master)->validate($repository)->saveRepository($this->data);
            $this->reset();
            if ($check_master['status']) {
                $id = !DB::getPDO()->lastInsertId() ? $check_master['data']->{$repository->getKeyName()} : DB::getPDO()->lastInsertId();
            }
            foreach ($value as $detail) {
                $check_detail = $repository->saveDetailRepository($id, $detail);
                $order_detail = $repository->updateSalesDetailRepository($code, $detail);
                if (!$check_detail['status']) {
                    DB::rollback();
                    Notes::error($check_detail['data']);
                }
            }
        }

        DB::commit();
        Alert::create();
        return Notes::create($this->data);
    }

}
