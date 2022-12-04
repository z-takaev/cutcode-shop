<?php

use Domain\Product\Models\Product;
use Domain\Product\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('product_property', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Property::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('value');
        });
    }

    public function down()
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('property_product');
            Schema::dropIfExists('properties');
        }
    }
};
