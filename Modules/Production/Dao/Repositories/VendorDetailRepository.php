<?php

namespace Modules\Production\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Production\Dao\Repositories\VendorRepository;

class VendorDetailRepository extends VendorRepository implements MasterInterface
{
    public $data;
    public $mapping  = [
        'primary' => 'production_vendor_product_vendor_id',
        'foreign' => 'production_vendor_product_product_id',
        'detail' => [
            'production_vendor_product_product_id' => 'temp_id',
            'production_vendor_product_price' => 'temp_price',
            'production_vendor_product_min' => 'temp_min',
            'production_vendor_product_max' => 'temp_max',
        ]
    ];

    public function saveDetailRepository($id, array $data)
    {
        try {
            $data[$this->mapping['primary']] = $id;
            DB::table($this->detail_table)->insert($data);
            return Notes::create();
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateDetailRepository($id, array $data)
    {
        try {
            $where = [
                $this->mapping['primary'] => $id,
                $this->mapping['foreign'] => $data[$this->mapping['foreign']],
            ];
            $check = DB::table($this->detail_table)->updateOrInsert($where, $data);

            return Notes::create();
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteDetailRepository($id, $foreign = false)
    {
        try {
            if ($foreign) {
                DB::table($this->detail_table)->where([$this->mapping['primary'] => $id, $this->mapping['foreign'] => $foreign])->delete();
                return Notes::delete('detail');
            } else {
                DB::table($this->detail_table)->whereIn($this->mapping['primary'], $id)->delete();
                DB::table($this->getTable())->whereIn($this->getKeyName(), $id)->delete();
                return Notes::delete('master');
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
