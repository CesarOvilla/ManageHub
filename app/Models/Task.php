<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logged_time',
        'estimated_hours',
        'status',
        'project_id',
        'deliverable_id',
        'ticket_id',
        'user_id',
        'order',
        'stage',
        'started_at',
        'paused_at',
        'elapsed_time',
        'is_urgent',
        'event_id',       // Agregado
        'attended',       // Agregado
        'created_at',
        'priority',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'is_urgent' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function deliverable()
    {
        return $this->belongsTo(Deliverable::class);
    }

    public function Ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyLogs()
    {
        return $this->hasMany(TaskDailyLog::class);
    }
}
