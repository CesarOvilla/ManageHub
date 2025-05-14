<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-ts-input label="{{ __('Email') }}" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-ts-password label="{{ __('Password') }}" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <x-ts-checkbox id="remember_me" name="remember">
                    <x-slot:label>
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </x-slot:label>
                </x-ts-checkbox>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <x-ts-link href="{{ route('password.request') }}" text="{{ __('Forgot your password?') }}" underline />
                @endif

                <x-ts-button type="submit" class="ms-4">
                    {{ __('Log in') }}
                </x-ts-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
