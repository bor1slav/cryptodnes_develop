<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoinToBlogArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog', function (Blueprint $table) {
            $table->unsignedBigInteger('coin_id')->nullable();
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('blog', function (Blueprint $table) {
            $table->dropForeign('blog_coin_id_foreign');
            $table->dropColumn('coin_id');
        });
        Schema::enableForeignKeyConstraints();

    }
}
