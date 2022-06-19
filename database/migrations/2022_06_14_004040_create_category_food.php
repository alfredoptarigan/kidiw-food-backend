<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('category_food', function (Blueprint $table) {
            $table->string('category_uuid');
            $table->string('food_uuid');

            $table->foreign('category_uuid')->references('uuid')->on('categories')->onDelete('cascade');
            $table->foreign('food_uuid')->references('uuid')->on('foods')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_food');
    }
};
