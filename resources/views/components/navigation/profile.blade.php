<div x-data="{
    showLabel: !isSidebarCollapsed,
    timeout: null,
    init() {
        this.$watch('isSidebarCollapsed', (collapsed) => {
            if (!collapsed) {
                this.timeout = setTimeout(() => this.showLabel = true, 200)
            } else {
                clearTimeout(this.timeout)
                this.showLabel = false
            }
        })
    }
}" x-init="init()">
    <!-- Link a perfil -->
    <a href="{{ route('profile.show') }}"
        class="group flex items-center gap-2.5 rounded-lg px-2.5 py-1.5 text-sm font-medium transition-all
              text-slate-800 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/10
              active:text-slate-950 dark:active:text-white">

        {{-- <x-lucide-icon name="user"
                       class="w-5 h-5 text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400" /> --}}
        @svg('lucide-user', 'w-5 h-5 text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400')
        <span x-show="showLabel" x-transition class="grow">Perfil</span>
    </a>

    <!-- Botón logout -->
    <form method="POST" action="{{ route('logout') }}" @submit.prevent="$el.submit()">
        @csrf
        <button type="submit"
            class="w-full group flex items-center gap-2.5 rounded-lg px-2.5 py-1.5 text-sm font-medium transition-all
                       text-slate-800 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/10
                       active:text-slate-950 dark:active:text-white">
            @svg('lucide-log-out', 'w-5 h-5 text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400')
            <span x-show="showLabel" x-transition>Cerrar sesión</span>
        </button>
    </form>
</div>
