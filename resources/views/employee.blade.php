<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f5f6fa; }
    </style>
</head>
<body>
    @include('partials.sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left">
                    <div class="page-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="page-title">Employee Directory</h1>
                        <p class="page-subtitle">All registered personnel with submitted leave records</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="count-badge" id="countBadge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span id="employeeCount">0</span> Employees
                    </div>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="search-filter-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search employees by name, school, or position...">
                    <button class="search-clear" id="searchClear" style="display:none;" onclick="clearSearch()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="view-toggles">
                    <button class="view-btn active" id="viewGrid" onclick="setView('grid')" title="Grid View">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </button>
                    <button class="view-btn" id="viewList" onclick="setView('list')" title="List View">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Loading Skeleton -->
            <div class="employees-grid" id="loadingSkeleton">
                <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
            </div>

            <!-- Employees Grid -->
            <div class="employees-grid" id="employeesGrid" style="display:none;"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon-wrap">
                    <div class="empty-icon-ring"></div>
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                </div>
                <h3 class="empty-title">No Employees Found</h3>
                <p class="empty-text">Try adjusting your search term or clear the filter</p>
                <button class="empty-reset-btn" onclick="clearSearch()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
                    </svg>
                    Reset Search
                </button>
            </div>

        </div>
    </main>

    <!-- Modal for Employee Records -->
    <div class="modal-overlay" id="employeeModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="employee-avatar-modal" id="modalEmployeeAvatar">JD</div>
                    <div class="modal-header-info">
                        <h2 class="modal-title" id="modalEmployeeName">Employee Name</h2>
                        <span class="modal-subtitle" id="modalEmployeeSubtitle">Leave Records</span>
                    </div>
                </div>
                <div class="modal-actions">
                    <div class="modal-search-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text" id="modalSearch" placeholder="Filter records...">
                    </div>
                    <div class="modal-date-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <input type="date" id="modalFilterDate" onchange="fetchEmployeeRecords()" title="Filter by date">
                    </div>
                    <button class="modal-close" onclick="closeEmployeeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Type of Leave</th>
                                <th>Inclusive Dates</th>
                                <th>Remarks</th>
                                <th>Date of Action</th>
                                <th>Deduction Remarks</th>
                                <th>Incharge</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody">
                            <tr><td colspan="10" style="text-align:center; padding: 40px; color: #94a3b8;">Loading details...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    /* ═══════════════════════════════════════
       EMPLOYEES PAGE — PREMIUM REDESIGN
       ═══════════════════════════════════════ */

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        transition: transform 0.3s ease;
    }

    .page-header-icon:hover {
        transform: scale(1.05) rotate(-3deg);
    }

    .page-header-icon svg {
        width: 24px; height: 24px; color: #fff;
    }

    .page-title {
        font-size: 1.35rem; font-weight: 800; color: #1e293b; letter-spacing: -0.03em;
    }

    .page-subtitle {
        font-size: 0.8rem; color: #94a3b8; margin-top: 2px;
    }

    .count-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 24px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4f46e5;
        font-size: 0.78rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid rgba(99, 102, 241, 0.08);
    }

    .count-badge svg {
        width: 16px;
        height: 16px;
    }

    .count-badge span {
        font-weight: 800;
        font-size: 0.92rem;
    }

    /* ── Search & Filter Bar ── */
    .search-filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        max-width: 550px;
    }

    .search-icon {
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
        width: 18px; height: 18px; color: #94a3b8; pointer-events: none;
        transition: color 0.25s;
    }

    .search-input {
        width: 100%; 
        padding: 13px 42px 13px 46px; 
        border: 1.5px solid #e2e8f0;
        border-radius: 14px; 
        font-size: 0.84rem; 
        font-family: 'Inter', sans-serif;
        color: #1e293b; 
        background: #fff; 
        outline: none; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .search-input::placeholder { color: #c0c7d6; }

    .search-input:focus {
        border-color: #6366f1; 
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08), 0 4px 16px rgba(99, 102, 241, 0.06);
    }

    .search-input-wrapper:focus-within .search-icon {
        color: #6366f1;
    }

    .search-clear {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: #f1f5f9;
        border: none;
        width: 26px; height: 26px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .search-clear svg {
        width: 12px; height: 12px; color: #64748b;
    }

    .search-clear:hover {
        background: #fee2e2;
    }

    .search-clear:hover svg { color: #ef4444; }

    /* ── View Toggles ── */
    .view-toggles {
        display: flex;
        gap: 4px;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 4px;
    }

    .view-btn {
        background: transparent;
        border: none;
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: #94a3b8;
        transition: all 0.25s ease;
    }

    .view-btn svg { width: 18px; height: 18px; }

    .view-btn.active {
        background: #fff;
        color: #6366f1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .view-btn:hover:not(.active) {
        color: #64748b;
    }

    /* ── Skeleton Loading ── */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .skeleton-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .skeleton-circle {
        width: 50px; height: 50px;
        border-radius: 15px;
        background: linear-gradient(90deg, #f1f5f9 25%, #e8ecf3 37%, #f1f5f9 63%);
        background-size: 200% 100%;
        animation: shimmer 1.5s ease-in-out infinite;
        flex-shrink: 0;
    }

    .skeleton-lines { flex: 1; }

    .skeleton-line {
        height: 12px;
        border-radius: 6px;
        background: linear-gradient(90deg, #f1f5f9 25%, #e8ecf3 37%, #f1f5f9 63%);
        background-size: 200% 100%;
        animation: shimmer 1.5s ease-in-out infinite;
        margin-bottom: 8px;
    }

    .skeleton-line.w80 { width: 80%; }
    .skeleton-line.w50 { width: 50%; }

    /* ── Employees Grid ── */
    .employees-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 18px;
    }

    .employees-grid.list-view {
        grid-template-columns: 1fr;
        gap: 8px;
    }

    /* ── Employee Card ── */
    @keyframes cardFadeIn {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .employee-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px 24px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        animation: cardFadeIn 0.4s ease both;
    }

    .employee-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 18px 18px 0 0;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .employee-card:hover::before { opacity: 1; }

    .employee-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }

    .employee-card-header {
        display: flex; align-items: center; gap: 14px; margin-bottom: 16px;
    }

    .employee-avatar {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem; flex-shrink: 0;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        letter-spacing: -0.02em;
    }

    /* Avatar color — uniform */
    .employee-avatar { background: #eef2ff; color: #6366f1; }

    .employee-card:hover .employee-avatar {
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .employee-info { flex: 1; min-width: 0; }

    .employee-name {
        font-size: 0.9rem; font-weight: 700; color: #1e293b;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 3px; letter-spacing: -0.01em; line-height: 1.3;
    }

    .employee-position-tag {
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-block;
        background: #f8fafc;
        color: #64748b;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .employee-card-details {
        display: flex; flex-direction: column; gap: 8px;
        padding-top: 14px; border-top: 1px solid #f8fafc;
    }

    .detail-item {
        display: flex; align-items: center; gap: 10px; font-size: 0.78rem; color: #64748b;
        line-height: 1.4;
    }

    .detail-item svg {
        width: 14px; height: 14px; color: #cbd5e1; flex-shrink: 0;
    }

    .detail-item span {
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .record-count-tag {
        position: absolute; bottom: 18px; right: 20px;
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 0.68rem; font-weight: 700;
        display: flex; align-items: center; gap: 4px;
    }

    /* Record count — uniform */
    .record-count-tag { background: #f5f3ff; color: #6366f1; }

    /* ── List View Card ── */
    .employees-grid.list-view .employee-card {
        border-radius: 14px;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 0;
    }

    .employees-grid.list-view .employee-card-header {
        margin-bottom: 0;
        flex: 0 0 240px;
    }

    .employees-grid.list-view .employee-card-details {
        flex: 1;
        flex-direction: row;
        padding-top: 0;
        border-top: none;
        gap: 24px;
        align-items: center;
    }

    .employees-grid.list-view .record-count-tag {
        position: static;
        flex-shrink: 0;
    }

    /* ── Modal Design ── */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.45); 
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex; justify-content: center; align-items: center;
        z-index: 1000; opacity: 0; pointer-events: none; 
        transition: all 0.35s ease;
    }

    .modal-overlay.open { opacity: 1; pointer-events: auto; }

    .modal-container {
        background: #fff; 
        width: 92%; max-width: 1150px; 
        border-radius: 20px;
        box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0,0,0,0.03);
        transform: scale(0.96) translateY(20px); 
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-height: 88vh; display: flex; flex-direction: column; overflow: hidden;
    }

    .modal-overlay.open .modal-container { 
        transform: scale(1) translateY(0); 
    }

    .modal-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        background: linear-gradient(180deg, #fafbff 0%, #fff 100%);
    }

    .modal-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .modal-header-info {
        min-width: 0;
    }

    .employee-avatar-modal {
        width: 46px; height: 46px; border-radius: 14px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .modal-title {
        font-size: 1.1rem; font-weight: 700; color: #1e293b;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .modal-subtitle {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .modal-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .modal-search-wrapper { 
        position: relative; 
    }

    .modal-search-wrapper svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; color: #94a3b8;
    }

    .modal-search-wrapper input {
        padding: 9px 14px 9px 34px; 
        border: 1.5px solid #e8ecf4; 
        border-radius: 12px;
        font-size: 0.8rem; 
        width: 220px; 
        outline: none; 
        transition: all 0.25s; 
        font-family: 'Inter', sans-serif;
        color: #1e293b;
    }

    .modal-search-wrapper input::placeholder { color: #c0c7d6; }

    .modal-search-wrapper input:focus { 
        border-color: #6366f1; 
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .modal-date-wrapper { position: relative; }
    .modal-date-wrapper svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #94a3b8; pointer-events: none; }
    .modal-date-wrapper input { padding: 9px 14px 9px 34px; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.8rem; width: 150px; outline: none; transition: all 0.25s; color: #475569; background: #fff; cursor: pointer; }
    .modal-date-wrapper input::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; transition: 0.2s; }
    .modal-date-wrapper input::-webkit-calendar-picker-indicator:hover { opacity: 1; }
    .modal-date-wrapper input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08); }

    .modal-close {
        background: #f8fafc; border: none; 
        width: 38px; height: 38px; border-radius: 12px;
        color: #94a3b8; cursor: pointer; 
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }

    .modal-close:hover { background: #fee2e2; color: #ef4444; }

    .modal-body { padding: 0; overflow-y: auto; flex: 1; }

    /* ── Record Table ── */
    .table-responsive { width: 100%; }

    .record-table { width: 100%; border-collapse: collapse; }

    .record-table th {
        background: #f8fafc; 
        padding: 14px 20px; 
        text-align: left;
        font-size: 0.7rem; 
        font-weight: 700; 
        color: #64748b;
        text-transform: uppercase; 
        letter-spacing: 0.06em;
        position: sticky; top: 0; z-index: 10;
        border-bottom: 2px solid #eef2ff;
    }

    .record-table td {
        padding: 14px 20px; 
        font-size: 0.82rem; 
        color: #475569; 
        border-bottom: 1px solid #f1f5f9;
    }

    .record-table tr:hover td { background: #fafaff; }

    .record-table tr:last-child td { border-bottom: none; }

    /* ── Action Buttons ── */
    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px; height: 32px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-edit { background: #f0fdf4; color: #16a34a; }
    .btn-edit:hover { background: #16a34a; color: #fff; transform: scale(1.1); }

    .btn-delete { background: #fef2f2; color: #dc2626; }
    .btn-delete:hover { background: #dc2626; color: #fff; transform: scale(1.1); }

    /* ── Badges ── */
    .badge-leave {
        font-size: 0.7rem; font-weight: 600; padding: 4px 10px;
        border-radius: 8px; background: #eef2ff; color: #6366f1;
        display: inline-block;
    }

    .remark-badge {
        font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px;
        display: inline-block;
    }

    .remark-badge.green { background: #ecfdf5; color: #059669; }
    .remark-badge.red { background: #fef2f2; color: #dc2626; }
    .remark-badge.violet { background: #f5f3ff; color: #7c3aed; }
    .remark-badge.yellow { background: #fffbeb; color: #d97706; }
    .remark-badge.gray { background: #f8fafc; color: #94a3b8; }

    /* ── Empty State ── */
    .empty-state { 
        text-align: center; 
        padding: 80px 20px; 
    }

    .empty-icon-wrap {
        position: relative;
        width: 100px; height: 100px;
        margin: 0 auto 24px;
    }

    .empty-icon-ring {
        position: absolute;
        inset: -6px;
        border-radius: 30px;
        border: 2px dashed #e2e8f0;
        animation: spin 20s linear infinite;
    }

    @keyframes spin { 100% { transform: rotate(360deg); } }

    .empty-icon {
        width: 100px; height: 100px; 
        background: linear-gradient(135deg, #f1f5f9, #e8ecf3); 
        border-radius: 26px; 
        display: flex; align-items: center; justify-content: center;
    }

    .empty-icon svg { width: 40px; height: 40px; color: #94a3b8; }

    .empty-title { 
        font-size: 1.1rem; color: #334155; font-weight: 700; margin-bottom: 6px; 
    }

    .empty-text { 
        color: #94a3b8; font-size: 0.84rem; margin-bottom: 20px; 
    }

    .empty-reset-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        background: #fff;
        color: #6366f1;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.25s;
    }

    .empty-reset-btn:hover {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .search-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-input-wrapper {
            max-width: 100%;
        }

        .employees-grid {
            grid-template-columns: 1fr;
        }

        .view-toggles { display: none; }

        .modal-container {
            width: 98%;
            border-radius: 16px;
        }

        .modal-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .modal-search-wrapper input {
            width: 100%;
        }

        .employees-grid.list-view .employee-card {
            flex-direction: column;
            align-items: stretch;
        }

        .employees-grid.list-view .employee-card-header {
            flex: none;
        }

        .employees-grid.list-view .employee-card-details {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allEmployees = [];
    let currentView = 'grid';
    const grid = document.getElementById('employeesGrid');
    const loadingSkeleton = document.getElementById('loadingSkeleton');
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('employeeCount');
    const modal = document.getElementById('employeeModal');

    // Fetch Unique Employees
    fetch('/api/employees')
        .then(res => res.json())
        .then(data => {
            allEmployees = data;
            loadingSkeleton.style.display = 'none';
            grid.style.display = 'grid';
            renderEmployees();
        })
        .catch(err => {
            console.error('Error:', err);
            loadingSkeleton.style.display = 'none';
            grid.style.display = 'grid';
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 50px; color: #ef4444;">Error loading employee list.</p>';
        });

    function getInitials(name) {
        return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
    }

    function renderEmployees(filter = '') {
        const q = filter.toLowerCase();
        const filtered = allEmployees.filter(e => 
            e.name.toLowerCase().includes(q) ||
            (e.school && e.school.toLowerCase().includes(q)) ||
            (e.position && e.position.toLowerCase().includes(q))
        );

        countEl.textContent = filtered.length;
        searchClear.style.display = q ? 'flex' : 'none';

        if (filtered.length === 0) {
            grid.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        grid.style.display = 'grid';
        emptyState.style.display = 'none';

        grid.innerHTML = filtered.map((emp, index) => `
            <div class="employee-card" onclick="openEmployeeModal('${emp.name.replace(/'/g, "\\'")}')" style="animation-delay: ${Math.min(index * 0.03, 0.6)}s">
                <div class="employee-card-header">
                    <div class="employee-avatar">${getInitials(emp.name)}</div>
                    <div class="employee-info">
                        <div class="employee-name" title="${emp.name}">${emp.name}</div>
                        <span class="employee-position-tag">${emp.position || 'No Position'}</span>
                    </div>
                </div>
                <div class="employee-card-details">
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        <span>${emp.school || 'Unassigned'}</span>
                    </div>
                </div>
                <div class="record-count-tag">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:11px; height:11px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    ${emp.record_count} Record${emp.record_count !== 1 ? 's' : ''}
                </div>
            </div>
        `).join('');
    }

    searchInput.addEventListener('input', function() {
        renderEmployees(this.value);
    });

    window.clearSearch = function() {
        searchInput.value = '';
        renderEmployees();
        searchInput.focus();
    };

    window.setView = function(view) {
        currentView = view;
        document.getElementById('viewGrid').classList.toggle('active', view === 'grid');
        document.getElementById('viewList').classList.toggle('active', view === 'list');
        grid.classList.toggle('list-view', view === 'list');
    };

    // Modal Logic
    let currentEmployeeForModal = '';

    window.openEmployeeModal = function(name) {
        currentEmployeeForModal = name;
        modal.classList.add('open');
        document.getElementById('modalEmployeeName').textContent = name;
        document.getElementById('modalEmployeeAvatar').textContent = getInitials(name);
        document.getElementById('modalEmployeeSubtitle').textContent = 'Leave Records';
        document.getElementById('modalSearch').value = '';
        document.getElementById('modalFilterDate').value = '';
        fetchEmployeeRecords();
    };

    window.closeEmployeeModal = function() {
        modal.classList.remove('open');
    };

    function fetchEmployeeRecords() {
        const tbody = document.getElementById('employeeTableBody');
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 60px; color: #94a3b8;"><div style="display:inline-flex; align-items:center; gap:10px;"><svg style="width:18px;height:18px;animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" /></svg> Loading records...</div></td></tr>';

        const date = document.getElementById('modalFilterDate').value;
        fetch(`/api/employees/records?name=${encodeURIComponent(currentEmployeeForModal)}&date=${encodeURIComponent(date)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error(text || 'Server Error');
            }
            return res.json();
        })
        .then(data => {
            // Update subtitle with record count
            document.getElementById('modalEmployeeSubtitle').textContent = `${data.length} Leave Record${data.length !== 1 ? 's' : ''}`;

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 60px; color: #94a3b8;">No records found for this employee.</td></tr>';
                return;
            }

            tbody.innerHTML = data.map((r, index) => {
                let remarkClass = 'gray';
                const rem = (r.remarks || '').toLowerCase();
                if (rem.includes('with pay') && rem.includes('without pay')) remarkClass = 'violet';
                else if (rem.includes('approved') || rem.includes('with pay')) remarkClass = 'green';
                else if (rem.includes('disapproved') || rem.includes('without pay') || rem.includes('cancelled')) remarkClass = 'red';
                else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'yellow';

                return `
                    <tr>
                        <td style="color:#94a3b8; font-family:monospace; font-size:0.75rem;">${index + 1}</td>
                        <td style="font-weight: 600; color: #1e293b;">${r.position || '-'}</td>
                        <td style="color: #475569;">${r.school || '-'}</td>
                        <td><span class="badge-leave">${r.type_of_leave || '-'}</span></td>
                        <td style="font-family: monospace; font-size: 0.75rem; color: #64748b;">${r.inclusive_dates || '-'}</td>
                        <td><span class="remark-badge ${remarkClass}">${r.remarks || '-'}</span></td>
                        <td style="font-family: monospace; font-size: 0.75rem; color: #64748b;">${r.date_of_action || '-'}</td>
                        <td style="font-size: 0.8rem; color: #64748b;">${r.deduction_remarks || '-'}</td>
                        <td style="font-size: 0.8rem; color: #64748b;">${r.incharge || '-'}</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button onclick="editRecord(${r.id})" class="btn-action btn-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button onclick="deleteRecord(${r.id})" class="btn-action btn-delete" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        })
        .catch((err) => {
            console.error('Fetch error:', err);
            tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 60px; color: #ef4444;">Error loading records: ' + err.message.substring(0, 100) + '...</td></tr>';
        });
    }

    window.editRecord = function(id) {
        window.location.href = `/form?edit=${id}`;
    };

    window.deleteRecord = function(id) {
        if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/leave-records/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                fetchEmployeeRecords(); // Refresh modal
                // Refresh the main employee list
                fetch('/api/employees')
                    .then(res => res.json())
                    .then(data => {
                        allEmployees = data;
                        renderEmployees(searchInput.value);
                    });
            } else {
                alert('Error deleting record');
            }
        })
        .catch(() => {
            alert('Error deleting record. Please try again.');
        });
    };

    // Modal interior search
    document.getElementById('modalSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#employeeTableBody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeEmployeeModal();
    });

    // Keyboard shortcut: Escape to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) {
            closeEmployeeModal();
        }
    });
});
</script>

</body>
</html>
