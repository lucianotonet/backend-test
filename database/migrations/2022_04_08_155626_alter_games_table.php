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
        Schema::table('games', function (Blueprint $table) {
            $table->integer('spins_limit')->after('revealed_at')->default(0);
            $table->integer('spins_count')->after('spins_limit')->default(0);
            $table->json('spins_history')->after('spins_count')->nullable();
            $table->decimal('total_points', 10, 2)->after('spins_history')->default(0.00);
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('spins_limit');
            $table->dropColumn('spins_history');
            $table->dropColumn('total_points');
        });
    }
};
