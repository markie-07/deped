<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Incharge Registry - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f8; }
    </style>
</head>
<body>
    @include('partials.sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">

            <!-- Hero Banner -->
            <div class="hero-banner">
                <!-- Dot grid decoration -->
                <div class="hero-dots"></div>

                <!-- Left Column -->
                <div class="hero-left">
                    <div class="hero-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Leave Management
                    </div>
                    <h1 class="hero-title">Incharge Registry</h1>
                    <p class="hero-desc">View all authorized personnel who processed and approved leave records across the division.</p>
                    <div class="hero-meta">
                        <div class="hero-meta-item">
                            <div class="hmi-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num" id="inchargeCount">—</span>
                                <span class="hmi-label">Personnel</span>
                            </div>
                        </div>
                        <div class="hero-meta-divider"></div>
                        <div class="hero-meta-item">
                            <div class="hmi-icon hmi-icon-green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num hmi-num-green" id="totalRecordsCount">—</span>
                                <span class="hmi-label">Total Records</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Search & Filter -->
                <div class="hero-right">
                    <div class="hero-search-card">
                        <p class="hsc-label">Find Personnel</p>
                        <div class="hero-search">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input type="text" id="inchargeSearch" placeholder="Search by name...">
                            <button id="searchClearBtn" onclick="clearSearch()" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        


                        <div class="hero-filter">
                            <div class="filter-select-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                <select id="assignedFilter">
                                    <option value="all">All Assignments</option>
                                    <option value="national">National</option>
                                    <option value="city">City</option>
                                </select>
                            </div>
                        </div>

                        <div class="hsc-toggles">
                            <button class="view-btn active" id="viewGrid" onclick="setView('grid')" title="Grid View">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                            </button>
                            <button class="view-btn" id="viewList" onclick="setView('list')" title="List View">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Loading Skeletons -->
            <div class="personnel-grid" id="skeletonGrid">
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
            </div>

            <!-- Personnel Grid -->
            <div class="personnel-grid" id="personnelGrid" style="display:none;"></div>

            <!-- Empty State -->
            <div id="emptyState" style="display:none;" class="empty-wrap">
                <div class="empty-art">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <h3>No Personnel Found</h3>
                <p>Try a different search term or select <strong>All</strong></p>
                <button class="empty-btn" onclick="clearSearch()">Clear Search</button>
            </div>

        </div>
    </main>

    <!-- ═══════════════════ MODAL ═══════════════════ -->
    <div class="modal-backdrop" id="inchargeModal" onclick="handleBackdropClick(event)">
        <div class="modal-sheet">

            <!-- Modal Sidebar Panel -->
            <div class="modal-panel">
                <div class="panel-avatar" id="panelAvatar"></div>
                <h2 class="panel-name" id="panelName">—</h2>
                <p class="panel-role">Incharge Personnel</p>
                <div class="panel-stat-wrap">
                    <div class="panel-stat">
                        <span class="ps-num" id="panelRecordCount">0</span>
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
                        <input type="date" id="modalFilterDate" value="{{ date('Y-m-d') }}" onchange="fetchInchargeRecords()">
                    </div>
                </div>
                <button class="panel-close-btn" onclick="closeInchargeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>

            <!-- Modal Main Content -->
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
                                <th>#</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Leave Type</th>
                                <th>Inclusive Dates</th>
                                <th>Remarks</th>
                                <th>Date of Action</th>
                                <th>Deduction Remark</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inchargeTableBody">
                            <tr><td colspan="10" class="table-loading">Loading…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   INCHARGE PAGE — BOLD PROFILE WALL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

/* ── Hero Banner ── */
.hero-banner {
    position: relative;
    background: #fff;
    border-radius: 22px;
    border: 1.5px solid #e8edf5;
    display: flex;
    align-items: stretch;
    gap: 0;
    overflow: hidden;
    margin-bottom: 52px; /* Increased to account for the -40px avatar offset on cards */
    box-shadow: 0 4px 24px rgba(99,102,241,0.07);
}

/* Dot-grid decoration */
.hero-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, #c7d2fe 1px, transparent 1px);
    background-size: 22px 22px;
    opacity: 0.45;
    pointer-events: none;
    border-radius: 22px;
}

/* Left column */
.hero-left {
    flex: 1;
    padding: 32px 36px;
    position: relative;
    z-index: 1;
}

.hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    background: #eef2ff;
    color: #6366f1;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 14px;
}
.hero-tag svg { width: 13px; height: 13px; }

.hero-title {
    font-size: 1.65rem;
    font-weight: 900;
    color: #1e1b4b;
    letter-spacing: -0.035em;
    line-height: 1.1;
    margin-bottom: 10px;
}

.hero-desc {
    font-size: 0.82rem;
    color: #64748b;
    line-height: 1.6;
    max-width: 420px;
    margin-bottom: 24px;
}

/* Meta stats row */
.hero-meta {
    display: flex;
    align-items: center;
    gap: 20px;
}

.hero-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.hmi-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: #eef2ff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hmi-icon svg { width: 16px; height: 16px; color: #6366f1; }

