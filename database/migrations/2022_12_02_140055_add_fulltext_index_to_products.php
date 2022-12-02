<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('text')
                ->nullable();

            $table->fullText(['name', 'text']);
        });
    }

    public function down()
    {
        if (app()->isLocal()) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('text');
            });
        }
    }
};
