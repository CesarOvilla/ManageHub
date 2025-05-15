<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_serial',
        'project_id',
        'name',
        'criteria',
        'techspec',
        'estimated_hours',
        'start_date',
        'end_date',
        'status',
        'type',
        'ticket_id',
        'responsable_id'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
