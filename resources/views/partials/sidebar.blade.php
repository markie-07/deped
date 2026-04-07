<!-- Sidebar Navigation -->
<div class="sidebar active" id="sidebar">
    <!-- Header: Logo -->
    <div class="sidebar-header">
        <a href="/admin/dashboard" class="sidebar-brand">
            <img src="{{ asset('images/SDO-Logo.png') }}" alt="DepEd" class="brand-logo">
            <span class="brand-name">Schools Division Office</span>
        </a>
    </div>

    <!-- Profile Section -->
    <a href="/admin/profile" class="sidebar-profile" style="text-decoration: none; display: flex; flex-direction: column; align-items: center;">
        @if(auth()->user() && auth()->user()->profile_image)
            <img src="/storage/{{ auth()->user()->profile_image }}" class="profile-avatar" style="object-fit: cover; border: 3px solid #e2e8f0;">
        @elseif(auth()->user())
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        @else
            <div class="profile-avatar">G</div>
        @endif
        <span class="profile-name">{{ auth()->user()->first_name ?? auth()->user()->name ?? 'Guest' }}</span>
        <span class="profile-role">{{ auth()->user()->position ?? 'User' }}</span>
    </a>

    <!-- Navigation Panels Container -->
    <div class="nav-panels-container">
        <!-- Main Navigation Panel -->
        <ul class="nav-list nav-panel" id="mainNavPanel">
            <li class="nav-list-item {{ request()->is('admin/dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <b></b><b></b>
                <a href="/admin/dashboard" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/form') ? 'active' : '' }}" data-tooltip="Form">
                <b></b><b></b>
                <a href="/admin/form" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <span class="nav-text">Form</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/leave-records') ? 'active' : '' }}" data-tooltip="Leave Records">
                <b></b><b></b>
                <a href="/admin/leave-records" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <span class="nav-text">Leave Records</span>
                </a>
            </li>

            <li class="nav-list-item" data-tooltip="Leave History">
                <b></b><b></b>
                <a href="javascript:void(0)" class="nav-link" onclick="showLeaveHistoryPanel()">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <span class="nav-text">Leave History</span>
                    <svg class="nav-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/incharge') ? 'active' : '' }}" data-tooltip="Incharge">
                <b></b><b></b>
                <a href="/admin/incharge" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75c-2.213 0-4.204.957-5.592 2.486m11.582 0a7.488 7.488 0 0 1-5.99 2.764c-2.213 0-4.204-.957-5.593-2.487m11.583 0a7.488 7.488 0 0 0-2.235-4.521M4.508 18.725a7.488 7.488 0 0 1 2.235-4.521M12 12.75A3.75 3.75 0 1 0 12 5.25a3.75 3.75 0 0 0 0 7.5Z" />
                        </svg>
                    </div>
                    <span class="nav-text">Incharge</span>
                </a>
            </li>

@php
    $pendingCount = \App\Models\User::where('is_approved', false)->count();
@endphp

            <li class="nav-list-item {{ request()->is('admin/employee-management') ? 'active' : '' }}" data-tooltip="Accounts">
                <b></b><b></b>
                <a href="/admin/employee-management" class="nav-link">
                    <div class="nav-icon" style="position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span id="sidebarPendingDot" style="display: {{ $pendingCount > 0 ? 'block' : 'none' }}; position:absolute; top:4px; right:4px; width:10px; height:10px; background:#ef4444; border-radius:50%; border:2px solid #f1f5f9; z-index: 100;"></span>
                    </div>
                    <span class="nav-text">Accounts</span>
                </a>
            </li>
        </ul>

        <!-- Leave History Sub-Panel -->
        <ul class="nav-list nav-panel nav-panel-sub" id="leaveHistoryPanel">
            <li class="nav-back-item">
                <a href="javascript:void(0)" class="nav-back-link" onclick="showMainPanel()">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                    <span class="nav-text">Leave History</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/employee') ? 'active' : '' }}" data-tooltip="Employee">
                <b></b><b></b>
                <a href="/admin/employee" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <span class="nav-text">Employee</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/school') ? 'active' : '' }}" data-tooltip="School">
                <b></b><b></b>
                <a href="/admin/school" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                    </div>
                    <span class="nav-text">School</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/position') ? 'active' : '' }}" data-tooltip="Position">
                <b></b><b></b>
                <a href="/admin/position" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <span class="nav-text">Position</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/types-of-leave') ? 'active' : '' }}" data-tooltip="Types of Leave">
                <b></b><b></b>
                <a href="/admin/types-of-leave" class="nav-link">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <span class="nav-text">Types of Leave</span>
                </a>
            </li>

            <li class="nav-list-item {{ request()->is('admin/remarks') ? 'active' : '' }}" data-tooltip="Remarks">
                <b></b><b></b>
                <a href="/admin/remarks" class="nav-link">
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

