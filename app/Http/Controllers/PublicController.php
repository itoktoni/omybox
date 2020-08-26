<?php

namespace App\Http\Controllers;

use App;
use Cart;
use Exception;
use Plugin\Helper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Sales\Dao\Models\Order;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Item\Dao\Models\Product;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Dao\Models\Wishlist;
use Illuminate\Support\Facades\Config;
use Modules\Sales\Dao\Models\Province;
use App\Http\Services\EcommerceService;
use Illuminate\Support\Facades\Artisan;
use Modules\Finance\Dao\Models\Account;
use App\Dao\Repositories\TeamRepository;
use Modules\Marketing\Dao\Models\Slider;
use Illuminate\Support\Facades\Validator;
use Modules\Marketing\Emails\ContactEmail;
use Modules\Sales\Emails\CreateOrderEmail;
use Modules\Procurement\Dao\Models\Purchase;
use Modules\Sales\Emails\CreateEstimateEmail;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Item\Dao\Repositories\TaxRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\WishlistRepository;
use Modules\Sales\Dao\Repositories\CourierRepository;
use Modules\Marketing\Dao\Repositories\PageRepository;
use Modules\Finance\Dao\Repositories\AccountRepository;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Marketing\Dao\Repositories\SliderRepository;
use Modules\Marketing\Dao\Repositories\SosmedRepository;
use Modules\Marketing\Dao\Repositories\ContactRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Modules\Procurement\Dao\Repositories\PurchasePrepareRepository;
use Modules\Procurement\Emails\CreateOrderEmail as EmailsCreateOrderEmail;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['myaccount']);
        view()->share('public_category', Helper::createOption((new CategoryRepository()), false, true, false))->where('item_category_status', 1);
        view()->share('public_sosmed', Helper::createOption((new SosmedRepository()), false, true, true));
        // view()->share('public_product', Helper::createOption((new ProductRepository()), false, true, true));
        // view()->share('public_page', Helper::createOption((new PageRepository()), false, true, false)->where('marketing_page_status', 1));
    }

    public function index($slider = false)
    {
        $wishlist = [];
        if (Auth::check()) {
            $wish = new WishlistRepository();
            $wishlist = $wish->getUserRepository();
        }

        if ($slider) {
            $model = new SliderRepository();
            $data = $model->slugRepository($slider);
            return View(Helper::setViewFrontend('single_slider'))->with([
                'data' => $data
            ]);
        }

        $default_slider = Helper::createOption(new SliderRepository(), false, true);

        
        $product = new ProductRepository();
        $bank = new BankRepository();
        $data_product = $product->getBestSeller()->get();
        $data_bank = Helper::shareOption($bank, false, true);
        $option_bank = $data_bank->mapWithKeys(function ($item) {
            return [$item->finance_bank_branch => $item->finance_bank_branch.' - '.$item->finance_bank_account_name];
        });

        return view(Helper::setViewFrontend(__FUNCTION__))->with([
            'sliders' => $default_slider,
            'whitelist' => $wishlist,
            'data_product' => $data_product,
            'bank' => $option_bank->all(),
        ]);
    }

    public function about()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function filters()
    {
        return redirect()->route('shop');
    }

    public function shop($type = null, $slug = null)
    {
        // dd(session()->all());
        // session()->forget('filter');
        if (request()->isMethod('POST')) {
            if (empty(request()->get('search'))) {
                session()->forget('filter.item_product_name');
            } else {
                session()->put('filter.item_product_name', request()->get('search'));
            }
        }
        $color = Helper::createOption(new ColorRepository(), false, true);
        $size = Helper::createOption(new SizeRepository(), false, true)->pluck('item_size_code');
        $tag = Helper::createOption(new TagRepository(), false, true)->pluck('item_tag_slug');
        $brand = Helper::createOption(new BrandRepository(), false, true)->pluck('item_brand_slug', 'item_brand_name');

        $object_product = new ProductRepository();
        $product = $object_product->dataRepository();
        $session = [];
        // session()->flush();
        if ($type == 'add' && is_numeric($slug)) {
            $item = $object_product->showRepository($slug);
            $additional = [];

            $discount = 0;
            if ($item->item_product_discount_type == 1) {
                $discount = $item->item_product_sell * $item->item_product_discount_value;
            } elseif ($item->item_product_discount_type == 2) {
                $discount = $item->item_product_discount_value;
            }

            $stock = DB::table('view_stock_product')->where('product', $item->item_product_id)->get();
            $option_stock = $stock->mapWithKeys(function ($item) {
                $size = $item->size ? $item->size . ' - ' : '';
                $color = $item->hex ? $item->hex . ' - ' : '';
                $stock = 'Stock ( ' . $item->qty . ' )';

                return [$item->id => $size . $color . $stock];
            })->toArray();

            $additional = [
                'image' => $item->item_product_image,
                'list_option' => $option_stock,
                'option' => $stock->first()->id ?? null,
                'product' => $item->item_product_id ?? null,
                'size' => $stock->first()->size ?? null,
                'color' => $stock->first()->hex ?? null,
                'stock' => $stock->first()->qty ?? null,
                'discount' => $discount,
                'gram' => $item->item_product_gram,
            ];

            $price = $item->item_product_sell - $discount;
            Cart::add($stock->first()->id, $item->item_product_name, $price, 1, $additional);
        } elseif ($type == 'love' && is_string($slug)) {
            $love = DB::table('item_wishlist')->where([
                'item_wishlist_item_product_id' => $slug,
                'item_wishlist_user_id' => Auth::user()->id,
            ]);

            if ($love->count() > 0) {
                $love->delete();
            } else {
                $love = DB::table('item_wishlist')->insert([
                    'item_wishlist_item_product_id' => $slug,
                    'item_wishlist_user_id' => Auth::user()->id,
                    'item_wishlist_created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            switch ($type) {
                case 'brand':
                    // if (!session()->has('filter.item_brand_slug.slug' . $slug)) {
                        session()->put('filter.item_brand_slug.slug', $slug);
                    // }
                    break;
                case 'category':
                    // if (!session()->has('filter.item_category_slug')) {
                        session()->put('filter.item_category_slug.slug', $slug);
                    // }
                    break;
                case 'size':
                    if (!session()->has('filter.item_product_item_size_json.' . $slug)) {
                        session()->put('filter.item_product_item_size_json.' . $slug, $slug);
                    }
                    break;
                case 'color':
                    if (!session()->has('filter.item_product_item_color_json.' . $slug)) {
                        session()->put('filter.item_product_item_color_json.' . $slug, $slug);
                    }
                    break;
                case 'tag':
                    if (!session()->has('filter.item_product_item_tag_json.' . $slug)) {
                        session()->put('filter.item_product_item_tag_json.' . $slug, $slug);
                    }
                    break;
                case 'reset':
                    session()->forget('filter');
                    break;
                case 'remove_filter':
                    session()->forget('filter.' . $slug);
                    foreach (session()->get('filter') as $rmv => $remove) {
                        if (empty($remove)) {
                            session()->forget('filter.' . $rmv);
                        }
                    }
                    break;
            }
        }
        if (session()->has('filter')) {
            foreach (session()->get('filter') as $key => $value) {
                if ($key == 'item_product_item_tag_json') {
                    foreach ($value as $filter) {
                        $product->where($key, 'like', '%' . $filter . '%');
                    }
                } elseif ($key == 'item_product_name') {
                    $product->where($key, 'like', '%' . $value . '%');
                } else {
                    $product->whereIn($key, array_values($value));
                }
            }
        }
        $wishlist = [];
        if (Auth::check()) {
            $wish = new WishlistRepository();
            $wishlist = $wish->getUserRepository();
        }

        $category = new CategoryRepository();
        $data_category = $category->with(['product'])->get();
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'color' => $color,
            'size' => $size,
            'tag' => $tag,
            'brand' => $brand,
            'category' => $data_category,
            'product' => $product->paginate(9),
            'whitelist' => $wishlist,
        ]);
    }

    public function faq()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function track($code)
    {
        $model = new OrderRepository();
        $data = $model->showRepository($code);
        if ($data) {
            try {
                //code...
                $response = Curl::to(route('waybill'))->withData([
                    'waybill' => $data->sales_order_rajaongkir_waybill,
                    'courier' => $data->sales_order_rajaongkir_courier,
                ])->post();
                $waybill  = json_decode($response);
                if (isset($waybill) && !empty($waybill->rajaongkir) && $waybill->rajaongkir->status->code == 200) {
                    return View(Helper::setViewFrontend(__FUNCTION__))->with([
                        'data' => $data,
                        'waybill' => $waybill->rajaongkir->result,
                    ]);
                } else {
                    abort(403, $waybill->rajaongkir->status->description);
                }
            } catch (\Throwable $th) {
                abort(403, 'Ongkir API was down !');
                //throw $th;
            }
        }
    }

    public function userprofile()
    {
        $user = new TeamRepository();
        $data = false;

        if (Auth::check()) {
            $data = $user->showRepository(Auth::user()->id);
        };

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $validation = [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'phone' => 'required',
            ];

            $validate = Validator::make($request, $validation);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }

            $success = $user->updateRepository(Auth::user()->id, $request);
            if ($success) {
                session()->flash('success', 'Data Has been saved');
                return redirect()->back();
            }
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'model' => $data,
        ]);
    }


    public function myaccount()
    {
        $user = new TeamRepository();
        $order = new OrderRepository();

        $province = $city = $location = $data = false;
        $list_location = $list_city  = $data_order = $my_wishlist = [];

        if (Auth::check()) {
            $data = $user->showRepository(Auth::user()->id);
            $data_order = $order->userRepository(Auth::user()->phone)->get();
        };

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $province = request()->get('province');
            $city = request()->get('city');
            $location = request()->get('location');

            $validation = [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'province' => 'required',
                'city' => 'required',
                'location' => 'required',
                'password' => 'required|min:6',
            ];

            $validate = Validator::make($request, $validation);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }

            if (request()->has('password')) {
                $request['password'] = bcrypt(request()->get('password'));
            }

            $user->updateRepository(Auth::user()->id, $request);
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'model' => $data,
            'order' => $data_order,
            'status' => Helper::shareStatus($order->status),
        ]);
    }

    public function page($slug = false)
    {
        if ($slug && Cache::has('marketing_page_api')) {
            $page = Cache::get('marketing_page_api');
            $data = $page->where('marketing_page_slug', $slug)->first();
            if (!$data) {
                abort(404, 'Page not found !');
            }

            return View(Helper::setViewFrontend('page'))->with([
                'data' => $data,
            ]);
        }

        abort(404, 'Page not found !');
    }

    public function promo($slug = false)
    {
        if ($slug) {
            $model = new PromoRepository();
            $data = $model->slugRepository($slug);

            return View(Helper::setViewFrontend('single_promo'))->with([
                'data' => $data,
            ]);
        }

        $promo = new PromoRepository();
        $data_promo = $promo->dataRepository()
            ->where('marketing_promo_status', 1)
            ->where('marketing_promo_type', 1)->get();
        $single = $data_promo->where('marketing_promo_default', 1)->first();
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'promo' => $data_promo->whereNotIn('marketing_promo_default', [1]),
            'single' => $single,
        ]);
    }

    public function category($slug = false)
    {
        if ($slug) {
            $category = new CategoryRepository();
            $data_category = $category->slugRepository($slug);
            $color = Helper::createOption(new ColorRepository(), false, true)->pluck('item_color_code');
            $size = Helper::createOption(new SizeRepository(), false, true)->pluck('item_size_code');
            $tag = Helper::createOption(new TagRepository(), false, true)->pluck('item_tag_slug');
            $brand = Helper::createOption(new BrandRepository(), false, true)->pluck('item_brand_slug', 'item_brand_name');

            $product = ProductRepository::where('item_product_item_category_id', $data_category->item_category_id)->paginate(9);
            return View(Helper::setViewFrontend('shop'))->with([
                'color' => $color,
                'size' => $size,
                'tag' => $tag,
                'brand' => $brand,
                'product' => $product,
            ]);
        }

        return View(Helper::setViewFrontend(__FUNCTION__));
    }

    public function cart()
    {
        // dd(request());
        if (request()->isMethod('POST')) {
            $index = 0;
            $request = request()->all();
            $validate = Validator::make(
                $request,
                [
                            'cart.*.qty' => 'numeric|min:1',
                            'cart.*.product' => 'required',
                        ],
                [],
                [
                            'cart.' . $index . '.qty' => 'Input must correct',
                        ]
            );

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
                
            foreach ($request['cart'] as $value) {
                $data_product = $value['product'];
                $data_qty = $value['qty'];
                $data_description = $value['description'];

                $product_single = ProductRepository::find($data_product);

                $discount = 0;
                if ($product_single->item_product_discount_type == 1) {
                    $discount = $product_single->item_product_sell * $product_single->item_product_discount_value;
                } elseif ($product_single->item_product_discount_type == 2) {
                    $discount = $product_single->item_product_discount_value;
                }
                $additional = [
                    'description' => $product_single->item_product_description,
                    'notes' => $data_description,
                    'image' => $product_single->item_product_image,
                    'price' => $product_single->item_product_sell,
                    'discount' => $discount,
                    'brand_id' => $product_single->item_product_item_brand_id ?? '',
                    'brand_name' => $product_single->brand->item_brand_name ?? '',
                    'brand_description' => $product_single->brand->item_brand_description ?? '',
                ];

                Cart::update($data_product, array(
                        'quantity' => [
                            'relative' => false,
                            'value' => $data_qty
                        ],
                        'attributes' => $additional
                    ));

                $index++;
            }

            if (isset($request['code']) && !empty($request['code'])) {
                $code = $request['code'];
                $validate = Validator::make($request, [
                    'code' => 'required|exists:marketing_promo,marketing_promo_code',
                ], [
                    'code.exists' => 'Voucher Not Valid !',
                ]);
                
                $promo = new PromoRepository();
                $data = $promo->codeRepository(strtoupper($code));
                if ($data) {
                    $value = Cart::getTotal();
                    $matrix = $data->marketing_promo_matrix;
                    if ($matrix) {

                        // validate with minimal
                        $minimal = $data->marketing_promo_minimal;
                        if ($minimal) {
                            if ($minimal > $value) {
                                $validate->getMessageBag()->add('code', 'Minimal value ' . number_format($minimal) . ' !');
                                return redirect()->back()->withErrors($validate);
                            }
                        }

                        $string = str_replace('@value', $value, $matrix);
                        $total = $value;

                        try {
                            $total = Helper::calculate($string);
                        } catch (\Throwable $th) {
                            $total = $value;
                        }
                        $promo = Cart::getConditions()->first();
                        $condition = new \Darryldecode\Cart\CartCondition(array(
                                'name' => $data->marketing_promo_code,
                                'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                                'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                                'value' => -$total,
                                'order' => 1,
                                'attributes' => array( // attributes field is optional
                                    'name' => $data->marketing_promo_name,
                                    'real' => $value,
                                )
                            ));

                        Cart::condition($condition);
                    }
                } else {
                    $validate->getMessageBag()->add('code', 'Voucher Not Valid !');
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }
            }

            return redirect()->back()->withErrors($validate)->withInput();
        }

        $bank = new BankRepository();
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'bank' => Helper::shareOption($bank, false, true)->pluck('finance_bank_name', 'finance_bank_name'),
        ]);
    }

    public function delete($id)
    {
        if (Cart::getContent()->contains('id', $id)) {
            Cart::remove($id);
            if (Cart::isEmpty()) {
                Cart::clearCartConditions();
            } else {
                $discount = Cart::getConditions()->first();
                if ($discount) {
                    $code = $discount->getName();
                    $request['code'] = $code;
                    $validate = Validator::make($request, [
                        'code' => 'required|exists:marketing_promo,marketing_promo_code',
                    ], [
                        'code.exists' => 'Voucher Not Valid !',
                    ]);
                    Cart::removeCartCondition($code);

                    $promo = new PromoRepository();
                    $data = $promo->codeRepository(strtoupper($code));
                    if ($data) {
                        $value = Cart::getTotal();
                        $matrix = $data->marketing_promo_matrix;
                        if ($matrix) {

                            // validate with minimal
                            $minimal = $data->marketing_promo_minimal;
                            if ($minimal) {
                                if ($minimal > $value) {
                                    $validate->getMessageBag()->add('code', 'Minimal value ' . number_format($minimal) . ' !');
                                    Cart::removeCartCondition($code);
                                    return redirect()->route('cart')->withErrors($validate);
                                }
                            }

                            $string = str_replace('@value', $value, $matrix);
                            $total = $value;

                            try {
                                $total = Helper::calculate($string);
                            } catch (\Throwable $th) {
                                $total = $value;
                            }
                            $promo = Cart::getConditions()->first();
                            $condition = new \Darryldecode\Cart\CartCondition(array(
                                    'name' => $data->marketing_promo_code,
                                    'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                                    'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                                    'value' => -$total,
                                    'order' => 1,
                                    'attributes' => array( // attributes field is optional
                                        'name' => $data->marketing_promo_name,
                                        'real' => $value,
                                    )
                                ));

                            Cart::condition($condition);
                        }
                    } else {
                        $validate->getMessageBag()->add('code', 'Voucher Not Valid !');
                        return redirect()->route('cart')->withErrors($validate)->withInput();
                    }
                }
            }

            return redirect()->route('cart');
        }

        return redirect()->route('cart');
    }

    public function add($id)
    {
        // Cart::clear();
        if (is_string($id)) {
            $product = new ProductRepository();
            $item = $product->showRepository($id);

            $promo = 0;
            if ($item->item_product_discount_type == 1) {
                $promo = $item->item_product_sell * $item->item_product_discount_value;
            } elseif ($item->item_product_discount_type == 2) {
                $promo = $item->item_product_discount_value;
            }
            $additional = [
                'description' => $item->item_product_description,
                'notes' => '',
                'image' => $item->item_product_image,
                'price' => $item->item_product_sell,
                'discount' => $promo,
                'brand_id' => $item->item_product_item_brand_id ?? '',
                'brand_name' => $item->brand->item_brand_name ?? '',
                'brand_description' => $item->brand->item_brand_description ?? '',
            ];

            Cart::add($item->item_product_id, $item->item_product_name, $item->item_product_sell - $promo, 1, $additional);
            $discount = Cart::getConditions()->first();
            if ($discount) {
                $code = $discount->getName();
                $request['code'] = $code;
                $validate = Validator::make($request, [
                        'code' => 'required|exists:marketing_promo,marketing_promo_code',
                    ], [
                        'code.exists' => 'Voucher Not Valid !',
                    ]);
                Cart::removeCartCondition($code);

                $promo = new PromoRepository();
                $data = $promo->codeRepository(strtoupper($code));
                if ($data) {
                    $value = Cart::getTotal();
                    $matrix = $data->marketing_promo_matrix;
                    if ($matrix) {

                            // validate with minimal
                        $minimal = $data->marketing_promo_minimal;
                        if ($minimal) {
                            if ($minimal > $value) {
                                $validate->getMessageBag()->add('code', 'Minimal value ' . number_format($minimal) . ' !');
                                Cart::removeCartCondition($code);
                                return redirect()->route('cart')->withErrors($validate);
                            }
                        }

                        $string = str_replace('@value', $value, $matrix);
                        $total = $value;

                        try {
                            $total = Helper::calculate($string);
                        } catch (\Throwable $th) {
                            $total = $value;
                        }
                        $promo = Cart::getConditions()->first();
                        $condition = new \Darryldecode\Cart\CartCondition(array(
                                    'name' => $data->marketing_promo_code,
                                    'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                                    'target' => 'subtotal', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                                    'value' => -$total,
                                    'order' => 1,
                                    'attributes' => array( // attributes field is optional
                                        'name' => $data->marketing_promo_name,
                                        'real' => $value,
                                    )
                                ));

                        Cart::condition($condition);
                    }
                } else {
                    $validate->getMessageBag()->add('code', 'Voucher Not Valid !');
                    return redirect()->route('cart')->withErrors($validate)->withInput();
                }
            }
        }
        return redirect()->back();
    }

    public function confirmation()
    {
        $bank = new BankRepository();
        if (request()->isMethod('POST')) {
            $request = request()->all();
            $payment = new PaymentRepository();
            $rules = [
                'finance_payment_amount' => 'required',
                'finance_payment_sales_order_id' => 'required|exists:sales_order,sales_order_id',
                'finance_payment_person' => 'required',
                'finance_payment_phone' => 'required',
                'finance_payment_email' => 'required|email',
                'finance_payment_date' => 'required',
                'files' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'finance_payment_to' => 'required',
            ];
            $message = [
                'finance_payment_amount.required' => 'Masukan Nilai Pembayaran',
                'finance_payment_sales_order_id.required' => 'Nomer Order tidak terdaftar',
                'finance_payment_sales_order_id.exists' => 'Nomer Order tidak ada di database',
                'finance_payment_person.required' => 'Nama pengirim tidak boleh kosong',
                'finance_payment_person.phone' => 'Handphone tidak boleh kosong',
                'finance_payment_email.required' => 'Email pengirim tidak boleh kosong',
                'files.required' => 'Upload Bukti Pembayaran',
            ];
            $validate = Validator::make($request, $rules, $message);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $check = $payment->saveRepository($request);
            if ($check['status']) {
                return redirect()->to('/')->with('success', 'Data has been Success');
            }
        }

        if ($code = request()->get('code')) {
            $order = new OrderRepository();
            $data_order = $order->showRepository($code);
        }
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'order' => $data_order ?? [],
            'bank' => Helper::shareOption($bank, false, true)->pluck('finance_bank_name', 'finance_bank_name'),
        ]);
    }

    public function checkout(EcommerceService $service)
    {
        $address = null;
        $email = null;
        $phone = null;
        $notes = null;
        $name = null;
        $postcode = null;
        $province = null;

        $city = [];
        $location = [];
        $ongkir = [];

        $list_city = [];
        $list_location = [];
        $order = new OrderRepository();
        $account = Helper::shareOption((new BankRepository()), false, true);
        $data_courier = Helper::shareOption((new CourierRepository()), false, true, false);
        $courier = $data_courier->pluck('rajaongkir_courier_name', 'rajaongkir_courier_code')->prepend('- Select Courier -', '')->all();
        if (Auth::check()) {
            $address = Auth::user()->address;
            $phone = Auth::user()->phone;
            $email = Auth::user()->email;
            $name = Auth::user()->name;
            $postcode = Auth::user()->postcode;

            $province = Auth::user()->province;
            $city = Auth::user()->city;
            $location = Auth::user()->location;
        }

        if ($province) {
            $list_city = City::where('rajaongkir_city_province_id', $province)->get()->sortBy('rajaongkir_city_name')->pluck('rajaongkir_city_name', 'rajaongkir_city_id')->toArray();
        }

        if ($city) {
            $list_location = Area::where('rajaongkir_area_city_id', $city)->get()->sortBy('rajaongkir_area_name')->pluck('rajaongkir_area_name', 'rajaongkir_area_id')->toArray();
        }

        if (Cache::has('province')) {
            $list_province =  Cache::get('province');
        } else {
            $list_province = Cache::rememberForever('province', function () {
                return Province::get()->sortBy('province')->pluck('rajaongkir_province_name', 'rajaongkir_province_id')->prepend(' Choose Province', '0')->toArray();
            });
        }


        $validate = [];
        if (request()->isMethod('POST')) {
            $discount = Cart::getConditions()->first();
            $request = request()->all();
            
            if ($discount) {
                $request['sales_order_marketing_promo_code'] = $discount->getName();
                $request['sales_order_marketing_promo_name'] = $discount->getAttributes()['name'];
                $request['sales_order_marketing_promo_value'] = abs($discount->getValue());
            }

            $rules = [
                'sales_order_rajaongkir_address' => 'required',
                'sales_order_email' => 'required|email',
                'sales_order_rajaongkir_name' => 'required',
                'sales_order_rajaongkir_phone' => 'required|regex:/(62)[0-9]{10}/|min:10',
            ];
            $request['sales_order_total'] = Cart::getTotal();
            $validate = Validator::make($request, $rules, ['sales_order_rajaongkir_phone.regex' => 'Handphone menggunakan awalan 62'], $order->custom_attribute);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
                

            $check = $order->saveRepository($request);
            $id = $check['data']->sales_order_id;
            foreach (Cart::getContent() as $item) {
                $stock = ProductRepository::where('item_product_id', $item->id)->first();
                $price_real = $item->price * $item->quantity;

                DB::table('sales_order_detail')->insert([
                    'sales_order_detail_sales_order_id' => $id,
                    'sales_order_detail_item_product_id' => $item->id,
                    'sales_order_detail_qty_order' => $item->quantity,
                    'sales_order_detail_price_order' => $item->price,
                    'sales_order_detail_total_order' => $price_real,
                    'sales_order_detail_item_brand' => $item->attributes['brand_id'],
                    'sales_order_detail_notes' => $item->attributes['notes'],
                    'sales_order_detail_discount' => $stock->item_product_sell - $item->price,
                    'sales_order_detail_price_real' => $stock->item_product_sell,
                ]);

                if (Cart::getContent()->contains('id', $item->id)) {
                    Cart::remove($item->id);
                    if (Cart::isEmpty()) {
                        Cart::clearCartConditions();
                    }
                }
            }

            $data = $order->showRepository($id, ['customer', 'forwarder', 'detail', 'detail.product']);

            return redirect()->route('cart')->with(['success' => true]);
        }


        return redirect()->route('cart')->with([
            ])->withErrors($validate);

        // return View(Helper::setViewFrontend(__FUNCTION__))->with([
        //     'address' => $address,
        //     'email' => $email,
        //     'phone' => $phone,
        //     'name' => $name,
        //     'account' => $account,
        //     'postcode' => $postcode,
        //     'province' => $province,
        //     'city' => $city,
        //     'location' => $location,
        //     'list_province' => $list_province,
        //     'list_city' => $list_city,
        //     'list_location' => $list_location,
        //     'courier' => $courier,
        //     'ongkir' => $ongkir,
        // ])->withErrors($validate);
    }

    public function email($id)
    {
        // $order = new OrderRepository();
        // $data = $order->showRepository($id, ['customer', 'forwarder', 'detail', 'detail.product']);
        // return new CreateOrderEmail($data);

        $order = new PurchasePrepareRepository();
        $data = $order->showRepository($id, ['vendor', 'detail', 'detail.product']);
        return new EmailsCreateOrderEmail($data);

        // $prepare_order = new PurchasePrepareRepository();
        // $prepare_order_data = $prepare_order->dataRepository()->where('purchase_status', 3)->whereNull('purchase_sent_date')->limit(1)->get();
        // if ($prepare_order_data) {

        //     foreach ($prepare_order_data as $prepare_order_item) {

        //         $data = $prepare_order->showRepository($prepare_order_item->purchase_id, ['vendor', 'detail', 'detail.product']);
        //         Mail::to([$data->vendor->procurement_vendor_email, config('website.warehouse')])->send(new EmailsCreateOrderEmail($data));
        //         $data->purchase_sent_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }
    }

    public function contact()
    {
        if (request()->isMethod('POST')) {
            $contact = new ContactRepository();
            $request = request()->all();
            request()->validate($contact->rules);

            $request['marketing_contact_subject'] = 'Question from '.$request['marketing_contact_name'];
            $data = $contact->saveRepository($request);
            if ($data['status']) {
                try {
                    Mail::to(config('website.email'))->send(new ContactEmail($data['data']));
                } catch (Exception $e) {
                }
            }

            return redirect()->back()->withInput();
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function install()
    {
        if (request()->isMethod('POST')) {
            $file = DotenvEditor::load('local.env');
            $file->setKey('DB_CONNECTION', request()->get('provider'));
            $file->setKey('DB_HOST', request()->get('host'));
            $file->setKey('DB_DATABASE', request()->get('database'));
            $file->setKey('DB_USERNAME', request()->get('username'));
            $file->setKey('DB_PASSWORD', request()->get('password'));
            $file->save();
            // dd(request()->get('provider'));
            $value = DotenvEditor::getValue('DB_CONNECTION');
            // dd($value);
            $file = DotenvEditor::setKey('DB_CONNECTION', request()->get('provider'));
            $file = DotenvEditor::save();
            // Config::write('database.connections', request()->get('provider'));
            dd(request()->all());
        }
        // rename(base_path('readme.md'), realpath('').'readme.md');
        return View('welcome');
    }

    public function cara_belanja()
    {
        return View('frontend.' . config('website.frontend') . '.pages.cara_belanja');
    }

    public function konfirmasi()
    {
        if (request()->isMethod('POST')) {
            dd(request()->all());
        }
        return View('frontend.' . config('website.frontend') . '.pages.konfirmasi');
    }

    public function product($slug = false)
    {
        $data_product = new ProductRepository();
        $product = $data_product->slugRepository($slug);

        $discount = 0;
        if ($product->item_product_discount_type == 1) {
            $discount = $product->item_product_sell * $product->item_product_discount_value;
        } elseif ($product->item_product_discount_type == 2) {
            $discount = $product->item_product_discount_value;
        }

        $outstanding = DB::table('view_outstanding_order')->where('sod_product', $product->item_product_id)->get()->pluck('sod_qty', 'sod_option')->all();

        $stock = DB::table('view_stock_product')->where('product', $product->item_product_id)->get();
        $option_stock = $stock->mapWithKeys(function ($item) use ($outstanding) {
            $collect_qty = $item->qty;
            if (array_key_exists($item->id, $outstanding)) {
                $collect_qty = $item->qty - $outstanding[$item->id];
            }

            // $size = $item->size ? $item->size . ' - ' : '';
            // $color = $item->hex ? $item->hex . ' - ' : '';
            // $stock = 'Stock ( ' . $collect_qty . ' )';

            // return [$item->id => $size . $color . $stock];


            $size = $item->size ? $item->size . ' - ' : '';
            $color = $item->hex ?? '';

            $stock = 'Stock ( ' . $collect_qty . ' )';

            return [$item->id => $size . $color];
        })->toArray();

        $additional = [
            'image' => $product->item_product_image,
            'list_option' => $option_stock,
            'option' => $stock->first()->id ?? null,
            'discount' => $discount,
            'stock' => $stock->first()->qty ?? null,
            'gram' => $product->item_product_gram,
        ];

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $validate = Validator::make($request, [
                'qty' => 'required|numeric|min:1',
                'option' => 'required|exists:view_stock_product,id',
            ], [
                'option.exists' => 'Please choose color & size !'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $parse = $stock->where('id', $request['option'])->first();
            $outstanding = DB::table('view_outstanding_order')->where(['sod_option' => $request['option']])->first();
            $outstanding_value = 0;
            if ($outstanding) {
                $outstanding_value = $outstanding->sod_qty ?? 0;
            }

            if ($request['qty']  > $parse->qty - $outstanding_value) {
                $validate->errors()->add('qty', 'Stock Not Enough !');
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $additional = [
                'image' => $product->item_product_image,
                'list_option' => $option_stock,
                'option' => $parse->id ?? null,
                'product' => $product->item_product_id ?? null,
                'size' => $parse->size ?? null,
                'color' => $parse->hex ?? null,
                'stock' => $parse->qty ?? null,
                'discount' => $discount,
                'gram' => $product->item_product_gram,
            ];

            $condition = [];
            $dataTax = $product->tax;
            if (config('website.tax') && $dataTax) {
                $condition = new CartCondition(array(
                    'name' => $dataTax->item_tax_name,
                    'type' => $dataTax->item_tax_type ? 'Percent' : 'Value',
                    'value' => $dataTax->item_tax_type ? (($product->item_product_sell - $discount) * $dataTax->item_tax_value) / 100 : ($product->item_product_sell - $discount) - $dataTax->item_tax_value,
                ));
            }

            Cart::add($parse->id, $product->item_product_name, $product->item_product_sell - $discount, request()->get('qty'), $additional, $condition);
        }

        $product->item_product_counter = $product->item_product_counter + 1;
        $product->save();
        $product_image = $data_product->getImageDetail($product->item_product_id);
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'single_product' => $product,
            'product_image' => $product_image,
            'discount' => $discount,
            'stock' => $stock,
            'list' => $option_stock,
        ]);
    }

    public function detail($slug)
    {
        if (!empty($slug)) {
            $data = DB::table('products')
                ->select(['products.*', 'category.name as categoryName'])
                ->leftJoin('category', 'category.id', 'products.category_id')
                ->where('products.slug', $slug)->first();
            return View('frontend.' . config('website.frontend') . '.pages.detail')->with([
                'data' => $data,
                'category' => Helper::createOption('category-api'),
                'tag' => Helper::createOption('tag-api'),
            ]);
        }
    }

    public function stock()
    {
        if (request()->has('id')) {
            $id = request()->get('id');
            $stock = DB::table('view_stock_product')->leftJoin((new Product())->getTable(), 'product', 'item_product_id')->where('id', $id)->first();
            if ($stock && $stock->item_product_min > $stock->qty) {
                return 'Stock Only ' . $stock->qty;
            }

            return 0;
        }
    }
}
