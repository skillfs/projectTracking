<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->string('recorded_by')->nullable()->after('timeline_step');
        });
    }

    public function down()
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn('recorded_by');
        });
    }
};
