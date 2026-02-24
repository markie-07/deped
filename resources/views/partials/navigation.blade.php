<!-- Top Navigation Bar -->
<nav class="top-navbar">
    <div class="navbar-left">
        <!-- Sidebar Toggle -->
        <div class="navbar-toggle" id="sidebarToggle" title="Toggle sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>
        <div class="page-info">
            <h1 class="page-title">
                @php
                    $titles = [
                        'dashboard' => 'Dashboard',
                        'form' => 'Form',
                        'school' => 'School',
                        'position' => 'Position',
                        'types-of-leave' => 'Types of Leave',
                        'remarks' => 'Remarks',
                        'leave-records-registry' => 'Leave Records',
                        'incharge' => 'Incharge Registry',
                    ];
                    $currentPath = request()->path();
                    $pageTitle = $titles[$currentPath] ?? ucfirst($currentPath);
                @endphp
                {{ $pageTitle }}
            </h1>
            <p class="page-subtitle">
                @php
                    $subtitles = [
                        'dashboard' => 'Overview of your division management system',
                        'form' => 'Manage forms and documents',
                        'school' => 'Manage schools in the division',
                        'position' => 'Manage positions and designations',
                        'types-of-leave' => 'Manage leave types and categories',
                        'remarks' => 'Manage remarks and notes',
                        'leave-records-registry' => 'Complete registry of all leave records',
                        'incharge' => 'Manage and view incharges and their recorded activities',
                    ];
                    $pageSubtitle = $subtitles[$currentPath] ?? '';
                @endphp
                {{ $pageSubtitle }}
            </p>
        </div>
    </div>

    <div class="navbar-right">
        <!-- Search -->
        <div class="navbar-search">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input type="text" placeholder="Search..." />
        </div>

        <!-- Notification Bell -->
        <div class="navbar-icon-btn" title="Notifications">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            <span class="notification-dot"></span>
        </div>

        <!-- User Dropdown -->
        <div class="navbar-user" id="navbarUserBtn">
            <div class="navbar-user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="navbar-user-info">
                <span class="navbar-user-name">{{ Auth::user()->name ?? 'User' }}</span>
                <span class="navbar-user-role">Administrator</span>
            </div>
            <svg class="navbar-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>

            <!-- Dropdown Menu -->
            <div class="navbar-dropdown" id="navbarDropdown">
                <a href="/dashboard" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profile
                </a>
                <a href="/dashboard" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-logout">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* ═══════════════════════════════════════
       TOP NAVIGATION BAR
       ═══════════════════════════════════════ */
    .top-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 2rem;
        background: #fff;
        border-bottom: 1px solid #eef0f6;
        position: sticky;
        top: 0;
        z-index: 50;
        min-height: 68px;
    }

    /* ── Left: Page Info ── */
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.02em;
        line-height: 1.3;
    }

    .page-subtitle {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 1px;
    }

    /* ── Sidebar Toggle ── */
    .navbar-toggle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        cursor: pointer;
        color: #64748b;
        transition: all 0.2s ease;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .navbar-toggle:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .navbar-toggle svg {
        width: 20px;
        height: 20px;
    }

    /* ── Right: Actions ── */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* ── Search ── */
    .navbar-search {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 14px;
        transition: all 0.25s ease;
    }

    .navbar-search:focus-within {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .navbar-search svg {
        width: 18px;
        height: 18px;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .navbar-search input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 0.82rem;
        color: #1e293b;
        width: 180px;
        font-family: inherit;
    }

    .navbar-search input::placeholder {
        color: #cbd5e1;
    }

    /* ── Icon Buttons ── */
    .navbar-icon-btn {
        position: relative;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        cursor: pointer;
        color: #64748b;
        transition: all 0.2s ease;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .navbar-icon-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .navbar-icon-btn svg {
        width: 20px;
        height: 20px;
    }

    .notification-dot {
        position: absolute;
        top: 8px;
        right: 9px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* ── User Dropdown ── */
    .navbar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 10px 5px 5px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        border: 1px solid transparent;
    }

    .navbar-user:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    .navbar-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .navbar-user-info {
        display: flex;
        flex-direction: column;
    }

    .navbar-user-name {
        font-size: 0.82rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.2;
    }

    .navbar-user-role {
        font-size: 0.68rem;
        color: #94a3b8;
        line-height: 1.2;
    }

    .navbar-chevron {
        width: 16px;
        height: 16px;
        color: #94a3b8;
        transition: transform 0.2s ease;
    }

    .navbar-user.open .navbar-chevron {
        transform: rotate(180deg);
    }

    /* ── Dropdown Menu ── */
    .navbar-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 200px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.2s ease;
        z-index: 100;
    }

    .navbar-user.open .navbar-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 0.82rem;
        color: #475569;
        text-decoration: none;
        transition: all 0.15s ease;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        font-family: inherit;
    }

    .dropdown-item:hover {
        background: #f8fafc;
        color: #1e293b;
    }

    .dropdown-item svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .dropdown-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 4px 8px;
    }

    .dropdown-logout {
        color: #ef4444;
    }

    .dropdown-logout:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .top-navbar {
            padding: 0.75rem 1rem;
        }

        .navbar-search {
            display: none;
        }

        .navbar-user-info {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                localStorage.setItem('sidebar-open', sidebar.classList.contains('active'));
            });

            // Restore saved state
            const saved = localStorage.getItem('sidebar-open');
            if (saved === 'false') {
                sidebar.classList.remove('active');
            }
        }

        // User dropdown
        const userBtn = document.getElementById('navbarUserBtn');

        if (userBtn) {
            userBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                this.classList.toggle('open');
            });

            document.addEventListener('click', function () {
                userBtn.classList.remove('open');
            });
        }
    });
</script>
