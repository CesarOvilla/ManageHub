<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('task_daily_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->date('date');  // Fecha del día trabajado
            $table->integer('daily_elapsed_time')->default(0);  // Tiempo acumulado en segundos para ese día
            $table->timestamps();

            $table->unique(['task_id', 'date']);  // Aseguramos que solo haya un registro por día y tarea
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_daily_logs');
    }
};
