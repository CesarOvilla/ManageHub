<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskDailyLog extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'date', 'daily_elapsed_time'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
