<?php

use Domain\Product\Models\Option;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Option::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('option_value_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('option_value_product');
            Schema::dropIfExists('option_values');
        }
    }
};
