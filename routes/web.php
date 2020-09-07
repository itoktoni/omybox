<?php

use App\Dao\Models\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Auth::routes();
Route::group(
    [
        'middleware' =>
        [
            'auth',
            'access'
        ]
    ],
    function () {
        try {
            DB::connection()->getPdo();
            Route::group(['prefix' => 'dashboard'], function () {
                if (Cache::has('routing')) {
                    $cache_query = Cache::get('routing');
                    foreach ($cache_query as $route) {
                        $path = $route->action_path . '@' . $route->action_function;
                        Route::match(['get', 'post'], $route->action_link, $path)->name($route->action_code);
                    }
                } else {
                    $cache_query = Cache::rememberForever('routing', function () {
                        return DB::table((new Action())->getTable())
                            ->where('action_enable', '1')
                            ->orderBy('action_path', 'asc')
                            ->orderBy('action_function', 'asc')
                            ->orderBy('action_sort', 'desc')
                            ->get();
                    });
                }
            });
        } catch (\Exception $e) {
        }
    }
);

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('groups/{code}', 'HomeController@sessionGroup')->name('access_group');
        Route::get('user/reset', 'UserController@resetPassword')->name('resetpassword');
        Route::post('user/change_password', 'UserController@change_password')->name('lock');
        Route::get('permision', 'HomeController@permision')->name('permision');
        Route::match(
            [
                'get',
                'post'
            ],
            'user/profile',
            'UserController@showProfile'
        )->name('profile');
    });
});

/*
developer console
*/
Route::get('console', 'HomeController@index')->name('console');
Route::match(['get', 'post'], 'file/{name}', 'HomeController@file')->name('file');
Route::match(['get', 'post'], 'directory/{name}', 'HomeController@directory')->name('directory');

/*
developer configuration
*/

Route::get('dashboard', 'HomeController@dashboard')->name('home');
Route::get(
    'home',
    function () {
        return redirect()->route('home');
    }
);
Route::get('route', 'HomeController@route')->name('route');
Route::match(['get', 'post'], 'configuration', 'HomeController@configuration')->name('configuration');
Route::match(['get', 'post'], 'website', 'HomeController@website')->name('website');

/*
public routes
*/
Route::get('/', 'PublicController@index')->name('beranda');
Route::get('/slider/{slider}', 'PublicController@index')->name('single_slider');

Route::match(['get', 'post'], 'shop', 'PublicController@shop')->name('shop');
Route::get('/shop/{type}/{slug}', 'PublicController@shop')->name('filters');

Route::get('/brand/{brand}', 'PublicController@shop')->name('filter_brand');
Route::get('/track/{code}', 'PublicController@track')->name('track');

Route::match(['get', 'post'], 'cart', 'PublicController@cart')->name('cart');
Route::match(['get', 'post'], 'checkout', 'PublicController@checkout')->name('checkout');
Route::match(['get', 'post'], 'userprofile', 'PublicController@userprofile')->name('userprofile');
Route::match(['get', 'post'], 'myaccount', 'PublicController@myaccount')->name('myaccount');
Route::match(['get', 'post'], 'confirmation', 'PublicController@confirmation')->name('confirmation');

Route::get('/delete/{id}', 'PublicController@delete')->name('delete');
Route::get('/email/{id}', 'PublicController@email')->name('email');

Route::get('/category', 'PublicController@category')->name('category');

Route::get('/promo', 'PublicController@promo')->name('promo');
Route::get('/promo/{slug}', 'PublicController@promo')->name('single_promo');
Route::get('/page/{slug}', 'PublicController@page')->name('page');

Route::match(['get', 'post'], '/product/{slug}', 'PublicController@product')->name('single_product');


Route::get('/about', 'PublicController@about')->name('about');
Route::get('/galery', 'PublicController@galery')->name('galery');
Route::get('/jual/{slug}', 'PublicController@product')->name('product');
Route::get('/add/{id}', 'PublicController@add')->name('add');

Route::match(['get', 'post'], 'contact', 'PublicController@contact')->name('contact');

/*
auth mechanizme
*/
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('reset', 'UserController@resetRedis')->name('reset');
Route::get('reboot', 'UserController@resetRouting')->name('reboot');


Route::post('/update_cart', function () {
    $index = 0;
    $request = request()->all();
    $validate = Validator::make(
        $request,
        [
            'qty' => 'numeric|min:1',
            'product' => 'required',
        ],
        [],
        [
            'qty' => 'Input must correct',
        ]
    );

    if ($validate->fails()) {

        return [
            'status' => false,
            'error' => $validate->errors()->getMessages(),
            'number' => $request['qty']
        ];
    } else {
        $stock = DB::table('view_stock_product')->where('id', $request['product'])->first();
        $input_qty = floatval($request['qty']);
        $data_qty = $stock->qty;
        $data_product = $stock->id;

        if ($input_qty > $data_qty) {

            Cart::session(Cart::getSessionKey())->update($data_product, array(
                'quantity' => [
                    'relative' => false,
                    'value' => $data_qty
                ], // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
            ));

            return [
                'status' => false,
                'error' => 'Stock Tidak Cukup',
                'number' => $data_qty
            ];
        }

        Cart::session(Cart::getSessionKey())->update($data_product, array(
            'quantity' => [
                'relative' => false,
                'value' => $input_qty
            ], // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        ));

        return [
            'status' => true,
            'error' => '',
            'number' => $input_qty
        ];
    }
})->name('update_cart');
