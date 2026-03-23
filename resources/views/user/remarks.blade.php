<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Remarks - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f5f6fa; }
    </style>
</head>
<body>
    @include('partials.user-sidebar')

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
                    <h1 class="hero-title">Remarks Analysis</h1>
                    <p class="hero-desc">Track and manage action outcomes — approved, disapproved, with pay, and without pay statuses.</p>
                    <div class="hero-meta">
                        <div class="hero-meta-item">
                            <div class="hmi-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num" id="remarkCount">—</span>
                                <span class="hmi-label">Remarks</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-search-card">
                        <p class="hsc-label">Find Remark</p>
                        <div class="hero-search">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input type="text" id="searchInput" placeholder="Search remarks...">
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
            <div id="loadingSkeleton">
                <div class="remarks-grid">
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                </div>
            </div>

            <!-- Remarks Grid -->
            <div class="remarks-grid" id="remarksGrid"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon-wrap">
                    <div class="empty-icon-ring"></div>
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                        </svg>
                    </div>
                </div>
                <h3 class="empty-title">No Remarks Found</h3>
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

    <!-- Modal for Remark Records -->
    <div class="modal-backdrop" id="remarkModal" onclick="handleBackdropClick(event)">
        <div class="modal-sheet">
            <!-- Left Panel -->
            <div class="modal-panel">
                <div class="panel-avatar" id="modalRemarkAvatar"></div>
                <h2 class="panel-name" id="modalRemarkText">—</h2>
                <p class="panel-role">Remark Category</p>
                <div class="panel-stat-wrap">
                    <div class="panel-stat">
                        <span class="ps-num" id="modalRemarkRecordCount">0</span>
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
                        <input type="date" id="modalFilterDate" value="{{ date('Y-m-d') }}" onchange="fetchRemarkRecords()">
                    </div>
                </div>
                <button class="panel-close-btn" onclick="closeRemarkModal()">
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
                                <th>Name</th>
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
                        <tbody id="remarkTableBody">
                            <tr><td colspan="9" style="text-align:center;padding:40px;color:#94a3b8;">Loading records...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    /* REMARKS PAGE — BANNER REDESIGN */
    .hero-banner { position: relative; background: #fff; border-radius: 22px; border: 1.5px solid #e8edf5; display: flex; align-items: stretch; overflow: hidden; margin-bottom: 28px; box-shadow: 0 4px 24px rgba(245,158,11,0.07); }
    .hero-dots { position: absolute; inset: 0; background-image: radial-gradient(circle, #fde68a 1px, transparent 1px); background-size: 22px 22px; opacity: 0.45; pointer-events: none; border-radius: 22px; }
    .hero-left { flex: 1; padding: 32px 36px; position: relative; z-index: 1; }
    .hero-tag { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; background: #fffbeb; color: #d97706; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px; }
    .hero-tag svg { width: 13px; height: 13px; }
    .hero-title { font-size: 1.65rem; font-weight: 900; color: #1e1b4b; letter-spacing: -0.035em; line-height: 1.1; margin-bottom: 10px; }
    .hero-desc { font-size: 0.82rem; color: #64748b; line-height: 1.6; max-width: 420px; margin-bottom: 24px; }
    .hero-meta { display: flex; align-items: center; gap: 20px; }
    .hero-meta-item { display: flex; align-items: center; gap: 10px; }
    .hmi-icon { width: 36px; height: 36px; border-radius: 10px; background: #fffbeb; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .hmi-icon svg { width: 16px; height: 16px; color: #f59e0b; }
    .hmi-num { display: block; font-size: 1.2rem; font-weight: 900; color: #1e1b4b; line-height: 1; }
    .hmi-label { display: block; font-size: 0.63rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }
    .hero-right { width: 300px; flex-shrink: 0; background: linear-gradient(145deg, #fffbeb 0%, #fef3c7 100%); border-left: 1.5px solid #fde68a; display: flex; align-items: center; justify-content: center; padding: 24px; position: relative; z-index: 1; }
    .hero-search-card { width: 100%; }
    .hsc-label { font-size: 0.72rem; font-weight: 700; color: #d97706; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; }
    .hero-search { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(245,158,11,0.12); display: flex; align-items: center; padding: 0 14px; gap: 8px; border: 1.5px solid #fde68a; transition: border-color 0.2s, box-shadow 0.2s; }
    .hero-search:focus-within { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.1); }
    .hero-search svg { width: 16px; height: 16px; color: #fbbf24; flex-shrink: 0; }
    .hero-search:focus-within svg:first-child { color: #f59e0b; }
    .hero-search input { flex: 1; border: none; outline: none; padding: 13px 0; font-size: 0.84rem; font-family: 'Inter', sans-serif; color: #1e293b; background: transparent; }
    .hero-search input::placeholder { color: #fbbf24; }
    .hero-search button { background: #f1f5f9; border: none; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
    .hero-search button svg { width: 10px; height: 10px; color: #64748b; }
    .hero-search button:hover { background: #fee2e2; }
    .hero-search button:hover svg { color: #ef4444; }
    .hsc-toggles { display: flex; gap: 4px; margin-top: 10px; background: #fef3c7; border-radius: 10px; padding: 3px; }
    .view-btn { background: transparent; border: none; flex: 1; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #92400e; transition: all 0.2s; }
    .view-btn svg { width: 16px; height: 16px; }
    .view-btn.active { background: #fff; color: #d97706; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }

    /* ── Page Header (kept for legacy CSS) ── */
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
    .page-header-left { display: flex; align-items: center; gap: 16px; }
    .page-header-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35); transition: transform 0.3s ease; }
    .page-header-icon:hover { transform: scale(1.05) rotate(-3deg); }
    .page-header-icon svg { width: 24px; height: 24px; color: #fff; }
    .page-title { font-size: 1.35rem; font-weight: 800; color: #1e293b; letter-spacing: -0.03em; }
    .page-subtitle { font-size: 0.8rem; color: #94a3b8; margin-top: 2px; }
    .count-badge { display: flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 24px; background: linear-gradient(135deg, #fffbeb, #fef3c7); color: #d97706; font-size: 0.78rem; font-weight: 600; border: 1px solid rgba(245, 158, 11, 0.08); }
    .count-badge svg { width: 16px; height: 16px; }
    .count-badge span { font-weight: 800; font-size: 0.92rem; }

    /* ── Search Bar & Toggles ── */
    .search-filter-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
    .search-input-wrapper { position: relative; max-width: 450px; flex: 1; }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8; pointer-events: none; transition: color 0.25s; }
    .search-input { width: 100%; padding: 13px 42px 13px 46px; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.84rem; font-family: 'Inter', sans-serif; color: #1e293b; background: #fff; outline: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .search-input:focus { border-color: #f59e0b; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.08), 0 4px 16px rgba(245, 158, 11, 0.06); }
    .search-clear { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: #f1f5f9; border: none; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .search-clear svg { width: 12px; height: 12px; color: #64748b; }
    .search-clear:hover { background: #fee2e2; color: #ef4444; }

    .view-toggles { display: flex; gap: 4px; background: #f1f5f9; border-radius: 12px; padding: 4px; }
    .view-btn { background: transparent; border: none; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #94a3b8; transition: all 0.25s ease; }
    .view-btn svg { width: 18px; height: 18px; }
    .view-btn.active { background: #fff; color: #f59e0b; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

    /* ── Grid ── */
    .remarks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding-bottom: 40px;
    }
    .remarks-grid.list-view { grid-template-columns: 1fr; gap: 8px; }

    /* ── Skeleton ── */
    @keyframes shimmer { 0%{background-position:-400px 0;} 100%{background-position:400px 0;} }
    .skeleton-card { background:#fff; border-radius:24px; overflow:hidden; border:1px solid #f1f5f9; display:flex; flex-direction:column; }
    .sk-banner { width:100%; height:80px; background:linear-gradient(90deg,#f1f5f9 25%,#f8fafc 50%,#f1f5f9 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-content { padding: 20px; }
    .sk-avatar { width:72px; height:72px; border-radius:20px; margin-top:-56px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; border:4px solid #fff; margin-bottom: 12px; }
    .sk-line { height:12px; border-radius:6px; margin-bottom:12px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-l1 { width:70%; } .sk-l2 { width:45%; }

    /* ── Remark Card — Premium Redesign ── */
    @keyframes cardReady { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .remark-card {
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

    .remark-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -12px rgba(30, 41, 59, 0.12);
        border-color: rgba(0, 0, 0, 0.1);
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

    .remark-card:hover .card-avatar {
        transform: scale(1.05) rotate(-2deg);
    }

    .card-badge {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 800;
        color: #d97706;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.5);
        margin-bottom: 2px;
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
        font-size: 0.7rem;
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
        color: #f59e0b;
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

    .remark-card:hover .action-icon {
        background: var(--theme-color, #f59e0b);
        color: #fff;
        transform: translateX(4px);
    }

    /* ── List View Layout ── */
    .remarks-grid.list-view {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .remarks-grid.list-view .remark-card {
        flex-direction: row;
        align-items: center;
        padding: 12px 20px;
        height: auto;
        min-height: 80px;
    }
    .remarks-grid.list-view .card-banner { display: none; }
    .remarks-grid.list-view .card-avatar-container { margin-top: 0; padding: 0; margin-right: 20px; }
    .remarks-grid.list-view .card-avatar { width: 52px; height: 52px; border-radius: 14px; font-size: 1rem; border: none; box-shadow: none; }
    .remarks-grid.list-view .card-badge { display: none; }
    .remarks-grid.list-view .card-main { padding: 0; flex-direction: row; align-items: center; flex: 1; gap: 24px; }
    .remarks-grid.list-view .card-name { margin-bottom: 0; min-height: auto; -webkit-line-clamp: 1; width: 300px; flex-shrink: 0; }
    .remarks-grid.list-view .card-details { margin-bottom: 0; flex-direction: row; flex: 1; gap: 32px; }
    .remarks-grid.list-view .detail-row { width: auto; min-width: 150px; }
    .remarks-grid.list-view .card-action-bar { margin-top: 0; padding-top: 0; border-top: none; width: auto; }
    .remarks-grid.list-view .action-label { display: none; }

    /* ── Empty State ── */
    .empty-state { text-align:center; padding:80px 20px; }
    .empty-icon-wrap { position:relative; width:100px; height:100px; margin:0 auto 24px; }
    .empty-icon-ring { position:absolute; inset:-6px; border-radius:30px; border:2px dashed #e2e8f0; animation:spin 20s linear infinite; }
    @keyframes spin { 100%{transform:rotate(360deg);} }
    .empty-icon { width:100px; height:100px; background:linear-gradient(135deg,#f1f5f9,#e8ecf3); border-radius:26px; display:flex; align-items:center; justify-content:center; }
    .empty-icon svg { width:40px; height:40px; color:#94a3b8; }
    .empty-title { font-size:1.1rem; color:#334155; font-weight:700; margin-bottom:6px; }
    .empty-text { color:#94a3b8; font-size:0.84rem; margin-bottom:20px; }
    .empty-reset-btn { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; border:1.5px solid #e2e8f0; border-radius:12px; background:#fff; color:#f59e0b; font-size:0.8rem; font-weight:600; cursor:pointer; transition:all 0.25s; font-family:'Inter',sans-serif; }
    .empty-reset-btn:hover { background:#f59e0b; color:#fff; border-color:#f59e0b; }

    /* ── Modal (split-panel) ── */
    .modal-backdrop { position:fixed; inset:0; background:rgba(15,23,42,0.5); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); display:flex; align-items:center; justify-content:center; z-index:1000; opacity:0; pointer-events:none; transition:opacity 0.3s ease; }
    .modal-backdrop.open { opacity:1; pointer-events:auto; }
    .modal-sheet { width:98% !important; max-width: none !important; max-height:90vh; display:flex; flex-direction: row; border-radius:24px; overflow:hidden; box-shadow:0 32px 80px -12px rgba(0,0,0,0.25); transform:scale(0.95) translateY(24px); transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1); }
    .modal-backdrop.open .modal-sheet { transform:scale(1) translateY(0); }
    .modal-panel { width:240px; flex-shrink:0; background:linear-gradient(160deg,#fffbeb 0%,#fef3c7 60%,#fde68a 100%); padding:36px 24px 28px; display:flex; flex-direction:column; align-items:center; position:relative; overflow:hidden; border-right:1px solid #fde68a; }
    .modal-panel::before { content:''; position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(251,191,36,0.2); top:-60px; right:-60px; }
    .modal-panel::after { content:''; position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(252,211,77,0.15); bottom:40px; left:-40px; }
    .panel-avatar { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,#f59e0b,#d97706); border:4px solid #fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:900; color:#fff; position:relative; z-index:1; box-shadow:0 8px 24px rgba(245,158,11,0.3); }
    .panel-name { font-size:0.9rem; font-weight:700; color:#1e1b4b; text-align:center; margin-top:14px; line-height:1.35; position:relative; z-index:1; }
    .panel-role { font-size:0.68rem; color:#d97706; text-align:center; margin-top:4px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; position:relative; z-index:1; }
    .panel-stat-wrap { margin-top:20px; background:rgba(255,255,255,0.7); border:1px solid rgba(251,191,36,0.4); border-radius:14px; padding:14px 20px; text-align:center; width:100%; position:relative; z-index:1; }
    .ps-num { display:block; font-size:1.6rem; font-weight:900; color:#b45309; }
    .ps-label { font-size:0.65rem; color:#d97706; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
    .panel-divider { width:100%; height:1px; background:rgba(251,191,36,0.35); margin:20px 0; position:relative; z-index:1; }
    .panel-filters { width:100%; position:relative; z-index:1; }
    .pf-label { display:block; font-size:0.65rem; color:#d97706; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px; }
    .pf-date-wrap { position:relative; background:rgba(255,255,255,0.75); border:1.5px solid rgba(251,191,36,0.5); border-radius:12px; display:flex; align-items:center; padding:0 12px; }
    .pf-date-wrap svg { width:14px; height:14px; color:#fbbf24; flex-shrink:0; }
    .pf-date-wrap input { flex:1; border:none; outline:none; background:transparent; padding:10px 8px; font-size:0.78rem; color:#1e1b4b; font-family:'Inter',sans-serif; cursor:pointer; min-width:0; }
    .pf-clear { width:100%; margin-top:8px; padding:8px; border-radius:10px; border:1.5px solid rgba(251,191,36,0.5); background:rgba(255,255,255,0.7); color:#d97706; font-size:0.72rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; }
    .pf-clear:hover { background:#fee2e2; color:#ef4444; border-color:#fca5a5; }
    .panel-close-btn { margin-top:28px; display:flex; align-items:center; justify-content:center; gap:6px; width:100%; padding:11px; border-radius:12px; border:1.5px solid rgba(251,191,36,0.5); background:rgba(255,255,255,0.7); color:#b45309; font-size:0.8rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; position:relative; z-index:1; }
    .panel-close-btn svg { width:16px; height:16px; }
    .panel-close-btn:hover { background:#fee2e2; border-color:#fca5a5; color:#ef4444; }
    .modal-main { flex:1; background:#fff; display:flex; flex-direction:column; overflow:hidden; min-width:0; }
    .modal-main-header { display:flex; align-items:center; justify-content:space-between; padding:20px 26px; border-bottom:1px solid #f1f5f9; background:#fffcf5; flex-shrink:0; gap:14px; }
    .mm-title { font-size:1rem; font-weight:700; color:#1e293b; }
    .mm-search { position:relative; display:flex; align-items:center; background:#f1f5f9; border-radius:12px; padding:0 14px; gap:8px; border:1.5px solid transparent; transition:all 0.2s; }
    .mm-search:focus-within { background:#fff; border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.08); }
    .mm-search svg { width:14px; height:14px; color:#94a3b8; flex-shrink:0; }
    .mm-search:focus-within svg { color:#f59e0b; }
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
    .modal-table { width:100%; border-collapse:collapse; text-align:left; table-layout: fixed; }
    .modal-table thead th { background:#fffcf5; padding:12px 18px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; position:sticky; top:0; z-index:5; border-bottom:2px solid #fef3c7; white-space:normal; vertical-align: middle; }
    .modal-table tbody td { padding:13px 18px; font-size:0.81rem; color:#475569; border-bottom:1px solid #f8fafc; word-break: break-word; vertical-align: top; line-height: 1.4; }

    /* Column widths for Remarks Modal */
    .modal-table th:nth-child(1), .modal-table td:nth-child(1) { width: 11%; } /* Name */
    .modal-table th:nth-child(2), .modal-table td:nth-child(2) { width: 10%; } /* Position */
    .modal-table th:nth-child(3), .modal-table td:nth-child(3) { width: 10%; } /* School */
    .modal-table th:nth-child(4), .modal-table td:nth-child(4) { width: 6%; }  /* Type */
    .modal-table th:nth-child(5), .modal-table td:nth-child(5) { width: 12%; } /* Dates */
    .modal-table th:nth-child(6), .modal-table td:nth-child(6) { width: 10%; } /* Remarks */
    .modal-table th:nth-child(7), .modal-table td:nth-child(7) { width: 10%; } /* Action Date */
    .modal-table th:nth-child(8), .modal-table td:nth-child(8) { width: 16%; } /* Deduction Remarks */
    .modal-table th:nth-child(9), .modal-table td:nth-child(9) { width: 7%; }  /* Incharge - Reduced */
    .modal-table th:nth-child(10), .modal-table td:nth-child(10) { width: 8%; } /* Actions - Increased */

    .modal-table tbody tr:hover td { background:#fffcf5; }
    .modal-table tbody tr:last-child td { border-bottom:none; }
    .badge { font-size:0.7rem; padding:4px 10px; border-radius:20px; font-weight:700; display:inline-block; }
    .badge-green { background:#ecfdf5; color:#059669; } .badge-red { background:#fef2f2; color:#dc2626; }
    .badge-violet { background:#f5f3ff; color:#7c3aed; } .badge-yellow { background:#fffbeb; color:#d97706; }
    .badge-gray { background:#f1f5f9; color:#64748b; } .badge-leave { font-size:0.7rem; font-weight:600; padding:4px 10px; border-radius:8px; background:#fffbeb; color:#d97706; display:inline-block; }
    /* Premium Action Buttons */
    .btn-action-group { display: flex; gap: 8px; justify-content: center; align-items: center; }
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        border: 1.5px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .btn-action svg { width: 16px; height: 16px; position: relative; z-index: 2; transition: transform 0.3s ease; }
    
    .btn-edit { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; box-shadow: 0 2px 4px rgba(22, 163, 74, 0.05); }
    .btn-edit:hover { background: #16a34a; color: #fff; border-color: #16a34a; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(22, 163, 74, 0.2); }
    .btn-edit:hover svg { transform: rotate(15deg) scale(1.1); }
    
    .btn-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.05); }
    .btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(220, 38, 38, 0.2); }
    .btn-delete:hover svg { transform: scale(1.1) rotate(-10deg); }

    .view-only-tag { font-size: 0.65rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; padding: 4px 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; font-style: normal; }

    /* ── Dark Mode ── */
    body.dark-mode { background: #0f172a; color: #cbd5e1; }
    body.dark-mode .hero-banner { background: #1e293b; border-color: #334155; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
    body.dark-mode .hero-dots { opacity: 0.1; }
    body.dark-mode .hero-title { color: #f8fafc; }
    body.dark-mode .hero-desc { color: #94a3b8; }
    body.dark-mode .hero-tag { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    body.dark-mode .hmi-icon { background: rgba(245, 158, 11, 0.15); }
    body.dark-mode .hmi-num { color: #f8fafc; }
    body.dark-mode .hero-right { background: #1a1f35; border-left-color: #334155; }
    body.dark-mode .hero-search { background: #0f172a; border-color: #334155; }
    body.dark-mode .hero-search input { color: #f1f5f9; }
    body.dark-mode .hsc-toggles { background: rgba(0,0,0,0.3); }
    body.dark-mode .view-btn { color: #94a3b8; }
    body.dark-mode .view-btn.active { background: #334155; color: #fbbf24; }
    
    body.dark-mode .remark-card { background: #1e293b; border-color: #334155; }
    body.dark-mode .card-name { color: #f1f5f9; }
    body.dark-mode .detail-row { color: #94a3b8; }
    body.dark-mode .action-icon { background: #0f172a; color: #475569; }
    body.dark-mode .remark-card:hover { border-color: #f59e0b; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.5); }
    body.dark-mode .card-action-bar { border-top-color: #334155; }

    /* Modal Dark Mode */
    body.dark-mode .modal-sheet { background: #0f172a; border: 1px solid #1e293b; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
    body.dark-mode .modal-panel { background: linear-gradient(160deg, #451a03 0%, #111827 100%); border-right-color: #1e293b; }
    body.dark-mode .panel-avatar { border-color: #1e293b; }
    body.dark-mode .panel-name { color: #f1f5f9; }
    body.dark-mode .panel-role { color: #fbbf24; }
    body.dark-mode .panel-stat-wrap { background: rgba(255,255,255,0.05); border-color: rgba(245, 158, 11, 0.2); }
    body.dark-mode .ps-num { color: #f1f5f9; }
    body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(245, 158, 11, 0.3); }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; }
    body.dark-mode .pf-clear, body.dark-mode .panel-close-btn { background: rgba(255,255,255,0.05); border-color: rgba(245, 158, 11, 0.2); color: #f1f5f9; }
    body.dark-mode .panel-divider { background: rgba(245, 158, 11, 0.2); }

    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #111827; border-bottom-color: #1e293b; }
    body.dark-mode .mm-title { color: #f1f5f9; }
    body.dark-mode .mm-search { background: #0a0f1e; }
    body.dark-mode .mm-search input { color: #f1f5f9; }
    body.dark-mode .modal-table thead th { background: #111827; border-bottom-color: #1e293b; color: #94a3b8; }
    body.dark-mode .modal-table tbody td { border-bottom-color: #1e293b; color: #cbd5e1; }
    body.dark-mode .modal-table tbody tr:hover td { background: #1e293b !important; color: #ffffff !important; }
    body.dark-mode .modal-table tbody tr:hover .cell-name { color: #ffffff !important; }
    body.dark-mode .modal-table tbody tr:hover .cell-meta { color: #94a3b8 !important; }
    body.dark-mode .badge-leave { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    body.dark-mode .btn-edit { background: rgba(22, 163, 74, 0.15); color: #4ade80; border-color: rgba(34, 197, 94, 0.3); box-shadow: none; }
    body.dark-mode .btn-edit:hover { background: #16a34a; color: #fff; box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4); }
    body.dark-mode .btn-delete { background: rgba(220, 38, 38, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3); box-shadow: none; }
    body.dark-mode .btn-delete:hover { background: #dc2626; color: #fff; box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4); }
    body.dark-mode .view-only-tag { background: rgba(255,255,255,0.05); border-color: #334155; color: #64748b; }

    /* Loading Skeleton Dark Mode */
    body.dark-mode .skeleton-card { background: #1e293b; border-color: #334155; }
    body.dark-mode .sk-banner { background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%); background-size: 400px 100%; }
    body.dark-mode .sk-avatar { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; border-color: #1e293b; }
    body.dark-mode .sk-line { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; }

    /* Custom classes for JS dynamic rows */
    .cell-name { font-weight: 600; color: #1e293b; }
    .cell-position { color: #475569; }
    .cell-school { color: #475569; }
    .cell-meta { font-family: monospace; font-size: 0.75rem; color: #64748b; }
    .cell-subtext { font-size: 0.8rem; color: #64748b; }
    .cell-incharge { font-size: 0.8rem; color: #64748b; }

    body.dark-mode .cell-name { color: #f1f5f9 !important; }
    body.dark-mode .cell-position { color: #cbd5e1 !important; }
    body.dark-mode .cell-school { color: #cbd5e1 !important; }
    body.dark-mode .cell-meta { color: #94a3b8 !important; }
    body.dark-mode .cell-subtext { color: #94a3b8 !important; }
    body.dark-mode .cell-incharge { color: #cbd5e1 !important; }

    /* ── Remark Card Dark Mode ── */
    body.dark-mode .remark-card { 
        background: transparent; 
        border: 1.5px solid var(--card-color, #334155); 
        box-shadow: none; 
    }
    body.dark-mode .card-name { color: #f1f5f9; }
    body.dark-mode .detail-row { color: #94a3b8; }
    body.dark-mode .detail-row svg { color: var(--card-color, #fbbf24); }
    body.dark-mode .action-label { color: var(--card-color, #fbbf24); }
    body.dark-mode .action-icon { background: rgba(255,255,255,0.05); color: var(--card-color, #fbbf24); }
    body.dark-mode .remark-card:hover { 
        background: rgba(30, 41, 59, 0.3); 
        transform: translateY(-8px); 
        box-shadow: 0 0 24px rgba(var(--card-color-rgb, 245, 158, 11), 0.15); 
    }
    body.dark-mode .remark-card:hover .action-icon { background: var(--card-color, #f59e0b); color: #fff; }
    body.dark-mode .card-action-bar { border-top-color: rgba(255,255,255,0.06); }
    body.dark-mode .card-badge { background: rgba(15, 23, 42, 0.7); color: var(--card-color, #fbbf24) !important; border-color: var(--card-color, #334155); }
    body.dark-mode .card-avatar { border: 4px solid #0f172a !important; }

    /* Modal Dark Mode Fixes */
    body.dark-mode .modal-sheet { background: #0f172a; border: 1px solid #1e293b; }
    body.dark-mode .modal-panel { background: linear-gradient(160deg, #78350f 0%, #111827 100%); }
    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #111827; border-bottom-color: #1e293b; }
    body.dark-mode .mm-title { color: #f1f5f9; }
    body.dark-mode .mm-search { background: #0a0f1e; border-color: #334155; }
    body.dark-mode .mm-search input { color: #f1f5f9; }
    body.dark-mode .modal-table thead th { background: #111827; border-bottom-color: #1e293b; color: #cbd5e1; }
    body.dark-mode .modal-table tbody td { border-bottom-color: #1e293b; color: #cbd5e1; }
    body.dark-mode .badge-leave { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
    body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(245, 158, 11, 0.3); }
    body.dark-mode .pf-date-wrap svg { color: #fff !important; }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; color-scheme: dark; }
    body.dark-mode .pf-date-wrap input::-webkit-calendar-picker-indicator { filter: brightness(0) invert(1) !important; }

    /* Custom classes for JS dynamic rows */
    body.dark-mode .cell-name { color: #f1f5f9 !important; }
    body.dark-mode .cell-meta { color: #cbd5e1 !important; }

    @media (max-width: 768px) {
        .content-body { padding: 12px 14px !important; }
        .hero-banner { flex-direction: column; border-radius: 22px; }
        .hero-left { padding: 24px 20px; }
        .hero-title { font-size: 1.35rem; }
        .hero-right { width: 100%; border-left: none; border-top: 1.5px solid #fde68a; padding: 20px; }
        
        .remarks-grid { 
            grid-template-columns: repeat(2, 1fr) !important; 
            gap: 10px !important; 
        }
        .remark-card { 
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

        .remarks-grid.list-view { grid-template-columns: 1fr !important; }
        .remarks-grid.list-view .remark-card { 
            flex-direction: row !important; 
            align-items: center !important; 
            padding: 10px 16px !important; 
            gap: 12px !important;
            min-height: auto !important;
        }
        .remarks-grid.list-view .card-avatar-container { margin: 0 !important; flex-shrink: 0 !important; }
        .remarks-grid.list-view .card-avatar { width: 44px !important; height: 44px !important; border-radius: 12px !important; }
        .remarks-grid.list-view .card-main { 
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            align-items: center !important;
            width: 100% !important;
            padding: 0 !important;
            flex: 1 !important;
            gap: 2px 12px !important;
        }
        .remarks-grid.list-view .card-name { 
            grid-column: 1 !important;
            width: 100% !important; 
            font-size: 0.82rem !important;
            margin: 0 !important;
        }
        .remarks-grid.list-view .card-details { 
            grid-column: 1 !important;
            flex-direction: column !important; 
            gap: 1px !important; 
            width: 100% !important; 
        }
        .remarks-grid.list-view .detail-row { min-width: 0 !important; font-size: 0.68rem !important; }
        .remarks-grid.list-view .detail-row svg { width: 12px !important; height: 12px !important; }
        .remarks-grid.list-view .card-action-bar {
            grid-column: 2 !important;
            grid-row: 1 / 3 !important;
            display: flex !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            width: auto !important;
        }
        .remarks-grid.list-view .action-label { display: none !important; }
        .remarks-grid.list-view .action-icon { width: 24px !important; height: 24px !important; border-radius: 8px !important; background: #f1f5f9 !important; }

        .modal-sheet {
            width: 95% !important;
            height: 85vh !important;
            border-radius: 24px !important;
            flex-direction: column !important;
            max-height: none !important;
            overflow-y: auto !important;
            background: #fff !important;
        }
        body.dark-mode .modal-sheet {
            background: #0f172a !important;
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
            border-bottom: 1px solid #fde68a;
        }
        .modal-panel::before, .modal-panel::after { display: none !important; }
        .panel-avatar { width: 40px !important; height: 40px !important; font-size: 0.9rem !important; margin-bottom: 0 !important; }
        .panel-name { font-size: 0.85rem !important; margin-top: 0 !important; }
        .panel-role { display: none !important; }
        .panel-divider { display: none !important; }
        .panel-stat-wrap { margin-top: 0 !important; padding: 8px 14px !important; }
        .ps-num { font-size: 1.1rem !important; }
        .panel-filters { display: flex !important; flex-direction: column !important; gap: 4px !important; width: 100% !important; margin-top: 12px; }
        .pf-date-wrap { width: 100% !important; }
        .pf-label { margin-bottom: 2px !important; }
        .panel-close-btn { margin-top: 12px !important; width: 100% !important; padding: 11px !important; flex: none !important; }

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
            z-index: 50 !important;
            background: #fafbff !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }
        body.dark-mode .modal-main-header {
            background: #111827 !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
        }
        .mm-search { width: 100% !important; }
        .mm-search input { width: 100% !important; }

        .modal-table-wrap {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            overflow-y: visible !important;
            flex: none !important;
        }
        .modal-table {
            min-width: 900px !important;
            table-layout: auto !important;
        }
        .modal-table thead th {
            position: relative !important;
            z-index: auto !important;
            padding: 8px 10px !important;
            font-size: 0.65rem !important;
        }
        .modal-table tbody td {
            padding: 10px 8px !important;
            font-size: 0.72rem !important;
            white-space: normal !important;
            word-break: break-word !important;
        }
        body.dark-mode .modal-panel { border-bottom-color: #1e293b !important; }
        body.dark-mode .hero-right { border-top-color: #334155; }
    }
    .badge { font-size: 0.7rem; padding: 4px 10px; border-radius: 20px; font-weight: 700; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .badge-green { background: #ecfdf5; color: #059669; border: 1px solid rgba(5,150,105,0.1); }
    .badge-red { background: #fef2f2; color: #dc2626; border: 1px solid rgba(220,38,38,0.1); }
    .badge-violet { background: #f5f3ff; color: #7c3aed; border: 1px solid rgba(124,58,237,0.1); }
    .badge-yellow { background: #fffbeb; color: #d97706; border: 1px solid rgba(217,119,6,0.1); }
    .badge-gray { background: #f1f5f9; color: #64748b; border: 1px solid rgba(100,116,139,0.1); }
    .badge-leave { font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:8px; background:#eef2ff; color:#6366f1; display:inline-block; }
</style>

<script>
const AUTH_USER_ID = "{{ auth()->id() }}";
const AUTH_USERNAME = "{{ auth()->user()->username ?? '' }}";
const AUTH_NAME = "{{ auth()->user()->name ?? '' }}";
const AUTH_ROLE = "{{ auth()->user()->role ?? 'user' }}";

document.addEventListener('DOMContentLoaded', function() {
    let allRemarks = [];
    let currentRemarkForModal = '';

    const remarksGrid = document.getElementById('remarksGrid');
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('remarkCount');
    const modal = document.getElementById('remarkModal');
    const loadingSkeleton = document.getElementById('loadingSkeleton');

    fetch('{{ url("/leave-records/remarks-list") }}').then(res => res.json()).then(data => {
        allRemarks = data;
        loadingSkeleton.style.display = 'none';
        renderRemarks();
    }).catch(err => {
        console.error('Error fetching remarks:', err);
        loadingSkeleton.style.display = 'none';
        remarksGrid.innerHTML = '<p style="text-align:center; color:#ef4444; padding: 40px;">Error loading remarks</p>';
    });

    const getInitials = (name) => {
        if (!name) return '??';
        return name.split(' ').filter(n => n.length > 0).map(n => n[0]).slice(0, 2).join('').toUpperCase();
    };

    const PALETTE = [
        { strip: 'linear-gradient(135deg, #f59e0b, #d97706)', avatar: 'linear-gradient(135deg, #f59e0b, #fbbf24)' },
        { strip: 'linear-gradient(135deg, #fbbf24, #f59e0b)', avatar: 'linear-gradient(135deg, #fbbf24, #fcd34d)' },
        { strip: 'linear-gradient(135deg, #d97706, #b45309)', avatar: 'linear-gradient(135deg, #d97706, #f59e0b)' },
        { strip: 'linear-gradient(135deg, #fcd34d, #fbbf24)', avatar: 'linear-gradient(135deg, #fcd34d, #fef3c7)' },
        { strip: 'linear-gradient(135deg, #b45309, #92400e)', avatar: 'linear-gradient(135deg, #b45309, #d97706)' }
    ];

    function getColours(name) {
        if (!name) return PALETTE[0];
        const rem = name.toLowerCase();
        if (rem.includes('with pay') && rem.includes('without pay')) return { strip: 'linear-gradient(135deg, #8b5cf6, #7c3aed)', avatar: 'linear-gradient(135deg, #8b5cf6, #a78bfa)', theme: '#6366f1' };
        if (rem.includes('without pay') || rem === 'disapproved') return { strip: 'linear-gradient(135deg, #ef4444, #dc2626)', avatar: 'linear-gradient(135deg, #ef4444, #f87171)', theme: '#ef4444' };
        if (rem.includes('with pay') || rem === 'approved') return { strip: 'linear-gradient(135deg, #10b981, #059669)', avatar: 'linear-gradient(135deg, #10b981, #34d399)', theme: '#10b981' };
        
        const i = name.charCodeAt(0) % PALETTE.length; 
        const p = PALETTE[isNaN(i) ? 0 : i]; 
        return { ...p, theme: '#f59e0b' };
    }

    function getCategoryLabel(remarks) {
        const r = remarks.toLowerCase();
        if (r.includes('with pay') && r.includes('without pay')) return 'Status: Hybrid';
        if (r.includes('without pay')) return 'Status: Without Pay';
        if (r.includes('with pay')) return 'Status: With Pay';
        if (r === 'approved') return 'Status: Approved';
        if (r === 'disapproved') return 'Status: Disapproved';
        return 'Category: General';
    }

    function formatDate(dateStr) {
        if (!dateStr || dateStr === '-') return '-';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return dateStr;
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        const y = date.getFullYear();
        return `${m}-${d}-${y}`;
    }

    function renderRemarks(filter = '') {
        const filtered = allRemarks.filter(r => r.remarks.toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;
        searchClear.style.display = filter ? 'flex' : 'none';

        if (filtered.length === 0) {
            remarksGrid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        remarksGrid.innerHTML = filtered.map((item, i) => {
            const initials = getInitials(item.remarks);
            const colours = getColours(item.remarks);
            return `
                <div class="remark-card" onclick="openRemarkModal('${item.remarks.replace(/'/g, "\\'")}')" style="animation-delay:${Math.min(i*0.03,0.6)}s; --theme-color: ${colours.theme}; --card-color: ${colours.theme}">
                    <div class="card-banner" style="background:${colours.strip}"></div>
                    <div class="card-avatar-container">
                        <div class="card-avatar" style="background:${colours.avatar}">${initials}</div>
                        <div class="card-badge" style="color: ${colours.theme}">${item.leave_count} Record${item.leave_count !== 1 ? 's' : ''}</div>
                    </div>
                    <div class="card-main">
                        <h3 class="card-name" title="${item.remarks}">${item.remarks}</h3>
                        <div class="card-details">
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <span class="detail-text">${getCategoryLabel(item.remarks)}</span>
                            </div>
                            <div class="detail-row">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <span class="detail-text">Recorded Action Entry</span>
                            </div>
                        </div>
                        <div class="card-action-bar">
                            <span class="action-label" style="color: ${colours.theme}">
                                VIEW RECORDS
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" style="width:10px; height:10px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
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

    searchInput.addEventListener('input', function() { renderRemarks(this.value); });
    window.clearSearch = function() { searchInput.value = ''; renderRemarks(); searchInput.focus(); };
    window.setView = function(view) {
        document.getElementById('viewGrid').classList.toggle('active', view === 'grid');
        document.getElementById('viewList').classList.toggle('active', view === 'list');
        remarksGrid.classList.toggle('list-view', view === 'list');
    };

    window.openRemarkModal = function(remarkText) {
        modal.classList.add('open');
        currentRemarkForModal = remarkText;
        document.getElementById('modalRemarkText').textContent = remarkText;
        const colours = getColours(remarkText);
        const avatarEl = document.getElementById('modalRemarkAvatar');
        avatarEl.textContent = getInitials(remarkText);
        avatarEl.style.background = colours.avatar;
        document.getElementById('modalSearch').value = '';
        
        // Clear the date filter to show all records by default
        // Set the date filter to today's date by default
        document.getElementById('modalFilterDate').value = "{{ date('Y-m-d') }}";
        
        fetchRemarkRecords();
    };

    window.fetchRemarkRecords = function() {
        const remark = currentRemarkForModal;
        const date = document.getElementById('modalFilterDate').value;
        
        const url = `{{ url("/leave-records/by-remark") }}?remark=${encodeURIComponent(remark)}&date=${encodeURIComponent(date)}`;
        const tbody = document.getElementById('remarkTableBody');
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:40px;color:#94a3b8;">Loading...</td></tr>';
        document.getElementById('modalRemarkRecordCount').textContent = '...';

        fetch(url).then(res => res.json()).then(data => {
            document.getElementById('modalRemarkRecordCount').textContent = data.length;
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:40px;color:#94a3b8;">No records found.</td></tr>';
                return;
            }
            tbody.innerHTML = data.map(r => {
                let remarkClass = 'badge-gray';
                const rem = (r.remarks || '').toLowerCase();
                if (rem.includes('with pay') && rem.includes('without pay')) remarkClass = 'badge-violet';
                else if (rem.includes('without pay') || rem === 'disapproved' || rem === 'cancelled') remarkClass = 'badge-red';
                else if (rem.includes('with pay') || rem === 'approved') remarkClass = 'badge-green';
                else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'badge-yellow';
                
                const remarkBadge = r.remarks ? `<span class="badge ${remarkClass}">${r.remarks}</span>` : '-';
                const inc = (r.incharge || '').toLowerCase();
                const isMyRecord = (r.user_id == AUTH_USER_ID) || (inc === AUTH_USERNAME.toLowerCase() || inc === AUTH_NAME.toLowerCase());
                const canEdit = isMyRecord || AUTH_ROLE === 'admin';

                return `
                <tr>
                    <td class="cell-name">${r.name}</td>
                    <td class="cell-position">${r.position || '-'}</td>
                    <td class="cell-school">${r.school || '-'}</td>
                    <td><span class="badge-leave">${r.type_of_leave}</span></td>
                    <td class="cell-meta cell-dates" style="font-family:monospace; font-size:0.75rem;">${r.inclusive_dates || '-'}</td>
                    <td>${remarkBadge}</td>
                    <td class="cell-meta" style="font-family:monospace; font-size:0.75rem;">${formatDate(r.date_of_action)}</td>
                    <td class="cell-subtext" style="font-size:0.8rem;">${r.deduction_remarks || '-'}</td>
                    <td class="cell-incharge" style="font-weight:500;">${r.incharge || '-'}</td>
                    <td>
                        <div class="btn-action-group">
                            ${canEdit ? `
                            <button onclick="editRecord(${r.id})" class="btn-action btn-edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg></button>
                            <button onclick="deleteRecord(${r.id})" class="btn-action btn-delete" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></button>
                            ` : ``}
                        </div>
                    </td>
                </tr>
            `;
            }).join('');
            if (document.getElementById('modalSearch').value) filterModalRecords();
        });
    };


    window.handleBackdropClick = function(e) {
        if (e.target.id === 'remarkModal') closeRemarkModal();
    };

    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#remarkTableBody tr');
        let visibleCount = 0;
        rows.forEach(row => { 
            if (row.cells.length < 2) return; 
            const text = row.textContent.toLowerCase(); 
            const isMatch = text.includes(q); 
            row.style.display = isMatch ? '' : 'none'; 
            if (isMatch) visibleCount++; 
        });
        const tbody = document.getElementById('remarkTableBody');
        const existingNoResults = document.getElementById('noResultsRow');
        if (visibleCount === 0 && rows.length > 0) { 
            if (!existingNoResults) { 
                const noResultsRow = document.createElement('tr'); 
                noResultsRow.id = 'noResultsRow'; 
                noResultsRow.innerHTML = `<td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">No records matching "${q}"</td>`; 
                tbody.appendChild(noResultsRow); 
            } else {
                existingNoResults.style.display = '';
                existingNoResults.innerHTML = `<td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">No records matching "${q}"</td>`;
            }
        } else if (existingNoResults) { 
            existingNoResults.style.display = 'none'; 
        }
    }

    document.getElementById('modalSearch').addEventListener('input', filterModalRecords);

    window.editRecord = function(id) {
        window.location.href = "{{ url('/user/form') }}?edit=" + id + "&source=remarks&remarkName=" + encodeURIComponent(currentRemarkForModal);
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
                fetchRemarkRecords();
                // Refresh main list
                fetch('{{ url("/leave-records/remarks-list") }}')
                    .then(res => res.json())
                    .then(data => {
                        allRemarks = data;
                        renderRemarks();
                    });
            } else {
                alert('Error deleting record.');
            }
        })
        .catch(() => alert('Error deleting record.'));
    };

    window.closeRemarkModal = function() { modal.classList.remove('open'); };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) {
            closeRemarkModal();
        }
    });

    // Check for openModal URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const openModal = urlParams.get('openModal');
    if (openModal) {
        const checkInterval = setInterval(() => {
            if (allRemarks.length > 0) {
                clearInterval(checkInterval);
                openRemarkModal(openModal);
            }
        }, 100);
    }
});
</script>

</body>
</html>
