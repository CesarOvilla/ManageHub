@props(['item'])

@php
    $class =
        'group flex items-center gap-2.5 rounded-lg px-2.5 py-1.5 text-sm font-medium transition-all text-slate-800 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/10 active:text-slate-950 dark:active:text-white';

    $iconClass = 'inline-block w-5 h-5 text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400';

    $activeRoute = isset($item['active_route']) && $item['active_route'] ? $item['active_route'] : $item['route'];
    $isActive = request()->routeIs($activeRoute);

    if ($isActive) {
        $class =
            'group flex items-center gap-2.5 rounded-lg px-2.5 py-1.5 text-sm font-medium transition-all bg-blue-50 text-slate-950 dark:bg-blue-900/20 dark:text-white';
        $iconClass = 'inline-block w-5 h-5 text-blue-600 dark:text-blue-400';
    }
@endphp

@if (!isset($item['permission']))
    <a href="{{ route($item['route']) }}" {{ $attributes->merge(['class' => $class]) }} x-data="{
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
    }">
        @if (isset($item['icon']) && $item['icon'])
            @svg('lucide-' . $item['icon'], $iconClass)
        @endif
        <span x-show="showLabel" x-transition class="grow">
            {{ __($item['label']) }}
        </span>
        @if ($isActive)
            <span x-show="showLabel" x-transition class="text-blue-600 dark:text-blue-400">&bull;</span>
        @endif
    </a>
@elseif (auth()->user()?->hasPermissionTo($item['permission']))
    <a href="{{ route($item['route']) }}" {{ $attributes->merge(['class' => $class]) }} x-data="{
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
    }">
        @if (isset($item['icon']) && $item['icon'])
            @svg('lucide-' . $item['icon'], $iconClass)
        @endif
        <span x-show="showLabel" x-transition class="grow">
            {{ __($item['label']) }}
        </span>
        @if ($isActive)
            <span x-show="showLabel" x-transition class="text-blue-600 dark:text-blue-400">&bull;</span>
        @endif
    </a>
@endif
