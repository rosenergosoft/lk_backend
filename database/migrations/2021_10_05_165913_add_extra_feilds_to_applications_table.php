<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFeildsToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('type')->after('user_id');
            $table->string('objectPurpose')->nullable()->after('pricing');
            $table->string('constructionVolume')->nullable()->after('pricing');
            $table->string('totalArea')->nullable()->after('pricing');
            $table->string('commissioningDate')->nullable()->after('pricing');
            $table->string('numberOfStoreys')->nullable()->after('pricing');
            $table->string('warmTotal')->nullable()->after('pricing');
            $table->string('warmHeating')->nullable()->after('pricing');
            $table->string('warmVentilation')->nullable()->after('pricing');
            $table->string('warmHotWaterH')->nullable()->after('pricing');
            $table->string('warmHotWaterR')->nullable()->after('pricing');
            $table->string('warmOther')->nullable()->after('pricing');
            $table->text('legalBase')->nullable()->after('pricing');
            $table->text('landBoundaries')->nullable()->after('pricing');
            $table->text('typeOfLand')->nullable()->after('pricing');
            $table->text('limitingParams')->nullable()->after('pricing');
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
            //
        });
    }
}
