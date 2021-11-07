<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFiledsToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('objectRightsDoc')->after('objectPurpose')->nullable();
            $table->string('waterLoad')->after('objectPurpose')->nullable();
            $table->string('projectLoadCalcDoc')->after('objectPurpose')->nullable();
            $table->string('hasCalculationData')->after('objectPurpose')->nullable();
            $table->string('waterTypeIn')->after('objectPurpose')->nullable();
            $table->string('waterTypeOut')->after('objectPurpose')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('waterTypeOut');
            $table->dropColumn('waterTypeIn');
            $table->dropColumn('hasCalculationData');
            $table->dropColumn('projectLoadCalcDoc');
            $table->dropColumn('waterLoad');
            $table->dropColumn('objectRightsDoc');
        });
    }
}
