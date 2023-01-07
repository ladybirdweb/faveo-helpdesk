<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kb_article_relationship', function (Blueprint $table) {
            $table->foreign('article_id', 'article_relationship_article_id_foreign')->references('id')->on('kb_article')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('category_id', 'article_relationship_category_id_foreign')->references('id')->on('kb_category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kb_article_relationship', function (Blueprint $table) {
            $table->dropForeign('article_relationship_article_id_foreign');
            $table->dropForeign('article_relationship_category_id_foreign');
        });
    }
};
