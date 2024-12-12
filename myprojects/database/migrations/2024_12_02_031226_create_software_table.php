<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('softwares', function (Blueprint $table) {
            $table->id('software_id');
            $table->string('f_name', length: 191);
            $table->string('l_name', length: 191);
            $table->string('department_id', length: 191);
            $table->string('tel', length: 10);
            $table->string('software_name', length: 191);
            $table->text('problem');
            $table->string('target', length: 191);
            $table->text('purpose');
            $table->string('status', length: 191);
            $table->string('file');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
