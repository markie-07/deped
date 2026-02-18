<!-- Sidebar Navigation -->
<div class="sidebar active" id="sidebar">
    <!-- Header: Logo -->
    <div class="sidebar-header">
        <a href="/dashboard" class="sidebar-brand">
            <img src="{{ asset('images/SDO-Logo.png') }}" alt="DepEd" class="brand-logo">
            <span class="brand-name">Schools Division Office</span>
        </a>
    </div>

    <!-- Profile Section -->
    <div class="sidebar-profile">
        <div class="profile-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
        </div>
        <span class="profile-name">{{ Auth::user()->name ?? 'User' }}</span>
        <span class="profile-role">Administrator</span>
    </div>

    <!-- Navigation List -->
    <ul class="nav-list">
        <li class="nav-list-item {{ request()->is('dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
            <b></b><b></b>
            <a href="/dashboard" class="nav-link">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </div>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-list-item {{ request()->is('form') ? 'active' : '' }}" data-tooltip="Form">
            <b></b><b></b>
            <a href="/form" class="nav-link">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <span class="nav-text">Form</span>
            </a>
        </li>

        <li class="nav-list-item {{ request()->is('school') ? 'active' : '' }}" data-tooltip="School">
            <b></b><b></b>
            <a href="/school" class="nav-link">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                </div>
                <span class="nav-text">School</span>
            </a>
        </li>

        <li class="nav-list-item {{ request()->is('position') ? 'active' : '' }}" data-tooltip="Position">
            <b></b><b></b>
            <a href="/position" class="nav-link">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <span class="nav-text">Position</span>
            </a>
        </li>

        <li class="nav-list-item {{ request()->is('types-of-leave') ? 'active' : '' }}" data-tooltip="Types of Leave">
            <b></b><b></b>
            <a href="/types-of-leave" class="nav-link">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <span class="nav-text">Types of Leave</span>
            </a>
        </li>

        <li class="nav-list-item {{ request()->is('remarks') ? 'active' : '' }}" data-tooltip="Remarks">
            <b></b><b></b>
            <a href="/remarks" class="nav-link">
                <div class="nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
                <span class="nav-text">Remarks</span>
            </a>
        </li>
    </ul>

