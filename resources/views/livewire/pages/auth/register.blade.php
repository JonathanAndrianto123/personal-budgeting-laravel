<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('auth')] class extends Component
{
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<style>
    .login-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 30px;
        color: white;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 10px;
    }

    .login-container h1 {
        font-size: 36px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
    }

    .login-container p.subtitle {
        text-align: center;
        font-size: 14px;
        color: #ddd;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #999;
        border-radius: 5px;
        font-size: 14px;
    }

    .submit-btn {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .link-login {
        font-size: 13px;
        text-align: center;
        margin-top: 15px;
    }

    .link-login a {
        color: #ddd;
        text-decoration: underline;
    }
</style>

<div class="login-container" data-aos="fade-up">
    <h1>DompetKu</h1>
    <p class="subtitle">Daftar akun baru untuk mulai mencatat pengeluaranmu</p>

    <form wire:submit.prevent="register">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Nama</label>
            <input wire:model="name" type="text" id="name" required autofocus>
            @error('name') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input wire:model="email" type="email" id="email" required>
            @error('email') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <input wire:model="password" type="password" id="password" required>
            @error('password') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input wire:model="password_confirmation" type="password" id="password_confirmation" required>
            @error('password_confirmation') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="submit-btn">Daftar</button>
    </form>

    <div class="link-login">
        Sudah punya akun? <a href="{{ route('login') }}" wire:navigate>Masuk di sini</a>
    </div>
</div>