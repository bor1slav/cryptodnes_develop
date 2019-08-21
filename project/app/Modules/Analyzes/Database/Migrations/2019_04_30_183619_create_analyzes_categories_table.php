<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateAnalyzesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyzes_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coin_id')->nullable();
            $table->foreign('coin_id')->references('id')->on('coins')->onDelete('cascade');
            $table->softDeletes();
            NestedSet::columns($table);
            $table->boolean('visible')->default(false);

            $table->timestamps();
        });

        Schema::create('analyzes_categories_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedBigInteger('category_id');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('slug')->unique();
            $table->string('locale')->index();
            $table->unique(['category_id', 'locale']);

            $table->foreign('category_id')->references('id')->on('analyzes_categories')->onDelete('cascade');
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
        Schema::dropIfExists('analyzes_categories');
        Schema::dropIfExists('analyzes_categories_translations');
        Schema::enableForeignKeyConstraints();

    }
}
