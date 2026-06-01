<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><img src="{{ asset('images/perpus.png') }}" alt="Logo Perpustakaan" style="width: 50px; height: 50px; object-fit: contain;"></div>
        <div class="brand-text">
            <div class="title">SIP Sekolah</div>
            <div class="sub">Panel Penjaga Perpustakaan</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>
        <div class="nav-item">
            <a href="{{ route('pperpus.dashboard') }}"
               class="nav-link {{ request()->routeIs('pperpus.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        {{-- Peminjaman --}}
        <div class="nav-section-label">Sirkulasi</div>
        <div class="nav-item nav-dropdown {{ request()->routeIs('pperpus.peminjaman.*') ? 'open' : '' }}">
            <a href="#" class="nav-link nav-dropdown-toggle {{ request()->routeIs('pperpus.peminjaman.*') ? 'active' : '' }}" onclick="toggleDropdown(this, event)">
                <i class="fas fa-clipboard-list"></i> <span>Peminjaman</span>
                <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('pperpus.peminjaman.perpustakaan.index') }}" 
                   class="nav-link nav-child {{ request()->routeIs('pperpus.peminjaman.perpustakaan.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Buku Perpustakaan
                </a>
                <a href="{{ route('pperpus.peminjaman.bos.index') }}" class="nav-link nav-child {{ request()->routeIs('pperpus.peminjaman.bos.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> Buku BOS
                </a>
            </div>
        </div>

        {{-- Pengembalian --}}
        <div class="nav-item nav-dropdown {{ request()->routeIs('pperpus.pengembalian.*') ? 'open' : '' }}">
            <a href="#" class="nav-link nav-dropdown-toggle {{ request()->routeIs('pperpus.pengembalian.*') ? 'active' : '' }}" onclick="toggleDropdown(this, event)">
                <i class="fas fa-clipboard-check"></i> <span>Pengembalian</span>
                <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('pperpus.pengembalian.perpustakaan.index') }}" class="nav-link nav-child {{ request()->routeIs('pperpus.pengembalian.perpustakaan.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Pengembalian Buku Perpustakaan
                </a>
                <a href="{{ route('pperpus.pengembalian.bos.index') }}" 
                   class="nav-link nav-child {{ request()->routeIs('pperpus.pengembalian.bos.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> Pengembalian Buku BOS
                </a>
            </div>
        </div>

        {{-- Laporan --}}
        <div class="nav-section-label">Manajemen & Laporan</div>
        <div class="nav-item nav-dropdown {{ request()->routeIs('pperpus.report.*') ? 'open' : '' }}">
            <a href="#" class="nav-link nav-dropdown-toggle {{ request()->routeIs('pperpus.report.*') ? 'active' : '' }}" onclick="toggleDropdown(this, event)">
                <i class="fas fa-chart-bar"></i> <span>Laporan</span>
                <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('pperpus.report.aktivitas.index') }}" 
                   class="nav-link nav-child {{ request()->routeIs('pperpus.report.aktivitas.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Aktivitas
                </a>
                <a href="{{ route('pperpus.report.denda.index') }}" 
                   class="nav-link nav-child {{ request()->routeIs('pperpus.report.denda.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i> Denda
                </a>
            </div>
        </div>

        <div class="nav-item">
            <a href="{{ route('pperpus.buku.index') }}" class="nav-link {{ request()->routeIs('pperpus.buku.index') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i> Cari Buku
            </a>
        </div>

        <div class="nav-section-label">Akun</div>
        <div class="nav-item">
            <a href="{{ route('pperpus.profile.index') }}" 
               class="nav-link {{ request()->routeIs('pperpus.profile.*') ? 'active' : '' }}">
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

{{-- ===== CSS Tambahan untuk Dropdown ===== --}}
<style>
.nav-dropdown-menu {
    display: none;
    overflow: hidden;
    background: #f8fafc;
    border-radius: 8px;
    margin: 4px 1.2rem 8px 1.2rem;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    padding: 6px 4px;
}
.nav-dropdown.open .nav-dropdown-menu {
    display: block;
    animation: fadeInDropdown 0.2s ease-out;
}
@keyframes fadeInDropdown {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}
.nav-dropdown.open .nav-arrow {
    transform: rotate(90deg);
}
.nav-arrow {
    margin-left: auto;
    font-size: 11px;
    transition: transform 0.25s ease;
    opacity: 0.6;
}
.nav-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
}
.nav-dropdown-toggle span {
    flex: 1;
}
.nav-child {
    padding: 0.55rem 1rem 0.55rem 2.8rem !important;
    font-size: 0.84rem;
    color: var(--text-muted);
    border-radius: 6px;
    margin: 2px 4px;
    transition: all 0.2s;
}
.nav-child i {
    font-size: 0.8rem;
    opacity: 0.8;
    position: absolute;
    left: 1.2rem;
}
.nav-child:hover {
    background: #ffffff;
    color: var(--info);
    box-shadow: 0 2px 5px rgba(0,0,0,0.02);
}
.nav-child.active {
    background: #ffffff;
    color: var(--info);
    font-weight: 700;
    box-shadow: 0 2px 5px rgba(0,0,0,0.04);
}
.nav-child.active::before {
    display: none;
}
</style>

{{-- ===== JS Dropdown ===== --}}
<script>
function toggleDropdown(el, event) {
    event.preventDefault();
    const dropdown = el.closest('.nav-dropdown');
    dropdown.classList.toggle('open');
}
</script>