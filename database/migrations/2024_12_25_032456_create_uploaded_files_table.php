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
        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->id('files_id');
            $table->foreignId('software_id')->constrained()->onDelete('cascade'); // Links to the 'softwares' table
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
        Schema::dropIfExists('uploaded_files');
    }
};
