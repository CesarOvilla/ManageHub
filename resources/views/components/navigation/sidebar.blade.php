<nav class="fixed bottom-0 start-0 top-0 z-40 flex h-full flex-col transition-all duration-300 ease-in-out border-r-8 bg-white dark:bg-gray-900 border-blue-900/10 dark:border-gray-700"
    :class="{
        'translate-x-0': mobileSidebarOpen,
        '-translate-x-full': !mobileSidebarOpen,
        'lg:translate-x-0': desktopSidebarOpen,
        'lg:-translate-x-full': !desktopSidebarOpen,
        'w-20': isSidebarCollapsed,
        'w-80 lg:w-64': !isSidebarCollapsed
    }"
    aria-label="Main Sidebar Navigation">

    <div class="flex h-20 items-center justify-between px-4" x-data="{
        showHeaderLabel: !isSidebarCollapsed,
        timeout: null,
        init() {
            this.$watch('isSidebarCollapsed', (collapsed) => {
                if (!collapsed) {
                    this.timeout = setTimeout(() => this.showHeaderLabel = true, 200)
                } else {
                    clearTimeout(this.timeout)
                    this.showHeaderLabel = false
                }
            });
        }
    }" x-init="init()">
        <!-- Texto HUB -->
        <a href="/dashboard"
            class="inline-flex items-center gap-2 text-lg font-bold tracking-wide text-slate-800 dark:text-slate-200"
            x-show="showHeaderLabel" x-transition>
            HUB
        </a>

        <!-- Botones -->
        <div class="flex items-center gap-2">
            <!-- Tema (solo escritorio, con transición) -->
            <button @click="toggleTheme" x-show="showHeaderLabel" x-transition
                class="hidden lg:inline-flex h-10 w-10 items-center justify-center rounded-lg
                       bg-slate-100 hover:bg-slate-200 dark:bg-gray-800 dark:hover:bg-gray-700
                       text-slate-800 dark:text-slate-200"
                title="Cambiar tema">
                <template x-if="darkMode">
                    <x-lucide-moon class="w-5 h-5 text-slate-600 dark:text-slate-300" />
                </template>
                <template x-if="!darkMode">
                    <x-lucide-sun class="w-5 h-5 text-slate-600 dark:text-slate-300" />
                </template>
            </button>
            <!-- Colapsar -->
            <button @click="toggleSidebarCollapse"
                class="hidden lg:inline-flex h-10 w-10 items-center justify-center rounded-lg
                       bg-slate-100 dark:bg-gray-800 hover:bg-slate-200 dark:hover:bg-gray-700">
                <template x-if="isSidebarCollapsed">
                    <x-lucide-chevron-right class="w-5 h-5 text-slate-600 dark:text-slate-300" />
                </template>
                <template x-if="!isSidebarCollapsed">
                    <x-lucide-chevron-left class="w-5 h-5 text-slate-600 dark:text-slate-300" />
                </template>
            </button>

            <!-- Cerrar (móvil) -->
            <button @click="closeMobileSidebar"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 dark:bg-gray-800 lg:hidden">
                ✕
            </button>
        </div>
    </div>

    <!-- Menú -->
    <div class="w-full grow space-y-2 overflow-auto p-4">
        @foreach (config('sidebar.menu') as $item)
            @include('components.navigation.sidebar-item', ['item' => $item])
        @endforeach
    </div>

    <!-- Footer -->
    <div class="w-full flex-none space-y-2 p-4 border-t border-slate-200 dark:border-gray-700">
        @include('components.navigation.profile') </div>
</nav>
