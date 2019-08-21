<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateBlogTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->softDeletes();
            NestedSet::columns($table);
            $table->boolean('visible')->default(false);
            $table->boolean('in_index')->default(false);
            $table->timestamps();
        });

        Schema::create('blog_tags_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tag_id');
            $table->string('title');
            $table->string('locale')->index();

            $table->unique(['tag_id','locale']);
            $table->foreign('tag_id')->references('id')->on('blog_tags')->onDelete('cascade');
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
        Schema::dropIfExists('blog_tags');
        Schema::dropIfExists('blog_tags_translations');
        Schema::enableForeignKeyConstraints();
    }
}
