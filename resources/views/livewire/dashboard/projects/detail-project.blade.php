<x-card class="p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

        {{-- Columna 1: Información general --}}
        <div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-3">
                Información General
            </h3>

            <div class="space-y-2 text-sm">
                <div>
                    <span class="font-medium text-slate-600 dark:text-slate-400">Nombre: </span>
                    <span class="text-slate-800 dark:text-slate-300">{{ $project->name }}</span>
                </div>

                <div>
                    <span class="font-medium text-slate-600 dark:text-slate-400">Estatus: </span>
                    <span class="inline-block rounded-full text-xs font-semibold px-2 py-1 
                        bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                        {{ $project->status }}
                    </span>
                </div>

                <div>
                    <span class="font-medium text-slate-600 dark:text-slate-400">Dominio: </span>
                    <a href="{{ $project->domain }}" target="_blank"
                        class="text-blue-600 dark:text-blue-400 hover:underline hover:text-blue-500 dark:hover:text-blue-300 break-words">
                        {{ $project->domain }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna 2: Desarrolladores --}}
        <div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-3">
                Desarrolladores
            </h3>

            <div class="flex items-center flex-wrap gap-2 mt-2">
                @foreach ($project->developers->take(4) as $user)
                    <div class="relative group">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                            class="h-10 w-10 rounded-full border border-slate-300 dark:border-slate-600 shadow-sm" />
                        <div
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-1 text-xs text-white bg-black rounded shadow opacity-0 group-hover:opacity-100 transition">
                            {{ $user->name }}
                        </div>
                    </div>
                @endforeach

                @if ($project->developers->count() > 4)
                    <div class="relative group">
                        <div
                            class="h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-600 flex items-center justify-center text-xs font-semibold text-slate-800 dark:text-slate-100">
                            +{{ $project->developers->count() - 4 }}
                        </div>
                        <div
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-4 py-2 text-xs text-white bg-black rounded shadow opacity-0 group-hover:opacity-100 transition">
                            @foreach ($project->developers->skip(4) as $extraUser)
                                {{ $extraUser->name }}<br>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Columna 3: Project Manager y Program Manager --}}
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">
                    Project Manager
                </h3>
                @if ($project->projectManager())
                    <div class="flex items-center gap-3">
                        <img src="{{ $project->projectManager()->profile_photo_url }}"
                            alt="{{ $project->projectManager()->name }}"
                            class="h-10 w-10 rounded-full object-cover border border-slate-300 dark:border-slate-600" />
                        <div>
                            <p class="font-medium text-slate-800 dark:text-slate-200">{{ $project->projectManager()->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $project->projectManager()->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-500 dark:text-slate-400">No asignado</p>
                @endif
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">
                    Program Manager
                </h3>
                @if ($project->programManager())
                    <div class="flex items-center gap-3">
                        <img src="{{ $project->programManager()->profile_photo_url }}"
                            alt="{{ $project->programManager()->name }}"
                            class="h-10 w-10 rounded-full object-cover border border-slate-300 dark:border-slate-600" />
                        <div>
                            <p class="font-medium text-slate-800 dark:text-slate-200">{{ $project->programManager()->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $project->programManager()->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-500 dark:text-slate-400">No asignado</p>
                @endif
            </div>
        </div>

        {{-- Columna 4: Cliente --}}
        <div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-3">
                Cliente
            </h3>
            @if ($project->client())
                <div class="flex items-center gap-3">
                    <img src="{{ $project->client()->profile_photo_url }}"
                        alt="{{ $project->client()->name }}"
                        class="h-10 w-10 rounded-full object-cover border border-slate-300 dark:border-slate-600" />
                    <div>
                        <p class="font-medium text-slate-800 dark:text-slate-200">{{ $project->client()->name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $project->client()->email }}</p>
                    </div>
                </div>
            @else
                <p class="text-sm text-slate-500 dark:text-slate-400">No asignado</p>
            @endif
        </div>
    </div>
</x-card>
