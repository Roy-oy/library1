<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Penjaga Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w:        260px;
            --header-h:         70px;

            
            --slate-950:        #0f172a;
            --slate-900:        #1e293b;
            --slate-800:        #334155;
            --slate-700:        #475569;
            --slate-600:        #64748b;
            --teal-600:         #0d9488;
            --teal-500:         #14b8a6;
            --teal-400:         #2dd4bf;
            --teal-100:         #ccfbf1;
            --teal-50:          #f0fdfa;
            --indigo-600:       #4f46e5;
            --indigo-100:       #e0e7ff;
            --indigo-50:        #e0e7ff;

            
            --sidebar-bg:       #1e293b;
            --sidebar-surface:  #0f172a;
            --sidebar-active:   #0d9488;
            --sidebar-hover:    #334155;
            --sidebar-text:     #f1f5f9;
            --sidebar-text-dim: #94a3b8;
            --sidebar-border:   rgba(255, 255, 255, 0.06);
            --sidebar-accent:   #2dd4bf;

            
            --primary:          #0d9488;
            --primary-dark:     #0f766e;
            --primary-soft:     #f0fdfa;
            --accent:           #6366f1;
            --accent-warm:      #f43f5e;

            
            --bg:               #f8fafc;
            --surface:          #ffffff;
            --surface-2:        #f1f5f9;

            
            --text:             #0f172a;
            --text-muted:       #475569;
            --text-light:       #94a3b8;

            
            --border:           #e2e8f0;
            --border-soft:      #f1f5f9;

            
            --success:          #10b981;
            --success-bg:       #ecfdf5;
            --warning:          #f59e0b;
            --warning-bg:       #fffbeb;
            --danger:           #ef4444;
            --danger-bg:        #fef2f2;
            --info:             #3b82f6;
            --info-bg:          #eff6ff;

            --radius:           14px;
            --radius-sm:        8px;
            --shadow-sm:        0 1px 3px rgba(15,23,42,.03), 0 1px 2px rgba(15,23,42,.02);
            --shadow:           0 4px 16px rgba(15,23,42,.04), 0 2px 6px rgba(15,23,42,.02);
            --shadow-md:        0 8px 24px rgba(15,23,42,.06), 0 4px 10px rgba(15,23,42,.03);
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
            box-shadow: 4px 0 24px rgba(15,23,42,.08);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(13,148,136,.1) 0%, transparent 40%);
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
        .brand-logo img { width: 28px; height: 28px; object-fit: contain; }
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
        .nav-link:hover i { opacity: 1; color: var(--sidebar-accent); }

        .nav-link.active {
            background: var(--sidebar-active);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(13,148,136,.30);
        }
        .nav-link.active i { opacity: 1; color: #ffffff; }
        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: #fff;
            font-size: .65rem; font-weight: 700;
            padding: .15rem .45rem;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 1rem 1.2rem;
            border-top: 1px solid var(--sidebar-border);
        }
        .user-card {
            display: flex; align-items: center; gap: .8rem;
            padding: .75rem;
            background: rgba(255,255,255,.03);
            border: 1px solid var(--sidebar-border);
            border-radius: 11px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--teal-600), var(--teal-400));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .82rem; color: #ffffff;
            flex-shrink: 0;
        }
        .user-info .name  { font-size: .81rem; font-weight: 700; color: #ffffff; }
        .user-info .role  { font-size: .7rem; color: var(--sidebar-text-dim); margin-top: .1rem; }

        
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        
        .header {
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 1.8rem;
            position: sticky; top: 0;
            z-index: 50;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
        }
        .header-left { display: flex; align-items: center; gap: .8rem; }
        .btn-menu {
            background: none; border: none; cursor: pointer;
            color: var(--text-muted); font-size: 1.1rem;
            width: 34px; height: 34px;
            display: none; align-items: center; justify-content: center;
            border-radius: var(--radius-sm);
            transition: background .2s;
        }
        .btn-menu:hover { background: var(--surface-2); }

        .page-title {
            font-size: 1.1rem; font-weight: 800; color: var(--text);
            letter-spacing: -.3px;
        }
        .header-breadcrumb {
            font-size: .78rem; color: var(--text-light);
            display: flex; align-items: center; gap: .4rem;
            margin-top: .1rem;
        }
        .header-right { margin-left: auto; display: flex; align-items: center; gap: 1rem; }

        .header-date {
            font-size: .8rem; color: var(--text-muted); font-weight: 600;
            background: var(--surface-2);
            padding: .45rem .9rem;
            border-radius: 30px;
            display: flex; align-items: center; gap: .45rem;
            border: 1px solid var(--border);
        }
        .header-date i { color: var(--primary); }

        .btn-logout {
            display: flex; align-items: center; gap: .45rem;
            padding: .45rem 1.1rem;
            background: var(--danger-bg);
            border: 1px solid #fecaca;
            color: var(--danger);
            border-radius: 30px;
            font-family: inherit; font-size: .8rem; font-weight: 700;
            cursor: pointer; text-decoration: none;
            transition: all .2s ease;
        }
        .btn-logout:hover {
            background: #fee2e2;
            box-shadow: 0 3px 10px rgba(220,38,38,.12);
        }

        
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: .6rem;
            padding: .65rem 1.4rem;
            background: linear-gradient(135deg, var(--teal-600), var(--teal-500));
            color: #ffffff;
            border: none; border-radius: var(--radius-sm);
            font-family: inherit; font-size: .88rem; font-weight: 700;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 4px 12px rgba(13,148,136,.2);
            transition: all .25s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13,148,136,.3);
            color: #ffffff;
        }
        .btn-primary:active { transform: translateY(0); }

        
        .content { padding: 1.6rem; flex: 1; }

        
        .alert {
            padding: .85rem 1.1rem;
            border-radius: var(--radius);
            font-size: .85rem;
            display: flex; align-items: center; gap: .6rem;
            margin-bottom: 1.2rem;
        }
        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid #a7f3d0; }
        .alert-danger  { background: var(--danger-bg);  color: var(--danger);  border: 1px solid #fecaca; }

        
        .pagination-wrap { padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; background: #fafbfc; }
        .pagination-wrap .info { font-size: 0.88rem; color: var(--text-muted); }
        .pagination-wrap nav { display: block; }
        .pagination { display: flex; padding-left: 0; list-style: none; margin: 0; gap: 0.4rem; align-items: center; }
        .page-item .page-link { display: flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 0.85rem; font-size: 0.9rem; font-weight: 700; color: var(--text-muted); background-color: #fff; border: 1.5px solid var(--border); border-radius: 10px; text-decoration: none; transition: all .2s ease; font-family: inherit; }
        .page-item .page-link:hover { background-color: var(--primary-soft); color: var(--primary); border-color: var(--primary); transform: translateY(-2px); }
        .page-item.active .page-link { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; border-color: transparent; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25); }
        .page-item.disabled .page-link { color: #cbd5e1; background-color: #f8fafc; border-color: #e2e8f0; cursor: not-allowed; transform: none; box-shadow: none; }
        

        
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,.3); z-index: 90;
            opacity: 0; transition: opacity .3s ease;
        }
        .sidebar-overlay.show { display: block; opacity: 1; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,.1); border-radius: 10px; }

        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .btn-menu { display: flex; }
        }
    </style>
    @stack('styles')
</head>
<body>

@include('pperpus.layouts.partials.sidebar')
<div class="sidebar-overlay" onclick=\"toggleSidebar()\"></div>

<div class="main-wrapper">
    @include('pperpus.layouts.partials.header')

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

    @include('pperpus.layouts.partials.footer')
</div>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    if(sidebar && overlay) {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    }
}
</script>
@stack('scripts')
</body>
</html>