<!-- Top Navigation Bar -->
<nav class="top-navbar">
    <div class="navbar-left">
        <!-- Sidebar Toggle -->
        <div class="navbar-toggle" id="sidebarToggle" title="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
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
                        'leave-records' => 'Leave Records',
                        'leave-records-registry' => 'Leave Records',
                        'incharge' => 'Incharge Registry',
                        'profile' => 'Profile',
                    ];
                    $currentPath = request()->path();
                    // Strip prefix like 'admin/' or 'user/'
                    $cleanPath = preg_replace('/^(admin|user)\//', '', $currentPath);
                    $pageTitle = $titles[$cleanPath] ?? ucfirst($cleanPath);
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
                        'leave-records' => 'Complete registry of all leave records',
                        'leave-records-registry' => 'Complete registry of all leave records',
                        'incharge' => 'Manage and view incharges and their recorded activities',
                        'profile' => 'Manage your account settings',
                    ];
                    $pageSubtitle = $subtitles[$cleanPath] ?? '';
                @endphp
                {{ $pageSubtitle }}
            </p>
        </div>
    </div>

    <div class="navbar-right">
        <!-- Dark mode toggle -->
        <div class="navbar-icon-btn" id="darkModeToggle" title="Toggle Appearance">
            <!-- Moon svg -->
            <svg id="moonIcon" class="dm-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
            </svg>
            <!-- Sun svg -->
            <svg id="sunIcon" class="dm-icon" style="display:none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M5.284 12.034H3.034m15.364 6.364l-1.591-1.591M6.716 6.716L5.125 5.125m12.159 0l-1.591 1.591M6.716 17.284l-1.591 1.591M12 8.25a3.75 3.75 0 100 7.5 3.75 3.75 0 000-7.5z" />
            </svg>
        </div>

        <!-- User Dropdown -->
        <div class="navbar-user" id="navbarUserBtn">
            @if(Auth::user() && Auth::user()->profile_image)
                <img src="/storage/{{ Auth::user()->profile_image }}" class="navbar-user-avatar" style="object-fit: cover;">
            @else
                <div class="navbar-user-avatar">
                    {{ Auth::user() ? strtoupper(substr(Auth::user()->username ?? Auth::user()->name ?? 'G', 0, 1)) : 'G' }}
                </div>
            @endif
            <div class="navbar-user-info">
                <span class="navbar-user-name">{{ Auth::user() ? (Auth::user()->username ?? Auth::user()->name) : 'Guest' }}</span>
                <span class="navbar-user-role">{{ Auth::user() ? (Auth::user()->position ?? 'User') : 'Guest' }}</span>
            </div>
            <svg class="navbar-chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>

            <!-- Dropdown Menu -->
            <div class="navbar-dropdown" id="navbarDropdown">
                <a href="{{ (auth()->user() && auth()->user()->role === 'admin') ? '/admin/profile' : '/user/profile' }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profile
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
        padding: 0 2rem; /* Increased padding for better breathing room */
        background: #fff;
        border-bottom: 1px solid #eef0f6;
        position: sticky;
        top: 0;
        z-index: 50;
        min-height: 70px; /* Matched to sidebar header for seamless top row */
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── Left: Page Info ── */
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 24px; /* Increased gap to push content away from sidebar toggle */
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
        width: 44px;
        height: 44px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        border-radius: 12px;
        cursor: pointer;
        color: #6366f1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        border: 1.5px solid #eef2ff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .navbar-toggle span {
        display: block;
        width: 20px;
        height: 2.5px;
        background: currentColor;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .navbar-toggle span:nth-child(2) { width: 14px; align-self: flex-start; margin-left: 10px; }
    .navbar-toggle span:nth-child(3) { width: 17px; }

    .navbar-toggle:hover {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
    }

    .navbar-toggle:hover span:nth-child(2) { width: 20px; margin-left: 0; }

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
        gap: 12px;
        padding: 6px 14px 6px 6px;
        border-radius: 100px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        background: #fff;
        border: 1.5px solid #eef2ff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .navbar-user:hover {
        border-color: #6366f1;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.15);
    }

    .navbar-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 800;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
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

    /* ═══════════════════════════════════════
       RESPONSIVE REFINEMENTS
       ═══════════════════════════════════════ */
    @media (max-width: 768px) {
        .top-navbar {
            padding: 0 1rem;
            min-height: 60px;
        }
        
        .navbar-search {
            display: none;
        }

        /* Hide subtitle on mobile to save space */
        .page-subtitle {
            display: none;
        }

        .page-title {
            font-size: 1rem;
        }

        .navbar-left {
            gap: 12px;
        }

        /* Adjust user info on small screens */
        .navbar-user-info {
            display: none;
        }

        .navbar-user {
            padding: 4px;
            gap: 0;
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .navbar-chevron {
            display: none;
        }

        /* Sidebar toggle on mobile: fixed or positioned differently? */
        .navbar-toggle {
            width: 38px;
            height: 38px;
            gap: 3px;
        }

        .navbar-toggle span {
            width: 16px;
            height: 2px;
        }
        
        .navbar-toggle span:nth-child(2) { margin-left: 8px; width: 10px; }
        .navbar-toggle span:nth-child(3) { width: 14px; }
    }

    /* ── HYPER-MODERN DARK MODE SYSTEM ── */
    :root {
        --body-bg: #f8fafc;
        --tile-bg: #ffffff;
        --tile-border: #e2e8f0;
        --nav-bg: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --accent: #6366f1;
    }

    body.dark-mode {
        --body-bg: #020617; /* Deepest Indigo Slate */
        --tile-bg: rgba(15, 23, 42, 0.8);
        --tile-border: rgba(30, 41, 59, 0.5);
        --nav-bg: rgba(15, 23, 42, 0.9);
        --text-main: #f1f5f9;
        --text-muted: #64748b;
        --accent: #818cf8;
    }

    body.dark-mode { background-color: var(--body-bg) !important; color: var(--text-main); transition: background-color 0.3s ease; }

    /* Top Navigation */
    body.dark-mode .top-navbar { 
        background: rgba(15, 23, 42, 0.95) !important; 
        backdrop-filter: blur(12px); 
        border-bottom: 1px solid rgba(30, 41, 59, 0.7); 
    }
    body.dark-mode .page-title { color: #fff; text-shadow: 0 0 20px rgba(99, 102, 241, 0.2); }
    body.dark-mode .navbar-user { background: transparent; border-color: transparent; }
    @media (min-width: 769px) {
        body.dark-mode .navbar-user { background: #0f172a; border-color: #1e293b; }
    }
    body.dark-mode .navbar-user:hover { background: #1a2233; border-color: #6366f1; }
    body.dark-mode .navbar-user-avatar { box-shadow: 0 0 15px rgba(99, 102, 241, 0.4); }
    body.dark-mode .navbar-user-name { color: #fff; }
    body.dark-mode .navbar-search { background: rgba(30, 41, 59, 0.5); border-color: var(--tile-border); }
    body.dark-mode .navbar-search input { color: #fff; }
    body.dark-mode .navbar-icon-btn, body.dark-mode .navbar-toggle { background: #0f172a; border-color: #1e293b; color: #94a3b8; }
    body.dark-mode .navbar-toggle span { background: #818cf8; }
    body.dark-mode .navbar-icon-btn:hover, body.dark-mode .navbar-toggle:hover { background: #6366f1; border-color: #6366f1; color: #fff; }
    body.dark-mode .navbar-toggle:hover span { background: #fff; }

    /* User Dropdown Dark Mode */
    body.dark-mode .navbar-dropdown { 
        background: #0f172a; 
        border-color: #1e293b; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.5); 
    }
    body.dark-mode .dropdown-item { color: #94a3b8; }
    body.dark-mode .dropdown-item:hover { background: rgba(30, 41, 59, 0.5); color: #fff; }
    body.dark-mode .dropdown-divider { background: #1e293b; }
    body.dark-mode .dropdown-logout:hover { background: rgba(239, 68, 68, 0.1); color: #f87171; }

    /* Sidebar */
    body.dark-mode .sidebar { background: #0f172a !important; border-right: none !important; }
    body.dark-mode .sidebar-header { border-bottom-color: rgba(30, 41, 59, 0.5); border-right: none; }
    body.dark-mode .sidebar-brand .brand-name { color: #f1f5f9; }
    body.dark-mode .sidebar-profile .profile-name { color: #fff; }
    body.dark-mode .nav-link { color: #64748b; }
    body.dark-mode .nav-link:hover { color: #fff; }
    body.dark-mode .nav-text { color: #cbd5e1 !important; opacity: 1 !important; visibility: visible !important; }
    body.dark-mode .nav-list-item.active .nav-text { color: #fff !important; font-weight: 800; }
    
    /* CURVE OUTSIDE FIX */
    body.dark-mode .nav-list-item.active { background: #020617 !important; }
    body.dark-mode .nav-list-item.active b { background: #020617 !important; display: block !important; }
    body.dark-mode .nav-list-item.active b::before { background: #0f172a !important; }
    
    body.dark-mode .nav-list-item.active .nav-icon { background: #6366f1 !important; border-color: #020617 !important; box-shadow: 0 0 20px rgba(99, 102, 241, 0.4); }

    /* Main Content & Dashboard Elements */
    body.dark-mode .main-content { background: var(--body-bg) !important; }
    body.dark-mode .tile, 
    body.dark-mode .stat-mini, 
    body.dark-mode .hero-banner { 
        background: var(--tile-bg) !important; 
        backdrop-filter: blur(10px);
        border: 1px solid var(--tile-border); 
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.6); 
    }

    /* Hero Banner */
    body.dark-mode .hero-dots { background-image: radial-gradient(circle, #334155 1px, transparent 1px); opacity: 0.3; }
    body.dark-mode .hero-title { color: #fff; }
    body.dark-mode .hero-desc { color: #94a3b8; }
    body.dark-mode .hero-right { 
        background: linear-gradient(145deg, #1e1b4b 0%, #020617 100%); 
        border-left: 1px solid var(--tile-border); 
    }
    body.dark-mode .hcc-label { color: var(--accent); }
    body.dark-mode .hcc-time, body.dark-mode .hcc-secs { color: #fff; text-shadow: 0 0 20px rgba(255,255,255,0.1); }
    body.dark-mode .hcc-date { color: var(--accent); }
    body.dark-mode .hero-tag { background: rgba(99, 102, 241, 0.15); color: var(--accent); border: 1px solid rgba(99, 102, 241, 0.2); }
    
    /* Hero Meta Items (Total Records etc) */
    body.dark-mode .hmi-num { color: #fff !important; }
    body.dark-mode .hmi-label { color: #94a3b8 !important; }
    body.dark-mode .hmi-icon { background: rgba(30, 41, 59, 0.5); }
    body.dark-mode .hero-meta-divider { background: var(--tile-border); }

    /* Stats & Labels Readability */
    body.dark-mode .sm-num { color: #fff; }
    body.dark-mode .sm-label { color: #94a3b8; font-weight: 600; }
    body.dark-mode .stat-indigo { background: rgba(30, 41, 59, 0.4) !important; border-color: rgba(99, 102, 241, 0.2); }
    body.dark-mode .stat-indigo .sm-icon { background: rgba(99, 102, 241, 0.1); color: #818cf8; }
    body.dark-mode .stat-emerald { background: rgba(6, 78, 59, 0.2) !important; border-color: rgba(52, 211, 153, 0.2); }
    body.dark-mode .stat-emerald .sm-icon { background: rgba(5, 150, 105, 0.1); color: #34d399; }
    body.dark-mode .stat-amber { background: rgba(69, 26, 3, 0.2) !important; border-color: rgba(251, 191, 36, 0.2); }
    body.dark-mode .stat-amber .sm-icon { background: rgba(217, 119, 6, 0.1); color: #fbbf24; }
    body.dark-mode .stat-rose { background: rgba(76, 5, 25, 0.2) !important; border-color: rgba(251, 113, 133, 0.2); }
    body.dark-mode .stat-rose .sm-icon { background: rgba(225, 29, 72, 0.1); color: #fb7185; }
    body.dark-mode .stat-purple { background: rgba(59, 7, 100, 0.2) !important; border-color: rgba(192, 132, 252, 0.2); }
    body.dark-mode .stat-purple .sm-icon { background: rgba(147, 51, 234, 0.1); color: #c084fc; }
    
    /* ── Activity Timeline Dark Mode ── */
    body.dark-mode .au-head .tc-title, body.dark-mode .au-head .tc-sub { color: #fff; }
    body.dark-mode .au-act { color: #e2e8f0; }
    body.dark-mode .au-act b { color: #818cf8; font-weight: 800; }
    body.dark-mode .au-det { color: #94a3b8; }
    body.dark-mode .au-tm { color: var(--accent); font-weight: 800; }
    body.dark-mode .au-tm-full { color: #64748b; }
    body.dark-mode .au-empty { color: #475569; }

    /* Timeline Line */
    body.dark-mode .au-timeline::before { 
        background: linear-gradient(to bottom, rgba(99,102,241,0.3), rgba(30,41,59,0.5), transparent) !important; 
    }

    /* Timeline Entry Hover */
    body.dark-mode .au-entry:hover { background: rgba(255, 255, 255, 0.03); border-radius: 12px; }

    /* Timeline Dots - Glowing */
    body.dark-mode .au-entry::before { border-color: #0f172a; box-shadow: 0 0 0 2px #1e293b; }
    body.dark-mode .au-entry.e-login::before { background: #10b981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.5); }
    body.dark-mode .au-entry.e-create::before { background: #6366f1; box-shadow: 0 0 8px rgba(99, 102, 241, 0.5); }
    body.dark-mode .au-entry.e-update::before { background: #f59e0b; box-shadow: 0 0 8px rgba(245, 158, 11, 0.5); }
    body.dark-mode .au-entry.e-delete::before { background: #ef4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.5); }
    body.dark-mode .au-entry.e-bulk::before { background: #8b5cf6; box-shadow: 0 0 8px rgba(139, 92, 246, 0.5); }

    /* Timeline Tags - Deep Tint */
    body.dark-mode .t-login { background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25); }
    body.dark-mode .t-create { background: rgba(99, 102, 241, 0.12); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.25); }
    body.dark-mode .t-update { background: rgba(245, 158, 11, 0.12); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.25); }
    body.dark-mode .t-delete { background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); }
    body.dark-mode .t-bulk { background: rgba(139, 92, 246, 0.12); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.25); }

    /* Timeline Avatar */
    body.dark-mode .au-av img { border-color: #1e293b; }

    /* Live Badge */
    body.dark-mode .au-live { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #34d399; }
    body.dark-mode .au-btn-list { background: #0f172a; border-color: #334155; color: #94a3b8; }
    body.dark-mode .au-btn-list:hover { background: #1e293b; border-color: var(--accent); color: var(--accent); }

    /* Chart Labels */
    body.dark-mode .tc-title { color: #fff; }
    body.dark-mode .tc-sub { color: #94a3b8; }

    /* Quick Actions visibility fix */
    body.dark-mode .ta-title { color: #fff; }
    body.dark-mode .ta-btn { background: #0f172a !important; border-color: #1f2937 !important; }
    body.dark-mode .ta-btn span { color: #cbd5e1 !important; font-weight: 700; }
    body.dark-mode .ta-btn:hover { background: #1e293b !important; border-color: var(--accent) !important; transform: translateY(-3px) !important; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5) !important; }
    body.dark-mode .ta-btn:hover span { color: #fff !important; }
    body.dark-mode .ta-ico { background: rgba(30, 41, 59, 0.5) !important; border-color: #334155 !important; }
    body.dark-mode .ta-btn:hover .ta-ico { background: var(--accent) !important; border-color: var(--accent) !important; color: #fff !important; }
    body.dark-mode .tc-pill { background: #1f2937; border-color: #374151; color: #94a3b8; }
    body.dark-mode .tc-pill.active { background: #6366f1; color: #fff; border-color: #6366f1; }

    /* Inputs & Forms (Modals etc) */
    body.dark-mode .act-filter-select, 
    body.dark-mode .act-filter-input { 
        background: #0f172a !important; 
        border-color: #334155 !important; 
        color: #fff !important; 
    }
    body.dark-mode .act-filter-select option { background: #0f172a; color: #fff; }

    /* Chart Pills / Filter Rows */
    body.dark-mode .tc-pills { background: #0f172a; border-color: #334155; }
    body.dark-mode .tc-pill { color: #94a3b8 !important; }
    body.dark-mode .tc-pill:hover:not(.active) { background: #1e293b; color: #fff; }
    body.dark-mode .tc-pill.active { background: var(--accent); color: #fff !important; }

    /* Chart Titles & Text */
    body.dark-mode .tc-title { color: #fff; }
    body.dark-mode .tc-sub { color: #94a3b8; }

    /* Native Date Picker Theme Support */
    body.dark-mode input[type="date"],
    body.dark-mode .act-filter-input {
        color-scheme: dark;
    }
    body.dark-mode input[type="date"]::-webkit-calendar-picker-indicator,
    body.dark-mode .act-filter-input::-webkit-calendar-picker-indicator {
        filter: brightness(0) invert(1) !important;
        cursor: pointer;
    }

    /* Target the SVG icons inside date wrappers used across various pages */
    body.dark-mode .pf-date-wrap svg,
    body.dark-mode .modal-date-wrapper svg,
    body.dark-mode .date-wrap svg,
    body.dark-mode .filter-input-wrap.date-wrap svg {
        color: #fff !important;
    }

    /* Modals */
    body.dark-mode .modal-container { background: #111827; border-color: #1f2937; }
    body.dark-mode .modal-header { background: #111827; border-bottom-color: #1f2937; }
    body.dark-mode .modal-title { color: #fff; }
    body.dark-mode .modal-icon-box { background: #1e1b4b; color: #818cf8; }
    body.dark-mode .modal-body { background: #111827; }
    body.dark-mode .modal-footer { background: #111827; border-top-color: #1f2937; }

    /* Scrollbars */
    body.dark-mode *::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    body.dark-mode *::-webkit-scrollbar-track { background: transparent; }

    /* Icons animation */
    .dm-icon { transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .navbar-icon-btn:hover .dm-icon { transform: rotate(45deg) scale(1.1); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    const isOpen = sidebar.classList.toggle('mobile-open');
                    
                    // Handle overlay
                    let overlay = document.getElementById('mobileOverlay');
                    if (!overlay) {
                        overlay = document.createElement('div');
                        overlay.id = 'mobileOverlay';
                        overlay.style.cssText = 'position:fixed;inset:0;background:rgba(15,23,42,0.5);z-index:99;display:none;backdrop-filter:blur(2px);';
                        overlay.onclick = function() {
                            sidebar.classList.remove('mobile-open');
                            overlay.style.display = 'none';
                            document.body.style.overflow = '';
                        };
                        document.body.appendChild(overlay);
                    }
                    
                    if (isOpen) {
                        overlay.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    } else {
                        overlay.style.display = 'none';
                        document.body.style.overflow = '';
                    }
                } else {
                    sidebar.classList.toggle('active');
                    localStorage.setItem('sidebar-open', sidebar.classList.contains('active'));
                }
                
                // Trigger transition for elements that might need it
                window.dispatchEvent(new Event('resize'));
            });

            // Restore saved state
            const saved = localStorage.getItem('sidebar-open');
            if (saved === 'false') {
                sidebar.classList.remove('active');
            } else if (saved === 'true') {
                sidebar.classList.add('active');
            }
        }

        // Dark Mode Logic
        const dmToggle = document.getElementById('darkModeToggle');
        const sun = document.getElementById('sunIcon');
        const moon = document.getElementById('moonIcon');
        const body = document.body;

        function updateThemeIcons(isDark) {
            if (isDark) {
                sun.style.display = 'block';
                moon.style.display = 'none';
            } else {
                sun.style.display = 'none';
                moon.style.display = 'block';
            }
        }

        // Apply saved theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
            updateThemeIcons(true);
        }

        if (dmToggle) {
            dmToggle.addEventListener('click', () => {
                const isDark = body.classList.toggle('dark-mode');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateThemeIcons(isDark);
                
                // If Chart.js exists, update it for dark mode
                if (window.Chart) {
                    Chart.helpers.each(Chart.instances, function(instance) {
                        const isDarkNow = body.classList.contains('dark-mode');
                        const gridColor = isDarkNow ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
                        const textColor = isDarkNow ? '#94a3b8' : '#64748b';
                        const tickColor = isDarkNow ? '#94a3b8' : '#475569';
                        
                        // Global defaults
                        Chart.defaults.color = textColor;
                        
                        if (instance.options.scales) {
                            if (instance.options.scales.x) {
                                if(instance.options.scales.x.grid) instance.options.scales.x.grid.color = gridColor;
                                if(instance.options.scales.x.ticks) instance.options.scales.x.ticks.color = tickColor;
                            }
                            if (instance.options.scales.y) {
                                if(instance.options.scales.y.grid) instance.options.scales.y.grid.color = gridColor;
                                if(instance.options.scales.y.ticks) instance.options.scales.y.ticks.color = tickColor;
                            }
                        }
                        
                        // Update Legend labels color
                        if (instance.options.plugins && instance.options.plugins.legend) {
                            instance.options.plugins.legend.labels.color = textColor;
                        }
                        
                        instance.update();
                    });
                }
            });
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

        // Global Fetch Interceptor to handle deactivation (403)
        const originalFetch = window.fetch;
        window.fetch = async function() {
            try {
                const response = await originalFetch.apply(this, arguments);
                if (response.status === 401 || response.status === 403) {
                    // Check if it's a deactivation message
                    const clone = response.clone();
                    try {
                        const data = await clone.json();
                        if (data.message && data.message.toLowerCase().includes('deactivated')) {
                            window.location.reload(); // Reload will trigger the middleware redirect
                        }
                    } catch(e) {}
                }
                return response;
            } catch (error) {
                throw error;
            }
        };
    });
</script>
