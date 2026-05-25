<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Kepala Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w:    260px;
            --header-h:     65px;
            --primary:      #1a3c5e;
            --primary-dark: #0d2740;
            --accent:       #c8a96e;
            --accent-light: #f5edd8;
            --bg:           #f0f4f8;
            --surface:      #ffffff;
            --text:         #2c3e50;
            --text-muted:   #7f8c8d;
            --border:       #e2e8f0;
            --success:      #27ae60;
            --warning:      #f39c12;
            --danger:       #e74c3c;
            --info:         #2980b9;
            --sidebar-text: rgba(255,255,255,.82);
            --radius:       12px;
            --shadow:       0 4px 20px rgba(0,0,0,.07);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ─────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            height: 100vh;
            position: fixed; top: 0; left: 0;
            display: flex; flex-direction: column;
            transition: transform .3s ease;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 1.4rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: .9rem;
        }
        .brand-logo {
            width: 40px; height: 40px;
            background: rgba(200,169,110,.2);
            border: 1.5px solid rgba(200,169,110,.4);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-logo i { color: var(--accent); font-size: 1.1rem; }
        .brand-text { line-height: 1.2; }
        .brand-text .title { font-size: .88rem; font-weight: 700; color: #fff; }
        .brand-text .sub   { font-size: .72rem; color: rgba(255,255,255,.5); }

        .sidebar-nav { flex: 1; padding: 1.2rem 0; overflow-y: auto; }
        .nav-section-label {
            font-size: .68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
            color: rgba(255,255,255,.35);
            padding: 1rem 1.5rem .4rem;
        }
        .nav-item { display: block; }
        .nav-link {
            display: flex; align-items: center; gap: .8rem;
            padding: .72rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .88rem; font-weight: 500;
            border-radius: 0;
            transition: background .2s, color .2s;
            position: relative;
        }
        .nav-link i { width: 18px; text-align: center; font-size: .9rem; opacity: .8; }
        .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }
        .nav-link.active {
            background: rgba(200,169,110,.15);
            color: var(--accent);
            font-weight: 600;
        }
        .nav-link.active i { opacity: 1; }
        .nav-link.active::before {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }
        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: #fff;
            font-size: .68rem; font-weight: 700;
            padding: .15rem .45rem;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .user-card {
            display: flex; align-items: center; gap: .8rem;
            padding: .7rem;
            background: rgba(255,255,255,.06);
            border-radius: 10px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            background: var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem; color: var(--primary-dark);
            flex-shrink: 0;
        }
        .user-info .name  { font-size: .82rem; font-weight: 600; color: #fff; }
        .user-info .role  { font-size: .72rem; color: rgba(255,255,255,.45); }

        /* ── MAIN ────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex; flex-direction: column;
        }

        /* ── HEADER ──────────────────────────────── */
        .header {
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 1.8rem;
            position: sticky; top: 0;
            z-index: 50;
            gap: 1rem;
            box-shadow: 0 1px 0 var(--border);
        }
        .header-left { display: flex; align-items: center; gap: .8rem; }
        .btn-menu {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-size: 1.1rem;
            display: none;
        }
        .page-title {
            font-size: 1.05rem; font-weight: 700; color: var(--text);
        }
        .header-right { margin-left: auto; display: flex; align-items: center; gap: .8rem; }
        .header-date { font-size: .82rem; color: var(--text-muted); }
        .btn-logout {
            display: flex; align-items: center; gap: .5rem;
            padding: .5rem 1rem;
            background: #fdf0ef;
            border: 1px solid #f5c6c2;
            color: var(--danger);
            border-radius: 8px;
            font-family: inherit; font-size: .83rem; font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-logout:hover { background: #fde8e7; }

        /* ── CONTENT ─────────────────────────────── */
        .content { padding: 1.8rem; flex: 1; }

        /* ── ALERTS ──────────────────────────────── */
        .alert {
            padding: .9rem 1.1rem;
            border-radius: var(--radius);
            font-size: .88rem;
            display: flex; align-items: center; gap: .6rem;
            margin-bottom: 1.2rem;
        }
        .alert-success { background: #eafaf1; color: var(--success); border: 1px solid #a9dfbf; }
        .alert-danger  { background: #fdf0ef; color: var(--danger);  border: 1px solid #f5c6c2; }

        /* ── Scrollbar ───────────────────────────── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,.15); border-radius: 10px; }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: none; }
            .main-wrapper { margin-left: 0; }
            .btn-menu { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

@include('kperpus.layouts.partials.sidebar')

<div class="main-wrapper">
    @include('kperpus.layouts.partials.header')

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    @include('kperpus.layouts.partials.footer')
</div>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}
</script>
@stack('scripts')
</body>
</html>