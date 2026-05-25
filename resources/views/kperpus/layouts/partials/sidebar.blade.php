<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><i class="fas fa-book-open"></i></div>
        <div class="brand-text">
            <div class="title">SIP Sekolah</div>
            <div class="sub">Sistem Informasi Perpustakaan</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <div class="nav-item">
            <a href="{{ route('kperpus.dashboard') }}"
               class="nav-link {{ request()->routeIs('kperpus.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
        </div>

        <div class="nav-section-label">Manajemen Koleksi</div>

        <div class="nav-item">
            <a href="{{ route('kperpus.buku.index') }}" class="nav-link {{ request()->routeIs('kperpus.buku.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Data Buku
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('kperpus.kategori.index') }}" class="nav-link {{ request()->routeIs('kperpus.kategori.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Kategori Buku
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('kperpus.siswa.index') }}" class="nav-link {{ request()->routeIs('kperpus.siswa.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Siswa
            </a>
        </div>

        <div class="nav-section-label">Transaksi</div>

        <div class="nav-item">
            <a href="{{ route('kperpus.peminjaman.index') }}" class="nav-link {{ request()->routeIs('kperpus.peminjaman.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-heart"></i> Peminjaman
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('kperpus.pengembalian.index') }}" class="nav-link {{ request()->routeIs('kperpus.pengembalian.*') ? 'active' : '' }}">
                <i class="fas fa-undo-alt"></i> Pengembalian
            </a>
        </div>

        <div class="nav-section-label">Manajemen</div>

        <div class="nav-item">
            <a href="{{ route('kperpus.petugas.index') }}" class="nav-link {{ request()->routeIs('kperpus.petugas.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Data Petugas
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('kperpus.report.aktivitas.index') }}" class="nav-link {{ request()->routeIs('kperpus.report.aktivitas.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Laporan Aktivitas
            </a>
        </div>

        <div class="nav-section-label">Akun</div>
        <div class="nav-item">
            <a href="{{ route('kperpus.profile.index') }}" class="nav-link {{ request()->routeIs('kperpus.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Profil Saya
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="name">{{ Str::limit(auth()->user()->name, 22) }}</div>
                <div class="role">{{ auth()->user()->getRoleLabel() }}</div>
            </div>
        </div>
    </div>
</aside>