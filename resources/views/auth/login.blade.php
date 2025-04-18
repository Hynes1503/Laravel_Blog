<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex flex-col items-center space-y-2 w-full mt-3">
            <a href="{{ route('auth.google') }}"
                class="border border-black w-full text-center px-4 py-2 bg-white-500 text-black rounded-full shadow-md hover:bg-red-600 transition">
                <i class="fa-brands fa-google"></i> Login with Goolge
            </a>
            <a href="{{ route('auth.facebook') }}"
                class="border border-black w-full text-center px-4 py-2 bg-white-500 text-blue rounded-full shadow-md hover:bg-blue-600 transition">
                <i class="fa-brands fa-facebook"></i> Login with Facebook
            </a>
        </div>

        <div class="flex items-center justify-between mt-4">
            <!-- Nút Đăng nhập -->
            <div class="w-1/3 flex justify-start">
                <x-primary-button class="">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <!-- Quên mật khẩu -->
            <div class="w-1/3 flex justify-center">
                @if (Route::has('password.request'))
                    <a class="ms-4 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <!-- Đăng ký -->
            <div class="w-1/3 flex justify-end">
                <a class="ms-4 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __("Don't have an account?") }}
                </a>
            </div>
        </div>


        {{-- <div class="flex items-center justify-end mt-4">

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __("Don't have an account?") }}
                </a>
            @endif

            <a href="{{ route('register') }}"
                class="ms-3 inline-flex items-center px-4 py-2 bg-white-800 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register') }}
            </a>

        </div> --}}

    </form>
</x-guest-layout>
