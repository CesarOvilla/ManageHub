<div class="space-y-8">
    {{-- Input de búsqueda con autofoco --}}
    <div x-data x-init="$nextTick(() => $refs.searchInput.focus())">
        <x-ts-input wire:model.live="search" x-ref="searchInput" label="Buscar" hint="Filtra por nombre de proyecto"
            placeholder="Escribe para buscar..." class="w-full max-w-lg" />
    </div>

    {{-- Grid de tarjetas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">

        @foreach ($projects as $project)
            <a href="{{ route('dashboard.projects.show', $project->id) }}"
                class="group flex flex-col justify-between rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm hover:shadow-md hover:ring-1 hover:ring-blue-400 dark:hover:ring-blue-500 transition duration-200 px-5 py-6 space-y-4">

                <div class="flex items-center space-x-2">
                    @svg('heroicon-o-folder', 'w-5 h-5 text-slate-500 dark:text-slate-300 shrink-0')
                    <h2 class="text-base font-semibold text-slate-800 dark:text-white leading-snug truncate">
                        {{ $project->name }}
                    </h2>
                </div>

                <div>
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold 
                        bg-green-100 dark:bg-green-900 
                        text-green-800 dark:text-green-300 
                        ring-1 ring-inset ring-green-200 dark:ring-green-800">
                        {{ $project->status }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 truncate">
                        {{ $project->domain }}
                    </p>
                </div>

                <div class="flex items-center space-x-2 mt-2">
                    @foreach ($project->developers->take(4) as $user)
                        <div class="relative group">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                class="h-9 w-9 rounded-full border border-slate-300 dark:border-slate-600 shadow-sm ring-1 ring-white dark:ring-slate-900" />
                            <div
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-black text-white text-xs rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10">
                                {{ $user->name }}
                            </div>
                        </div>
                    @endforeach

                    @if ($project->developers->count() > 4)
                        <div class="relative group">
                            <div
                                class="h-9 w-9 flex items-center justify-center rounded-full bg-slate-200 dark:bg-slate-600 text-xs font-semibold text-slate-800 dark:text-white">
                                +{{ $project->developers->count() - 4 }}
                            </div>
                            <div
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-4 py-3 text-xs text-white bg-black rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition max-w-xs z-10 text-left">
                                @foreach ($project->developers->skip(4) as $extraUser)
                                    {{ $extraUser->name }}<br>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
