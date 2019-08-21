<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionKindsToAnalyzesTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analyzes_translations', function (Blueprint $table) {
            $table->text('mini_description')->nullable();
            $table->string('picture_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analyzes_translations', function (Blueprint $table) {
            $table->dropColumn('mini_description');
            $table->dropColumn('picture_description');
        });
    }
}
