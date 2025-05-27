<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    {{-- <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" /> --}}

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email address') }}</label>
            <input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
            >
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
            <input
                wire:model="password"
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="{{ __('Password') }}"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
            >
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                wire:model="remember"
                id="remember"
                name="remember"
                type="checkbox"
                class="h-4 w-4 text-teal-600 border-gray-300 rounded"
            >
            <label for="remember" class="ml-2 block text-sm text-gray-900">{{ __('Remember me') }}</label>
        </div>

        <div class="flex flex-col items-end gap-2">
            <button
                type="submit"
                class="bg-teal-900 text-white text-1xl font-bold py-2 px-5 rounded-lg shadow hover:bg-teal-800 w-full"
            >
                {{ __('Log in') }}
            </button>
            @if (Route::has('password.request'))
                <a class="text-sm text-teal-700 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="text-teal-700 hover:underline">{{ __('Sign up') }}</a>
        </div>
    @endif
</div>
