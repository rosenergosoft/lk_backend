<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->bigInteger('user_id')
                ->unsigned()
                ->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('sms_codes', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();

            $table->bigInteger('document_id')->unsigned()->change();
            $table->foreign('document_id')
                ->references('id')->on('documents')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('document_signatures', function (Blueprint $table) {
            $table->bigInteger('document_id')->unsigned()->change();
            $table->foreign('document_id')
                ->references('id')->on('documents')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('disclosure', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();

            $table->bigInteger('disclosure_label_id')->unsigned()->change();
            $table->foreign('disclosure_label_id')
                ->references('id')->on('disclosure_list')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();
        });


        Schema::table('applications', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('appeals', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('appeals_docs', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();

            $table->bigInteger('appeal_id')->unsigned()->change();
            $table->foreign('appeal_id')
                ->references('id')->on('appeals')
                ->onDelete('cascade')
                ->change();
        });

        Schema::table('appeals_messages', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();

            $table->bigInteger('appeal_id')->unsigned()->change();
            $table->foreign('appeal_id')
                ->references('id')->on('appeals')
                ->onDelete('cascade')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
