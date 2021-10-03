<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AppDocs;

class ChangeAppealsDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appeals_docs', function (Blueprint $table) {
            $table->dropForeign("appeals_docs_appeal_id_foreign");
        });

        Schema::rename("appeals_docs", "app_docs");

        Schema::table('app_docs', function (Blueprint $table) {
            $table->renameColumn('appeal_id', 'entity_id');
            $table->string('type');
        });

        AppDocs::truncate();
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
