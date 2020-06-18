<?php

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Modules\Item\Dao\Repositories\StockRepository;
// use Helper;
// use Curl;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
//
if (Cache::has('routing')) {
    $cache_query = Cache::get('routing');
    Route::middleware(['auth:api'])->group(function () use ($cache_query) {
        foreach ($cache_query as $route) {
            Route::post($route->action_module, $route->action_path . '@data')->name($route->action_module . '_api');
        }
    });
}
Route::match(
    [
        'GET',
        'POST'
    ],
    'city',
    function () {
        $input = request()->get('q');
        $province = request()->get('province');

        $query = DB::table('rajaongkir_cities');
        if ($province) {
            $query->where('rajaongkir_city_province_id', $province);
        }

        return $query->get();
    }
)->name('city');

Route::match(
    [
        'GET',
        'POST'
    ],
    'location',
    function () {
        $input = request()->get('q');
        $city = request()->get('city');

        $query = DB::table('rajaongkir_areas');
        if ($city) {
            $query->where('rajaongkir_area_city_id', $city);
        }

        return $data = $query->get();
    }
)->name('location');

Route::match(
    [
        'GET',
        'POST'
    ],
    'ongkir',
    function () {
        $from = '6981';
        $to = request()->get('to');
        $weight = request()->get('weight');
        $courier = request()->get('courier');
        $curl = curl_init();
        $key = env('RAJAONGKIR_APIKEY');
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$from&originType=subdistrict&destination=$to&destinationType=subdistrict&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $key"
            ),
        ));

        $response = curl_exec($curl);

        $parse = json_decode($response, true);
        if (isset($parse)) {
            $data = $parse['rajaongkir'];
            if ($data['status']['code'] == '200') {
                $items = array();
                foreach ($data['results'][0]['costs'] as $value) {
                    $items[] = [
                        'id' => $value['cost'][0]['value'],
                        'service' => $value['service'],
                        'description' => $value['description'],
                        'etd' => $value['cost'][0]['etd'],
                        'cost' => $value['cost'][0]['value'],
                        'price' => number_format($value['cost'][0]['value'])
                    ];
                }
            } else {

                $items[] = [
                    'id' => null,
                    'text' => $data['status']['code'] . ' - ' . $data['status']['description']
                ];
            }
        } else {

            $items[] = [
                'id' => null,
                'text' => 'Connection Time Out !'
            ];
        }

        curl_close($curl);

        return response()->json($items);
    }
)->name('ongkir');


Route::match(
    [
        'GET',
        'POST'
    ],
    'waybill',
    function () {
        $waybill = request()->get('waybill');
        $courier = request()->get('courier');
        $request = 'waybill=' . $waybill . '&courier=' . $courier;
        $key = env('RAJAONGKIR_APIKEY');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
)->name('waybill');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/stock', 'PublicController@stock')->name('stock');


Route::match(
    [
        'GET',
        'POST'
    ],
    'po',
    function () {
        $po = request()->get('po');
        $product = request()->get('product');
        $qty = request()->get('qty');
        $loc = request()->get('loc');
        $save = false;

        $product = DB::table('view_stock')->where('item_product_id', $product)->first();
        dd($product);
        $data = DB::table('procurement_purchase_detail')
            ->where('purchase_detail_purchase_id', $po)
            ->where('purchase_detail_option', $product)->first();
        if ($data) {
            $save = DB::table('procurement_purchase_detail')->where([
                'purchase_detail_purchase_id' => $po,
                'purchase_detail_option' => $product,
            ])->update([
                'purchase_detail_qty_receive' => $qty,
                'purchase_detail_location_id' => $loc
            ]);

            $stock = new StockRepository();
            $batch = Helper::autoNumber($stock->getTable(), 'item_stock_batch', 'G' . date('Ymd'), config('website.autonumber'));

            for ($i = 0; $i < $qty; $i++) {

                $item = [
                    'item_stock_qty' => 1,
                    'item_stock_product' => $product,
                    'item_stock_size' => $product,
                    'item_stock_color' => $product,
                    'item_stock_location' => $product,
                    'item_stock_qty' => $product,
                    'item_stock_option' => $product,
                    'item_stock_batch' => $batch,
                ];
                $check_stock = $stock->saveRepository($item);
            }

            $data['purchase_detail_barcode'] = $batch;

            $check = DB::table($this->detail_table)->updateOrInsert($where, $data);
            return Notes::create($check);
        }

        return response()->json($save);
    }
)->name('purchase_api');
