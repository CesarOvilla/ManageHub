<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-ts-input label="{{ __('Name') }}" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-ts-input label="{{ __('Email') }}" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-ts-password label="{{ __('Password') }}" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-ts-password label="{{ __('Confirm Password') }}" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-ts-checkbox name="terms" id="terms" required>
                        <x-slot:label>
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline hover:text-gray-900 dark:hover:text-gray-100">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline hover:text-gray-900 dark:hover:text-gray-100">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </span>
                        </x-slot:label>
                    </x-ts-checkbox>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-ts-link href="{{ route('login') }}" text="{{ __('Already registered?') }}" underline />

                <x-ts-button type="submit" class="ms-4">
                    {{ __('Register') }}
                </x-ts-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
