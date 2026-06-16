<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><img src="{{ asset('images/utama.png') }}" alt="Logo Perpustakaan" style="width: 50px; height: 50px; object-fit: contain;"></div>
        <div class="brand-text">
            <div class="title">E-Library SMPN 8<br>Percut Sei Tuan</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <div class="nav-item">
            <a href="{{ route('kperpus.dashboard') }}"
               class="nav-link {{ request()->routeIs('kperpus.dashboard') ? 'active' : '' }}">
                <i class="fas fa-building-columns"></i> Dashboard
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
                <i class="fas fa-user-graduate"></i> Data Siswa
            </a>
        </div>

        <div class="nav-section-label">Manajemen</div>

        <div class="nav-item">
            <a href="{{ route('kperpus.petugas.index') }}" class="nav-link {{ request()->routeIs('kperpus.petugas.*') ? 'active' : '' }}">
                <i class="fas fa-id-badge"></i> Data Petugas
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('kperpus.report.aktivitas.index') }}" class="nav-link {{ request()->routeIs('kperpus.report.aktivitas.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Laporan Aktivitas
            </a>
        </div>

        <div class="nav-section-label">Akun</div>
        <div class="nav-item">
            <a href="{{ route('kperpus.profile.index') }}" class="nav-link {{ request()->routeIs('kperpus.profile.*') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i> Profil Saya
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