</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        min-height: 100vh;
        background: #fff;
        font-family: 'Poppins', sans-serif;
    }

    /* ═══════════════════════════════════════
       SIDEBAR
       ═══════════════════════════════════════ */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 70px;
        background: #f1f5f9;
        transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: visible;
        z-index: 100;
        display: flex;
        flex-direction: column;
    }

    .sidebar::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 1px;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        z-index: 3;
        pointer-events: none;
    }

    .sidebar.active {
        width: 260px;
        transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── Header ── */
    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        min-height: 70px;
        border-bottom: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        padding-left: 5px;
        overflow: hidden;
    }

    .brand-logo {
        min-width: 44px;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .sidebar:not(.active) .brand-logo {
        min-width: 36px;
        width: 36px;
        height: 36px;
    }

    .sidebar:not(.active) .sidebar-brand {
        padding-left: 0;
        justify-content: center;
        width: 100%;
        overflow: visible;
        gap: 0;
    }

    .sidebar:not(.active) .brand-name {
        width: 0;
        overflow: hidden;
    }

    .brand-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.15s ease;
    }

    .sidebar.active .brand-name {
        opacity: 1;
        transition: opacity 0.3s ease 0.2s;
    }

    /* ── Profile Section ── */
    .sidebar-profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 10px 15px;
        border-bottom: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .profile-avatar {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        border: 3px solid #e2e8f0;
    }

    .profile-name {
        margin-top: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        text-align: center;
        opacity: 0;
        max-height: 0;
        transition: opacity 0.15s ease, max-height 0.15s ease;
        overflow: hidden;
    }

    .profile-role {
        font-size: 0.68rem;
        font-weight: 400;
        color: #94a3b8;
        white-space: nowrap;
        text-align: center;
        opacity: 0;
        max-height: 0;
        transition: opacity 0.15s ease, max-height 0.15s ease;
        overflow: hidden;
    }

    .sidebar.active .profile-name {
        opacity: 1;
        max-height: 30px;
        transition: opacity 0.3s ease 0.2s, max-height 0.3s ease 0.2s;
    }

    .sidebar.active .profile-role {
        opacity: 1;
        max-height: 20px;
        transition: opacity 0.3s ease 0.2s, max-height 0.3s ease 0.2s;
    }

    .sidebar:not(.active) .profile-avatar {
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
        border-width: 2px;
    }

    .sidebar:not(.active) .sidebar-profile {
        padding: 12px 10px 10px;
    }

    .nav-list {
        list-style: none;
        padding: 15px 0 15px 5px;
        flex: 1;
        overflow: visible;
    }

    .nav-list::-webkit-scrollbar { width: 3px; }
    .nav-list::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.08);
        border-radius: 4px;
    }

    /* ── Nav Items ── */
    .nav-list-item {
        position: relative;
        width: 100%;
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
        list-style: none;
        margin-bottom: 8px;
        transition: background 0.3s ease;
    }

    .nav-list-item.active {
        background: #fff;
        z-index: 5;
    }

    .nav-list-item:not(.active):hover {
        background: rgba(99, 102, 241, 0.06);
    }

    /* ── Curved Outside — <b> tags ── */
    .nav-list-item b:nth-child(1) {
        position: absolute;
        top: -35px;
        right: 0;
        height: 35px;
        width: 35px;
        background: #fff;
        display: none;
        z-index: 4;
    }

    .nav-list-item b:nth-child(1)::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-bottom-right-radius: 35px;
        background: #f1f5f9;
    }

    .nav-list-item b:nth-child(2) {
        position: absolute;
        bottom: -35px;
        right: 0;
        height: 35px;
        width: 35px;
        background: #fff;
        display: none;
        z-index: 4;
    }

    .nav-list-item b:nth-child(2)::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-top-right-radius: 35px;
        background: #f1f5f9;
    }

    .nav-list-item.active b:nth-child(1),
    .nav-list-item.active b:nth-child(2) {
        display: block;
    }

    /* ── Nav Link ── */
    .nav-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #64748b;
        transition: color 0.2s;
        width: 100%;
        min-height: 56px;
        position: relative;
        z-index: 6;
    }

    .nav-list-item:not(.active):hover .nav-link {
        color: #6366f1;
    }

    .nav-list-item.active .nav-link {
        color: #1e293b;
    }

    .nav-icon {
        min-width: 60px;
        width: 60px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .nav-icon svg {
        width: 22px;
        height: 22px;
        transition: transform 0.2s ease;
    }

    /* ── Hover: non-active icons ── */
    .nav-list-item:not(.active):hover .nav-icon svg {
        transform: scale(1.2);
    }

    /* ── Hover: active icon circle ── */
    .nav-list-item.active:hover .nav-icon {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(99, 102, 241, 0.6);
    }

    .sidebar:not(.active) .nav-list-item.active:hover .nav-icon {
        transform: translateY(-50%) scale(1.1);
    }

    /* ── Active Icon: Circle (shared styles) ── */
    @keyframes popIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        60% {
            transform: scale(1.15);
            opacity: 1;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes popInCollapsed {
        0% {
            transform: translateY(-50%) scale(0);
            opacity: 0;
        }
        60% {
            transform: translateY(-50%) scale(1.15);
            opacity: 1;
        }
        100% {
            transform: translateY(-50%) scale(1);
            opacity: 1;
        }
    }

    .nav-list-item.active .nav-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 50%;
        box-shadow: 0 4px 18px rgba(99, 102, 241, 0.45);
        z-index: 10;
        border: 3px solid #f1f5f9;
        margin: 6px 8px 6px 8px;
        animation: popIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .nav-list-item.active .nav-icon svg {
        width: 20px;
        height: 20px;
        stroke: #fff;
    }

    /* ── Collapsed: Circle protrudes to the right ── */
    .sidebar:not(.active) .nav-list-item.active .nav-icon {
        position: absolute;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        margin: 0;
        width: 50px;
        height: 50px;
        min-width: 50px;
        animation: popInCollapsed 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .nav-text {
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
        padding-right: 15px;
        opacity: 0;
        transition: opacity 0.15s ease;
    }

    .sidebar.active .nav-text {
        opacity: 1;
        transition: opacity 0.3s ease 0.2s;
    }

    .sidebar:not(.active) .nav-text {
        pointer-events: none;
        width: 0;
        padding: 0;
        overflow: hidden;
    }

    /* ── Tooltip for Collapsed Sidebar ── */
    .sidebar:not(.active) .nav-list-item[data-tooltip] {
        position: relative;
    }

    .sidebar:not(.active) .nav-list-item[data-tooltip]::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 30px);
        top: 50%;
        transform: translateY(-50%) translateX(-6px);
        background: #1e293b;
        color: #fff;
        font-size: 0.78rem;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 8px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15), 0 1px 4px rgba(0, 0, 0, 0.1);
        z-index: 200;
        letter-spacing: 0.01em;
    }

    /* Small arrow pointing left */
    .sidebar:not(.active) .nav-list-item[data-tooltip]::before {
        content: '';
        position: absolute;
        left: calc(100% + 20px);
        top: 50%;
        transform: translateY(-50%) translateX(-6px);
        border: 5px solid transparent;
        border-right-color: #1e293b;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 200;
    }

    .sidebar:not(.active) .nav-list-item[data-tooltip]:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(0);
    }

    .sidebar:not(.active) .nav-list-item[data-tooltip]:hover::before {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(0);
    }

    /* ═══════════════════════════════════════
       MAIN CONTENT
       ═══════════════════════════════════════ */
    .main-content {
        margin-left: 70px;
        min-height: 100vh;
        background: #fff;
        font-family: 'Poppins', sans-serif;
        transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar.active ~ .main-content {
        margin-left: 260px;
        transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .content-body {
        padding: 2rem;
    }

    /* ═══════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════ */
    @media (max-width: 768px) {
        .sidebar {
            width: 0;
        }

        .sidebar.active {
            width: 260px;
        }

        .main-content {
            margin-left: 0;
        }

        .sidebar.active ~ .main-content {
            margin-left: 0;
        }
    }
</style>


