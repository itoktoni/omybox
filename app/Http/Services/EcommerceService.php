<?php

namespace App\Http\Services;

use DataTables;
use Plugin\Alert;
use Helper;
use Illuminate\Support\Facades\Validator;
use App\Dao\Interfaces\MasterInterface;

class EcommerceService
{
    public $rules;
    public $code;
    public $action;
    public $model;
    public $data;
    public $filter;
    public $searching;
    public $column;
    public $length;
    public $character;
    public $prefix;
    public $raw = [];

    public function reset(){
        $this->data = null;
        $this->code = null;
        $this->prefix = null;
        $this->length = null;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function setLenght($length = null)
    {
        if ($this->length == null) {
            $this->length = config('website.autonumber');
        } else {
            $this->length = $length;
        }
        return $this;
    }

    public function setCharacter($character = null)
    {
        if ($character) {
            $this->character = $character;
        } else {
            $this->character = Helper::unic(6);
        }
        return $this;
    }

    public function setPrefix($prefix = null)
    {
        if ($prefix) {
            $this->prefix = $prefix;
        } else {
            $this->prefix = $this->character . date('Ym');;
        }
        return $this;
    }

    public function setCode($code = null)
    {
        if ($code) {
            $this->code = $code;
        } else {
            if ($this->prefix) {
                $this->code = $this->prefix;
            }

            $this->setPrefix();
        }

        return $this;
    }

    public function validate(MasterInterface $repository)
    {
        // set validation or use default validation
        if ($this->rules == null) {
            $this->setRules($repository->rules);
        }

        if ($this->data == null) {
            $this->setData(request()->all());
        }

        if (isset($repository->custom_attribute)) {
            Validator::make($this->data, $this->rules, [], $repository->custom_attribute)->validate();
        } else if (isset($repository->custom_message)) {
            Validator::make($this->data, $this->rules, $repository->custom_message)->validate();
        } else {
            Validator::make($this->data, $this->rules)->validate();
        }

        if (!$repository->incrementing && !isset($this->data[$repository->getKeyName()])) {

            if ($this->length == null) {
                if (isset($repository->length)) {
                    $this->setLenght($repository->length);
                } else {
                    $this->setLenght(config('website.autonumber'));
                }
            }
            if ($this->code == null) {
                if (isset($repository->prefix)) {
                    $this->setCharacter($repository->prefix);
                }

                $this->setPrefix();
                $this->setCode();
                $autonumber = Helper::autoNumber($repository->getTable(), $repository->getKeyName(), $this->code, $this->length);
            } else {
                $autonumber = $this->code;
            }
            $this->data[$repository->getKeyName()] = $autonumber;
        }
       
        return $repository;
        // valdiate rules
    }

    public function save(MasterInterface $repository)
    {
        // save to database
        $repo = $this->validate($repository);
        $check = $repo->saveRepository($this->data);
        // check if status status success or failed
        if ($check['status']) {
            Alert::create();
        } else {
            Alert::error($check['data']);
        }
        return $check;
    }

    public function setModel(MasterInterface $repository)
    {
        $this->model = $repository->dataRepository();
        return $this;
    }

    public function setFilter(MasterInterface $repository)
    {
        if ($this->model == null) {
            $this->setModel($repository);
        }
        $this->filter = Helper::filter($this->model);
        return $this;
    }

    public function setSearching(MasterInterface $repository)
    {
        if ($this->model == null) {
            $this->setModel($repository);
        }
        if ($this->filter == null) {
            $this->setFilter($repository);
        }

        $query = $this->filter;
        $request = request()->all();

        if (!empty($request['search'])) {
            $code         = $request['code'];
            $search       = $request['search'];
            $aggregate    = $request['aggregate'];
            $search_field = empty($code) ? $repository->searching : $code;
            $aggregation  = empty($aggregate) ? 'like' : $aggregate;
            $input        = empty($aggregate) ? "%$search%" : "$search";
            $query->where($search_field, $aggregation, $input);
        }
        $this->searching = $query;
        return $this;
    }

    public function setAction(array $action)
    {
        $this->action = $action;
        return $this;
    }

    public function setRaw(array $raw)
    {
        $this->raw = $raw;
        return $this;
    }

    public function setColumn(array $column)
    {
        $this->column = $column;
        return $this;
    }

    public function datatable(MasterInterface $repository)
    {
        if ($this->model == null) {
            $this->setModel($repository);
        }

        if ($this->filter == null) {
            $this->setFilter($repository);
        }

        if ($this->searching == null) {
            $this->setSearching($repository);
        }
        // set action
        if ($this->action == null) {
            $action  = [
                'update' => ['primary', 'edit'],
                'show'   => ['success', 'show'],
            ];
            $this->setAction($action);
        }
        $model = $this->searching->getModel();
        $key = $model->getKeyName();
        $attribute = [
            'key'       => $key,
            'route'     => config('module'),
            'action'    => $this->action,
            'searching' => $model->searching,
            'raw'       => [],
        ];
        //start datatable
        $datatable = Datatables::of($this->searching);
        // $datatable->setTotalRecords(count($table));
        if (!request()->has('clean')) {
            $datatable->editColumn('checkbox', function ($select) use ($key) {
                return Helper::createCheckbox($select->{$key});
            });
            $action_parse = $this->action;
            $datatable->addColumn('action', function ($select) use ($key, $attribute, $action_parse) {
                $route  = $attribute['route'];
                $data = Helper::createAction([
                    'key'    => $select->{$key},
                    'route'  => $route,
                    'action' => $action_parse,
                ]);
                return $data;
            });

            $rawColumns = ['action', 'checkbox'];
            // set action
            if (!empty($this->raw)) {
                $rawColumns = array_merge($rawColumns, $this->raw);
            }

            $datatable->rawColumns($rawColumns);
        }
        //end dattable
        return $datatable;
    }

    public function delete(MasterInterface $repository)
    {
        // set validation or use default validation
        if ($this->rules == null) {
            $rules = ['id' => 'required'];
            $this->setRules($rules);
        }
        // valdiate rules
        request()->validate($this->rules, ['id.required' => 'Please select any data !']);
        $check = $repository->deleteRepository(request()->get('id'));
        if ($check['status']) {
            Alert::delete();
        } else {
            Alert::error($check['data']);
        }
    }

    public function update(MasterInterface $repository)
    {
        if ($this->rules == null) {
            $rules = [$repository->searching => 'required'];
            $this->setRules($rules);
        }

        $id = request()->query('code');
        $ce = request()->validate($this->rules);
        $check = $repository->updateRepository($id, request()->all());
        if ($check['status']) {
            Alert::delete();
        } else {
            Alert::error($check['data']);
        }
    }

    public function show(MasterInterface $repository, $relation = false)
    {
        $id   = request()->get('code');
        return $repository->showRepository($id, $relation);
    }
}
