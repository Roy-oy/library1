<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
            <div class="brand-logo"><img src="{{ asset('images/utama.png') }}" alt="Logo Perpustakaan" style="width: 50px; height: 50px; object-fit: contain;"></div>
        </div>
        <div class="brand-text">
            <div class="title">E-Library SMPN 8<br>Percut Sei Tuan</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.dashboard') }}"
               class="nav-link {{ request()->routeIs('ksekolah.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </div>

        <div class="nav-section-label">Laporan Analitik</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.report.aktivitas.index') }}" 
               class="nav-link {{ request()->routeIs('ksekolah.report.aktivitas.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan Aktivitas
            </a>
        </div>

        <div class="nav-section-label">Pantauan Data</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.petugas.index') }}" 
               class="nav-link {{ request()->routeIs('ksekolah.petugas.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> Data Petugas
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.buku.index') }}" 
               class="nav-link {{ request()->routeIs('ksekolah.buku.*') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i> Koleksi Buku
            </a>
        </div>

        <div class="nav-section-label">Pengaturan Akun</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.profile.index') }}" 
               class="nav-link {{ request()->routeIs('ksekolah.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> Profil Saya
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                @if(auth()->user()->foto_profile)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="user-info">
                <div class="name">{{ Str::limit(auth()->user()->name, 22) }}</div>
                <div class="role">{{ auth()->user()->getRoleLabel() }}</div>
            </div>
        </div>
    </div>
</aside>