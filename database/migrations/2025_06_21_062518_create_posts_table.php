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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Title of the post');
            $table->text('content')->comment('Content of the post');
            $table->string('slug');
            $table->timestamp('publication_date')->comment('publication date')->nullable();
            $table->timestamp('last_modified_date')->comment('moification date')->nullable();
            $table->string('status')->comment('(D - Draft, P - Published, I - Inactive)');
            $table->text('featured_image_url')->comment('URL of the featured image');
            $table->integer('views_count')->comment('view count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
