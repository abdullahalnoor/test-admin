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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0)->nullable()->comment('self join');	
            $table->unsignedBigInteger('user_id');	
            $table->string('name');
            // $table->string('slug')->unique();
            $table->string('image',300)->nullable();	
            $table->tinyInteger('status')->default(1)->comment('1 = active; 2 = inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
