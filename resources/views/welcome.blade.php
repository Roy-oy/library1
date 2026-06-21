<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library | SMPN 8 Percut Sei Tuan</title>
    <!-- Font Serif Klasik Formal & Sans Serit untuk Keterangan -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
            margin: 0;
            height: 100vh;
        }
        .font-classic {
            font-family: 'Cinzel', serif;
        }
    </style>
</head>
<body class="relative bg-cover bg-center bg-no-repeat flex flex-col h-screen select-none" style="background-image: url('{{ asset('images/homes.jpeg') }}');">

    <!-- OVERLAY: Gradasi lembut dari kiri ke kanan (Sisi kiri gelap untuk teks, sisi kanan terang untuk memperlihatkan foto sekolah) -->
    <div class="absolute inset-0 z-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>

    <!-- MAIN CONTAINER -->
    <div class="relative z-10 flex flex-col h-full justify-between px-8 md:px-20 py-8">
        
        <!-- HEADER -->
        <header class="flex justify-between items-center w-full">
            <div class="flex items-center gap-4">
                <div class="p-1.5 bg-white rounded-xl shadow-lg border border-gray-100">
                    <img src="{{ asset('images/utama.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                </div>
                <div class="flex flex-col border-l-2 border-white/20 pl-4">
                    <span class="text-white font-bold text-lg tracking-widest font-classic">E-LIBRARY</span>
                    <span class="text-gray-300 text-xs tracking-wider uppercase font-medium">SMPN 8 Percut Sei Tuan</span>
                </div>
            </div>
        </header>

        <!-- CONTENT SIDE -->
        <main class="w-full text-center mx-auto my-auto pt-10 flex flex-col items-center">
            <!-- Label Kecil Klasik -->
            <div class="inline-flex items-center justify-center gap-2 px-3 py-1 bg-blue-600/20 border border-blue-500/30 rounded-full mb-6">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="text-blue-300 text-xs font-semibold tracking-widest uppercase">Official Digital Library</span>
            </div>

            <!-- Judul Utama yang Tegas & Berwibawa -->
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight tracking-wide font-classic drop-shadow-md">
                Gerbang Ilmu <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-white">Masa Depan Bangsa</span>
            </h2>

            <!-- Deskripsi Singkat & Jelas -->
            <p class="text-gray-300 text-sm md:text-base font-light leading-relaxed mb-8 max-w-lg mx-auto border-b border-white/10 pb-6">
                Akses ribuan buku, jurnal, dan materi pembelajaran digital dalam satu platform terintegrasi. Mewujudkan generasi UPT SPF SMP Negeri 8 yang cerdas dan berkarakter.
            </p>

            <!-- Tombol Aksi Utama yang Rapi -->
            <div class="flex flex-col items-center gap-2">
                <a href="{{ route('login') }}" class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition-all duration-300 shadow-xl hover:shadow-blue-600/20 hover:-translate-y-0.5 tracking-wide">
                    Silahkan Login
                </a>
                <span class="text-xs text-gray-400 italic">Gunakan akun akses resmi</span>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="flex flex-col items-center justify-center w-full border-t border-white/10 pt-4 text-gray-400 text-xs tracking-wide gap-2">
            <div>
                &copy; 2026 E-Library SMPN 8 Percut Sei Tuan.
            </div>
            <div class="flex gap-4 text-gray-500">
                <span>Cerdas</span>
                <span>•</span>
                <span>Berkarakter</span>
                <span>•</span>
                <span>Literat</span>
            </div>
        </footer>

    </div>

</body>
</html>