@props(['title', 'count', 'icon', 'color' => 'blue'])

@php
    $textColor = "text-$color-500";
@endphp

<div class="relative rounded-2xl border bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
    @svg('heroicon-s-' . $icon, 'absolute bottom-4 right-3 h-14 w-14 ' . $textColor)
    <div class="flex items-center justify-between">
        <i class="fab fa-behance text-xl dark:text-gray-400"></i>
    </div>
    <div class="mt-5 text-2xl font-medium leading-8 dark:text-gray-100">{{ $count }}</div>
    <div class="text-sm dark:text-gray-500">{{ $title }}</div>
</div>
