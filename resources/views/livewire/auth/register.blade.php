<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <h2 class="text-2xl font-bold text-center">{{ __('Create an account') }}</h2>
    <p class="text-center text-zinc-600 dark:text-zinc-400 mb-4">{{ __('Enter your details below to create your account') }}</p>

    @if (session('status'))
        <div class="text-center text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit.prevent="register" class="flex flex-col gap-6">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium">{{ __('Name') }}</label>
            <input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="{{ __('Full name') }}"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
                />
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium">{{ __('Email address') }}</label>
            <input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
                />
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium">{{ __('Password') }}</label>
            <input
                wire:model="password"
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Password') }}"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
                />
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium">{{ __('Confirm password') }}</label>
            <input
                wire:model="password_confirmation"
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Confirm password') }}"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-teal-900"
                />
            @error('password_confirmation') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ __('Create account') }}
            </button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">{{ __('Log in') }}</a>
    </div>
</div>
