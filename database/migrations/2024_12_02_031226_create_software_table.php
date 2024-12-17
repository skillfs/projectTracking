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
            $table->string('f_name', 191);
            $table->string('l_name', 191);
            $table->string('department_id', 191);
            $table->string('tel', 10);
            $table->string('software_name', 191);
            $table->text('problem');
            $table->string('target', 191);
            $table->text('purpose');
            $table->string('status', 191)->default('pending'); // Default to 'pending'
            $table->boolean('approved_by_dh')->default(false);
            $table->boolean('approved_by_admin')->default(false);
            $table->string('file')->nullable();
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
