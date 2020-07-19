<?php

namespace App\Http\Controllers;

use Helper;
use Plugin\Alert;
use Plugin\Notes;
use Plugin\Response;

class APIController extends Controller
{
    public $template;
    public $render;
    public static $model;

    public function po()
    {
        if (request()->isMethod('POST')) {
            $request = request()->all();
            // request()->validate(self::$model->rules);
            // $data = GroupUser::create($request);
            // $data = $service->save(self::$model);
            return $request;
        }
        // return view(Helper::setViewCreate())->with($this->share());
    }
}
