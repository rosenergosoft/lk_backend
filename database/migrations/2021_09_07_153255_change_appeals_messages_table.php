<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAppealsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeals_messages', function (Blueprint $table) {
            $table->dropForeign('appeals_messages_appeal_id_foreign');
        });

        Schema::rename("appeals_messages", "messages");

        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('appeal_id', 'entity_id');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
}
