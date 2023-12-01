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
        Schema::create('task_table', function (Blueprint $table) {
            $table->id();
            $table->char('task_name');
            $table->text('description');
            $table->date('assignment_date')->default(now()->toDateString());
            $table->date('deadline');
            $table->char('status')->default('pending');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('Cascade');
            $table->foreignId('admin_id')->references('id')->on('users')->onDelete('Cascade');
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_table');
    }
};
