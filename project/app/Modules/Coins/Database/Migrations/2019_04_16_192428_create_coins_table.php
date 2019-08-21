<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('api_key');
            $table->string('symbol');
            $table->json('homepage')->nullable();
            $table->json('repos_url')->nullable();
            $table->json('blockchain_sites')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('visible')->default(true);
            $table->softDeletes();
            NestedSet::columns($table);
            $table->timestamps();
        });

        Schema::create('coins_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coin_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['coin_id','locale']);
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
        Schema::dropIfExists('coins');
        Schema::dropIfExists('coins_translations');
        Schema::enableForeignKeyConstraints();
    }
}
