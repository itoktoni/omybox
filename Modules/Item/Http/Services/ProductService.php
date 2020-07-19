<?php

namespace Modules\Item\Http\Services;

use Plugin\Alert;
use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Facades\DB;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Mail;
use App\Dao\Interfaces\MasterInterface;

class ProductService extends MasterService
{
    public function save(MasterInterface $repository)
    {
        // save to database
        $data = request()->all();
        if (isset($data['item_product_file'])) {
            $file = $data['item_product_file'];
            if (!empty($file)) { //handle images
                $name = Helper::upload($file, Helper::getTemplate(__CLASS__));
                $data['item_product_image'] = $name;
                $data['item_product_image_thumnail'] = 'thumnail_' . $name;
            }
        }
        $check = $this->setData($data)->validate($repository)->saveRepository($this->data);
        // check if status status success or failed
        if ($check['status']) {
            Alert::create();
        } else {
            Alert::error($check['data']);
            Helper::remove($name, Helper::getTemplate(__CLASS__));
        }
        return $check;
    }

    public function update(MasterInterface $repository)
    {
        $id = request()->query('code');
        $data = $repository->showRepository($id,null);
        $request = request()->all();
        if(!empty($data)){
            if(isset($request['item_product_file'])){
                $file = $request['item_product_file'];
                if (!empty($file)) { //handle images
                    $name = Helper::upload($file, Helper::getTemplate(__CLASS__));
                    $request['item_product_image'] = $name;
                    $request['item_product_image_thumnail'] = 'thumnail_' . $name;
                    Helper::remove($data->item_product_image, Helper::getTemplate(__CLASS__));
                }
            }
        }   
        $check = $this->validate($repository)->updateRepository($id, $request);
       
        if ($check['status']) {
            Alert::delete();
        } else {
            Alert::error($check['data']);
        }
    }
}
