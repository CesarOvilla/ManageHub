<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deliverables', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('project_serial')->nullable(); // <= nuevo campo
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->onDelete('set null');
            $table->foreignId('responsable_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('name')->nullable(); // Ahora puede ser nulo
            $table->text('criteria')->nullable();
            $table->text('techspec')->nullable();
            $table->float('estimated_hours')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->unique(['project_id', 'project_serial']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliverables');
    }
};
