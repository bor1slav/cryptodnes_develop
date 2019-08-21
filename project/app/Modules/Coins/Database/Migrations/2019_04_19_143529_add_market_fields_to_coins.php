<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarketFieldsToCoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->decimal('current_price', 36,18)->nullable();
            $table->decimal('market_cap', 36, 18)->nullable();
            $table->string('market_cap_rank')->nullable();
            $table->decimal('total_volume',36,18)->nullable();
            $table->decimal('high_24h', 36,18)->nullable();
            $table->decimal('low_24h', 36,18)->nullable();
            $table->decimal('price_change_24h', 36,18)->nullable();
            $table->decimal('price_change_percentage_24h', 27,18)->nullable();
            $table->decimal('market_cap_change_24h', 36,18)->nullable();
            $table->decimal('market_cap_change_percentage_24h', 27,18)->nullable();
            $table->decimal('circulating_supply', 36, 18)->nullable();
            $table->decimal('total_supply', 36, 18)->nullable();
            $table->decimal('ath',36,18)->nullable();
            $table->decimal('ath_change_percentage', 36, 18)->nullable();
            $table->decimal('price_change_percentage_1h_in_currency',27, 18)->nullable();
            $table->decimal('price_change_percentage_24h_in_currency',27, 18)->nullable();
            $table->decimal('price_change_percentage_7d_in_currency',27, 18)->nullable();
            $table->decimal('price_change_percentage_30d_in_currency',27, 18)->nullable();
            $table->decimal('price_change_percentage_1y_in_currency',27, 18)->nullable();
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
            $table->dropColumn('current_price');
            $table->dropColumn('market_cap');
            $table->dropColumn('market_cap_rank');
            $table->dropColumn('total_volume');
            $table->dropColumn('high_24h');
            $table->dropColumn('low_24h');
            $table->dropColumn('price_change_24h');
            $table->dropColumn('price_change_percentage_24h');
            $table->dropColumn('market_cap_change_24h');
            $table->dropColumn('market_cap_change_percentage_24h');
            $table->dropColumn('circulating_supply');
            $table->dropColumn('total_supply');
            $table->dropColumn('ath');
            $table->dropColumn('ath_change_percentage');
            $table->dropColumn('price_change_percentage_1h_in_currency');
            $table->dropColumn('price_change_percentage_24h_in_currency');
            $table->dropColumn('price_change_percentage_7d_in_currency');
            $table->dropColumn('price_change_percentage_30d_in_currency');
            $table->dropColumn('price_change_percentage_1y_in_currency');
        });
    }
}
