<header
    class="fixed top-0 start-0 end-0 z-30 flex h-20 items-center shadow-sm lg:hidden
           bg-white text-slate-800 dark:bg-gray-900 dark:text-slate-200"
>
    <div class="flex justify-between w-full px-4">
        <!-- Logo -->
        <a href="/dashboard" class="text-lg font-bold">
            HUB
        </a>

        <!-- Botones -->
        <div class="flex gap-2">
            <button
                @click="toggleTheme"
                class="h-10 w-10 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-slate-800 dark:text-slate-200"
                title="Cambiar tema"
            >
                🌓
            </button>

            <button
                @click="toggleMobileSidebar"
                class="h-10 w-10 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-slate-800 dark:text-slate-200"
                title="Abrir menú"
            >
                ☰
            </button>
        </div>
    </div>
</header>
