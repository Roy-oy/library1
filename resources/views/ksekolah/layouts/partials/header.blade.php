<header class="header">
    <div class="header-left">
        <button class="btn-menu" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <span class="page-title">@yield('page-title', 'Dashboard')</span>
    </div>

    <div class="header-right">
        <span class="header-date">
            <i class="fas fa-calendar-alt" style="color:#3498db; margin-right:.3rem"></i>
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