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
            $table->foreignId('department_id')->references('department_id')->on('departments')->cascadeOnDelete();
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
            $table->date('timeline_start')->nullable();
            $table->date('timeline_end')->nullable();
            $table->timestamps();
        });

        Schema::create('timelines', function (Blueprint $table) {
            $table->id('timeline_id');
            $table->foreignId('timeline_regist_number')->references('software_id')->on('softwares')->cascadeOnDelete();
            $table->date('timeline_date');
            $table->string('timeline_step');
            $table->string('recorded_by')->nullable();
            // $table->date('timeline_start');
            // $table->date('timeline_end');
            $table->timestamps();
        });

        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->id('files_id');
            $table->foreignId('software_id')->references('software_id')->on('softwares')->cascadeOnDelete(); // Links to the 'softwares' table
            $table->string('original_name'); // Stores the original file name
            $table->string('path'); // Stores the file path
            $table->timestamps(); // To track when files were uploaded
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timelines');
        Schema::dropIfExists('uploaded_files');
        Schema::dropIfExists('softwares');
    }
};
