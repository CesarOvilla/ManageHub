<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'deliverable_id', 'title', 'description', 'status', 'order', 'priority', 'score'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
