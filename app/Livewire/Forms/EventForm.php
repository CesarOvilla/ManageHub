<?php

namespace App\Livewire\Forms;

use App\Enums\EventTypeEnum;
use Livewire\Form;
use App\Models\Event;

class EventForm extends Form
{
    public $id;
    public $project_id;
    public $name;
    public $description;
    public $type = EventTypeEnum::OTRO->value;
    public $duration_minutes;
    public $schedule_type;
    public $days_of_week;
    public $start_time;

    public $users_id = [];

    public function rules(): array
    {
        return [
            'project_id' => ['nullable', 'exists:projects,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'duration_minutes' => ['required', 'integer'],
            'schedule_type' => ['required', 'string'],
            'days_of_week' => ['nullable',],
            'start_time' => ['required', 'date_format:H:i'],
        ];
    }

    public function store(): Event
    {
        // dd($this->all());
        $event =Event::updateOrCreate(
            ['id' => $this->id],
            [
                'project_id' => $this->project_id,
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->type,
                'duration_minutes' => $this->duration_minutes,
                'schedule_type' => $this->schedule_type,
                'days_of_week' => $this->days_of_week,
                'start_time' => $this->start_time,
            ]
        );

        $event->users()->sync($this->users_id);

        return $event;
    }
}
