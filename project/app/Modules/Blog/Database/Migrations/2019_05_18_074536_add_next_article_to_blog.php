<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextArticleToBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog', function (Blueprint $table) {
            $table->unsignedBigInteger('next_article_id')->nullable();
            $table->foreign('next_article_id')->references('id')->on('blog')->onDelete('cascade');
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
            $table->dropForeign('blog_next_article_id_foreign');
            $table->dropColumn('next_article_id');
        });
        Schema::enableForeignKeyConstraints();

    }
}
