<div x-data="{ activeTab: @entangle('currentTab') }" class="w-full">
    <x-ts-loading delay="shortest" loading="selectTab" />

    {{-- Tabs --}}
    <ul class="flex overflow-x-auto border-b border-slate-200 dark:border-slate-700 space-x-2 sm:space-x-4 -mb-px">
        @foreach ($statuses as $status)
            <li>
                <button wire:click.prevent="$set('currentTab', '{{ $status }}')"
                    x-on:click="activeTab = '{{ $status }}'"
                    class="relative whitespace-nowrap px-4 sm:px-6 py-3 text-sm font-medium rounded-t
                        text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200
                        transition-colors duration-200"
                    :class="{
                        'border-b-2 border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400': activeTab === '{{ $status }}'
                    }">
                    {{ $status }}
                    <x-ts-badge text="{{ $status_deliverable_count[$status] }}" sm outline color="indigo" />

                    {{-- Subrayado animado --}}
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 dark:bg-indigo-400
                            transform scale-x-0 origin-left transition-transform duration-200"
                        :class="{ 'scale-x-100': activeTab === '{{ $status }}' }">
                    </span>
                </button>
            </li>
        @endforeach
    </ul>

    {{-- Contenido de cada tab --}}
    @foreach ($statuses as $status)
        <div x-show="activeTab === '{{ $status }}'"
            x-transition:enter="transition-opacity ease-out duration-200 transform"
            x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition-opacity ease-in duration-150 transform"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
            class="tab-content pt-7">
            @if ($currentTab === $status)
                @livewire('dashboard.projects.cycle.stage-component', ['project' => $project, 'status' => $status, 'deliverable_search' => $deliverable_search], key($status))
            @endif
        </div>
    @endforeach
</div>
