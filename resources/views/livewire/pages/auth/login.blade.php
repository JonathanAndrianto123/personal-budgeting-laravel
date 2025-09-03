<x-auth>
    <div class="login-container" data-aos="fade-up">
        <h1>DompetKu</h1>
        <p class="subtitle">Catat & pantau pengeluaranmu setiap hari</p>

        {{-- error display --}}
        @if ($errors->any())
            <div style="color: red; margin-bottom: 1rem;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- login form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="submit-btn">Masuk</button>
        </form>
    </div>

    <style>
        /* CSS kamu yang lama tetap bisa dipakai di sini */
    </style>
</x-auth>
