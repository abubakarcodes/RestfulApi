<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Product;
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description' , 1000);
            $table->unsignedInteger('quantity');
            $table->string('status')->default(Product::PRODUCT_UNAVAILABLE);
            $table->string('image');
            $table->unsignedBigInteger('seller_id');
            $table->timestamps();
            $table->softDeletes(); //deleted_at
            $table->foreign('seller_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
