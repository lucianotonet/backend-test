<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('image');
            $table->decimal('x3_points', 10, 2)->default(1.00);
            $table->decimal('x4_points', 10, 2)->default(2.00);
            $table->decimal('x5_points', 10, 2)->default(3.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('symbols');
    }
};
