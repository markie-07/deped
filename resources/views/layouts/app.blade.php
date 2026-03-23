<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DepEd Manager')</title>
    <meta name="description" content="@yield('description', 'Schools Division Office - DepEd Manager System')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Extra per-page head content (scripts, styles) --}}
    @stack('head')

    <style>
        /* ═══════════════════════════════════════════════
           GLOBAL RESET — Overrides Tailwind Preflight
           ═══════════════════════════════════════════════ */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            overflow-x: hidden !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        /* ═══════════════════════════════════════════════
           APP SHELL — Sidebar + Main Content
           ═══════════════════════════════════════════════ */
        .main-content {
            margin-left: 70px; /* Collapsed sidebar width */
            min-height: 100vh;
            background: #f1f5f9;
            transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar.active ~ .main-content {
            margin-left: 260px; /* Expanded sidebar width */
        }

        /* ═══════════════════════════════════════════════
           MOBILE OVERLAY (dims page when sidebar is open)
           ═══════════════════════════════════════════════ */
        #mobileOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            z-index: 99;
            backdrop-filter: blur(2px);
        }

        #mobileOverlay.show {
            display: block;
        }

        /* ═══════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS
           ═══════════════════════════════════════════════ */

        /* --- Tablet (≤ 1024px) --- */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 70px !important;
            }

            .sidebar.active ~ .main-content {
                margin-left: 70px !important;
            }
        }

        /* --- Mobile (≤ 768px) --- */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%) !important;
                width: 260px !important;
                z-index: 200 !important;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }

            .sidebar.mobile-open {
                transform: translateX(0) !important;
            }

            .sidebar.active {
                /* On mobile, sidebar expansion is handled by mobile-open class */
                width: 260px !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            /* Stack page wrap padding */
            .bento-wrap {
                padding: 12px !important;
            }

            /* Ensure tables scroll horizontally */
            .table-container,
            .table-wrap,
            [class*="table"] {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* --- Small Mobile (≤ 480px) --- */
        @media (max-width: 480px) {
            .main-content {
                margin-left: 0 !important;
            }
        }



        /* ═══════════════════════════════════════════════
           SCROLL BAR — Global Slim Style
           ═══════════════════════════════════════════════ */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    {{-- Per-page styles --}}
    @stack('styles')
</head>
<body>

    {{-- Sidebar (admin or user version based on role) --}}
    @if(auth()->check() && auth()->user()->role === 'admin')
        @include('partials.sidebar')
    @elseif(auth()->check())
        @include('partials.user-sidebar')
    @endif

    {{-- Mobile Overlay --}}
    <div id="mobileOverlay" onclick="closeMobileMenu()"></div>



    {{-- Main Page Content --}}
    <main class="main-content" id="mainContent">
        {{-- Top Navigation Bar --}}
        @include('partials.navigation')

        {{-- Page-specific content --}}
        @yield('content')
    </main>

    {{-- Per-page scripts --}}
    @stack('scripts')

    <script>
        // ── Mobile Sidebar Toggle ──
        function openMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('mobileOverlay');
            if (sidebar) sidebar.classList.add('mobile-open');
            if (overlay) overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('mobileOverlay');
            if (sidebar) sidebar.classList.remove('mobile-open');
            if (overlay) overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Close mobile overlay if clicking outside or on navigation
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                const sidebar = document.querySelector('.sidebar');
                const toggleBtn = document.getElementById('sidebarToggle');
                const overlay = document.getElementById('mobileOverlay');
                
                if (sidebar && sidebar.classList.contains('mobile-open')) {
                    if (!sidebar.contains(e.target) && (!toggleBtn || !toggleBtn.contains(e.target))) {
                        closeMobileMenu();
                    }
                }
            }
        });

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        });

        // ── Sidebar State Persistence ──
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            if (sidebar && window.innerWidth > 768) {
                const saved = localStorage.getItem('sidebar-open');
                if (saved === 'false') {
                    sidebar.classList.remove('active');
                } else {
                    sidebar.classList.add('active');
                }
            }
        });
    </script>
</body>
</html>
