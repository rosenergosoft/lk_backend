<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDocumentSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('document_id');
            $table->string('type');
            $table->string('hash')->nullable();
            $table->text('sign')->nullable();
            $table->string('sms_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('document_signatures');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
