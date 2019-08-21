<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOldNewPricesToCoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->decimal('current_price_euro', 36,18)->nullable();
            $table->decimal('current_price_bgn', 36,18)->nullable();
            $table->decimal('old_price_24h_euro', 36,18)->nullable();
            $table->decimal('old_price_24h_bgn', 36,18)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->dropColumn('current_price_euro');
            $table->dropColumn('current_price_bgn');
            $table->dropColumn('old_price_24h_euro');
            $table->dropColumn('old_price_24h_bgn');
        });
    }
}
