<x-guest-layout>
    <div class="flex flex-col gap-0 p-0 mt-6 md:flex-row md:shadow-md md:rounded-xl ">
        <div
            class="relative flex items-center justify-center w-full pt-16 pb-6 pl-6 pr-6 shadow-md md:shadow-none md:pr-16 bg-slate-100 md:w-6/12 rounded-xl md:rounded-l-xl md:rounded-r-none">
            <form method="POST" action="{{ route('login') }}">
                <h2 class="absolute top-0 w-full pr-6 mt-6 text-xl font-bold text-center md:pr-16">Authenticate</h2>
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full px-2 py-1 mt-1 " type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block w-full px-2 py-1 mt-1 " type="password" name="password"
                        required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="text-gray-500 border-gray-300 rounded shadow-sm focus:ring-gray-500" name="remember">
                        <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline rounded-md hover:text-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 bg-primary">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div
            class="relative flex items-center pt-16 pb-6 pl-6 pr-6 mt-10 mb-10 shadow-md md:mt-0 md:mb-0 md:shadow-none justify-centerw-full md:pl-16 bg-slate-50 md:w-6/12 rounded-xl md:rounded-r-xl md:rounded-l-none">
            <form method="POST" action="{{ route('register') }}">
                <h2 class="absolute top-0 w-full pr-6 mt-6 text-xl font-bold text-center md:pr-16">Sign up</h2>
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block w-full px-2 py-1 mt-1" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full px-2 py-1 mt-1 " type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block w-full px-2 py-1 mt-1" type="password" name="password"
                        required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block w-full px-2 py-1 mt-1 " type="password"
                        name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">


                    <x-primary-button class="ms-4 bg-primary hover:bg-primary-dark ">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    {{-- Session Status
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    --}}
</x-guest-layout>
