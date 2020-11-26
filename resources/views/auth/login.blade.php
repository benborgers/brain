@section('title', 'Log in to your Brain')

<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <input type="hidden" name="remember" value="true" />

            <div class="flex justify-end mt-4 mb-4">
                <x-jet-button class="ml-4">
                    {{ __('Login') }}
                </x-jet-button>
            </div>

            <div class="space-y-1">
                <a class="block underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    Already have an account?
                </a>

                @if (Route::has('password.request'))
                    <a class="block underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
