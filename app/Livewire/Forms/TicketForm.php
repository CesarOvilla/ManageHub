<?php

namespace App\Livewire\Forms;

use App\Enums\TicketStatusEnum;
use Livewire\Form;
use App\Models\Ticket;

class TicketForm extends Form
{
    public $id;
    public $user_id;
    public $project_id;
    public $deliverable_id;
    public $title;
    public $description;
    public $status = TicketStatusEnum::PENDIENTE->value;

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'deliverable_id' => ['nullable', 'exists:deliverables,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string',],
            'status' => ['required', 'string', 'max:255'],
        ];
    }

    public function store(): Ticket
    {
        return Ticket::updateOrCreate(
            ['id' => $this->id],
            [
                'user_id' => $this->user_id,
                'project_id' => $this->project_id,
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
            ]
        );

    }
}
