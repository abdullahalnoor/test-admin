<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
              //SETTING THE PRIMARY KEYS
             $table->primary(['category_id','product_id']);
 
             //FOREIGN KEY CONSTRAINTS
             $table->foreign('category_id')->references('id')->onUpdate('cascade')->on('categories')->onDelete('cascade');
             $table->foreign('product_id')->references('id')->onUpdate('cascade')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};