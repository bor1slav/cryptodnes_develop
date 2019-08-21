<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateAnalyzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyzes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('analyzes_categories')->onDelete('cascade');
            $table->softDeletes();
            NestedSet::columns($table);

            $table->boolean('visible')->default(false);
            $table->timestamps();
        });

        Schema::create('analyzes_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedBigInteger('analyze_id');
            $table->longText('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('slug')->unique();
            $table->string('locale')->index();
            $table->unique(['analyze_id', 'locale']);

            $table->foreign('analyze_id')->references('id')->on('analyzes')->onDelete('cascade');
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
        Schema::dropIfExists('analyzes');
        Schema::dropIfExists('analyzes_translations');
        Schema::enableForeignKeyConstraints();
    }
}
