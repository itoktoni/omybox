<?php

namespace App\Http\Controllers;

use App\User;
use Plugin\Alert;
use Plugin\Response;
use Illuminate\Http\Request;
use App\Dao\Models\GroupUser;
use App\Http\Middleware\AccessMenu;
use App\Http\Services\MasterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Dao\Repositories\TeamRepository;
use App\Http\Middleware\AccessMiddleware;
use App\Dao\Repositories\GroupModuleRepository;

class UserController extends Controller
{
    public $table;
    public $key;
    public $field;
    public $model;
    public $template;
    public $rules;
    public $datatable;
    public $searching;
    public $render;

    public function __construct(User $abstrak)
    {
        $this->table     = $abstrak->getTable();
        $this->key       = $abstrak->getKeyName();
        $this->field     = $abstrak->getFillable();
        $this->model     = $abstrak;
        $this->template  = 'user';
        $this->searching = 'name';
        $this->rules     = [
            'name'     => 'required|min:3',
            'username' => 'required|min:3|unique:' . $this->table,
            'email'    => 'required|min:3|email|unique:' . $this->table,
            'password' => 'required|min:3',
        ];
        $this->datatable = [
            'user_id'    => 'ID',
            'name'       => 'Top ID',
            'email'      => 'Email',
            'username'   => 'Username',
            'group_user' => 'Group',
            'site_id'    => 'Site',
        ];
    }

    public function index()
    {
        return view('home');
    }

    public function groups($code, Request $request)
    {
        session()->put(Auth::User()->username . '_group_access', $code);
        return Response::redirectBack();;
    }

    public function create()
    {
        if (request()->isMethod('POST')) {
            $this->validate(request(), $this->rules);
            $this->model->simpan(request()->all());
        }

        $group = new GroupUser();
        return view('page.' . $this->template . '.create')->with([
            'template' => $this->template,
            'grub'     => $group->get(),
        ]);
    }

    public function showProfile(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $repo = new TeamRepository();
            $check = $repo->updateRepository(Auth::user()->id, request()->all());
            if ($check['status']) {
                Alert::delete();
            } else {
                Alert::error($check['data']);
            }
        }

        $group_module = new GroupModuleRepository();
        $group_list = $group_module->getGroupByUser(Auth()->user()->group_user)->get();
        if ($group_list->count() > 0) {
            session()->put(Auth()->user()->username . '_group_access', $group_list->first()->conn_gu_group_user);
        }

        return view('page.' . $this->template . '.profile')->with([
            'key'  => Auth::user()->user_id,
            'data' => $this->model->select()->where('user_id', '=', Auth::user()->user_id),
            'group_list' =>  $group_list,
        ]);
    }

    public function resetpassword()
    {
        return view('auth.lock');
    }

    public function change_password(Request $request)
    {
        $this->validate($request, [
            'change_password' => 'required|min:8',
        ]);

        $user = new TeamRepository();
        $password = $request->input('change_password');
        $data     = $user->where($user->getKeyName(), Auth::User()->id)->update([
            'password' => bcrypt($password)
        ]);
        Alert::create('Change password success !');
        return Response::redirectTo('/dashboard');
    }

    public function resetRedis()
    {
        if (Auth::check()) {

            $key = $this->key;
            $access_menu = Auth::user()->username . '_access_menu';
            $group_list = Auth::user()->username . '_group_list';
            $access_user = 'App\User_By_Id_' . Auth::user()->$key;
            Cache::has($access_menu) ? Cache::forget($access_menu) : '';
            Cache::has($group_list) ? Cache::forget($group_list) : '';
            Cache::has('tables') ? Cache::forget('tables') : '';
            Cache::has('filter') ? Cache::forget('filter') : '';
            Auth::logout();
        }
        return redirect()->to('/');
    }

    public function resetRouting()
    {
        $this->resetRedis();
        Cache::forget('routing');

        return redirect()->to('/');
    }
}
