@use('App\Enums\EventScheduleTypeEnum')

<form wire:submit.prevent="save" class="max-w-screen-lg mx-auto p-4">
    <x-card class="space-y-8 p-6">

        {{-- Título principal --}}
        <h1 class="text-center text-xl font-bold text-slate-800 dark:text-white">
            {{ $event ? __('Editar evento') : __('Agregar evento') }}
        </h1>

        {{-- Información del Evento --}}
        <fieldset class="space-y-4">
            <legend class="text-lg font-semibold text-slate-700 dark:text-slate-200 border-b pb-2">
                {{ __('Información del Evento') }}
            </legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ts-input label="Nombre" wire:model="form.name" />
                <x-ts-select.styled label="Proyecto" wire:model.live="form.project_id" :options="$projects"
                    select="label:label|value:value" />
                <x-ts-select.styled label="Usuario" wire:model.live="form.users_id" :options="$users"
                    select="label:label|value:value" multiple searchable />
                <x-ts-select.styled label="Tipo" wire:model="form.type" :options="$eventTypes"
                    select="label:label|value:value" />
            </div>

            <x-ts-textarea label="Descripción" wire:model="form.description" resize-auto />
        </fieldset>

        {{-- Horario del Evento --}}
        <fieldset class="space-y-4">
            <legend class="text-lg font-semibold text-slate-700 dark:text-slate-200 border-b pb-2">
                {{ __('Horario del Evento') }}
            </legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ts-input label="Duración (minutos)" type="number" wire:model="form.duration_minutes" />
                <x-ts-select.styled label="Tipo de horario" wire:model.live="form.schedule_type"
                    :options="$scheduleTypes" select="label:label|value:value" />

                @if ($form->schedule_type == EventScheduleTypeEnum::DAYS_OF_WEEK->value)
                    <x-ts-select.styled label="Día de la semana" wire:model="form.days_of_week"
                        :options="$weekDays" select="label:label|value:value" multiple />
                @endif

                @if (
                    $form->schedule_type == EventScheduleTypeEnum::WEEKLY->value ||
                    $form->schedule_type == EventScheduleTypeEnum::TWO_WEEKS->value)
                    <x-ts-select.styled label="Día de la semana" wire:model="form.days_of_week"
                        :options="$weekDays" select="label:label|value:value" />
                @endif

                @if ($form->schedule_type == EventScheduleTypeEnum::MONTHLY->value)
                    <x-ts-input label="Día del mes" type="number" wire:model="form.days_of_week" min="1" max="31" />
                @endif

                <x-ts-time label="Hora de inicio" wire:model="form.start_time" format="24" />
            </div>
        </fieldset>

        {{-- Botón Guardar --}}
        <div class="pt-4 text-right">
            <x-button>
                {{ __('Guardar') }}
            </x-button>
        </div>

    </x-card>
</form>
