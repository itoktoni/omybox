<?php

namespace Modules\Item\Http\Controllers;

use Plugin\Helper;
use Plugin\Notes;
use Plugin\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Intervention\Image\Facades\Image;
use Modules\Item\Http\Services\ProductService;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Item\Dao\Repositories\TaxRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;

class ProductController extends Controller
{
    public $template;
    public $folder;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ProductRepository();
        }
        $this->folder = 'Item';
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $brand = Helper::createOption((new BrandRepository()));
        $category = Helper::createOption((new CategoryRepository()));
        $tax = Helper::createOption((new TaxRepository()));
        $tag = Helper::shareTag((new TagRepository()), 'item_tag_slug');
        $color = Helper::shareOption((new ColorRepository()), false);
        $size = Helper::shareTag((new SizeRepository()), 'item_size_code');
        $type = Helper::shareStatus(self::$model->promo);

        $view = [
            'key'       => self::$model->getKeyName(),
            'brand'      => $brand,
            'category'  => $category,
            'tag'  => $tag,
            'tax'  => $tax,
            'color'  => $color,
            'size'  => $size,
            'type'  => $type,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $check = $service->save(self::$model);
            if ($check['status']) {
                return redirect()->route($this->getModule() . '_update', ['code' => $check['data']->item_product_id]);
            }
            return redirect()->back();
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);

            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'image_detail' => self::$model->getImageDetail($data->item_product_id),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete_image()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            self::$model->deleteImageDetail($code);

            Helper::removeImage($code, 'product_detail');
            return response()->json(['status' => $code]);
        }
    }

    public function upload()
    {
        if (request()->has('code')) {

            $code = request()->get('code');
            $path = public_path('files/product_detail');
            $photos = request()->file('file');

            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $name = sha1(date('YmdHis') . Str::random(30));
                $save_name = $name . '.' . $photo->getClientOriginalExtension();
                $resize_name = 'thumbnail_' . $save_name;

                Image::make($photo)
                    ->resize(250, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->save($path . '/' . $resize_name);

                $photo->move($path, $save_name);
                self::$model->saveImageDetail($code, $save_name);
            }

            return response()->json(['status' => 1]);
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['item_product_image'])->datatable(self::$model);
            $datatable->editColumn('item_product_sell', function ($select) {
                return number_format($select->item_product_sell);
            });
            $datatable->editColumn('item_product_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->item_product_image);
            });
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
