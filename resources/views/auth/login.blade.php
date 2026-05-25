<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 2.5rem 2rem 2rem;
            text-align: center;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: #14b8a6;
            color: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.2rem;
            box-shadow: 0 8px 15px rgba(20, 184, 166, 0.25);
        }

        .card-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            color: #0f766e;
            margin-bottom: 4px;
        }

        .card-header p {
            color: #64748b;
            font-size: 1rem;
        }

        .card-body {
            padding: 0 2rem 2.5rem;
        }

        .form-group {
            margin-bottom: 1.4rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Icon kiri (user & lock) */
        .input-wrapper > i:first-child { 
            position: absolute;
            left: 16px;
            color: #64748b;
            font-size: 1.1rem;
            z-index: 2;
            pointer-events: none; /* Supaya klik tembus ke input */
        }

        input {
            width: 100%;
            /* Padding: Atas Kanan Bawah Kiri */
            /* Padding kanan dibuat 50px agar teks tidak menabrak icon mata */
            padding: 14px 50px 14px 48px;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #14b8a6;
            background: white;
        }

        /* Tombol Icon Mata */
        .toggle-password {
            position: absolute;
            right: 12px; /* Mengatur jarak dari sisi kanan kolom input */
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 8px;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #14b8a6;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer {
            text-align: center;
            padding: 1.5rem;
            color: #64748b;
            font-size: 0.9rem;
            border-top: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="card-header">
        <div class="logo">📚</div>
        <h1>Selamat Datang</h1>
        <p>Sistem Perpustakaan Sekolah</p>
    </div>

    <div class="card-body">
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Masukkan username Anda" autofocus required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Masukkan password Anda"
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-arrow-right"></i> MASUK
            </button>
        </form>
    </div>

    <div class="footer">
        © 2024 Sistem Perpustakaan Sekolah
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>