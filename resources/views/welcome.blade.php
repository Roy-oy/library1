<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library | SMPN 8 Percut Sei Tuan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
<body class="relative bg-cover bg-center bg-no-repeat flex flex-col h-screen" style="background-image: url('{{ asset('images/homes.jpeg') }}');">

    {{-- 
        Overlay dibuat dua lapis:
        1. Lapis bawah: warna biru gelap transparan supaya foto tetap kelihatan
           tapi ada nuansa warna yang menyatu dengan tema sekolah (biru putih)
        2. Lapis atas: gradient gelap hanya di atas dan bawah untuk memastikan
           teks header dan footer terbaca jelas
    --}}

    {{-- Lapis 1: tint biru ringan agar foto tidak terlihat "mentah" --}}
    <div class="absolute inset-0 z-0" style="background: rgba(15, 40, 80, 0.30);"></div>

    {{-- Lapis 2: gradient gelap hanya di tepi atas dan bawah --}}
    <div class="absolute inset-0 z-0" style="background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0.45) 0%,
        rgba(0, 0, 0, 0.05) 25%,
        rgba(0, 0, 0, 0.05) 75%,
        rgba(0, 0, 0, 0.45) 100%
    );"></div>

    <!-- HEADER -->
    <header class="relative z-10 w-full px-8 md:px-16 py-6 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logos.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            <div class="flex flex-col">
                <span class="text-blue-300 font-semibold text-xs tracking-wider uppercase">E-Library</span>
                <h1 class="text-white font-bold text-base md:text-lg tracking-wide uppercase">
                    SMPN 8 Percut Sei Tuan
                </h1>
            </div>
        </div>
        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition-colors shadow-md">
            Masuk / Login
        </a>
    </header>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-grow flex items-center justify-center flex-col text-center px-6 max-w-3xl mx-auto">
        <h2 class="text-4xl md:text-6xl font-bold text-white mb-4 tracking-tight drop-shadow-lg">
            Selamat Datang
        </h2>
        <p class="text-base md:text-xl text-gray-100 font-normal leading-relaxed max-w-xl drop-shadow">
            Jelajahi Dunia Pengetahuan Tanpa Batas di Perpustakaan Digital Kami.
        </p>
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 w-full text-center py-6 text-gray-300 text-xs md:text-sm tracking-wide">
        &copy; 2026 E-Library SMPN 8 Percut Sei Tuan. All Rights Reserved.
    </footer>

</body>
</html>