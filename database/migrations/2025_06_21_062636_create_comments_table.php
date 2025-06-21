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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment_content')->comment('Content of the comment');
            $table->timestamp('comment_date')->comment('Date of the comment');
            $table->string('reviewer_name')->comment('Name of the reviewer')->nullable();
            $table->string('reviewer_email')->comment('Email of the reviewer')->nullable();
            $table->boolean('is_hidden')->default(false);  
            $table->timestamps();
            $table->foreignId('post_id')->constrained()->onDelete('cascade')->comment('Foreign key to the posts table');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('Foreign key to the users table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
