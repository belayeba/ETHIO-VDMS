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
        Schema::create('notifications', function (Blueprint $table) 
            {
                $table->uuid('notification_id')->primary();  // Use `id` to follow Laravel conventions for primary keys
                $table->uuid('user_id');  // Keep user_id as a UUID
                $table->text('subject');
                $table->text('message');
                $table->string('url');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');  // Use the standard `id` as the foreign key
                $table->softDeletes();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
