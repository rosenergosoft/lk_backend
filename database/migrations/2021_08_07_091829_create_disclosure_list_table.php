<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDisclosureListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disclosure_list', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('type_label');
            $table->integer('group'); // 0 - electricity, 1 - water, 2 - warm
            $table->string('title');
            $table->string('deadline');
            $table->string('frequency'); // yearly|quarterly|other
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
        Schema::dropIfExists('disclosure_list');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