</div>

<style>
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
        transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1), transform 0.35s ease;
        overflow: visible;
        z-index: 200; 
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
        background: rgba(0, 0, 0, 0.05);
        z-index: 3;
        pointer-events: none;
    }

    .sidebar.active {
        width: 260px;
        overflow: hidden;
        transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Allow protrusion only when NOT active (collapsed) */
    .sidebar:not(.active) {
        overflow: visible;
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
        flex-shrink: 0;
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

    .sidebar:not(.active) .sidebar-brand {
        padding-left: 0;
        justify-content: center;
        width: 100%;
        overflow: visible;
        gap: 0;
    }

    .sidebar:not(.active) .brand-logo {
        margin: 0;
        min-width: 36px;
        width: 36px;
        height: 36px;
    }

    .brand-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.15s ease, width 0.15s ease;
        width: 0;
        overflow: hidden;
    }

    .sidebar.active .brand-name {
        opacity: 1;
        width: auto;
        transition: opacity 0.3s ease 0.2s, width 0.3s ease 0.2s;
    }

    /* ── Profile Section ── */
    .sidebar-profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 10px 15px;
        border-bottom: none;
        overflow: hidden;
        flex-shrink: 0;
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
        border-radius: 50%;
    }

    .sidebar:not(.active) .sidebar-profile {
        padding: 12px 10px 10px;
    }

    /* ── Nav Lists ── */
    .sidebar:not(.active) .nav-list {
        padding: 15px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .nav-list {
        list-style: none;
        padding: 35px 0 35px 5px;
        flex: 1;
        min-height: 0;
        transition: transform 0.35s ease;
    }

    .sidebar.active .nav-list {
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: none;
    }

    .sidebar.active .nav-list::-webkit-scrollbar {
        display: none;
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
        display: flex;
        justify-content: flex-start;
    }

    .sidebar:not(.active) .nav-list-item {
        justify-content: center;
        padding-left: 0;
    }

    .nav-list-item.active {
        background: #fff;
        z-index: 5;
    }

    /* ── Curved Outside effect ── */
    .nav-list-item b:nth-child(1) {
        position: absolute;
        top: -30px;
        right: 0;
        height: 30px;
        width: 30px;
        background: #fff;
        display: none;
        z-index: 4;
    }
    .nav-list-item b:nth-child(1)::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        border-bottom-right-radius: 25px;
        background: #f1f5f9;
    }
    .nav-list-item b:nth-child(2) {
        position: absolute;
        bottom: -30px;
        right: 0;
        height: 30px;
        width: 30px;
        background: #fff;
        display: none;
        z-index: 4;
    }
    .nav-list-item b:nth-child(2)::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        border-top-right-radius: 25px;
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
        justify-content: flex-start;
    }

    .sidebar:not(.active) .nav-link {
        justify-content: center;
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
        color: #fff;
    }

    .nav-list-item.active .nav-icon svg {
        width: 20px;
        height: 20px;
        stroke: #fff;
    }

    .sidebar:not(.active) .nav-list-item.active .nav-icon {
        position: relative;
        right: 0;
        margin: 0 auto;
        width: 48px;
        height: 48px;
        min-width: 48px;
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

    .nav-arrow {
        width: 14px; height: 14px;
        margin-left: auto; margin-right: 15px;
        color: #94a3b8; transition: transform 0.3s;
    }
    .sidebar:not(.active) .nav-arrow { display: none; }

    /* ── Tooltips ── */
    .sidebar:not(.active) .nav-list-item[data-tooltip] {
        position: relative;
        display: flex;
        justify-content: center;
    }
    .sidebar:not(.active) .nav-list-item[data-tooltip]::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 25px);
        top: 50%;
        transform: translateY(-50%) translateX(-6px);
        background: #1e293b; color: #fff;
        padding: 8px 14px; border-radius: 8px;
        font-size: 0.75rem; font-weight: 500;
        white-space: nowrap; opacity: 0; visibility: hidden;
        transition: all 0.2s ease; z-index: 1000;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .sidebar:not(.active) .nav-list-item[data-tooltip]:hover::after {
        opacity: 1; visibility: visible; transform: translateY(-50%) translateX(0);
    }

    /* ── Panel Navigation ── */
    .nav-panels-container {
        position: relative; flex: 1; overflow: hidden; min-height: 0;
    }
    .sidebar:not(.active) .nav-panels-container { overflow: visible; }

    .nav-panel {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
        overflow-y: auto; overflow-x: hidden; scrollbar-width: none;
    }
    .sidebar:not(.active) .nav-panel { overflow: visible; }
    .nav-panel:not(.active-panel) { pointer-events: none; opacity: 0; }
    .nav-panel.active-panel { pointer-events: auto; opacity: 1; }

    .nav-panel-sub { transform: translateX(100%); }
    .nav-panels-container.show-sub #mainNavPanel { transform: translateX(-100%); }
    .nav-panels-container.show-sub .nav-panel-sub { transform: translateX(0); }

    /* ── Back Button ── */
    .nav-back-item { margin-bottom: 8px; width: 100%; display: flex; justify-content: flex-start; }
    .sidebar:not(.active) .nav-back-item { justify-content: center; }

    .nav-back-link {
        display: flex; align-items: center; text-decoration: none;
        color: #6366f1; transition: all 0.2s ease;
        width: 100%; min-height: 56px; border-bottom: 1px solid #e2e8f0;
    }
    .sidebar.active .nav-back-link { padding: 0 20px; gap: 12px; }
    .sidebar:not(.active) .nav-back-link { justify-content: center; padding: 0; border-bottom: none; }
    .nav-back-link:hover { background: #f8faff; }

    /* ── Main Content Adjustment ── */
    .main-content {
        margin-left: 70px;
        min-height: 100vh;
        background: #fff;
        transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        padding: 0;
    }

    .sidebar.active ~ .main-content {
        margin-left: 260px;
    }

    /* Content Body Padding */
    .content-body {
        padding: 2rem 2.5rem;
        transition: padding 0.3s ease;
    }

    /* ── Mobile Logic Overlay ── */
    @media (max-width: 768px) {
        .sidebar {
            width: 280px !important;
            transform: translateX(-100%);
        }
        .sidebar.mobile-open {
            transform: translateX(0);
            box-shadow: 20px 0 50px rgba(0,0,0,0.15);
        }

        /* ── Override ALL :not(.active) centering rules for mobile-open ── */

        /* Brand / Header: left-align */
        .sidebar.mobile-open .sidebar-brand {
            padding-left: 5px !important;
            justify-content: flex-start !important;
            gap: 12px !important;
        }
        .sidebar.mobile-open .brand-logo {
            min-width: 44px !important;
            width: 44px !important;
            height: 44px !important;
        }
        .sidebar.mobile-open .brand-name {
            opacity: 1 !important;
            width: auto !important;
            overflow: visible !important;
        }

        /* Profile */
        .sidebar.mobile-open .sidebar-profile {
            padding: 20px 10px 15px !important;
        }
        .sidebar.mobile-open .profile-avatar {
            width: 65px !important;
            height: 65px !important;
            font-size: 1.4rem !important;
            border-width: 3px !important;
        }
        .sidebar.mobile-open .profile-name {
            opacity: 1 !important;
            max-height: 30px !important;
        }
        .sidebar.mobile-open .profile-role {
            opacity: 1 !important;
            max-height: 20px !important;
        }

        /* Nav list: left-align, standard padding */
        .sidebar.mobile-open .nav-list {
            padding: 35px 0 35px 5px !important;
            align-items: flex-start !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* Nav items: left-aligned */
        .sidebar.mobile-open .nav-list-item {
            justify-content: flex-start !important;
            padding-left: 0 !important;
        }

        /* Nav link: left-aligned */
        .sidebar.mobile-open .nav-link {
            justify-content: flex-start !important;
        }

        /* Nav text: visible */
        .sidebar.mobile-open .nav-text {
            opacity: 1 !important;
            width: auto !important;
            padding-right: 15px !important;
            pointer-events: auto !important;
            overflow: visible !important;
        }

        /* Nav arrow: visible */
        .sidebar.mobile-open .nav-arrow {
            display: block !important;
        }

        /* Active icon: match expanded sidebar style */
        .sidebar.mobile-open .nav-list-item.active .nav-icon {
            position: relative !important;
            right: auto !important;
            margin: 6px 8px 6px 8px !important;
            width: 44px !important;
            height: 44px !important;
            min-width: 44px !important;
        }

        /* Curved outside: works on mobile like desktop expanded */
        .sidebar.mobile-open .nav-list-item.active b:nth-child(1),
        .sidebar.mobile-open .nav-list-item.active b:nth-child(2) {
            display: block !important;
        }

        /* Tooltips: hide on mobile-open since text is visible */
        .sidebar.mobile-open .nav-list-item[data-tooltip]::after {
            display: none !important;
        }

        /* Back button: left align */
        .sidebar.mobile-open .nav-back-item {
            justify-content: flex-start !important;
        }
        .sidebar.mobile-open .nav-back-link {
            justify-content: flex-start !important;
            padding: 0 20px !important;
            gap: 12px !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        /* Panel containers */
        .sidebar.mobile-open .nav-panels-container {
            overflow: hidden !important;
        }
        .sidebar.mobile-open .nav-panel {
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        /* Main content: full width on mobile */
        .main-content, .sidebar.active ~ .main-content {
            margin-left: 0 !important;
        }

        .content-body {
            padding: 1.25rem 1rem !important;
        }
    }
</style>

<script>
    function updateActivePanel() {
        const container = document.querySelector('.nav-panels-container');
        const mainPanel = document.getElementById('mainNavPanel');
        const subPanel = document.getElementById('leaveHistoryPanel');
        if (!container || !mainPanel || !subPanel) return;

        if (container.classList.contains('show-sub')) {
            mainPanel.classList.remove('active-panel');
            subPanel.classList.add('active-panel');
        } else {
            mainPanel.classList.add('active-panel');
            subPanel.classList.remove('active-panel');
        }
    }

    function showLeaveHistoryPanel() {
        const container = document.querySelector('.nav-panels-container');
        if (container) {
            container.classList.add('show-sub');
            updateActivePanel();
        }
    }

    function showMainPanel() {
        const container = document.querySelector('.nav-panels-container');
        if (container) {
            container.classList.remove('show-sub');
            updateActivePanel();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const subPanel = document.getElementById('leaveHistoryPanel');
        const container = document.querySelector('.nav-panels-container');
        
        if (subPanel && subPanel.querySelector('.nav-list-item.active')) {
            showLeaveHistoryPanel();
        } else {
            // Keep current panel but ensure active styling
            updateActivePanel();
        }

        // Fix for sidebar state persistence in CSS transitions
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            const saved = localStorage.getItem('sidebar-open');
            if (saved === 'false') {
                sidebar.classList.remove('active');
            } else if (saved === 'true') {
                sidebar.classList.add('active');
            }
        }
    });
</script>
