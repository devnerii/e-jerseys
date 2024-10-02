<x-guest-layout>
    <div class="flex flex-col gap-0 p-0 mt-6 md:flex-row md:shadow-md md:rounded-xl ">
        <div
            class="relative flex flex-col items-center justify-center w-full p-6 shadow-md md:shadow-none bg-slate-100 md:w-12/12 rounded-xl md:rounded-l-xl md:rounded-r-none">
            <div class="mb-4 text-lg text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>



    </div>
</x-guest-layout>
