<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Kepala Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w:        260px;
            --header-h:         70px;

            
            --slate-950:        #0b0f19;
            --slate-900:        #111827;
            --slate-800:        #1f2937;
            --slate-700:        #374151;
            --slate-600:        #4b5563;
            --blue-600:         #d97706; 
            --blue-500:         #f59e0b;
            --blue-400:         #fbbf24;
            --blue-100:         #fef3c7;
            --blue-50:          #fffbeb;
            --indigo-600:       #4b5563;
            --indigo-100:       #f3f4f6;

            
            --sidebar-bg:       #111827;
            --sidebar-surface:  #1f2937;
            --sidebar-active:   #d97706;
            --sidebar-hover:    #1f2937;
            --sidebar-text:     #f9fafb;
            --sidebar-text-dim: #9ca3af;
            --sidebar-border:   rgba(255, 255, 255, 0.05);
            --sidebar-accent:   #fbbf24;

            
            --primary:          #d97706;
            --primary-dark:     #b45309;
            --primary-soft:     #fffbeb;
            --accent:           #374151;

            
            --bg:               #f9fafb;
            --surface:          #ffffff;
            --surface-2:        #f3f4f6;

            
            --text:             #111827;
            --text-muted:       #4b5563;
            --text-light:       #9ca3af;

            
            --border:           #e5e7eb;
            --border-soft:      #f3f4f6;

            
            --success:          #10b981;
            --success-bg:       #ecfdf5;
            --warning:          #f59e0b;
            --warning-bg:       #fffbeb;
            --danger:           #ef4444;
            --danger-bg:        #fef2f2;
            --info:             #2563eb;
            --info-bg:          #eff6ff;

            --radius:           14px;
            --radius-sm:        8px;
            --shadow-sm:        0 1px 3px rgba(17,24,39,.03);
            --shadow:           0 4px 16px rgba(17,24,39,.04);
            --shadow-md:        0 8px 24px rgba(17,24,39,.06);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            height: 100vh;
            position: fixed; top: 0; left: 0;
            display: flex; flex-direction: column;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            z-index: 100;
            box-shadow: 4px 0 24px rgba(17,24,39,.08);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(217,119,6,.1) 0%, transparent 40%);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 1.3rem 1.4rem;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex; align-items: center; gap: .85rem;
            position: relative;
        }
        .brand-logo {
            width: 42px; height: 42px;
            background: transparent;
            border: none;
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-logo img { width: 38px; height: 38px; object-fit: contain; }
        .brand-text .title { font-size: .8rem; font-weight: 700; color: #ffffff; line-height: 1.3; }

        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; position: relative; }
        .sidebar-nav::-webkit-scrollbar { width: 0; }

        .nav-section-label {
            font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.4px;
            color: var(--sidebar-text-dim);
            padding: 1.1rem 1.4rem .45rem;
        }
        .nav-item { display: block; }
        .nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .65rem 1.4rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .84rem; font-weight: 500;
            transition: all .2s ease;
            position: relative;
            margin: 1px .7rem;
            border-radius: 9px;
        }
        .nav-link i {
            width: 20px; text-align: center; font-size: .88rem;
            color: var(--sidebar-text-dim);
            opacity: .8;
            transition: all .2s;
            flex-shrink: 0;
        }
        .nav-link:hover {
            background: var(--sidebar-hover);
            color: #ffffff;
        }
        .nav-link:hover i { color: #ffffff; opacity: 1; }
        
        .nav-link.active {
            background: var(--sidebar-active);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.35);
        }
        .nav-link.active i { color: #ffffff; opacity: 1; }

        .sidebar-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid var(--sidebar-border);
            background: rgba(11, 15, 25, 0.5);
        }
        .user-card {
            display: flex; align-items: center; gap: .75rem;
            padding: .6rem .7rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }
        .user-avatar {
            width: 34px; height: 34px;
            background: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem; color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.3);
        }
        .user-info .name  { font-size: .8rem; font-weight: 600; color: #ffffff; }
        .user-info .role  { font-size: .7rem; color: var(--sidebar-text-dim); margin-top: 1px; }

        
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        
        .header {
            height: var(--header-h);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-soft);
            display: flex; align-items: center;
            padding: 0 1.8rem;
            position: sticky; top: 0;
            z-index: 50;
            box-shadow: 0 1px 2px rgba(17,24,39,.02);
        }
        .header-left { display: flex; align-items: center; gap: .8rem; }
        .btn-menu {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-size: 1.1rem;
            display: none;
        }
        .page-title {
            font-size: 1.15rem; font-weight: 700; color: var(--text);
            letter-spacing: -0.3px;
        }
        .header-right { margin-left: auto; display: flex; align-items: center; gap: 1rem; }
        .header-date {
            font-size: .8rem; color: var(--text-muted); font-weight: 600;
            background: var(--surface-2);
            padding: .45rem .9rem; border-radius: 30px;
            display: flex; align-items: center; gap: .45rem;
        }
        .btn-logout {
            display: flex; align-items: center; gap: .45rem;
            padding: .45rem 1rem;
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border-radius: 30px;
            font-family: inherit; font-size: .8rem; font-weight: 700;
            cursor: pointer; text-decoration: none;
            transition: all .2s ease;
        }
        .btn-logout:hover { 
            background: var(--danger); color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
        }

        
        .content { padding: 1.8rem; flex: 1; }

        .alert {
            padding: .85rem 1.1rem;
            border-radius: var(--radius);
            font-size: .84rem; font-weight: 500;
            display: flex; align-items: center; gap: .6rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.15); }
        .alert-danger  { background: var(--danger-bg); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.15); }

        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-light); }

        
        .pagination-wrap { padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; background: #fafbfc; margin-top: 1.5rem; border-radius: 0 0 var(--radius) var(--radius); }
        .pagination-wrap .info { font-size: 0.88rem; color: var(--text-muted); }
        .pagination-wrap nav { display: block; }
        .pagination { display: flex; padding-left: 0; list-style: none; margin: 0; gap: 0.4rem; align-items: center; }
        .page-item .page-link { display: flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 0.85rem; font-size: 0.9rem; font-weight: 700; color: var(--text-muted); background-color: #fff; border: 1.5px solid var(--border); border-radius: 10px; text-decoration: none; transition: all .2s ease; font-family: inherit; }
        .page-item .page-link:hover { background-color: var(--primary-soft); color: var(--primary); border-color: var(--primary); transform: translateY(-2px); }
        .page-item.active .page-link { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-color: transparent; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.25); }
        .page-item.disabled .page-link { color: #cbd5e1; background-color: #f8fafc; border-color: #e2e8f0; cursor: not-allowed; transform: none; box-shadow: none; }
        .page-link[rel="prev"] span, .page-link[rel="next"] span { display: none; }

        
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(17,24,39,.4); z-index: 90;
            opacity: 0; transition: opacity .3s ease;
            backdrop-filter: blur(4px);
        }
        .sidebar-overlay.show { display: block; opacity: 1; }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>

@include('ksekolah.layouts.partials.sidebar')
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="main-wrapper">
    @include('ksekolah.layouts.partials.header')

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

    @include('ksekolah.layouts.partials.footer')
</div>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    sidebar.classList.toggle('open');
    if (sidebar.classList.contains('open')) {
        overlay.classList.add('show');
    } else {
        overlay.classList.remove('show');
    }
}
</script>
@stack('scripts')
</body>
</html>