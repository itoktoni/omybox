<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Modules\Item\Dao\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Dao\Models\Material;
use Modules\Production\Models\Vendor;
use Modules\Sales\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\ColorRepository;

class Product extends Model
{
  use SoftDeletes;
  protected $table = 'item_product';
  protected $primaryKey = 'item_product_id';
  protected $fillable = [
    'item_product_id',
    'item_product_slug',
    'item_product_min',
    'item_product_max',
    'item_product_sku',
    'item_product_buy',
    'item_product_image',
    'item_product_sell',
    'item_product_item_category_id',
    'item_product_item_brand_id',
    'item_product_item_tag_json',
    'item_product_item_tax_id',
    'item_product_name',
    'item_product_display',
    'item_product_description',
    'item_product_updated_at',
    'item_product_created_at',
    'item_product_deleted_at',
    'item_product_updated_by',
    'item_product_created_by',
    'item_product_counter',
    'item_product_status',
    'item_product_item_color_json',
    'item_product_item_size_json',
    'item_product_discount_type',
    'item_product_discount_value',
    'item_product_gram',
    'item_product_flag',
    'item_product_care',
    'item_product_return',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $keyType = 'string';
  public $rules = [
    'item_product_name' => 'required|min:3',
    'item_product_sell' => 'required',
    'item_product_gram' => 'required|numeric',
    'item_product_file' => 'file|image|mimes:jpeg,png,jpg|max:4048',
  ];

  public $with = ['brand', 'material'];

  const CREATED_AT = 'item_product_created_at';
  const UPDATED_AT = 'item_product_updated_at';
  const DELETED_AT = 'item_product_deleted_at';

  public $searching = 'item_product_name';
  public $datatable = [
    'item_product_id'          => [false => 'ID'],
    'item_category_name'        => [true => 'Category'],
    'item_category_slug'        => [false => 'Category'],
    'item_product_name'        => [true => 'Product Name'],
    'item_product_flag'        => [false => 'Flag'],
    'item_brand_name'        => [true => 'Brand'],
    'item_brand_slug'        => [false => 'Brand'],
    'item_product_buy'        => [false => 'Buy'],
    'item_product_sell'        => [true => 'Price'],
    'item_product_gram'        => [false => 'Gram'],
    'item_product_image'        => [true => 'Images'],
    'item_product_display'        => [false => 'Frontend'],
    'item_product_slug'        => [false => 'Slug'],
    'item_wishlist_item_product_id'        => [false => 'Product'],
    'item_wishlist_user_id'        => [false => 'User'],
    'item_product_discount_type'        => [false => 'Slug'],
    'item_product_discount_value'        => [false => 'Slug'],
    'item_product_item_tag_json'        => [false => 'Tag'],
    'item_product_description' => [false => 'Description'],
    'item_product_created_at'  => [false => 'Created At'],
    'item_product_created_by'  => [false => 'Updated At'],
  ];

  public $stock = [
    'item_product_id'          => [false => 'ID'],
    'item_brand_name'        => [true => 'Brand'],
    'item_category_name'        => [true => 'Category'],
    'item_category_slug'        => [false => 'Category'],
    'item_product_name'        => [true => 'Full Name'],
    'item_color_name'                    => [true => 'Color'],
    'item_brand_slug'        => [false => 'Brand'],
    'size'                    => [true => 'Size'],
    'qty'                    => [true => 'Qty'],
    'hex'                    => [false => 'Qty'],
    'item_product_gram'        => [false => 'Gram'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public $promo = [
    '0' => ['Not Active', 'danger'],
    '1' => ['Percent', 'primary'],
    '2' => ['Amount', 'success'],
  ];


  public function tax()
  {
    return $this->hasOne(Tax::class, 'item_tax_id', 'item_product_item_tax_id');
  }

   public function brand()
  {
    return $this->hasOne(Brand::class, 'item_brand_id', 'item_product_item_brand_id');
  }

   public function material()
  {
    return $this->hasMany(Material::class, 'item_material_item_product_id', 'item_product_id');
  }

  public static function boot()
  {
    parent::boot();

    parent::creating(function ($model) {
      $model->item_product_id = Helper::autoNumber($model->getTable(), 'item_product_id', 'P' . date('ymd'), 10);
    });
    parent::saving(function ($model) {

      $file = 'item_product_file';
      if (request()->has($file)) {
        $image = $model->item_product_image;
        if ($image) {
          Helper::removeImage($image, Helper::getTemplate(__CLASS__));
        }

        $file = request()->file($file);
        $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
        $model->item_product_image = $name;
      }

      // $request_size = request()->get('item_product_item_size_id');
      // $request_color = request()->get('item_product_item_color_id');
      // $request_name = request()->get('item_product_name');

      // if (!empty($request_color) && !empty($request_size)) {
      //   $size = new SizeRepository();
      //   $data_size = $size->showRepository($request_size)->item_size_code;
      //   $color = new ColorRepository();
      //   $data_color = $color->showRepository($request_color)->item_color_name;

      //   $model->item_product_group_name = $request_name . ' ' . strtoupper($data_color) . ' ' . strtoupper($data_size);
      // } else if (!empty($request_color) && empty($request_size)) {

      //   $color = new ColorRepository();
      //   $data_color = $color->showRepository($request_color)->item_color_name;

      //   $model->item_product_group_name = $request_name . ' ' . strtoupper($data_color);
      // } else if (!empty($request_size) && empty($request_color)) {
      //   $size = new SizeRepository();
      //   $data_size = $size->showRepository($request_size)->item_size_code;

      //   $model->item_product_group_name = $request_name . ' ' . strtoupper($data_size);
      // }

      if (request()->has('item_product_item_tag_json')) {
        $model->item_product_item_tag_json = json_encode(request()->get('item_product_item_tag_json'));
      }
      if (request()->has('item_product_item_color_json')) {
        $model->item_product_item_color_json = json_encode(request()->get('item_product_item_color_json'));
      }
      if (request()->has('item_product_item_size_json')) {
        $model->item_product_item_size_json = json_encode(request()->get('item_product_item_size_json'));
      }

      if ($model->item_product_name && empty($model->item_product_slug)) {
        $model->item_product_slug = Str::slug($model->item_product_name);
      } else {
        $model->item_product_slug = Str::slug($model->item_product_slug);
      }

      $model->item_product_name = strtoupper($model->item_product_name);
      if (Cache::has('item_product_api')) {
        Cache::forget('item_product_api');
      }
    });

    parent::deleting(function ($model) {
      if (request()->has('id')) {
        $data = $model->whereIn($model->getkeyName(), request()->get('id'))->get();
        if ($data) {
          Cache::forget('item_product_api');
          foreach ($data as $value) {
            if ($value->item_product_image) {
              Helper::removeImage($value->item_product_image, Helper::getTemplate(__CLASS__));
            }
          }
        }
      }
    });
  }
}
