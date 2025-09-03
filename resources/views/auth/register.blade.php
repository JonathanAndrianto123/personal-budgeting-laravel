@extends('auth')
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

    .form-group input[type="email"],
    .form-group input[type="text"],
    .form-group input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #999;
        border-radius: 5px;
        font-size: 14px;
    }

    .form-group input[type="checkbox"] {
        margin-right: 5px;
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
        /* transition: background 0.3s ease; */
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .forgot-link {
        font-size: 13px;
        float: right;
    }
</style>

@section('login')

<div class="login-container" data-aos="fade-up">
    <h1>DompetKu</h1>
    <p class="subtitle">Catat & pantau pengeluaranmu setiap hari</p>

    
    <form action="{{ route('register-proses') }}" method="POST">
        @csrf

        @if (session('fail'))
            <div style="color: red; margin-bottom: 1rem;">
                {{ session('fail') }}
            </div>
        @endif

        <!-- Nama -->
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>            
        </div>

        <!-- Submit -->
        <button type="submit" class="submit-btn">Daftar</button>
    </form>
</div>


@endsection