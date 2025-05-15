<div class="py-5 sm:flex sm:items-center sm:justify-between ">
    <div>
        <div class="flex items-center gap-x-3">
            <h2 class="text-4xl font-extrabold dark:text-white"> {{ $title }}</h2>
        </div>

    </div>
    <div class="flex items-center mt-4 gap-x-3">
        {{ $slot }}
    </div>
</div>
