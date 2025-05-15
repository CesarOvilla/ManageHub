<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->time('logged_time')->default('00:00:00');
            $table->float('estimated_hours')->nullable();
            $table->string('status');
            $table->boolean('is_urgent')->default(false);
            $table->integer('order')->default(0);
            $table->integer('priority')->default(0)->nullable();
            $table->string('stage')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('paused_at')->nullable();
            $table->integer('elapsed_time')->default(0);
            $table->foreignId('project_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('deliverable_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('ticket_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tasks');
    }
};
