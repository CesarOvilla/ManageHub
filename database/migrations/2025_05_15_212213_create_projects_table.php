<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Relación con el equipo
            $table->foreignId('team_id')
                ->constrained()
                ->onDelete('cascade'); // Si se elimina el equipo, se eliminan los proyectos

            $table->string('status');
            $table->string('name');
            $table->text('stakeholders');
            $table->string('client_email');
            $table->string('client_contact')->nullable();
            $table->string('convention')->unique();
            $table->string('repo_webapp')->nullable();
            $table->string('repo_mobile')->nullable();
            $table->string('server_ip')->nullable();
            $table->text('ssh_credentials')->nullable();
            $table->string('domain')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('projects');
    }
};
