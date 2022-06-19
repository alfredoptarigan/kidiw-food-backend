<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->string('uuid')->primary()->unique()->index();
            $table->string('name');
            $table->string('price');
            $table->boolean('is_available')->default(1);
            $table->integer('quantity')->default(0);
            $table->double('rate_review')->nullable();
            $table->string('image')->nullable();
            $table->text('description');
            $table->softDeletes();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foods');
    }
};