.hmi-icon-green { background: #ecfdf5; }
.hmi-icon-green svg { color: #10b981; }

.hmi-num {
    display: block;
    font-size: 1.2rem;
    font-weight: 900;
    color: #1e1b4b;
    line-height: 1;
}
.hmi-num-green { color: #059669; }

.hmi-label {
    display: block;
    font-size: 0.63rem;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-top: 2px;
}

.hero-meta-divider {
    width: 1px;
    height: 36px;
    background: #e2e8f0;
}

/* Right column */
.hero-right {
    width: 380px; /* Increased from 320px */
    flex-shrink: 0;
    background: linear-gradient(145deg, #f5f3ff 0%, #ede9fe 100%);
    border-left: 1.5px solid #e0e7ff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    position: relative;
    z-index: 1;
}

.hero-search-card {
    width: 100%;
}

.hsc-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #4f46e5;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 10px;
}

.hero-search {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 16px rgba(99,102,241,0.12);
    display: flex; align-items: center;
    padding: 0 14px;
    gap: 8px;
    border: 1.5px solid #ddd6fe;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.hero-search:focus-within {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.hero-search svg { width: 16px; height: 16px; color: #a5b4fc; flex-shrink: 0; transition: color 0.2s; }
.hero-search:focus-within svg:first-child { color: #6366f1; }

.hero-search input {
    flex: 1; border: none; outline: none; padding: 13px 0;
    font-size: 0.84rem; font-family: 'Inter', sans-serif; color: #1e293b;
    background: transparent;
}
.hero-search input::placeholder { color: #c4b5fd; }

.hero-search button {
    background: #f1f5f9; border: none; width: 24px; height: 24px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0;
}
.hero-search button svg { width: 10px; height: 10px; color: #64748b; }
.hero-search button:hover { background: #fee2e2; }
.hero-search button:hover svg { color: #ef4444; }

.hsc-toggles { display: flex; gap: 4px; margin-top: 10px; background: #ede9fe; border-radius: 10px; padding: 3px; }
.view-btn { background: transparent; border: none; flex: 1; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #7c3aed; transition: all 0.2s; }
.view-btn svg { width: 16px; height: 16px; pointer-events: none; }
.view-btn.active { background: #fff; color: #6366f1; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }

.hsc-hint {
    font-size: 0.68rem;
    color: #a5b4fc;
    margin-top: 10px;
    text-align: center;
}

/* ── Filter Dropdown (matches School page) ── */
.hero-filter {
    margin-top: 10px;
}
.filter-select-wrap {
    position: relative;
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #ddd6fe;
    padding: 0 14px;
    box-shadow: 0 4px 16px rgba(99,102,241,0.08);
    transition: all 0.2s;
}
.filter-select-wrap:focus-within {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.filter-select-wrap svg {
    position: absolute;
    left: 14px;
    width: 14px;
    height: 14px;
    color: #a5b4fc;
    pointer-events: none;
}
.filter-select-wrap:focus-within svg {
    color: #6366f1;
}
.filter-select-wrap select {
    flex: 1;
    border: none;
    outline: none;
    padding: 11px 0 11px 26px;
    font-size: 0.78rem;
    font-weight: 700;
    font-family: inherit;
    color: #1e293b;
    background: transparent;
    cursor: pointer;
}

    /* ── Personnel Grid ── */
    .personnel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding-bottom: 40px;
    }
    .personnel-grid.list-view { grid-template-columns: 1fr; gap: 12px; }

    /* ── Skeleton ── */
    @keyframes shimmer { 0%{background-position:-400px 0;} 100%{background-position:400px 0;} }
    .skeleton-card { background:#fff; border-radius:24px; overflow:hidden; border:1px solid #f1f5f9; display:flex; flex-direction:column; }
    .sk-banner { width:100%; height:80px; background:linear-gradient(90deg,#f1f5f9 25%,#f8fafc 50%,#f1f5f9 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-content { padding: 20px; }
    .sk-avatar { width:72px; height:72px; border-radius:20px; margin-top:-56px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; border:4px solid #fff; margin-bottom: 12px; }
    .sk-line { height:12px; border-radius:6px; margin-bottom:12px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-l1 { width:70%; } .sk-l2 { width:45%; }

    /* Incharge Card — Premium Redesign */
    @keyframes cardReady { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .incharge-card {
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

    .incharge-card:hover {
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
        margin-top: -56px;
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

    .incharge-card:hover .card-avatar {
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

    .card-main {
        padding: 12px 20px 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .card-name {
        font-size: 0.88rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
        letter-spacing: -0.01em;
        line-height: 1.2;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
        margin-bottom: 8px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 0.72rem;
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
        padding-top: 8px;
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

    .incharge-card:hover .action-icon {
        background: #6366f1;
        color: #fff;
        transform: translateX(4px);
    }

    /* ── List View Layout ── */
    .personnel-grid.list-view .incharge-card {
        flex-direction: row;
        align-items: center;
        padding: 12px 20px;
        height: auto;
        min-height: 80px;
    }

    .personnel-grid.list-view .card-banner { display: none; }
    .personnel-grid.list-view .card-avatar-container { margin-top: 0; padding: 0; margin-right: 20px; }
    .personnel-grid.list-view .card-avatar { width: 52px; height: 52px; border-radius: 14px; font-size: 1rem; border: none; box-shadow: none; }
    .personnel-grid.list-view .card-badge { display: none; }
    .personnel-grid.list-view .card-main { padding: 0; flex-direction: row; align-items: center; flex: 1; gap: 24px; }
    .personnel-grid.list-view .card-name { margin-bottom: 0; min-height: auto; -webkit-line-clamp: 1; width: 300px; flex-shrink: 0; }
    .personnel-grid.list-view .card-details { margin-bottom: 0; flex-direction: row; flex: 1; gap: 32px; }
    .personnel-grid.list-view .detail-row { width: auto; min-width: 150px; }
    .personnel-grid.list-view .card-action-bar { margin-top: 0; padding-top: 0; border-top: none; width: auto; }
    .personnel-grid.list-view .action-label { display: none; }

    /* List View Skeleton */
    .personnel-grid.list-view .skeleton-card {
        flex-direction: row;
        align-items: center;
        padding: 12px 20px;
        height: 80px;
        border-radius: 14px;
    }
    .personnel-grid.list-view .sk-banner { display: none; }
    .personnel-grid.list-view .sk-avatar { margin-top: 0; width: 52px; height: 52px; margin-right: 20px; border-radius: 14px; }
    .personnel-grid.list-view .sk-content { padding: 0; flex: 1; }

/* ── Empty State ── */
.empty-wrap {
    text-align: center;
    padding: 60px 20px;
}
.empty-art {
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border-radius: 24px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.empty-art svg { width: 44px; height: 44px; color: #a5b4fc; }
.empty-wrap h3 { font-size: 1.05rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
.empty-wrap p  { font-size: 0.8rem; color: #94a3b8; margin-bottom: 20px; }
.empty-btn {
    padding: 10px 22px; border-radius: 12px;
    border: 1.5px solid #e0e7ff; background: #fff;
    color: #6366f1; font-size: 0.8rem; font-weight: 600;
    font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s;
}
.empty-btn:hover { background: #6366f1; color: #fff; border-color: #6366f1; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MODAL — SPLIT PANEL DESIGN
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(15,23,42,0.5);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    z-index: 1000;
    opacity: 0; pointer-events: none;
    transition: opacity 0.3s ease;
}
.modal-backdrop.open { opacity: 1; pointer-events: auto; }

    .modal-sheet {
        width: 98% !important;
        max-width: none !important;
        max-height: 90vh;
        display: flex;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 32px 80px -12px rgba(0,0,0,0.25);
        transform: scale(0.95) translateY(24px);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
.modal-backdrop.open .modal-sheet { transform: scale(1) translateY(0); }
    /* Dark Mode (Modal Overrides) */
    body.dark-mode .modal-sheet { background: #0f172a; border: 1px solid #1e293b; box-shadow: 0 40px 100px -12px rgba(0,0,0,0.7); }
    body.dark-mode .modal-panel { background: linear-gradient(160deg, #1e1b4b 0%, #0f172a 60%, #020617 100%); border-right: 1px solid #1e293b; }
    body.dark-mode .modal-panel::before { background: rgba(99,102,241,0.05); }
    body.dark-mode .modal-panel::after { background: rgba(99,102,241,0.03); }
    body.dark-mode .panel-avatar { border-color: #1e293b; box-shadow: 0 8px 32px rgba(0,0,0,0.4); }
    body.dark-mode .panel-name { color: #f1f5f9; }
    body.dark-mode .panel-role { color: #818cf8; }
    body.dark-mode .panel-stat-wrap { background: rgba(30,41,59,0.4); border-color: rgba(99,102,241,0.15); }
    body.dark-mode .ps-num { color: #fff; }
    body.dark-mode .ps-label { color: #818cf8; }
    body.dark-mode .panel-divider { background: rgba(30,41,59,0.7); }
    body.dark-mode .pf-label { color: #818cf8; }
    body.dark-mode .pf-date-wrap { background: rgba(15,23,42,0.4); border-color: #334155; }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; color-scheme: dark; }
    body.dark-mode .pf-date-wrap svg { color: #818cf8; }
    body.dark-mode .panel-close-btn { background: rgba(30,41,59,0.5); border-color: #334155; color: #cbd5e1; }
    body.dark-mode .panel-close-btn:hover { background: rgba(239,68,68,0.1); border-color: #f87171; color: #f87171; }
    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #111827; border-bottom: 1px solid #1e293b; }
    body.dark-mode .mm-title { color: #f1f5f9; }
    body.dark-mode .mm-search { background: #1e293b; }
    body.dark-mode .mm-search input { color: #f1f5f9; }
    body.dark-mode .mm-search svg { color: #64748b; }
    body.dark-mode .modal-body::-webkit-scrollbar-thumb { background: #334155; }

/* ── Left Panel ── */
.modal-panel {
    width: 240px;
    flex-shrink: 0;
    background: linear-gradient(160deg, #eef2ff 0%, #e0e7ff 60%, #dbeafe 100%);
    padding: 36px 24px 28px;
    display: flex; flex-direction: column; align-items: center;
    position: relative;
    overflow: hidden;
    border-right: 1px solid #e0e7ff;
}
.modal-panel::before {
    content: '';
    position: absolute;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(165,180,252,0.25);
    top: -60px; right: -60px;
}
.modal-panel::after {
    content: '';
    position: absolute;
    width: 140px; height: 140px; border-radius: 50%;
    background: rgba(167,243,208,0.3);
    bottom: 40px; left: -40px;
}

.panel-avatar {
    width: 76px; height: 76px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    border: 4px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; font-weight: 900; color: #fff;
    position: relative; z-index: 1;
    box-shadow: 0 8px 24px rgba(99,102,241,0.3);
}

.panel-name {
    font-size: 0.9rem; font-weight: 700; color: #1e1b4b;
    text-align: center; margin-top: 14px; line-height: 1.35;
    position: relative; z-index: 1;
}
.panel-role {
    font-size: 0.68rem; color: #6366f1;
    text-align: center; margin-top: 4px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.06em;
    position: relative; z-index: 1;
}

.panel-stat-wrap {
    margin-top: 20px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(165,180,252,0.4);
    border-radius: 14px;
    padding: 14px 20px;
    text-align: center;
    width: 100%;
    position: relative; z-index: 1;
}
.ps-num { display: block; font-size: 1.6rem; font-weight: 900; color: #4338ca; }
.ps-label { font-size: 0.65rem; color: #6366f1; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

.panel-divider {
    width: 100%; height: 1px;
    background: rgba(165,180,252,0.35);
    margin: 20px 0;
    position: relative; z-index: 1;
}

.panel-filters { width: 100%; position: relative; z-index: 1; }
.pf-label { display: block; font-size: 0.65rem; color: #6366f1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 8px; }

.pf-date-wrap {
    position: relative;
    background: rgba(255,255,255,0.75);
    border: 1.5px solid rgba(165,180,252,0.5);
    border-radius: 12px;
    display: flex; align-items: center;
    padding: 0 12px;
}
.pf-date-wrap svg { width: 14px; height: 14px; color: #818cf8; flex-shrink: 0; }

.pf-date-wrap input {
    flex: 1; border: none; outline: none; background: transparent;
    padding: 10px 8px; font-size: 0.78rem;
    color: #1e1b4b; font-family: 'Inter', sans-serif; cursor: pointer;
    min-width: 0;
}
.pf-date-wrap input::-webkit-calendar-picker-indicator {
    opacity: 0.6; cursor: pointer;
}

.pf-clear {
    width: 100%; margin-top: 8px;
    padding: 8px; border-radius: 10px;
    border: 1.5px solid rgba(165,180,252,0.5);
    background: rgba(255,255,255,0.7);
    color: #6366f1;
    font-size: 0.72rem; font-weight: 600;
    font-family: 'Inter', sans-serif; cursor: pointer;
    transition: all 0.2s;
}
.pf-clear:hover { background: #fee2e2; color: #ef4444; border-color: #fca5a5; }

.panel-close-btn {
    margin-top: auto; margin-top: 28px;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    width: 100%; padding: 11px;
    border-radius: 12px;
    border: 1.5px solid rgba(165,180,252,0.5);
    background: rgba(255,255,255,0.7);
    color: #4338ca;
    font-size: 0.8rem; font-weight: 600;
    font-family: 'Inter', sans-serif; cursor: pointer;
    transition: all 0.2s;
    position: relative; z-index: 1;
}
.panel-close-btn svg { width: 16px; height: 16px; }
.panel-close-btn:hover { background: #fee2e2; border-color: #fca5a5; color: #ef4444; }

/* ── Right Main Panel ── */
.modal-main {
    flex: 1;
    background: #fff;
    display: flex; flex-direction: column;
    overflow: hidden;
    min-width: 0;
}

.modal-main-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 26px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbff;
    flex-shrink: 0;
    gap: 14px;
}

.mm-title { font-size: 1rem; font-weight: 700; color: #1e293b; }

.mm-search {
    position: relative;
    display: flex; align-items: center;
    background: #f1f5f9; border-radius: 12px;
    padding: 0 14px; gap: 8px;
    border: 1.5px solid transparent;
    transition: all 0.2s;
}
.mm-search:focus-within { background: #fff; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.mm-search svg { width: 14px; height: 14px; color: #94a3b8; flex-shrink: 0; }
.mm-search:focus-within svg { color: #6366f1; }
.mm-search input {
    border: none; outline: none; background: transparent;
    padding: 9px 0; font-size: 0.8rem;
    font-family: 'Inter', sans-serif; color: #1e293b;
    width: 200px;
}
.mm-search input::placeholder { color: #b0bac9; }


    .modal-table-wrap { 
        flex: 1; 
        overflow-y: auto; 
        overflow-x: hidden; 
        scrollbar-width: none; 
        -ms-overflow-style: none;
    }
    .modal-table-wrap::-webkit-scrollbar { display: none; }
    .modal-table { width: 100%; border-collapse: collapse; text-align: left; table-layout: fixed; }
    .modal-table thead th { background: #f8fafc; padding: 12px 18px; font-size: 0.68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; position: sticky; top: 0; z-index: 5; border-bottom: 2px solid #eef2ff; white-space: nowrap; }
    .modal-table tbody td { padding: 13px 18px; font-size: 0.81rem; color: #475569; border-bottom: 1px solid #f8fafc; word-wrap: break-word; vertical-align: top; line-height: 1.4; }

    /* Action Buttons */
    .btn-action { width:32px; height:32px; border-radius:10px; border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.25s cubic-bezier(0.4, 0, 0.2, 1); flex-shrink: 0; }
    .btn-edit { background:#f0fdf4; color:#16a34a; } 
    .btn-edit:hover { background:#16a34a; color:#fff; transform: translateY(-2px) scale(1.1); box-shadow: 0 4px 12px rgba(22,163,74,0.2); }
    .btn-delete { background:#fef2f2; color:#dc2626; } 
    .btn-delete:hover { background:#dc2626; color:#fff; transform: translateY(-2px) scale(1.1); box-shadow: 0 4px 12px rgba(220,38,38,0.2); }

    /* Column widths for Incharge Modal */
    .modal-table th:nth-child(1), .modal-table td:nth-child(1) { width: 4%; }  /* # */
    .modal-table th:nth-child(2), .modal-table td:nth-child(2) { width: 12%; } /* Name */
    .modal-table th:nth-child(3), .modal-table td:nth-child(3) { width: 10%; } /* Position */
    .modal-table th:nth-child(4), .modal-table td:nth-child(4) { width: 10%; } /* School */
    .modal-table th:nth-child(5), .modal-table td:nth-child(5) { width: 8%; }  /* Leave Type */
    .modal-table th:nth-child(6), .modal-table td:nth-child(6) { width: 12%; } /* Dates */
    .modal-table th:nth-child(7), .modal-table td:nth-child(7) { width: 10%; } /* Remarks */
    .modal-table th:nth-child(8), .modal-table td:nth-child(8) { width: 8%; }  /* Date of Action */
    .modal-table th:nth-child(9), .modal-table td:nth-child(9) { width: 10%; } /* Deduction Remark */
    .modal-table th:nth-child(10), .modal-table td:nth-child(10) { width: 7%; } /* Actions */

    .modal-table tbody tr:hover td { background: #f5f7ff; color: #1e293b; }
    .table-loading { text-align: center !important; padding: 60px !important; color: #94a3b8 !important; font-weight: 500 !important; }
    .badge { font-size:0.7rem; padding:4px 10px; border-radius:20px; font-weight:700; display:inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.02); white-space: nowrap; }
    .badge-green { background:#ecfdf5; color:#059669; border: 1px solid rgba(5,150,105,0.1); } 
    .badge-red { background:#fef2f2; color:#dc2626; border: 1px solid rgba(220,38,38,0.1); }
    .badge-violet { background:#f5f3ff; color:#7c3aed; border: 1px solid rgba(124,58,237,0.1); } 
    .badge-yellow { background:#fffbeb; color:#d97706; border: 1px solid rgba(217,119,6,0.1); }
    .badge-gray { background:#f1f5f9; color:#64748b; border: 1px solid rgba(100,116,139,0.1); } 
    .badge-leave { font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:8px; background:#eef2ff; color:#6366f1; display:inline-block; white-space: nowrap; }

/* ── Dark Mode Overrides ── */
body.dark-mode { background: #0f172a; color: #cbd5e1; }

body.dark-mode .hero-banner { background: #1e293b; border-color: #334155; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
body.dark-mode .hero-dots { opacity: 0.1; }
body.dark-mode .hero-title { color: #f8fafc; }
body.dark-mode .hero-meta-divider { background: #334155; }
body.dark-mode .hmi-num { color: #f8fafc; }
body.dark-mode .hero-right { background: #1a1f35; border-left-color: #334155; }
body.dark-mode .hero-search { background: #0f172a; border-color: #334155; }
body.dark-mode .hero-search input { color: #f1f5f9; }
body.dark-mode .hsc-toggles { background: rgba(0,0,0,0.3); }
body.dark-mode .view-btn { color: #94a3b8; }
body.dark-mode .view-btn.active { background: #334155; color: #818cf8; }
body.dark-mode .filter-select-wrap { background: #0f172a; border-color: #334155; }
body.dark-mode .filter-select-wrap select { color: #f1f5f9; }
body.dark-mode .filter-select-wrap select option { background: #1e293b; color: #f1f5f9; }

/* Cards in Dark Mode */
body.dark-mode .incharge-card { background: transparent; border: 1.5px solid var(--card-color, #334155); box-shadow: none; }
body.dark-mode .card-name { color: #f1f5f9; }
body.dark-mode .detail-row { color: #94a3b8; }
body.dark-mode .detail-row svg { color: var(--card-color, #818cf8); }
body.dark-mode .action-label { color: var(--card-color, #818cf8); }
body.dark-mode .action-icon { background: rgba(255,255,255,0.05); color: var(--card-color, #818cf8); }
body.dark-mode .incharge-card:hover { background: rgba(30, 41, 59, 0.3); transform: translateY(-8px); box-shadow: 0 0 20px rgba(var(--card-color-rgb, 99,102,241), 0.15); }
body.dark-mode .incharge-card:hover .action-icon { background: var(--card-color, #6366f1); color: #fff; }
body.dark-mode .card-action-bar { border-top-color: rgba(255,255,255,0.06); }
body.dark-mode .card-badge { background: rgba(15, 23, 42, 0.7); color: var(--card-color, #818cf8); border-color: var(--card-color, #334155); }
body.dark-mode .card-avatar { border: 4px solid #0f172a !important; }

/* Modal in Dark Mode */
body.dark-mode .modal-sheet { background: #0f172a; border: 1px solid #1e293b; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
body.dark-mode .modal-panel { background: linear-gradient(160deg, #1e1b4b 0%, #111827 100%); border-right-color: #1e293b; }
body.dark-mode .panel-avatar { border-color: #1e293b !important; }
body.dark-mode .panel-name { color: #f1f5f9; }
body.dark-mode .panel-role { color: #818cf8; }
body.dark-mode .panel-stat-wrap { background: rgba(255,255,255,0.05); border-color: rgba(99, 102, 241, 0.2); }
body.dark-mode .ps-num { color: #f1f5f9; }
body.dark-mode .ps-label { color: #818cf8; }
body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(99, 102, 241, 0.3); }
body.dark-mode .pf-date-wrap input { color: #f1f5f9; color-scheme: dark; }
body.dark-mode .pf-date-wrap input::-webkit-calendar-picker-indicator { filter: brightness(0) invert(1) !important; }
body.dark-mode .pf-date-wrap svg { color: #fff !important; }
body.dark-mode .pf-clear, body.dark-mode .panel-close-btn { background: rgba(255,255,255,0.05); border-color: rgba(99, 102, 241, 0.2); color: #f1f5f9; }
body.dark-mode .panel-divider { background: rgba(99, 102, 241, 0.2); }

body.dark-mode .modal-main { background: #0f172a !important; }
body.dark-mode .modal-main-header { background: #0a0f1e !important; border-bottom: 1px solid #1e293b !important; }
body.dark-mode .mm-title { color: #f1f5f9; }
body.dark-mode .mm-search { background: #0a0f1e !important; border: 1px solid #1e293b !important; }
body.dark-mode .mm-search input { color: #f1f5f9; }
body.dark-mode .modal-table { background: transparent !important; }
body.dark-mode .modal-table thead th { background: #0a0f1e !important; border-bottom: 2px solid #1e293b !important; color: #94a3b8; }
body.dark-mode .modal-table tbody td { background: transparent !important; border-bottom: 1px solid #1e293b !important; color: #cbd5e1; }
body.dark-mode .modal-table tbody tr:hover td { background: rgba(255, 255, 255, 0.03) !important; color: #f1f5f9 !important; }

/* Dynamic Classes */
.cell-name { font-weight: 700; color: #1e293b; }
.cell-position { color: #475569; }
.cell-meta { font-family: monospace; font-size: 0.725rem; color: #94a3b8; }
.cell-subtext { font-size: 0.8rem; color: #64748b; }

body.dark-mode .cell-name { color: #f1f5f9 !important; }
body.dark-mode .cell-position { color: #cbd5e1 !important; }
body.dark-mode .cell-meta { color: #94a3b8 !important; }
body.dark-mode .cell-subtext { color: #94a3b8 !important; }

/* Status Badges in Dark Mode */
body.dark-mode .badge-type { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
body.dark-mode .remark-pill.green { background: rgba(16, 185, 129, 0.15); color: #34d399; }
body.dark-mode .remark-pill.red { background: rgba(239, 68, 68, 0.15); color: #f87171; }
body.dark-mode .remark-pill.yellow { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
body.dark-mode .remark-pill.gray { background: rgba(148, 163, 184, 0.15); color: #cbd5e1; }

body.dark-mode .btn-edit { background: rgba(22, 163, 74, 0.2); color: #4ade80; }
body.dark-mode .btn-edit:hover { background: #16a34a; color: #fff; }
body.dark-mode .btn-delete { background: rgba(220, 38, 38, 0.2); color: #f87171 !important; }
body.dark-mode .btn-delete:hover { background: #dc2626; color: #fff; }

/* ── Skeleton Dark Mode ── */
body.dark-mode .skeleton-card { background: #1e293b; border-color: #334155; }
body.dark-mode .sk-banner { background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%); background-size: 400px 100%; animation: shimmer 1.6s ease-in-out infinite; }
body.dark-mode .sk-avatar { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; animation: shimmer 1.6s ease-in-out infinite; border-color: #1e293b !important; }
body.dark-mode .sk-line { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; animation: shimmer 1.6s ease-in-out infinite; }

    /* ── Mobile Responsiveness ── */
    @media (max-width: 768px) {
        .content-body { padding: 12px 14px !important; }
        .hero-banner { flex-direction: column; border-radius: 22px; margin-bottom: 30px; }
        .hero-left { padding: 24px 20px; }
        .hero-title { font-size: 1.35rem; }
        .hero-right { width: 100%; border-left: none; border-top: 1.5px solid #e0e7ff; padding: 20px; }
        .hsc-hint { display: none; }
        
        .personnel-grid { 
            grid-template-columns: repeat(2, 1fr) !important; 
            gap: 10px !important; 
        }
        .incharge-card { 
            border-radius: 16px !important; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.04) !important;
        }
        .card-banner { height: 50px !important; }
        .card-avatar-container { margin-top: -32px !important; padding: 0 10px !important; }
        .card-avatar { width: 44px !important; height: 44px !important; border-radius: 12px !important; border-width: 3px !important; font-size: 0.9rem !important; }
        .card-badge { padding: 2px 6px !important; font-size: 0.55rem !important; border-radius: 6px !important; }
        .card-main { padding: 8px 10px 10px !important; }
        .card-name { font-size: 0.78rem !important; margin-bottom: 4px !important; -webkit-line-clamp: 2 !important; min-height: 2.2em; }
        .card-details { gap: 2px !important; margin-bottom: 6px !important; }
        .detail-row { font-size: 0.6rem !important; gap: 4px !important; }
        .detail-row svg { width: 11px !important; height: 11px !important; }
        .card-action-bar { padding-top: 8px !important; }
        .action-label { font-size: 0.58rem !important; gap: 4px !important; }
        .action-icon { width: 22px !important; height: 22px !important; border-radius: 6px !important; }

        .personnel-grid.list-view { grid-template-columns: 1fr !important; }
        .personnel-grid.list-view .incharge-card { 
            flex-direction: row !important; 
            align-items: center !important; 
            padding: 10px 16px !important; 
            gap: 12px !important;
            min-height: auto !important;
        }
        .personnel-grid.list-view .card-avatar-container { margin: 0 !important; flex-shrink: 0 !important; }
        .personnel-grid.list-view .card-avatar { width: 44px !important; height: 44px !important; border-radius: 12px !important; }
        .personnel-grid.list-view .card-main { 
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            align-items: center !important;
            width: 100% !important;
            padding: 0 !important;
            flex: 1 !important;
            gap: 2px 12px !important;
        }
        .personnel-grid.list-view .card-name { 
            grid-column: 1 !important;
            width: 100% !important; 
            font-size: 0.82rem !important;
            margin: 0 !important;
        }
        .personnel-grid.list-view .card-details { 
            grid-column: 1 !important;
            flex-direction: column !important; 
            gap: 1px !important; 
            width: 100% !important; 
        }
        .personnel-grid.list-view .detail-row { min-width: 0 !important; font-size: 0.68rem !important; }
        .personnel-grid.list-view .detail-row svg { width: 12px !important; height: 12px !important; }
        .personnel-grid.list-view .card-action-bar {
            grid-column: 2 !important;
        }

        .modal-sheet {
            width: 95% !important;
            height: 85vh !important;
            margin: auto !important;
            border-radius: 24px !important;
            flex-direction: column !important;
            max-height: none !important;
            overflow-y: auto !important;
            background: #fff !important;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4) !important;
            border: 1px solid #e2e8f0;
        }

        body.dark-mode .modal-sheet {
            background: #0f172a !important;
            border-color: #1e293b !important;
        }

        .modal-panel {
            width: 100% !important;
            flex-shrink: 0 !important;
            padding: 16px 20px !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 12px !important;
            border-right: none !important;
            border-bottom: 2px solid #e0e7ff;
            max-height: none !important;
            overflow: visible !important;
        }

        body.dark-mode .modal-panel {
            background: linear-gradient(160deg, #1e1b4b 0%, #111827 100%) !important;
            border-bottom: 1px solid #1e293b !important;
        }

        .modal-panel::before, .modal-panel::after { display: none !important; }
        .panel-avatar { width: 40px !important; height: 40px !important; font-size: 0.9rem !important; margin-bottom: 0 !important; border-width: 2px !important; }
        .panel-name { font-size: 0.85rem !important; margin-top: 0 !important; text-align: left !important; }
        .panel-role { display: none !important; }
        .panel-divider { display: none !important; }
        .panel-stat-wrap { margin-top: 0 !important; padding: 8px 14px !important; margin-bottom: 0 !important; }
        .ps-num { font-size: 1.1rem !important; }
        .panel-filters { display: flex !important; flex-direction: column !important; gap: 4px !important; width: 100% !important; margin-top: 12px; }
        .pf-date-wrap { width: 100% !important; }
        .pf-label { margin-bottom: 2px !important; }
        .panel-close-btn { margin-top: 12px !important; width: 100% !important; padding: 11px !important; flex: none !important; border-radius: 12px !important; font-size: 0.8rem !important; }
        
        .modal-main {
            overflow: visible !important;
            flex: none !important;
            background: transparent !important;
        }
        .modal-main-header { 
            flex-direction: column !important; 
            align-items: stretch !important;
            gap: 8px !important;
            padding: 12px 16px !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 100 !important;
            background: #fff !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }
        body.dark-mode .modal-main-header {
            background: #0f172a !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
        }
        .mm-search { width: 100% !important; }
        .mm-search input { width: 100% !important; }
        
        .modal-table-wrap {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            overflow-y: visible !important;
            flex: none !important;
        }
        .modal-table {
            min-width: 1500px !important;
            table-layout: fixed !important;
        }
        /* Optimized column widths for 10-column layout */
        .modal-table th:nth-child(1), .modal-table td:nth-child(1) { width: 50px !important; }   /* # */
        .modal-table th:nth-child(2), .modal-table td:nth-child(2) { width: 200px !important; }  /* Name */
        .modal-table th:nth-child(3), .modal-table td:nth-child(3) { width: 160px !important; }  /* Position */
        .modal-table th:nth-child(4), .modal-table td:nth-child(4) { width: 160px !important; }  /* School */
        .modal-table th:nth-child(5), .modal-table td:nth-child(5) { width: 140px !important; }  /* Leave Type */
        .modal-table th:nth-child(6), .modal-table td:nth-child(6) { width: 180px !important; }  /* Dates */
        .modal-table th:nth-child(7), .modal-table td:nth-child(7) { width: 150px !important; }  /* Remarks */
        .modal-table th:nth-child(8), .modal-table td:nth-child(8) { width: 120px !important; }  /* Date of Action */
        .modal-table th:nth-child(9), .modal-table td:nth-child(9) { width: 220px !important; }  /* Deduction */
        .modal-table th:nth-child(10), .modal-table td:nth-child(10) { width: 100px !important; }  /* Actions */
        .modal-table thead th {
            position: relative !important;
            z-index: auto !important;
            padding: 12px 14px !important;
            font-size: 0.7rem !important;
        }
        .modal-table tbody td {
            padding: 14px 14px !important;
            font-size: 0.75rem !important;
            white-space: normal !important;
            word-break: break-word !important;
        }
        body.dark-mode .modal-panel { border-bottom-color: #1e293b !important; }
        body.dark-mode .hero-right { border-top-color: #334155; }
        body.dark-mode .personnel-grid.list-view .action-icon { background: #1e293b !important; }
    }
</style>

<script>
const USER_ASSIGNED = "{{ auth()->user()->assigned ?? '' }}";

document.addEventListener('DOMContentLoaded', function () {
    const assignedFilter = document.getElementById('assignedFilter');
    if (assignedFilter && USER_ASSIGNED) {
        assignedFilter.value = USER_ASSIGNED.toLowerCase();
    }

    // ── Colour palette for cards (cycles) ──
    const PALETTE = [
        { strip: 'linear-gradient(135deg, #6366f1, #4f46e5)', avatar: 'linear-gradient(135deg, #6366f1, #818cf8)', color: '#6366f1' },
        { strip: 'linear-gradient(135deg, #10b981, #059669)', avatar: 'linear-gradient(135deg, #10b981, #34d399)', color: '#10b981' },
        { strip: 'linear-gradient(135deg, #f59e0b, #d97706)', avatar: 'linear-gradient(135deg, #f59e0b, #fbbf24)', color: '#f59e0b' },
        { strip: 'linear-gradient(135deg, #ec4899, #db2777)', avatar: 'linear-gradient(135deg, #ec4899, #f472b6)', color: '#ec4899' },
        { strip: 'linear-gradient(135deg, #0ea5e9, #0284c7)', avatar: 'linear-gradient(135deg, #0ea5e9, #38bdf8)', color: '#0ea5e9' },
        { strip: 'linear-gradient(135deg, #14b8a6, #0d9488)', avatar: 'linear-gradient(135deg, #14b8a6, #2dd4bf)', color: '#14b8a6' },
    ];

    let allIncharges = [];
    let currentView = localStorage.getItem('inchargeView') || 'grid';

    const grid      = document.getElementById('personnelGrid');
    const skeleton  = document.getElementById('skeletonGrid');
    const emptyEl   = document.getElementById('emptyState');
    const countEl   = document.getElementById('inchargeCount');
    const searchInput  = document.getElementById('inchargeSearch');
    const searchClearBtn = document.getElementById('searchClearBtn');

    // Apply saved view on load
    if (currentView === 'list') {
        grid.classList.add('list-view');
        skeleton.classList.add('list-view');
        document.getElementById('viewGrid').classList.remove('active');
        document.getElementById('viewList').classList.add('active');
    }

    function formatDate(dateStr) {
        if (!dateStr || dateStr === '—' || dateStr === '-') return '-';
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

    function getColorIdx(name) {
        if (!name) return 0;
        let h = 0;
        for (let c of name) h = (h * 31 + c.charCodeAt(0)) & 0xffff;
        return h % PALETTE.length;
    }

    // Fetch incharges
    fetch('{{ url("/leave-records/incharges") }}')
        .then(r => r.json())
        .then(data => {
            allIncharges = data;
            skeleton.style.display = 'none';
            grid.style.display = 'grid';
            // Populate banner total records stat
            const totalRec = data.reduce((sum, i) => sum + (i.leave_count || 0), 0);
            const totalRecEl = document.getElementById('totalRecordsCount');
            if (totalRecEl) totalRecEl.textContent = totalRec;
            renderGrid();
        });



    window.setView = function(view) {
        currentView = view;
        localStorage.setItem('inchargeView', view);
        document.getElementById('viewGrid').classList.toggle('active', view === 'grid');
        document.getElementById('viewList').classList.toggle('active', view === 'list');
        grid.classList.toggle('list-view', view === 'list');
        skeleton.classList.toggle('list-view', view === 'list');
    };

    function renderGrid(filter = '') {
        let list = allIncharges;

        const assignedVal = document.getElementById('assignedFilter').value;
        if (assignedVal !== 'all') {
            list = list.filter(i => (i.assigned || '').toLowerCase() === assignedVal.toLowerCase());
        }
        if (filter.trim()) {
            list = list.filter(i => i.incharge.toLowerCase().includes(filter.toLowerCase()));
        }

        countEl.textContent = list.length;

        if (list.length === 0) {
            grid.innerHTML = '';
            emptyEl.style.display = 'block';
            return;
        }
        emptyEl.style.display = 'none';

        grid.innerHTML = list.map((i, idx) => {
            const ci = getColorIdx(i.incharge);
            const col = PALETTE[ci];
            const initials = getInitials(i.incharge);
            const safeName = i.incharge.replace(/'/g, "\\'");
            const storageBase = '{{ url("/storage") }}';
            const coverBg = i.cover_image
                ? `background-image:url('${storageBase}/${i.cover_image}'); background-size:${(i.cover_zoom || 1)*100}%; background-position:${i.cover_offset_x ?? 50}% ${i.cover_offset_y ?? 50}%;`
                : `background:${col.strip}`;
            const avatarContent = i.profile_image
                ? `<img src="${storageBase}/${i.profile_image}" style="width:100%;height:100%;object-fit:cover;border-radius:20px; transform: translate(${i.profile_offset_x ?? 0}px, ${i.profile_offset_y ?? 0}px) scale(${i.profile_zoom ?? 1});">`
                : initials;
            const avatarBg = i.profile_image ? 'background:transparent;overflow:hidden;' : `background:${col.avatar}`;
            const position = i.position || '—';
            const roleLabel = i.role ? (i.role.charAt(0).toUpperCase() + i.role.slice(1)) : 'User';
            
            return `
            <div class="incharge-card" onclick="openInchargeModal('${safeName}')" style="animation-delay:${Math.min(idx*0.04,0.5)}s; --card-color: ${col.color}">
                <div class="card-banner" style="${coverBg}"></div>
                <div class="card-avatar-container">
                    <div class="card-avatar" style="${avatarBg}">${avatarContent}</div>
                    <div class="card-badge">${i.leave_count} Record${i.leave_count !== 1 ? 's' : ''}</div>
                </div>
                <div class="card-main">
                    <h3 class="card-name" title="${i.incharge}">${i.first_name || i.incharge}</h3>
                    <div class="card-details">
                        <div class="detail-row" title="Assignment">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                            <span class="detail-text" style="text-transform: capitalize;">${i.assigned || 'National'}</span>
                        </div>
                        <div class="detail-row" title="${position}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .414-.336.75-.75.75H4.5a.75.75 0 0 1-.75-.75v-4.25m16.5 0a3 3 0 0 0-3-3H6.75a3 3 0 0 0-3 3m16.5 0V9a2.25 2.25 0 0 0-2.25-2.25H16.5V4.5a2.25 2.25 0 0 0-2.25-2.25h-4.5A2.25 2.25 0 0 0 7.5 4.5v2.25H5.25A2.25 2.25 0 0 0 3 9v5.15" />
                            </svg>
                            <span class="detail-text">${position}</span>
                        </div>
                        <div class="detail-row" title="${roleLabel}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0ZM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="detail-text">${roleLabel}</span>
                        </div>
                    </div>
                    <div class="card-action-bar">
                        <span class="action-label">View Records</span>
                        <div class="action-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" style="width:12px; height:12px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    searchInput.addEventListener('input', e => {
        renderGrid(e.target.value);
        searchClearBtn.style.display = e.target.value ? 'flex' : 'none';
    });

    if (assignedFilter) {
        assignedFilter.addEventListener('change', () => {
            renderGrid(searchInput.value);
        });
    }

    window.clearSearch = function() {
        searchInput.value = '';
        searchClearBtn.style.display = 'none';
        renderGrid();
        searchInput.focus();
    };

    window.clearModalDate = function() {
        document.getElementById('modalFilterDate').value = '';
        fetchInchargeRecords();
    };

    // ── Modal ──
    const modal = document.getElementById('inchargeModal');
    let currentIncharge = '';

    window.openInchargeModal = function(name) {
        currentIncharge = name;
        const ci = getColorIdx(name);
        const panelAvatar = document.getElementById('panelAvatar');
        // Find matching incharge data for profile image
        const matchedIncharge = allIncharges.find(ic => ic.incharge === name);
        const storageBase = '{{ url("/storage") }}';
        if (matchedIncharge && matchedIncharge.profile_image) {
            panelAvatar.innerHTML = `<img src="${storageBase}/${matchedIncharge.profile_image}" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">`;
            panelAvatar.style.background = 'transparent';
            panelAvatar.style.overflow = 'hidden';
        } else {
            panelAvatar.innerHTML = getInitials(name);
            panelAvatar.style.background = PALETTE[ci].avatar;
        }
        // Use first_name for display name if available
        document.getElementById('panelName').textContent = (matchedIncharge && matchedIncharge.first_name) ? matchedIncharge.first_name : name;
        document.getElementById('modalSearch').value = '';
        // Set the date filter to today's date by default
        const now = new Date();
        const today = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
        document.getElementById('modalFilterDate').value = today;
        
        modal.classList.add('open');
        fetchInchargeRecords();
    };

    window.closeInchargeModal = function() {
        modal.classList.remove('open');
    };

    window.handleBackdropClick = function(e) {
        if (e.target === modal) closeInchargeModal();
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) {
            closeInchargeModal();
        }
    });




    window.fetchInchargeRecords = function() {
        const tbody = document.getElementById('inchargeTableBody');
        tbody.innerHTML = '<tr><td colspan="10" class="table-loading">Loading records…</td></tr>';

        const date = document.getElementById('modalFilterDate').value;
        fetch(`{{ url("/leave-records/by-incharge") }}?incharge=${encodeURIComponent(currentIncharge)}&date=${encodeURIComponent(date)}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('panelRecordCount').textContent = data.length;
                const displayName = (data.length > 0 && data[0].first_name) ? data[0].first_name : currentIncharge;
                document.getElementById('panelName').textContent = displayName;

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="10" class="table-loading">No records found for this filter.</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map((r, idx) => {
                    let bc = 'badge-gray';
                    const rem = (r.remarks || '').toLowerCase();
                    if (rem.includes('with pay') && rem.includes('without pay')) bc = 'badge-violet';
                    else if (rem.includes('with pay')) bc = 'badge-green';
                    else if (rem.includes('without pay')) bc = 'badge-red';
                    else if (rem.includes('approved')) bc = 'badge-green';
                    else if (rem.includes('disapproved') || rem.includes('cancelled')) bc = 'badge-red';
                    else if (rem.includes('pending') || rem.includes('review')) bc = 'badge-yellow';

                    return `<tr>
                        <td class="cell-meta" style="font-weight: 600; font-family:monospace;">${idx + 1}</td>
                        <td class="cell-name" style="font-weight: 700;">${r.name}</td>
                        <td class="cell-position" style="font-weight: 600;">${r.position || '—'}</td>
                        <td class="cell-subtext">${r.school || '—'}</td>
                        <td><span class="badge-leave">${r.type_of_leave || '—'}</span></td>
                        <td class="cell-meta" style="font-family:monospace; letter-spacing: -0.01em;">${r.inclusive_dates || '—'}</td>
                        <td><span class="badge ${bc}">${r.remarks || '—'}</span></td>
                        <td class="cell-meta" style="font-family:monospace; font-weight:700;">${formatDate(r.date_of_action)}</td>
                        <td class="cell-meta">${r.deduction_remarks || '—'}</td>
                        <td style="width:12%;">
                            <div style="display:flex; gap:8px; justify-content:center; flex-wrap:nowrap;">
                                <button class="btn-action btn-edit" onclick="editRecord(${r.id})" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteRecord(${r.id})" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>`;
                }).join('');
            });
    };

    // Search within modal
    document.getElementById('modalSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#inchargeTableBody tr').forEach(row => {
            if (row.cells.length > 1) row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    window.editRecord = function(id) { 
        window.location.href = "{{ url('/admin/form') }}?edit=" + id + "&source=incharge&inchargeName=" + encodeURIComponent(currentIncharge); 
    };

    window.deleteRecord = function(id) {
        if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) return;

        fetch(`{{ url("/leave-records") }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchInchargeRecords();
                // Refresh main grid
                fetch('{{ url("/leave-records/incharges") }}')
                    .then(res => res.json())
                    .then(data => {
                        allIncharges = data;
                        renderGrid(searchInput.value);
                    });
            } else {
                alert('Error deleting record.');
            }
        })
        .catch(() => alert('Error deleting record.'));
    };
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) {
            closeInchargeModal();
        }
    });

    // Check for openModal URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const openModal = urlParams.get('openModal');
    if (openModal) {
        const checkInterval = setInterval(() => {
            if (allIncharges.length > 0) {
                clearInterval(checkInterval);
                openInchargeModal(openModal);
            }
        }, 100);
    }
});
</script>

</body>
</html>
