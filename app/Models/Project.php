<?php

namespace App\Models;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'status',
        'name',
        'stakeholders',
        'client_email',
        'client_contact',
        'convention',
        'repo_webapp',
        'repo_mobile',
        'server_ip',
        'ssh_credentials',
        'domain',
        'type'
    ];

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role') // Campo intermedio para roles
            ->withTimestamps();
    }


    // Obtener solo los desarrolladores
    public function developers()
    {
        return $this->users()->wherePivot('role', Roles::SOFTWARE_DEVELOPER);
    }

    // Obtener solo el Project Manager
    public function projectManager()
    {
        return $this->users()->wherePivot('role', Roles::PROJECT_MANAGER)->first();
    }

    // Obtener solo el Program Manager
    public function programManager()
    {
        return $this->users()->wherePivot('role', Roles::PROGRAM_MANAGER)->first();
    }

    // Obtener solo el Cliente
    public function client()
    {
        return $this->users()->wherePivot('role', Roles::CLIENT)->first();
    }

}
