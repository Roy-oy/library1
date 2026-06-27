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
            <a href="{{ route('pperpus.dashboard') }}"
               class="nav-link {{ request()->routeIs('pperpus.dashboard') ? 'active' : '' }}">
                <i class="fas fa-building-columns"></i> Dashboard
            </a>
        </div>

        
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

        
        <div class="nav-item nav-dropdown {{ request()->routeIs('pperpus.pengembalian.*') ? 'open' : '' }}">
            <a href="#" class="nav-link nav-dropdown-toggle {{ request()->routeIs('pperpus.pengembalian.*') ? 'active' : '' }}" onclick="toggleDropdown(this, event)">
                <i class="fas fa-clipboard-check"></i> <span>Pengembalian</span>
                <i class="fas fa-chevron-right nav-arrow"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('pperpus.pengembalian.perpustakaan.index') }}" 
                   class="nav-link nav-child {{ request()->routeIs('pperpus.pengembalian.perpustakaan.*') ? 'active' : '' }}">
                   <i class="fas fa-book"></i>Buku Perpustakaan
                </a>
                <a href="{{ route('pperpus.pengembalian.bos.index') }}" 
                   class="nav-link nav-child {{ request()->routeIs('pperpus.pengembalian.bos.*') ? 'active' : '' }}">
                   <i class="fas fa-book-open"></i>Buku BOS
                </a>
            </div>
        </div>

        
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


<style>
.nav-dropdown-menu {
    display: none;
    overflow: hidden;
    background: rgba(15, 23, 42, 0.38); 
    border-radius: 8px;
    margin: 4px 1.2rem 8px 1.2rem;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.08);
    padding: 6px 4px;
}
.nav-dropdown.open .nav-dropdown-menu {
    display: block;
    animation: fadeInDropdown 0.2s ease-out;
}
@keyframes fadeInDropdown {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
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
    color: var(--sidebar-text-dim);
    border-radius: 6px;
    margin: 2px 4px;
    transition: all 0.2s;
    text-decoration: none;
    display: block;
    position: relative;
}
.nav-child i {
    font-size: 0.8rem;
    opacity: 0.7;
    position: absolute;
    left: 1.2rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--sidebar-text-dim) !important;
    transition: all 0.2s;
}
.nav-child:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #ffffff;
}
.nav-child:hover i {
    color: var(--sidebar-accent) !important;
    opacity: 1;
}
.nav-child.active {
    background: rgba(13, 148, 136, 0.2); 
    color: #2dd4bf;
    font-weight: 700;
}
.nav-child.active i {
    color: #2dd4bf !important;
    opacity: 1;
}
</style>


<script>
function toggleDropdown(el, event) {
    event.preventDefault();
    const dropdown = el.closest('.nav-dropdown');
    dropdown.classList.toggle('open');
}
</script>