<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')->nullable();
        });
    }

    public function down()
    {
        if (app()->isLocal()) {
            Schema::table('users', function (Blueprint $table) {
                //
            });
        }
    }
};
