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
<body class="bg-cover bg-center bg-no-repeat min-h-screen flex items-center justify-center p-4 relative" style="background-image: url('{{ asset('images/home.png') }}');">
    
    <!-- Overlay simpel dengan sedikit blur -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-0"></div>

    <!-- Kotak Login Mewah & Simpel -->
    <div class="w-full max-w-sm bg-white p-8 md:p-10 rounded-xl shadow-2xl relative z-10">
        
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/perpus.png') }}" alt="Logo" class="w-14 h-14 object-contain">
        </div>
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Login</h2>
            
            <!-- Menampilkan Pesan Error Laravel bawaan -->
            @if ($errors->any())
                <div class="mt-3 p-2 bg-red-50 text-red-600 text-xs font-medium rounded border border-red-100 text-left">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors">
            </div>

            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors pr-12">
                <button type="button" onclick="togglePassword()" class="absolute right-4 top-9 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </button>
            </div>

            <button type="submit" 
                class="w-full py-3.5 bg-black hover:bg-gray-800 text-white font-medium text-sm rounded transition-colors mt-2 uppercase tracking-widest">
                Masuk
            </button>
        </form>
        
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