<?php

namespace App\Http\Controllers;

use Config;
// use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Closure;
use Helper;
use Plugin\Response;
use App\Charts\HomeChart;
use Illuminate\Http\Request;
use App\Dao\Models\GroupUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Alkhachatryan\LaravelWebConsole\LaravelWebConsole;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'access']);
    }

    /**
     * Show pretty routes.
     *
     * @return \Illuminate\Http\Response
     */
    public function route()
    {
        $middlewareClosure = function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        };

        $routes = collect(Route::getRoutes());

        foreach (config('pretty-routes.hide_matching') as $regex) {
            $routes = $routes->filter(function ($value, $key) use ($regex) {
                return !preg_match($regex, $value->uri());
            });
        }

        return view('page.home.routes', [
            'routes' => $routes,
            'middlewareClosure' => $middlewareClosure,
        ]);
    }

    public function sessionGroup($code)
    {
        session()->put(Auth::User()->username . '_group_access', $code);
        return redirect()->to(route('home'));
    }

    public function lifewire()
    {
        return view(Helper::setViewDashboard('lifewire'));
    }

    public function list()
    {
        return $this->index();
    }

    public function index()
    {
        return LaravelWebConsole::show();
    }

    public function dashboard()
    {
        if (Auth::user()->group_user == 'customer') {
            return redirect()->to('/');
        }
        $chart = new HomeChart();
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'line', [1, 2, 3, 4])->backgroundColor('#0088cc')->fill(true);
        $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1])->backgroundColor('#ddf1fa')->fill(true);

        $chart->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);

        session('button', 2);

        return view(Helper::setViewDashboard())->with(['chart' => $chart]);
    }

    public function configuration()
    {
        if (request()->isMethod('POST')) {
            $data = [

                'debug' => request()->get('debug'),
                'env' => request()->get('env'),
                'address' => request()->get('address'),
                'maps' => request()->get('maps'),
                'description' => request()->get('description'),
                'footer' => request()->get('footer'),
                'header' => htmlentities(request()->get('header')),
                'service' => request()->get('service'),
                'color' => request()->get('color'),
                'colors' => request()->get('colors'),
                'backend' => request()->get('backend'),
                'frontend' => request()->get('frontend'),
                'owner' => request()->get('owner'),
                'phone' => request()->get('phone'),
                'live' => request()->get('live'),
                'seo' => request()->get('seo'),
                'name' => request()->get('name'),
                'email' => request()->get('email'),
                'cache' => request()->get('website_cache'),
                'session' => request()->get('website_session'),
                'developer_setting' => request()->get('developer_setting'),
                'warehouse' => request()->get('warehouse'),
            ];

            Config::write('website', $data);

            if (request()->exists('favicon')) {
                $file   = request()->file('favicon');
                $favicon   = config('app.name') . '_favicon.' . $file->extension();
                $file->storeAs('logo', $favicon);
                Config::write('website', ['favicon' => $favicon]);
            }

            if (request()->exists('logo')) {
                $file   = request()->file('logo');
                $name   = config('app.name') . '_logo.' . $file->extension();
                $simpen = $file->storeAs('logo', $name);
                Config::write('website', ['logo' => $name]);
            }

            session()->put('success', 'Configuration Success !');
            return Response::redirectBack();;
        }

        $frontend = array_map('basename', File::directories(resource_path('views/frontend/')));
        $backend  = array_map('basename', File::directories(resource_path('views/backend/')));
        if (!Cache::has('group')) {
            Cache::rememberForever('group', function () {
                return DB::table((new GroupUser())->getTable())->get();
            });
        }

        $mail_driver = array("smtp", "sendmail", "mailgun", "mandrill", "ses", "sparkpost", "log", "array", "preview");

        $session_driver = ["file", "cookie", "database", "redis"];
        $cache_driver   = ["apc", "database", "file", "redis"];

        $database_driver = [
            "sqlite" => 'SQlite',
            "mysql"  => 'MySQL',
            "pgsql"  => 'PostgreSQL',
            "sqlsrv" => 'SQL Server',
        ];

        return view('page.home.configuration')->with([
            'group'           => Cache::get('group'),
            'frontend'        => array_combine($frontend, $frontend),
            'backend'         => array_combine($backend, $backend),
            'database'        => env('DB_CONNECTION'),
            'mail_driver'     => array_combine($mail_driver, $mail_driver),
            'session_driver'  => array_combine($session_driver, $session_driver),
            'cache_driver'    => array_combine($cache_driver, $cache_driver),
            'database_driver' => $database_driver,
        ]);
    }

    public function error()
    {
        return view('page.home.home');
    }

    public function master()
    {
        return view('page.master.test');
    }

    public function permision()
    {
        return view('errors.permision');
    }

    public function directory($name)
    {
    }

    public function file($name)
    {
        $data = $folder = null;
        $mode = 'txt';

        if (request()->has('folder')) {
            $folder = request()->get('folder');
        }

        session('last', $folder);

        $Storage = Storage::disk('system');

        if (request()->isMethod('POST')) {
            $Storage->put($name, request()->get('code'));
        }

        if ($Storage->exists($name)) {
            $data = File::get(base_path($name));
        }

        $directory = $directories = Storage::disk('system')->directories();
        $files = $files = Storage::disk('system')->files();
        return view('page.home.file')->with([
            'name' => $name,
            'data' => $data,
            'mode' => Helper::mode($name),
            'directory' => $directory,
            'files' => $files,
        ]);
    }

    public function query()
    {
        $data = File::get(base_path('app/Http/Controllers/HomeController.php'));
        $directory = $directories = Storage::disk('system')->directories();
        $files = $files = Storage::disk('system')->files();
        return view('page.home.query')->with([
            'data' => $data,
            'directory' => $directory,
            'files' => $files,
        ]);
        // return $test;
        // dd(nl2br($test));
        // $listing = FTP::connection()->getDirListing();
        // dd($listing);
        // dd(config('app.name'));
        // Config::write('system.name', 'http://xdlee.com');

        //        $data = DB::table('actions')
        //                ->leftJoin('module_connection_action', 'actions.action_code', '=', 'module_connection_action.conn_ma_action')
        //                ->leftJoin('modules', 'module_connection_action.conn_ma_module', '=', 'modules.module_code')
        //                ->leftJoin('group_module_connection_module', 'group_module_connection_module.conn_gm_module', '=', 'modules.module_code')
        //                ->leftJoin('group_modules', 'group_modules.group_module_code', '=', 'group_module_connection_module.conn_gm_group_module')
        //                ->leftJoin('group_user_connection_group_module', 'group_user_connection_group_module.conn_gu_group_module', '=', 'group_modules.group_module_code')
        //                ->where('conn_gu_group_user', Auth::user()->group_user)
        //                ->orderBy('module_sort', 'asc')
        //                ->orderBy('action_sort', 'asc')
        //                ->toSql();
        //
        //        dd($data);
    }
}
