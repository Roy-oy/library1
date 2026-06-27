<header class="header">
    <div class="header-left">
        <button class="btn-menu" onclick="toggleSidebar()" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
        </div>
    </div>

    <div class="header-right">
        @php
            $terlambatHeaderCount = \App\Models\DetailPeminjaman::where(function ($query) {
                $query->where('status_detail', 'terlambat')
                      ->orWhere(function ($q) {
                          $q->where('status_detail', 'dipinjam')
                            ->where('sumber_buku', 'buku perpus')
                            ->whereNotNull('tanggal_jatuh_tempo')
                            ->whereDate('tanggal_jatuh_tempo', '<', now()->startOfDay());
                      });
            })->count();
        @endphp

        <div class="header-notif-container" style="position: relative;">
            <button onclick="toggleNotifDropdown()" style="position: relative; display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background: {{ $terlambatHeaderCount > 0 ? 'var(--danger-bg)' : 'var(--surface-2)' }}; border: 1px solid {{ $terlambatHeaderCount > 0 ? '#fecaca' : 'var(--border)' }}; border-radius: 50%; color: {{ $terlambatHeaderCount > 0 ? 'var(--danger)' : 'var(--text-muted)' }}; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-bell"></i>
                @if($terlambatHeaderCount > 0)
                    <span style="position: absolute; top: -2px; right: -2px; background: var(--danger); color: white; font-size: 0.65rem; font-weight: 800; padding: 0.15rem 0.35rem; border-radius: 10px; border: 2px solid white; line-height: 1;">{{ $terlambatHeaderCount }}</span>
                @endif
            </button>
            
            <div id="notifDropdown" style="display: none; position: absolute; top: 110%; right: 0; width: 280px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 1px solid var(--border); z-index: 100; overflow: hidden;">
                <div style="padding: 1rem; border-bottom: 1px solid var(--border-soft); background: var(--surface-2);">
                    <h4 style="margin: 0; font-size: 0.85rem; font-weight: 700; color: var(--text);">Notifikasi</h4>
                </div>
                <div style="max-height: 300px; overflow-y: auto;">
                    @if($terlambatHeaderCount > 0)
                        <a href="{{ route('pperpus.dashboard') }}#denda-section" style="display: flex; gap: 1rem; padding: 1rem; border-bottom: 1px solid var(--border-soft); text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background='transparent'">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--danger-bg); color: var(--danger); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.82rem; font-weight: 700; color: var(--text); margin-bottom: 0.2rem;">Buku Terlambat</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.4;">Terdapat <b>{{ $terlambatHeaderCount }}</b> buku yang melewati batas waktu pengembalian.</div>
                            </div>
                        </a>
                    @else
                        <div style="padding: 2rem 1rem; text-align: center;">
                            <i class="fas fa-bell-slash" style="font-size: 2rem; color: var(--border); margin-bottom: 0.5rem; display: block;"></i>
                            <div style="font-size: 0.82rem; font-weight: 600; color: var(--text-muted);">Tidak ada notifikasi</div>
                            <div style="font-size: 0.72rem; color: var(--text-light); margin-top: 0.2rem;">Semua aktivitas berjalan lancar.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script>
            function toggleNotifDropdown() {
                const dropdown = document.getElementById('notifDropdown');
                if (dropdown.style.display === 'none') {
                    dropdown.style.display = 'block';
                } else {
                    dropdown.style.display = 'none';
                }
            }

            document.addEventListener('click', function(event) {
                const container = document.querySelector('.header-notif-container');
                const dropdown = document.getElementById('notifDropdown');
                if (container && dropdown && !container.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });
        </script>

        <span class="header-date">
            <i class="fas fa-calendar-alt"></i>
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</header>