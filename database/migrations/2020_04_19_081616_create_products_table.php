<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('barcode')->unique();
            $table->string('category_name');
            $table->decimal('product_base_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('product_discount', 5, 2)->default(0);
            $table->unsignedBigInteger('entered_by')->nullable();            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('shelf')->nullable();
            $table->string('client_id');
            $table->enum('product_status', ['Active', 'Inactive']);
            // $table->decimal('price', 8, 2);
            $table->boolean('status')->default(true);
            $table->timestamps();
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
};
