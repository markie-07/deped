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
                        
                        <!-- Name Filter Dropdown -->
                        <div class="hero-filter">
                            <div class="filter-select-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                                </svg>
                                <select id="alphaSelect" onchange="filterByLetter(this.value)">
                                    <option value="ALL">All Letters</option>
                                </select>
                            </div>
                        </div>
                        
                        <p class="hsc-hint">Click any card below to view leave records</p>
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
                        <input type="date" id="modalFilterDate" onchange="fetchInchargeRecords()">
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="inchargeTableBody">
                            <tr><td colspan="9" class="table-loading">Loading…</td></tr>
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

/* ── Skeleton ── */
@keyframes shimmer { 0%{background-position:-400px 0;} 100%{background-position:400px 0;} }
.skeleton-card { background:#fff; border-radius:24px; overflow:hidden; border:1px solid #f1f5f9; display:flex; flex-direction:column; }
.sk-banner { width:100%; height:80px; background:linear-gradient(90deg,#f1f5f9 25%,#f8fafc 50%,#f1f5f9 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
.sk-content { padding: 20px; }
.sk-avatar { width:72px; height:72px; border-radius:20px; margin-top:-56px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; border:4px solid #fff; margin-bottom: 12px; }
.sk-line { height:12px; border-radius:6px; margin-bottom:12px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
.sk-l1 { width:70%; } .sk-l2 { width:45%; }

    /* ── Personnel Card — Premium Redesign ── */
    @keyframes cardReady { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .person-card {
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

    .person-card:hover {
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

    .person-card:hover .card-avatar {
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
        padding: 16px 20px 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-person-name {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px; /* Slightly reduced */
        letter-spacing: -0.02em;
        line-height: 1.2;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.4em;
    }

    /* Added sub-label for consistence */
    .card-sub-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 16px;
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

    .person-card:hover .action-icon {
        background: #6366f1;
        color: #fff;
        transform: translateX(4px);
    }

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
    width: 94%; max-width: 1160px;
    max-height: 90vh;
    display: flex;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 32px 80px -12px rgba(0,0,0,0.25);
    transform: scale(0.95) translateY(24px);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.modal-backdrop.open .modal-sheet { transform: scale(1) translateY(0); }
    body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(99,102,241,0.3); }
    body.dark-mode .pf-date-wrap svg { color: #fff !important; }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; color-scheme: dark; }
    body.dark-mode .pf-date-wrap input::-webkit-calendar-picker-indicator { filter: brightness(0) invert(1) !important; }

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

.modal-table-wrap { flex: 1; overflow-y: auto; }

.modal-table { width: 100%; border-collapse: collapse; text-align: left; }

.modal-table thead th {
    background: #f8fafc;
    padding: 12px 18px;
    font-size: 0.68rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.06em;
    position: sticky; top: 0; z-index: 5;
    border-bottom: 2px solid #eef2ff;
    white-space: nowrap;
}

.modal-table tbody td {
    padding: 13px 18px;
    font-size: 0.81rem; color: #475569;
    border-bottom: 1px solid #f8fafc;
}
.modal-table tbody tr:hover td { background: #fafaff; }
.modal-table tbody tr:last-child td { border-bottom: none; }

.table-loading {
    text-align: center; padding: 60px !important;
    color: #94a3b8; font-size: 0.85rem;
}

/* ── Badges ── */
.badge-type {
    display: inline-block;
    font-size: 0.68rem; font-weight: 600; padding: 3px 9px;
    border-radius: 20px; background: #eef2ff; color: #6366f1;
}

.remark-pill {
    display: inline-block;
    font-size: 0.68rem; font-weight: 700; padding: 3px 10px;
    border-radius: 20px;
}
.remark-pill.green  { background: #ecfdf5; color: #059669; }
.remark-pill.red    { background: #fef2f2; color: #dc2626; }
.remark-pill.yellow { background: #fffbeb; color: #d97706; }
.remark-pill.gray   { background: #f8fafc; color: #94a3b8; }

/* ── Edit button ── */
.btn-edit {
    width: 30px; height: 30px; border-radius: 9px;
    border: none; background: #f0fdf4; color: #16a34a;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.2s;
}
.btn-edit:hover { background: #16a34a; color: #fff; transform: scale(1.08); }
.btn-edit svg { width: 13px; height: 13px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Colour palette for cards (cycles) ──
    const PALETTE = [
        { strip: 'linear-gradient(135deg,#6366f1,#8b5cf6)', avatar: 'linear-gradient(135deg,#6366f1,#818cf8)' },
        { strip: 'linear-gradient(135deg,#10b981,#06b6d4)', avatar: 'linear-gradient(135deg,#10b981,#34d399)' },
        { strip: 'linear-gradient(135deg,#f59e0b,#ef4444)', avatar: 'linear-gradient(135deg,#f59e0b,#fbbf24)' },
        { strip: 'linear-gradient(135deg,#ec4899,#8b5cf6)', avatar: 'linear-gradient(135deg,#ec4899,#f472b6)' },
        { strip: 'linear-gradient(135deg,#0ea5e9,#6366f1)', avatar: 'linear-gradient(135deg,#0ea5e9,#38bdf8)' },
        { strip: 'linear-gradient(135deg,#14b8a6,#10b981)', avatar: 'linear-gradient(135deg,#14b8a6,#2dd4bf)' },
    ];

    let allIncharges = [];
    let currentLetter = 'ALL';

    const grid      = document.getElementById('personnelGrid');
    const skeleton  = document.getElementById('skeletonGrid');
    const emptyEl   = document.getElementById('emptyState');
    const countEl   = document.getElementById('inchargeCount');
    const alphaSelect = document.getElementById('alphaSelect');
    const searchInput  = document.getElementById('inchargeSearch');
    const searchClearBtn = document.getElementById('searchClearBtn');

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
        return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    }

    function getColorIdx(name) {
        let h = 0;
        for (let c of name) h = (h * 31 + c.charCodeAt(0)) & 0xffff;
        return h % PALETTE.length;
    }

    // Fetch incharges
    fetch('{{ url("/leave-records/incharges") }}')
        .then(r => r.json())
        .then(data => {
            allIncharges = data;
            buildAlphaBar(data);
            skeleton.style.display = 'none';
            grid.style.display = 'grid';
            // Populate banner total records stat
            const totalRec = data.reduce((sum, i) => sum + (i.leave_count || 0), 0);
            const totalRecEl = document.getElementById('totalRecordsCount');
            if (totalRecEl) totalRecEl.textContent = totalRec;
            renderGrid();
        });

    function buildAlphaBar(data) {
        const letters = [...new Set(data.map(i => i.incharge[0].toUpperCase()))].sort();
        letters.forEach(l => {
            const opt = document.createElement('option');
            opt.value = l;
            opt.textContent = l;
            alphaSelect.appendChild(opt);
        });
    }

    window.filterByLetter = function(letter) {
        currentLetter = letter;
        alphaSelect.value = letter;
        renderGrid(searchInput.value);
    };

    function renderGrid(filter = '') {
        let list = allIncharges;

        if (currentLetter !== 'ALL') {
            list = list.filter(i => i.incharge[0].toUpperCase() === currentLetter);
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
            return `
            <div class="person-card" onclick="openInchargeModal('${safeName}')" style="animation-delay:${Math.min(idx*0.04,0.5)}s">
                <div class="card-banner" style="${coverBg}"></div>
                <div class="card-avatar-container">
                    <div class="card-avatar" style="${avatarBg}">${avatarContent}</div>
                    <div class="card-badge">${i.leave_count} Record${i.leave_count !== 1 ? 's' : ''}</div>
                </div>
                <div class="card-main">
                    <h3 class="card-person-name" title="${i.incharge}">${i.incharge}</h3>
                    <div class="card-sub-label">${position}</div>
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

    window.clearSearch = function() {
        searchInput.value = '';
        searchClearBtn.style.display = 'none';
        renderGrid();
        searchInput.focus();
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
        document.getElementById('panelName').textContent = name;
        document.getElementById('modalSearch').value = '';
        document.getElementById('modalFilterDate').value = '';
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
        tbody.innerHTML = '<tr><td colspan="9" class="table-loading">Loading records…</td></tr>';

        const date = document.getElementById('modalFilterDate').value;
        fetch(`{{ url("/leave-records/by-incharge") }}?incharge=${encodeURIComponent(currentIncharge)}&date=${encodeURIComponent(date)}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('panelRecordCount').textContent = data.length;
                document.getElementById('panelName').textContent = currentIncharge;

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="9" class="table-loading">No records found for this filter.</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map((r, idx) => {
                    let rc = 'gray';
                    const rem = (r.remarks || '').toLowerCase();
                    if (rem.includes('approved') || rem.includes('with pay')) rc = 'green';
                    else if (rem.includes('disapproved') || rem.includes('without pay') || rem.includes('cancelled')) rc = 'red';
                    else if (rem.includes('pending') || rem.includes('review')) rc = 'yellow';

                    return `<tr>
                        <td style="color:#cbd5e1;font-size:0.72rem;font-family:monospace;">${idx + 1}</td>
                        <td style="font-weight:700;color:#1e293b;">${r.name}</td>
                        <td>${r.position || '—'}</td>
                        <td>${r.school || '—'}</td>
                        <td><span class="badge-type">${r.type_of_leave || '—'}</span></td>
                        <td style="font-family:monospace;font-size:0.75rem;">${r.inclusive_dates || '—'}</td>
                        <td><span class="remark-pill ${rc}">${r.remarks || '—'}</span></td>
                        <td style="font-family:monospace;font-size:0.75rem;">${formatDate(r.date_of_action)}</td>
                        <td>
                            <div style="display:flex;gap:8px;">
                                <button class="btn-edit" onclick="editRecord(${r.id})" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteRecord(${r.id})" title="Delete" style="width:30px;height:30px;border-radius:9px;border:none;background:#fef2f2;color:#dc2626;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
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

    window.editRecord = function(id) { window.location.href = "{{ url('/admin/form') }}?edit=" + id; };

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
});
</script>

</body>
</html>
