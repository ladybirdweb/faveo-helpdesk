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
        Schema::table('kb_comment', function (Blueprint $table) {
            $table->foreign('article_id', 'comment_article_id_foreign')->references('id')->on('kb_article')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kb_comment', function (Blueprint $table) {
            $table->dropForeign('comment_article_id_foreign');
        });
    }
};
