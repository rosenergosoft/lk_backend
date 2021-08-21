<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('status');
            $table->unsignedSmallInteger('connectionType')->nullable();
            $table->string('requester')->nullable();
            $table->string('contractNumber')->nullable();
            $table->string('contractDate')->nullable();
            $table->string('connectionDuration')->nullable();
            $table->string('objectName')->nullable();
            $table->string('objectLocation')->nullable();
            $table->string('kadastrNum')->nullable();
            $table->unsignedSmallInteger('constructionReason')->nullable();
            $table->string('connectorsCount')->nullable();
            $table->string('maxPower')->nullable();
            $table->string('previousMaxPower')->nullable();
            $table->unsignedSmallInteger('integrityCategory')->nullable();
            $table->unsignedSmallInteger('powerLevel')->nullable();
            $table->unsignedSmallInteger('loadType')->nullable();
            $table->boolean('emergencyAuto')->nullable();
            $table->unsignedSmallInteger('estimationYear')->nullable();
            $table->unsignedTinyInteger('estimationQuater')->nullable();
            $table->string('power')->nullable();
            $table->unsignedInteger('energoCompanyName')->nullable();
            $table->unsignedInteger('pricing')->nullable();
            $table->text('other')->nullable();
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
        Schema::dropIfExists('applications');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
