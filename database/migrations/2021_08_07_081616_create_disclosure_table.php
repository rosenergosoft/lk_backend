<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisclosureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disclosure', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->boolean("is_processed");
            $table->boolean("is_show");
            $table->integer("group_by"); // 0 - not grouped, 1 - grouped by quarters, 2 - group by years
            $table->foreignId('user_id');
            $table->foreignId('disclosure_label_id');
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
        Schema::dropIfExists('disclosure');
    }
}
