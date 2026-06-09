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