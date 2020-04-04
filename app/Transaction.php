<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'buyer_id',
        'product_id',
        'quantity',
    ];

    protected $dates = ['deleted_at'];
    public $transformer = TransactionTransformer::class;
    public function buyer(){
        return $this->belongsTo(Buyer::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
