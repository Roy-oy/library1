<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><img src="{{ asset('images/logos.png') }}" alt="Logo Sekolah" style="width: 50px; height: 50px;"></div>
        <div class="brand-text">
            <div class="title">SIP SMP Negeri 1 Percut Sei Tuan</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.dashboard') }}"
               class="nav-link {{ request()->routeIs('ksekolah.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        <div class="nav-section-label">Laporan</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.report.aktivitas.index') }}" 
               class="nav-link {{ request()->routeIs('ksekolah.report.aktivitas.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Laporan Aktivitas
            </a>
        </div>

        <div class="nav-section-label">Pantauan</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.petugas.index') }}" class="nav-link {{ request()->routeIs('ksekolah.petugas.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i> Data Petugas
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.buku.index') }}" class="nav-link {{ request()->routeIs('ksekolah.buku.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Koleksi Buku
            </a>
        </div>

        <div class="nav-section-label">Akun</div>
        <div class="nav-item">
            <a href="{{ route('ksekolah.profile.index') }}" class="nav-link {{ request()->routeIs('ksekolah.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profil Saya
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