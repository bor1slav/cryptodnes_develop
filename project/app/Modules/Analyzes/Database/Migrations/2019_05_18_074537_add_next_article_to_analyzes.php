<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextArticleToAnalyzes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analyzes', function (Blueprint $table) {
            $table->unsignedBigInteger('next_article_id')->nullable();
            $table->foreign('next_article_id')->references('id')->on('analyzes')->onDelete('cascade');
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
        Schema::table('analyzes', function (Blueprint $table) {
            $table->dropForeign('analyzes_next_article_id_foreign');
            $table->dropColumn('next_article_id');
        });
        Schema::enableForeignKeyConstraints();

    }
}
