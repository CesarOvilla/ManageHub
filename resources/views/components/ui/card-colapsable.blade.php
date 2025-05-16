<div class="w-full mx-auto mt-6">
    <x-ts-card x-data="{ open: false }" x-init="open = {{ $open ?? 'false' }}">
        <!-- Título con ícono -->
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <div class="flex flex-row justify-center items-center gap-5">
                <h2 class="text-2xl font-bold">{{ $title }}</h2>
                @isset($saving)
                        {{ $saving }}
                @endisset
            </div>
            <span x-show="!open" class="text-gray-500">@svg('heroicon-c-arrow-down', 'w-4 h-4')</span>
            <span x-show="open" class="text-gray-500">@svg('heroicon-c-arrow-up', 'w-4 h-4')</span>
        </div>
        <hr class='my-2' />
        <!-- Contenido colapsable -->
        <div x-show="open" x-transition x-cloak class="text-gray-700">
            {{ $slot }}
        </div>
    </x-ts-card>
</div>
