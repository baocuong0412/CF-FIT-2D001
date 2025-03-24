<x-guest-layout>
    <div>
        <h1 class="text-center" style="font-size: 40px; font-weight: bold;">Đăng Nhập</h1>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if (session('error'))
        <div class="mb-4 text-red-600 font-semibold text-center">
            {{ session('error') }}
        </div>
    @endif


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <div class="flex justify-between items-center">
                <!-- Nhớ tài khoản của tôi -->
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Nhớ tài khoản của tôi') }}</span>
                </label>

                <!-- Quên mật khẩu? -->
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                @endif
            </div>
        </div>


        <div class="text-center mt-4">
            <div>
                <x-primary-button class="">
                    {{ __('Đăng Nhập') }}
                </x-primary-button>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex justify-center border-2 border-gray-400 p-2 rounded-lg">
                <img src="{{ asset('images/logo-google.png') }}" alt="logo-google"
                    style="width: 30px; margin-right: 2px">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-1 "
                    href="{{ route('google.redirect') }}">
                    {{ __('Đăng nhập bằng Google.') }}
                </a>
            </div>

            <div class="flex justify-center mt-2">
                <p>{{ __('Bạn muốn đăng ký tài khoản?') }}</p>

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __('Đăng ký tài khoản.') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
