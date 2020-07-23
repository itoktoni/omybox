<?php

namespace App\Http\Controllers;

use Config;
// use Illuminate\Support\Facades\Config;
use Helper;
use Closure;
use Plugin\Notes;
use Plugin\Response;
use App\Charts\HomeChart;
use Illuminate\Http\Request;
use App\Dao\Models\GroupUser;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use Modules\Sales\Dao\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Item\Dao\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Modules\Sales\Dao\Models\OrderDetail;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Alkhachatryan\LaravelWebConsole\LaravelWebConsole;
use Modules\Inventory\Dao\Repositories\LocationRepository;

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

        $username = Auth::user()->username;
        
        if (request()->has('toggle')) {
            if (Cache::has($username.'_toggle')) {
                $check = Cache::get($username.'_toggle');
                if ($check) {
                    Cache::put($username.'_toggle', false);
                } else {
                    Cache::put($username.'_toggle', true);
                }
            } else {
                Cache::put($username.'_toggle', true);
            }

            return redirect()->back();
        }

        if (request()->has('refresh')) {
            $list = [
                'sales_order_id',
                'sales_order_rajaongkir_name',
                'item_brand_name',
                'item_product_id',
                'item_product_name',
                'sales_order_detail_qty_order',
                'sales_order_detail_notes',
            ];
            $query = Order::select($list)->join('sales_order_detail', 'sales_order_detail_sales_order_id', 'sales_order_id')
                ->join('item_product', 'item_product_id', 'sales_order_detail_item_product_id')
                ->leftJoin('item_brand', 'item_brand_id', 'item_product_item_brand_id');

            $data = $query->whereIn('sales_order_status', [3,4])->whereNull('sales_order_detail_qty_prepare');

            if (Auth::user()->group_user == 'partner') {
                $data->where('sales_order_detail_item_brand', Auth::user()->brand);
            }

            return view(Helper::setViewDashboard('table'))->with(['detail' => $data->get()]);
        }
        
        if (request()->has('order') && request()->has('id')) {
            $order = request()->get('order');
            $id = request()->get('id');

            DB::beginTransaction();

            $prepare = Order::find($order)->update(['sales_order_status' => 4]);
            $delete = OrderDetail::where('sales_order_detail_sales_order_id', $order)->where('sales_order_detail_item_product_id', $id);
            $delete->update(['sales_order_detail_qty_prepare' => $delete->first()->sales_order_detail_qty_order]);
            $model_location = new LocationRepository();
            $location = $model_location->dataRepository()->where('inventory_warehouse_brand_id', Auth::user()->branch)->get();
            $data_location = $location->pluck('inventory_location_id')->toArray();
            if (empty($data_location)) {
                DB::rollback();
                return redirect()->back()->withErrors('Stock in this location is Empty !');
            }
            $product = Product::find($id);
            $material = $product->material ?? false;
            if ($material) {
                foreach ($material as $materi) {
                    $stock = new Stock();
                    $pesanan = $delete->first()->sales_order_detail_qty_order * $materi->item_material_value;
                    $cek_stock = $stock->where('item_stock_product', $materi->item_material_procurement_product_id)->whereIn('item_stock_location', $data_location)->orderBy('item_stock_qty', 'DESC');
                    $single_stock = $cek_stock->first();
                    if ($single_stock) {
                        $jumlah = $cek_stock->sum('item_stock_qty');
                        if ($jumlah < $pesanan) {
                            DB::rollback();
                            return redirect()->back()->withErrors(['Stock Not Enough !']);
                        } elseif ($single_stock->item_stock_qty >= $pesanan) {
                            $pengurangan = $single_stock->item_stock_qty - $pesanan;
                        } elseif ($jumlah >= $pesanan) {
                            $pengurangan = $jumlah - $pesanan;
                            $stock->where('item_stock_product', $materi->item_material_procurement_product_id)->update(['item_stock_qty' => 0]);
                        } else {
                            DB::rollback();
                            return redirect()->back()->withErrors(['Stock Not Enough !']);

                            // $pengurangan = $jumlah - $pesanan;
                            // $stock->where('item_stock_product', $materi->item_material_procurement_product_id)->update(['item_stock_qty' => 0]);
                        }
                        $stock->find($single_stock->item_stock_id)->update(['item_stock_qty' => $pengurangan]);
                    }
                }
            }

            $ready = OrderDetail::whereNull('sales_order_detail_qty_prepare')->first();
            
            if (empty($ready)) {
                Order::find($order)->update(['sales_order_status' => 5]);
            }
            DB::commit();

            return redirect()->back();
        }
        // return view(Helper::setViewDashboard())->with(['chart' => $chart]);
        
        return view(Helper::setViewDashboard());
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
                'header' => request()->get('header'),
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
                'sign' => request()->get('sign'),
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
            return Response::redirectBack();
            ;
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
