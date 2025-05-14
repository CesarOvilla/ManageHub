<div
    class="relative z-20 flex flex-col sm:w-[30rem] rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-lg px-4">

    <div class="flex justify-center items-center mt-4">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
