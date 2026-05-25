<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><i class="fas fa-school"></i></div>
        <div class="brand-text">
            <div class="title">SIP Sekolah</div>
            <div class="sub">Panel Kepala Sekolah</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>
        <a href="{{ route('ksekolah.dashboard') }}"
           class="nav-link {{ request()->routeIs('ksekolah.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>

        <div class="nav-section-label">Laporan</div>
        <a href="{{ route('ksekolah.report.aktivitas.index') }}" 
           class="nav-link {{ request()->routeIs('ksekolah.report.aktivitas.*') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Laporan Aktivitas
        </a>

        <div class="nav-section-label">Pantauan</div>
        <a href="{{ route('ksekolah.petugas.index') }}" class="nav-link {{ request()->routeIs('ksekolah.petugas.*') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i> Data Petugas
        </a>
        <a href="{{ route('ksekolah.buku.index') }}" class="nav-link {{ request()->routeIs('ksekolah.buku.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Koleksi Buku
        </a>

        <div class="nav-section-label">Akun</div>
        <a href="{{ route('ksekolah.profile.index') }}" class="nav-link {{ request()->routeIs('ksekolah.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i> Profil Saya
        </a>
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