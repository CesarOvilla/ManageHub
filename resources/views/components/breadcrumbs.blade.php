@unless ($breadcrumbs->isEmpty())
    <nav aria-label="Breadcrumb" class="container mx-auto mb-6">
        <ol class="flex flex-wrap items-center justify-end gap-1 rounded-md bg-primary-500/5 px-4 py-3 text-sm shadow-sm
                   text-gray-700 dark:text-gray-200 dark:bg-primary-100/10">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="flex items-center gap-1">
                    @if ($breadcrumb->url && !$loop->last)
                        <a href="{{ $breadcrumb->url }}"
                           class="transition-colors font-medium text-primary-600 hover:text-primary-800 hover:underline
                                  dark:text-primary-300 dark:hover:text-primary-200">
                            {{ $breadcrumb->title }}
                        </a>
                    @else
                        <span class="font-semibold text-primary-700 dark:text-primary-200">
                            {{ $breadcrumb->title }}
                        </span>
                    @endif

                    @unless ($loop->last)
                        <svg class="mx-1 h-4 w-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    @endunless
                </li>
            @endforeach
        </ol>
    </nav>
@endunless
