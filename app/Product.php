<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Seller;
use App\Transaction;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    const PRODUCT_AVAILABLE = 'available';
    const PRODUCT_UNAVAILABLE = 'unavailable';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    protected $hidden = ['pivot'];
    protected $dates = ['deleted_at'];
    public $transformer = ProductTransformer::class;
    public function isAvailable(){
       return $this->status == Product::PRODUCT_AVAILABLE;
    }


    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
