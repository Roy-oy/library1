<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center md:p-6">

    <div class="w-full max-w-5xl min-h-screen md:min-h-[600px] bg-white md:rounded-2xl md:shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
        
        <div class="hidden md:flex flex-col justify-between p-12 relative bg-cover bg-center text-white" style="background-image: url('{{ asset('images/home.png') }}');">
            <div class="absolute inset-0 bg-black/60 z-0"></div>

            <div class="relative z-10 flex items-center gap-3">
                <img src="{{ asset('images/logos.png') }}" alt="Logo" class="w-10 h-10 object-contain bg-white/10 p-1 rounded-lg backdrop-blur-sm">
                <span class="font-bold text-lg tracking-wider">E-LIBRARY</span>
            </div>

            <div class="relative z-10 mt-auto">
                <h1 class="text-4xl font-bold leading-tight mb-4">
                    Selamat Datang di <br> <span class="text-amber-400">E-Library</span>
                </h1>
                <p class="text-gray-300 text-sm leading-relaxed max-w-md">
                    Jajahi ribuan jendela ilmu dunia hanya dalam satu genggaman. Silakan masuk untuk mengakses koleksi buku digital, jurnal, dan literatur terbaik kami.
                </p>
            </div>

            <div class="relative z-10 mt-8 text-xs text-gray-400">
                &copy; 2026 E-Library. All rights reserved.
            </div>
        </div>

        <div class="flex flex-col justify-center p-8 sm:p-12 md:p-16 bg-white relative">
            
            <div class="flex md:hidden justify-center mb-6">
                <img src="{{ asset('images/logos.png') }}" alt="Logo" class="w-14 h-14 object-contain">
            </div>

            <div class="mb-8 text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-950 tracking-tight">Masuk Akun</h2>
                <p class="text-sm text-gray-500 mt-2">Akses kembali ruang baca digital Anda.</p>
                
                @if ($errors->any())
                    <div class="mt-4 p-3 bg-red-50 text-red-600 text-xs font-medium rounded-lg border border-red-100 text-left flex items-center gap-2">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
                    <div class="relative">
                        <input type="text" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-black/5 focus:border-black transition-all pl-11"
                            placeholder="Masukkan username Anda">
                        <i class="fas fa-user absolute left-4 top-4 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-black/5 focus:border-black transition-all pr-12 pl-11"
                            placeholder="••••••••">
                        <i class="fas fa-lock absolute left-4 top-4 text-gray-400 text-sm"></i>
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-black focus:ring-black mr-2">
                        Ingat Saya
                    </label>
                    <a href="#" class="text-gray-600 hover:text-black font-medium transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" 
                    class="w-full py-3.5 bg-black hover:bg-gray-800 text-white font-semibold text-sm rounded-lg transition-colors mt-2 uppercase tracking-widest shadow-md shadow-black/10">
                    Masuk
                </button>
            </form>
            
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