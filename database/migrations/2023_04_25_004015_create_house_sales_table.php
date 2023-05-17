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
        Schema::create('house_sales', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('house_id');
            $table->date('date');
            $table->integer('price');
            $table->integer('estimated_price')->nullable();
            $table->decimal('bedrooms');
            $table->decimal('bathrooms');
            $table->integer('sqft_living');
            $table->integer('sqft_lot');
            $table->decimal('floors');
            $table->string('waterfront');
            $table->tinyInteger('view');
            $table->string('condition');
            $table->string('grade');
            $table->integer('sqft_above');
            $table->integer('sqft_basement');
            $table->integer('yr_built');
            $table->integer('yr_renovated');
            $table->string('zipcode');
            $table->double('lat');
            $table->double('long');
            $table->integer('sqft_living15');
            $table->integer('sqft_lot15');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_sales');
    }
};
