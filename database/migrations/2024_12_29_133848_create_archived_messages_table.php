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
        Schema::create('archived_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->foreignId('sent_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('sent_to')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('has_attachment')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_messages');
    }
};