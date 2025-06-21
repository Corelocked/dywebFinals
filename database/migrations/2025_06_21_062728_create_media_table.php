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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->comment('Name of the media file');
            $table->string('file_type')->max(10)->comment('Type of the media file (e.g., image, video, audio)');
            $table->integer('file_size')->default(0)->comment('Size of the media file in bytes');
            $table->string('url')->comment('URL of the media file');
            $table->timestamp('upload_date')->comment('Date when the media file was uploaded')->nullable();
            $table->string('description')->comment('Description of the media file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
