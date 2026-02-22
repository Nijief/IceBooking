<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skates', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('brand');
            $table->integer('size');
            $table->integer('quantity')->default(0);
            $table->decimal('price_per_hour', 8, 2)->default(150);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skates');
    }
};