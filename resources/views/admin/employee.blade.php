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

            <!-- Hero Banner -->
            <div class="hero-banner">
                <div class="hero-dots"></div>
                <div class="hero-left">
                    <div class="hero-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Leave Management
                    </div>
                    <h1 class="hero-title">Employee Directory</h1>
                    <p class="hero-desc">All registered personnel with submitted leave records across the DepEd Division.</p>
                    <div class="hero-meta">
                        <div class="hero-meta-item">
                            <div class="hmi-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num" id="employeeCount">—</span>
                                <span class="hmi-label">Employees</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-search-card">
                        <p class="hsc-label">Find Employee</p>
                        <div class="hero-search">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input type="text" id="searchInput" placeholder="Search by name, school, or position...">
                            <button id="searchClear" onclick="clearSearch()" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="hsc-toggles">
                            <button class="view-btn active" id="viewGrid" onclick="setView('grid')" title="Grid">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            </button>
                            <button class="view-btn" id="viewList" onclick="setView('list')" title="List">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading Skeleton -->
            <div class="employees-grid" id="loadingSkeleton">
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
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
    <div class="modal-backdrop" id="employeeModal" onclick="handleBackdropClick(event)">
        <div class="modal-sheet">
            <!-- Left Panel -->
            <div class="modal-panel">
                <div class="panel-avatar" id="modalEmployeeAvatar"></div>
                <h2 class="panel-name" id="modalEmployeeName">—</h2>
                <p class="panel-role">Employee / Personnel</p>
                <div class="panel-stat-wrap">
                    <div class="panel-stat">
                        <span class="ps-num" id="modalEmployeeRecordCount">0</span>
                        <span class="ps-label">Total Records</span>
                    </div>
                </div>
                <div class="panel-divider"></div>
                <div class="panel-filters">
                    <label class="pf-label">Filter by Date</label>
                    <div class="pf-date-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <input type="date" id="modalFilterDate" onchange="fetchEmployeeRecords()">
                    </div>
                </div>
                <button class="panel-close-btn" onclick="closeEmployeeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
            <!-- Right Main Panel -->
            <div class="modal-main">
                <div class="modal-main-header">
                    <h3 class="mm-title">Leave Records</h3>
                    <div class="mm-search">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" id="modalSearch" placeholder="Search records...">
                    </div>
                </div>
                <div class="modal-table-wrap">
                    <table class="modal-table">
                        <thead>
                            <tr>
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
                            <tr><td colspan="9" style="text-align:center;padding:40px;color:#94a3b8;">Loading records...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    /* EMPLOYEES PAGE — BANNER REDESIGN */
    .hero-banner { position: relative; background: #fff; border-radius: 22px; border: 1.5px solid #e8edf5; display: flex; align-items: stretch; overflow: hidden; margin-bottom: 28px; box-shadow: 0 4px 24px rgba(99,102,241,0.07); }
    .hero-dots { position: absolute; inset: 0; background-image: radial-gradient(circle, #c7d2fe 1px, transparent 1px); background-size: 22px 22px; opacity: 0.45; pointer-events: none; border-radius: 22px; }
    .hero-left { flex: 1; padding: 32px 36px; position: relative; z-index: 1; }
    .hero-tag { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; background: #eef2ff; color: #6366f1; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px; }
    .hero-tag svg { width: 13px; height: 13px; }
    .hero-title { font-size: 1.65rem; font-weight: 900; color: #1e1b4b; letter-spacing: -0.035em; line-height: 1.1; margin-bottom: 10px; }
    .hero-desc { font-size: 0.82rem; color: #64748b; line-height: 1.6; max-width: 420px; margin-bottom: 24px; }
    .hero-meta { display: flex; align-items: center; gap: 20px; }
    .hero-meta-item { display: flex; align-items: center; gap: 10px; }
    .hmi-icon { width: 36px; height: 36px; border-radius: 10px; background: #eef2ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .hmi-icon svg { width: 16px; height: 16px; color: #6366f1; }
    .hmi-num { display: block; font-size: 1.2rem; font-weight: 900; color: #1e1b4b; line-height: 1; }
    .hmi-label { display: block; font-size: 0.63rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }
    .hero-right { width: 300px; flex-shrink: 0; background: linear-gradient(145deg, #f5f3ff 0%, #ede9fe 100%); border-left: 1.5px solid #e0e7ff; display: flex; align-items: center; justify-content: center; padding: 24px; position: relative; z-index: 1; }
    .hero-search-card { width: 100%; }
    .hsc-label { font-size: 0.72rem; font-weight: 700; color: #4f46e5; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; }
    .hero-search { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(99,102,241,0.12); display: flex; align-items: center; padding: 0 14px; gap: 8px; border: 1.5px solid #ddd6fe; transition: border-color 0.2s, box-shadow 0.2s; }
    .hero-search:focus-within { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
    .hero-search svg { width: 16px; height: 16px; color: #a5b4fc; flex-shrink: 0; }
    .hero-search:focus-within svg:first-child { color: #6366f1; }
    .hero-search input { flex: 1; border: none; outline: none; padding: 13px 0; font-size: 0.84rem; font-family: 'Inter', sans-serif; color: #1e293b; background: transparent; }
    .hero-search input::placeholder { color: #c4b5fd; }
    .hero-search button { background: #f1f5f9; border: none; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
    .hero-search button svg { width: 10px; height: 10px; color: #64748b; }
    .hero-search button:hover { background: #fee2e2; }
    .hero-search button:hover svg { color: #ef4444; }
    .hsc-toggles { display: flex; gap: 4px; margin-top: 10px; background: #ede9fe; border-radius: 10px; padding: 3px; }
    .view-btn { background: transparent; border: none; flex: 1; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #7c3aed; transition: all 0.2s; }
    .view-btn svg { width: 16px; height: 16px; }
    .view-btn.active { background: #fff; color: #6366f1; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }

    /* ── Page Header (legacy) ── */
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
    /* ── Grid Container (Legacy/Removed) ── */
    /* No direct body styling here */

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

    /* ── Grid ── */
    .employees-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px; padding-bottom:40px; }

    /* ── Skeleton ── */
    @keyframes shimmer { 0%{background-position:-400px 0;} 100%{background-position:400px 0;} }
    .skeleton-card { background:#fff; border-radius:24px; overflow:hidden; border:1px solid #f1f5f9; display:flex; flex-direction:column; }
    .sk-banner { width:100%; height:80px; background:linear-gradient(90deg,#f1f5f9 25%,#f8fafc 50%,#f1f5f9 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-content { padding: 20px; }
    .sk-avatar { width:72px; height:72px; border-radius:20px; margin-top:-56px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; border:4px solid #fff; margin-bottom: 12px; }
    .sk-line { height:12px; border-radius:6px; margin-bottom:12px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-l1 { width:70%; } .sk-l2 { width:45%; } .sk-l3 { width:60%; }

    /* ── Employee Card — Premium Redesign ── */
    @keyframes cardReady { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .employee-card {
        background: #fff;
        border-radius: 24px;
        border: 1.5px solid #f1f5f9;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: cardReady 0.5s ease both;
        display: flex;
        flex-direction: column;
        position: relative;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
    }

    .employee-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -12px rgba(99, 102, 241, 0.15);
        border-color: rgba(99, 102, 241, 0.2);
    }

    .card-banner {
        height: 80px;
        width: 100%;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .card-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.1) 100%);
        opacity: 0.3;
    }

    .card-avatar-container {
        margin-top: -40px;
        padding: 0 20px;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .card-avatar {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        border: 4px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.3rem;
        color: #fff;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .employee-card:hover .card-avatar {
        transform: scale(1.05) rotate(-2deg);
    }

    .card-badge {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 800;
        color: #6366f1;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.5);
        margin-bottom: 4px;
    }

    .modal-body { 
        padding: 0; 
        overflow-y: auto; 
        overflow-x: auto; 
        flex: 1; 
        scrollbar-width: none; 
        -ms-overflow-style: none;
    }
    .modal-body::-webkit-scrollbar { display: none; }

    .card-main {
        padding: 16px 20px 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-name {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
        line-height: 1.2;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.4em;
    }

    .card-details {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 500;
    }

    .detail-row svg {
        width: 14px;
        height: 14px;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .detail-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .card-action-bar {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .action-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #6366f1;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #f8fafc;
        color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .employee-card:hover .action-icon {
        background: #6366f1;
        color: #fff;
        transform: translateX(4px);
    }

    /* ── Empty State ── */
    .empty-state { text-align:center; padding:80px 20px; }
    .empty-icon-wrap { position:relative; width:100px; height:100px; margin:0 auto 24px; }
    .empty-icon-ring { position:absolute; inset:-6px; border-radius:30px; border:2px dashed #e2e8f0; animation:spin 20s linear infinite; }
    @keyframes spin { 100%{transform:rotate(360deg);} }
    .empty-icon { width:100px; height:100px; background:linear-gradient(135deg,#f1f5f9,#e8ecf3); border-radius:26px; display:flex; align-items:center; justify-content:center; }
    .empty-icon svg { width:40px; height:40px; color:#94a3b8; }
    .empty-title { font-size:1.1rem; color:#334155; font-weight:700; margin-bottom:6px; }
    .empty-text { color:#94a3b8; font-size:0.84rem; margin-bottom:20px; }
    .empty-reset-btn { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; border:1.5px solid #e2e8f0; border-radius:12px; background:#fff; color:#6366f1; font-size:0.8rem; font-weight:600; cursor:pointer; transition:all 0.25s; font-family:'Inter',sans-serif; }
    .empty-reset-btn:hover { background:#6366f1; color:#fff; border-color:#6366f1; }

    /* ── Modal (split-panel, indigo) ── */
    .modal-panel { width:240px; flex-shrink:0; background:linear-gradient(160deg,#eef2ff 0%,#e0e7ff 60%,#c7d2fe 100%); padding:36px 24px 28px; display:flex; flex-direction:column; align-items:center; position:relative; overflow:hidden; border-right:1px solid #c7d2fe; }
    .modal-panel::before { content:''; position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(99,102,241,0.15); top:-60px; right:-60px; }
    .modal-panel::after { content:''; position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(99,102,241,0.1); bottom:40px; left:-40px; }
    .panel-avatar { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#4f46e5); border:4px solid #fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:900; color:#fff; position:relative; z-index:1; box-shadow:0 8px 24px rgba(99,102,241,0.3); }
    .panel-name { font-size:0.9rem; font-weight:700; color:#1e1b4b; text-align:center; margin-top:14px; line-height:1.35; position:relative; z-index:1; }
    .panel-role { font-size:0.68rem; color:#4f46e5; text-align:center; margin-top:4px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; position:relative; z-index:1; }
    .panel-stat-wrap { margin-top:20px; background:rgba(255,255,255,0.7); border:1px solid rgba(99,102,241,0.3); border-radius:14px; padding:14px 20px; text-align:center; width:100%; position:relative; z-index:1; }
    .ps-num { display:block; font-size:1.6rem; font-weight:900; color:#1e1b4b; }
    .ps-label { font-size:0.65rem; color:#6366f1; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
    .panel-divider { width:100%; height:1px; background:rgba(99,102,241,0.25); margin:20px 0; position:relative; z-index:1; }
    .panel-filters { width:100%; position:relative; z-index:1; }
    .pf-label { display:block; font-size:0.65rem; color:#6366f1; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px; }
    .pf-date-wrap { position:relative; background:rgba(255,255,255,0.75); border:1.5px solid rgba(99,102,241,0.4); border-radius:12px; display:flex; align-items:center; padding:0 12px; }
    .pf-date-wrap svg { width:14px; height:14px; color:#6366f1; flex-shrink:0; }
    .pf-date-wrap input { flex:1; border:none; outline:none; background:transparent; padding:10px 8px; font-size:0.78rem; color:#1e1b4b; font-family:'Inter',sans-serif; cursor:pointer; min-width:0; }
    .pf-clear { width:100%; margin-top:8px; padding:8px; border-radius:10px; border:1.5px solid rgba(99,102,241,0.4); background:rgba(255,255,255,0.7); color:#6366f1; font-size:0.72rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; }
    .pf-clear:hover { background:#fee2e2; color:#ef4444; border-color:#fca5a5; }
    .panel-close-btn { margin-top:28px; display:flex; align-items:center; justify-content:center; gap:6px; width:100%; padding:11px; border-radius:12px; border:1.5px solid rgba(99,102,241,0.4); background:rgba(255,255,255,0.7); color:#1e1b4b; font-size:0.8rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; position:relative; z-index:1; }
    .panel-close-btn svg { width:16px; height:16px; }
    .panel-close-btn:hover { background:#fee2e2; border-color:#fca5a5; color:#ef4444; }
    .modal-main { flex:1; background:#fff; display:flex; flex-direction:column; overflow:hidden; min-width:0; }
    .modal-main-header { display:flex; align-items:center; justify-content:space-between; padding:20px 26px; border-bottom:1px solid #f1f5f9; background:#f8fafc; flex-shrink:0; gap:14px; }
    .mm-title { font-size:1rem; font-weight:700; color:#1e293b; }
    .mm-search { position:relative; display:flex; align-items:center; background:#f1f5f9; border-radius:12px; padding:0 14px; gap:8px; border:1.5px solid transparent; transition:all 0.2s; }
    .mm-search:focus-within { background:#fff; border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
    .mm-search svg { width:14px; height:14px; color:#94a3b8; flex-shrink:0; }
    .mm-search:focus-within svg { color:#6366f1; }
    .mm-search input { border:none; outline:none; background:transparent; padding:9px 0; font-size:0.8rem; font-family:'Inter',sans-serif; color:#1e293b; width:200px; }
    .mm-search input::placeholder { color:#b0bac9; }
    .modal-table-wrap { 
        flex:1; 
        overflow-y:auto; 
        overflow-x:auto; 
        scrollbar-width: none; 
        -ms-overflow-style: none;
    }
    .modal-table-wrap::-webkit-scrollbar { display: none; }
    .modal-table { width:100%; min-width: 1400px; border-collapse:collapse; text-align:left; }
    .modal-table thead th { background:#f8fafc; padding:12px 18px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; position:sticky; top:0; z-index:5; border-bottom:2px solid #e2e8f0; white-space:nowrap; }
    .modal-table tbody td { padding:13px 18px; font-size:0.81rem; color:#475569; border-bottom:1px solid #f8fafc; }
    .modal-table tbody tr:hover td { background:#f8fafc; }
    .modal-table tbody tr:last-child td { border-bottom:none; }
    .badge-leave { font-size:0.7rem; font-weight:600; padding:4px 10px; border-radius:8px; background:#eef2ff; color:#4f46e5; display:inline-block; }
    .btn-action { width:32px; height:32px; border-radius:10px; border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.25s ease; }
    .btn-edit { background:#f0fdf4; color:#16a34a; } .btn-edit:hover { background:#16a34a; color:#fff; transform:scale(1.1); }
    .btn-delete { background:#fef2f2; color:#dc2626; } .btn-delete:hover { background:#dc2626; color:#fff; transform:scale(1.1); }

    /* Legacy Search Bar Removal */
    .search-filter-bar { display:none; }

    /* ── List View Layout ── */
    .employees-grid.list-view {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .employees-grid.list-view .employee-card {
        flex-direction: row;
        align-items: center;
        padding: 12px 20px;
        height: auto;
        min-height: 80px;
    }

    .employees-grid.list-view .card-banner {
        display: none;
    }

    .employees-grid.list-view .card-avatar-container {
        margin-top: 0;
        padding: 0;
        margin-right: 20px;
    }

    .employees-grid.list-view .card-avatar {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        font-size: 1rem;
    }

    .employees-grid.list-view .card-badge {
        display: none;
    }

    .employees-grid.list-view .card-main {
        padding: 0;
        flex-direction: row;
        align-items: center;
        flex: 1;
        gap: 24px;
    }

    .employees-grid.list-view .card-name {
        margin-bottom: 0;
        min-height: auto;
        -webkit-line-clamp: 1;
        width: 240px;
        flex-shrink: 0;
    }

    .employees-grid.list-view .card-details {
        margin-bottom: 0;
        flex-direction: row;
        flex: 1;
        gap: 32px;
    }

    .employees-grid.list-view .detail-row {
        width: auto;
        min-width: 150px;
    }

    .employees-grid.list-view .card-action-bar {
        margin-top: 0;
        padding-top: 0;
        border-top: none;
        width: auto;
    }

    .employees-grid.list-view .action-label {
        display: none;
    }

    /* ── Modal Design ── */
    .modal-backdrop {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.45); 
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex; justify-content: center; align-items: center;
        z-index: 1000; opacity: 0; pointer-events: none; 
        transition: all 0.35s ease;
    }

    .modal-backdrop.open { opacity: 1; pointer-events: auto; }

    .modal-sheet {
        background: #fff; 
        width: 98% !important; 
        max-width: none !important;
        border-radius: 20px;
        box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0,0,0,0.03);
        transform: scale(0.96) translateY(20px); 
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-height: 88vh; display: flex; flex-direction: row; overflow: hidden;
    }

    .modal-backdrop.open .modal-sheet { 
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

    .badge { font-size:0.7rem; padding:4px 10px; border-radius:20px; font-weight:700; display:inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .badge-green { background:#ecfdf5; color:#059669; border: 1px solid rgba(5,150,105,0.1); } 
    .badge-red { background:#fef2f2; color:#dc2626; border: 1px solid rgba(220,38,38,0.1); }
    .badge-violet { background:#f5f3ff; color:#7c3aed; border: 1px solid rgba(124,58,237,0.1); } 
    .badge-yellow { background:#fffbeb; color:#d97706; border: 1px solid rgba(217,119,6,0.1); }
    .badge-gray { background:#f1f5f9; color:#64748b; border: 1px solid rgba(100,116,139,0.1); } 

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

    /* ── Dark Mode ── */
    body.dark-mode { background: #0f172a; color: #cbd5e1; }
    body.dark-mode .hero-banner { background: #1e293b; border-color: #334155; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
    body.dark-mode .hero-dots { opacity: 0.1; }
    body.dark-mode .hero-title { color: #f8fafc; }
    body.dark-mode .hero-desc { color: #94a3b8; }
    body.dark-mode .hero-tag { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
    body.dark-mode .hmi-icon { background: rgba(99, 102, 241, 0.15); }
    body.dark-mode .hmi-num { color: #f8fafc; }
    body.dark-mode .hero-right { background: #1a1f35; border-left-color: #334155; }
    body.dark-mode .hero-search { background: #0f172a; border-color: #334155; }
    body.dark-mode .hero-search input { color: #f1f5f9; }
    body.dark-mode .hsc-toggles { background: rgba(0,0,0,0.3); }
    body.dark-mode .view-btn { color: #94a3b8; }
    body.dark-mode .view-btn.active { background: #334155; color: #818cf8; }
    body.dark-mode .section-title { color: #94a3b8; }
    body.dark-mode .section-count { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
    
    /* ── Employee Card Dark Mode ── */
    body.dark-mode .employee-card { 
        background: transparent;
        border: 1.5px solid var(--card-color, #334155);
        box-shadow: none;
    }
    body.dark-mode .card-name { color: #f1f5f9; }
    body.dark-mode .detail-row { color: #94a3b8; }
    body.dark-mode .detail-row svg { color: var(--card-color, #818cf8); }
    body.dark-mode .action-label { color: var(--card-color, #818cf8); }
    body.dark-mode .action-icon { background: rgba(255,255,255,0.05); color: var(--card-color, #818cf8); }
    body.dark-mode .employee-card:hover { 
        background: rgba(30, 41, 59, 0.3);
        transform: translateY(-8px);
        box-shadow: 0 0 20px rgba(var(--card-color-rgb, 99,102,241), 0.15);
    }
    body.dark-mode .employee-card:hover .action-icon {
        background: var(--card-color, #6366f1);
        color: #fff;
    }
    body.dark-mode .card-action-bar { border-top-color: rgba(255,255,255,0.06); }
    body.dark-mode .card-badge { background: rgba(15, 23, 42, 0.7); color: var(--card-color, #818cf8); border-color: var(--card-color, #334155); }
    body.dark-mode .card-avatar { border: 4px solid #0f172a !important; }

    /* Loading Skeleton Dark Mode */
    body.dark-mode .skeleton-card { background: #1e293b; border-color: #334155; }
    body.dark-mode .sk-banner { background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%); background-size: 400px 100%; }
    body.dark-mode .sk-avatar { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; border-color: #1e293b; }
    body.dark-mode .sk-line { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; }

    /* Modal Dark Mode */
    body.dark-mode .modal-sheet { background: #0f172a; border: 1px solid #1e293b; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
    body.dark-mode .modal-panel { background: linear-gradient(160deg, #1e1b4b 0%, #111827 100%); border-right-color: #1e293b; }
    body.dark-mode .panel-avatar { border-color: #1e293b; }
    body.dark-mode .panel-name { color: #f1f5f9; }
    body.dark-mode .panel-role { color: #818cf8; }
    body.dark-mode .panel-stat-wrap { background: rgba(255,255,255,0.05); border-color: rgba(99, 102, 241, 0.2); }
    body.dark-mode .ps-num { color: #f1f5f9; }
    body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(99, 102, 241, 0.3); }
    body.dark-mode .pf-date-wrap svg { color: #fff !important; }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; color-scheme: dark; }
    body.dark-mode .pf-date-wrap input::-webkit-calendar-picker-indicator { filter: brightness(0) invert(1) !important; }
    body.dark-mode .pf-clear, body.dark-mode .panel-close-btn { background: rgba(255,255,255,0.05); border-color: rgba(99,102,241,0.2); color: #f1f5f9; }
    body.dark-mode .panel-divider { background: rgba(99,102,241,0.2); }

    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #111827; border-bottom-color: #1e293b; }
    body.dark-mode .mm-title { color: #f1f5f9; }
    body.dark-mode .mm-search { background: #0a0f1e; }
    body.dark-mode .mm-search input { color: #f1f5f9; }
    body.dark-mode .modal-table thead th { background: #111827; border-bottom-color: #1e293b; color: #cbd5e1; }
    body.dark-mode .modal-table tbody td { border-bottom-color: #1e293b; color: #cbd5e1; }
    body.dark-mode .modal-table tbody tr:hover td { background: #1a1f35; }
    body.dark-mode .badge-leave { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
    body.dark-mode .btn-edit { background: rgba(22, 163, 74, 0.2); color: #4ade80; }
    body.dark-mode .btn-delete { background: rgba(220, 38, 38, 0.2); color: #f87171; }
    body.dark-mode .modal-close { background: #1e293b; color: #94a3b8; }

    /* Custom classes for JS dynamic rows */
    .cell-name { font-weight: 600; color: #1e293b; }
    .cell-school { color: #475569; }
    .cell-meta { font-family: monospace; font-size: 0.75rem; color: #64748b; }
    .cell-subtext { font-size: 0.8rem; color: #64748b; }
    .cell-incharge { font-size: 0.8rem; color: #64748b; }

    body.dark-mode .cell-name { color: #f1f5f9 !important; }
    body.dark-mode .cell-school { color: #cbd5e1 !important; }
    body.dark-mode .cell-meta { color: #94a3b8 !important; }
    body.dark-mode .cell-subtext { color: #94a3b8 !important; }
    body.dark-mode .cell-incharge { color: #cbd5e1 !important; }
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
    fetch('{{ url("/api/employees") }}')
        .then(res => res.json())
        .then(data => {
            // Handle various data structures
            if (Array.isArray(data)) {
                allEmployees = data;
            } else if (data && typeof data === 'object') {
                allEmployees = data.Value || data.data || data.employees || [];
            } else {
                allEmployees = [];
            }
            
            console.log('Fetched employees:', allEmployees.length);
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

    function formatDate(dateStr) {
        if (!dateStr || dateStr === '-') return '-';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return dateStr;
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        const y = date.getFullYear();
        return `${m}-${d}-${y}`;
    }

    function getInitials(name) {
        if (!name) return '??';
        return name.split(' ').filter(n => n.length > 0).map(n => n[0]).slice(0, 2).join('').toUpperCase();
    }
    const PALETTES = [
        ['#6366f1', '#4f46e5'], ['#818cf8', '#6366f1'], ['#4f46e5', '#3730a3'],
        ['#a5b4fc', '#818cf8'], ['#3730a3', '#1e1b4b'], ['#c7d2fe', '#a5b4fc']
    ];
    function getGrad(name) { 
        if (!name) return PALETTES[0];
        const i = name.charCodeAt(0) % PALETTES.length; 
        return PALETTES[isNaN(i) ? 0 : i]; 
    }

    function renderEmployees(filter = '') {
        const q = filter.toLowerCase();
        const filtered = allEmployees.filter(e => 
            (e.name || '').toLowerCase().includes(q) ||
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

        grid.innerHTML = filtered.map((emp, index) => {
            const [c1, c2] = getGrad(emp.name);
            const initials = getInitials(emp.name);
            const pos = emp.position || 'No Position';
            const sch = emp.school || 'No School';
            
            const empName = emp.name || 'Unknown';
            const escapedName = empName.replace(/'/g, "\\'");
            
            return `
                <div class="employee-card" onclick="openEmployeeModal('${escapedName}')" style="animation-delay: ${Math.min(index * 0.03, 0.6)}s; --card-color: ${c1}">
                    <div class="card-banner" style="background: linear-gradient(135deg, ${c1}, ${c2})"></div>
                    <div class="card-avatar-container">
                        <div class="card-avatar" style="background: linear-gradient(135deg, ${c1}, ${c2})">${initials}</div>
                        <div class="card-badge">${emp.record_count} Record${emp.record_count !== 1 ? 's' : ''}</div>
                    </div>
                    <div class="card-main">
                        <h3 class="card-name" title="${empName}">${empName}</h3>
                        <div class="card-details">
                            <div class="detail-row" title="${pos}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .414-.336.75-.75.75H4.5a.75.75 0 0 1-.75-.75v-4.25m16.5 0a3 3 0 0 0-3-3H6.75a3 3 0 0 0-3 3m16.5 0V9a2.25 2.25 0 0 0-2.25-2.25H16.5V4.5a2.25 2.25 0 0 0-2.25-2.25h-4.5A2.25 2.25 0 0 0 7.5 4.5v2.25H5.25A2.25 2.25 0 0 0 3 9v5.15" />
                                </svg>
                                <span class="detail-text">${pos}</span>
                            </div>
                            <div class="detail-row" title="${sch}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                </svg>
                                <span class="detail-text">${sch}</span>
                            </div>
                        </div>
                        <div class="card-action-bar">
                            <span class="action-label">View Profile</span>
                            <div class="action-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" style="width:12px; height:12px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
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
        const [c1, c2] = getGrad(name);
        document.getElementById('modalEmployeeAvatar').textContent = getInitials(name);
        document.getElementById('modalEmployeeAvatar').style.background = `linear-gradient(135deg, ${c1}, ${c2})`;
        document.getElementById('modalSearch').value = '';
        document.getElementById('modalFilterDate').value = new Date().toLocaleDateString('en-CA');
        
        fetchEmployeeRecords();
    };

    window.closeEmployeeModal = function() {
        modal.classList.remove('open');
    };


    window.handleBackdropClick = function(e) {
        if (e.target.id === 'employeeModal') closeEmployeeModal();
    };

    function fetchEmployeeRecords() {
        const tbody = document.getElementById('employeeTableBody');
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">Loading...</td></tr>';
        document.getElementById('modalEmployeeRecordCount').textContent = '...';

        const date = document.getElementById('modalFilterDate').value;

        fetch(`{{ url("/api/employees/records") }}?name=${encodeURIComponent(currentEmployeeForModal)}&date=${encodeURIComponent(date)}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(async res => {
            if (!res.ok) { const text = await res.text(); throw new Error(text || 'Server Error'); }
            return res.json();
        })
        .then(data => {
            document.getElementById('modalEmployeeRecordCount').textContent = data.length;
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">No records found.</td></tr>';
                return;
            }
            tbody.innerHTML = data.map((r, index) => {
                let remarkClass = 'badge-gray';
                const rem = (r.remarks || '').toLowerCase();
                if (rem.includes('with pay') && rem.includes('without pay')) remarkClass = 'badge-violet';
                else if (rem.includes('without pay') || rem === 'disapproved' || rem === 'cancelled') remarkClass = 'badge-red';
                else if (rem.includes('with pay') || rem === 'approved') remarkClass = 'badge-green';
                else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'badge-yellow';
                
                const remarkBadge = r.remarks ? `<span class="badge ${remarkClass}">${r.remarks}</span>` : '-';

                return `
                <tr>
                    <td class="cell-name">${r.position || '-'}</td>
                    <td class="cell-school">${r.school || '-'}</td>
                    <td><span class="badge-leave">${r.type_of_leave || '-'}</span></td>
                    <td class="cell-meta" style="font-family:monospace;font-size:0.75rem;">${r.inclusive_dates || '-'}</td>
                    <td>${remarkBadge}</td>
                    <td class="cell-meta" style="font-family:monospace;font-size:0.75rem;">${formatDate(r.date_of_action)}</td>
                    <td class="cell-subtext">${r.deduction_remarks || '-'}</td>
                    <td class="cell-incharge" style="font-weight:500;">${r.incharge || '-'}</td>
                    <td>
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <button onclick="editRecord(${r.id})" class="btn-action btn-edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg></button>
                            <button onclick="deleteRecord(${r.id})" class="btn-action btn-delete" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></button>
                        </div>
                    </td>
                </tr>
            `;
            }).join('');
            if (document.getElementById('modalSearch').value) filterModalRecords();
        });
    }

    window.editRecord = function(id) {
        window.location.href = "{{ url('/admin/form') }}?edit=" + id;
    };

    window.deleteRecord = function(id) {
        if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`{{ url('/leave-records') }}/${id}`, {
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
                fetch('{{ url("/api/employees") }}')
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

    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#employeeTableBody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    }

    document.getElementById('modalSearch').addEventListener('input', filterModalRecords);

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
