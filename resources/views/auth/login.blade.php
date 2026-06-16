<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Library SMPN 8</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Font Serif Klasik Formal & Sans Serif untuk Keterangan (Konsisten dengan Homepage) -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-classic { font-family: 'Cinzel', serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-0 md:p-6 select-none">

    <!-- CONTAINER UTAMA -->
    <div class="w-full max-w-5xl min-h-screen md:min-h-[620px] bg-white md:rounded-3xl md:shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
        
        <!-- SISI KIRI: PREVIEW GAMBAR SEKOLAH (Mengambil 5 dari 12 Kolom) -->
        <div class="hidden md:flex md:col-span-5 flex-col justify-between p-10 relative bg-cover bg-center text-white" style="background-image: url('{{ asset('images/homes.jpeg') }}');">
            <!-- Overlay Gradasi Gelap yang Elegan -->
            <div class="absolute inset-0 bg-gradient-to-b from-blue-950/80 via-black/50 to-blue-950/90 z-0"></div>

            <!-- Logo & Brand Sekolah -->
            <div class="relative z-10 flex items-center gap-3">
                <div class="p-1 bg-white rounded-lg shadow-md">
                    <img src="{{ asset('images/utama.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                </div>
                <div class="flex flex-col border-l border-white/20 pl-3">
                    <span class="font-bold text-sm tracking-widest font-classic">E-LIBRARY</span>
                    <span class="text-[10px] text-gray-300 tracking-wider uppercase">SMPN 8 PST</span>
                </div>
            </div>

            <!-- Pesan Selamat Datang -->
            <div class="relative z-10 mt-auto">
                <span class="text-amber-400 text-xs font-semibold tracking-widest uppercase block mb-2 font-classic italic">Selamat Datang di</span>
                <h1 class="text-3xl font-bold leading-tight mb-4 font-classic">
                    Ruang Baca <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">Digital</span>
                </h1>
                <p class="text-gray-300 text-xs leading-relaxed max-w-xs border-t border-white/10 pt-4 font-light">
                    Silakan masuk untuk kembali menjelajahi ribuan jendela ilmu dunia dalam genggaman Anda.
                </p>
            </div>
        </div>

        <!-- SISI KANAN: FORM LOGIN (Mengambil 7 dari 12 Kolom) -->
        <div class="flex flex-col justify-center p-8 sm:p-12 md:p-16 bg-white relative md:col-span-7">
            
            <!-- Logo Mobile (Hanya muncul di HP) -->
            <div class="flex md:hidden justify-center mb-6">
                <div class="p-1.5 bg-white rounded-full shadow-md border border-gray-100">
                    <img src="{{ asset('images/utama.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                </div>
            </div>

            <!-- Header Form -->
            <div class="mb-8 text-center md:text-left">
                <h2 class="text-3xl font-bold text-slate-900 tracking-wide font-classic">Masuk Akun</h2>
                <p class="text-sm text-slate-500 mt-1">Akses kembali sistem perpustakaan digital sekolah.</p>
                
                <!-- Notifikasi Error -->
                @if ($errors->any())
                    <div class="mt-4 p-3.5 bg-red-50 text-red-600 text-xs font-medium rounded-xl border border-red-100 text-left flex items-center gap-2.5 shadow-sm">
                        <i class="fas fa-exclamation-circle text-base text-red-500"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
            </div>

            <!-- Form Isian -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Input Username -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 tracking-wider uppercase mb-2">Username</label>
                    <div class="relative group">
                        <input type="text" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-600/10 focus:border-[#0056b3] focus:bg-white transition-all pl-12 text-sm"
                            placeholder="Masukkan nama pengguna">
                        <i class="fas fa-user absolute left-4 top-4 text-slate-400 group-focus-within:text-[#0056b3] transition-colors text-sm"></i>
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-slate-700 tracking-wider uppercase">Password</label>
                    </div>
                    <div class="relative group">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 text-slate-900 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-600/10 focus:border-[#0056b3] focus:bg-white transition-all pr-12 pl-12 text-sm"
                            placeholder="••••••••">
                        <i class="fas fa-lock absolute left-4 top-4 text-slate-400 group-focus-within:text-[#0056b3] transition-colors text-sm"></i>
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Opsi Tambahan -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-slate-600 cursor-pointer font-medium">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#0056b3] focus:ring-[#0056b3] mr-2.5 transition-all">
                        Ingat Saya
                    </label>
                    <a href="#" class="text-[#0056b3] hover:text-[#004085] font-semibold transition-colors">Lupa Password?</a>
                </div>

                <!-- Tombol Masuk Utama (Warna Biru Almamater) -->
                <button type="submit" 
                    class="w-full py-4 bg-[#0056b3] hover:bg-[#004085] text-white font-bold text-xs rounded-xl transition-all duration-300 mt-4 uppercase tracking-widest shadow-lg shadow-blue-600/20 hover:shadow-xl hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </form>

            <!-- Copyright Khusus Tampilan Mobile -->
            <div class="text-center mt-8 text-[10px] text-slate-400 md:hidden">
                &copy; 2026 E-Library SMPN 8 Percut Sei Tuan.
            </div>
            
        </div>

    </div>

    <!-- Script Mata Sandi -->
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