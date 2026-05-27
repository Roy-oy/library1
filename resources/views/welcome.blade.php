<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library | SMPN 1 PERCUT SEI TUAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            margin: 0;
            height: 100vh;
        }
    </style>
</head>
<body class="relative bg-cover bg-center bg-no-repeat flex flex-col" style="background-image: url('{{ asset('images/home.png') }}');">
    
    <!-- Overlay gelap yang rata dan simpel -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <!-- HEADER: Super simpel, bersih, rata -->
    <header class="relative z-10 w-full px-8 md:px-12 py-8 flex justify-between items-center">
        <!-- Kiri: Logo & Judul -->
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/perpus.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            <h1 class="text-white font-semibold text-lg md:text-xl tracking-widest uppercase">
                E-Library SMPN 1 Percut Sei Tuan
            </h1>
        </div>
        
        <!-- Kanan: Button Login (Solid & Elegan) -->
        <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-black font-semibold text-sm uppercase tracking-wider rounded hover:bg-gray-200 transition-colors">
            Login
        </a>
    </header>

    <!-- MAIN CONTENT: Tulisan jelas tanpa efek berlebihan -->
    <main class="relative z-10 flex-grow flex items-center justify-center flex-col text-center px-4">
        <h2 class="text-5xl md:text-7xl font-bold text-white mb-4 tracking-tight">
            Selamat Datang
        </h2>
        <p class="text-lg md:text-xl text-gray-300 font-light tracking-wide">
            Jelajahi Dunia Pengetahuan Tanpa Batas
        </p>
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 w-full text-center py-8 text-gray-400 text-sm font-light">
        &copy; 2026 Sistem Perpustakaan Sekolah
    </footer>

</body>
</html>
