<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
  protected $table = 'item_wishlist';
  protected $primaryKey = 'item_wishlist_id';
  protected $fillable = [
    'item_wishlist_id',
    'item_wishlist_item_product_id',
    'item_wishlist_user_id',
    'item_wishlist_updated_at',
    'item_wishlist_created_at',
    'item_wishlist_deleted_at',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_wishlist_item_product_id' => 'required',
    'item_wishlist_user_id' => 'required',
  ];

  const CREATED_AT = 'item_wishlist_created_at';
  const UPDATED_AT = 'item_wishlist_updated_at';
  const DELETED_AT = 'item_wishlist_deleted_at';

  public $searching = 'item_wishlist_item_product_id';
  public $datatable = [
    'item_wishlist_id'          => [true => 'ID'],
    'item_wishlist_created_at'  => [true => 'Created At'],
  ];
}
