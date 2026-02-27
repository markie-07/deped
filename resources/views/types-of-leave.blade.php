<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Types of Leave - DepEd Manager</title>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="page-title">Leave Types</h1>
                        <p class="page-subtitle">Classification and statistics for all leave categories</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="count-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
                        </svg>
                        <span id="typeCount">0</span> Items
                    </div>
                </div>
            </div>

            <!-- Search & View Toggle Bar -->
            <div class="search-filter-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search leave types...">
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
            <div id="loadingSkeleton">
                <div class="types-grid">
                    <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                    <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                    <div class="skeleton-card"><div class="skeleton-circle"></div><div class="skeleton-lines"><div class="skeleton-line w80"></div><div class="skeleton-line w50"></div></div></div>
                </div>
            </div>

            <!-- Leave Types Grid -->
            <div class="types-grid" id="typesGrid"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon-wrap">
                    <div class="empty-icon-ring"></div>
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                        </svg>
                    </div>
                </div>
                <h3 class="empty-title">No Leave Types Found</h3>
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

    <!-- Modal for Leave Type Records -->
    <div class="modal-overlay" id="typeModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="type-avatar-modal" id="modalTypeAvatar"></div>
                    <div class="modal-header-info">
                        <h2 class="modal-title" id="modalTypeName">Leave Type</h2>
                        <span class="modal-subtitle" id="modalTypeSubtitle">Leave Records</span>
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
                        <input type="date" id="modalFilterDate" onchange="fetchTypeRecords()" title="Filter by date">
                    </div>
                    <button class="modal-close" onclick="closeTypeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <table class="record-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>School</th>
                            <th>Inclusive Dates</th>
                            <th>Remarks</th>
                            <th>Date of Action</th>
                            <th>Deduction Remarks</th>
                            <th>Incharge</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="typeTableBody">
                        <tr><td colspan="7" style="text-align:center; padding: 40px; color: #94a3b8;">Loading records...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<style>
    /* ═══════════════════════════════════════
       LEAVE TYPES PAGE — PROFESSIONAL REDESIGN
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
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        transition: transform 0.3s ease;
    }

    .page-header-icon:hover {
        transform: scale(1.05) rotate(-3deg);
    }

    .page-header-icon svg { width: 24px; height: 24px; color: #fff; }

    .page-title { font-size: 1.35rem; font-weight: 800; color: #1e293b; letter-spacing: -0.03em; }
    .page-subtitle { font-size: 0.8rem; color: #94a3b8; margin-top: 2px; }

    .count-badge {
        display: flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 24px;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669;
        font-size: 0.78rem; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.08);
    }

    .count-badge svg { width: 16px; height: 16px; }
    .count-badge span { font-weight: 800; font-size: 0.92rem; }

    /* ── Search Bar & Toggles ── */
    .search-filter-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
    .search-input-wrapper { position: relative; max-width: 450px; flex: 1; }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #94a3b8; pointer-events: none; transition: color 0.25s; }
    .search-input { width: 100%; padding: 13px 42px 13px 46px; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.84rem; font-family: 'Inter', sans-serif; color: #1e293b; background: #fff; outline: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .search-input:focus { border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.08), 0 4px 16px rgba(16, 185, 129, 0.06); }
    .search-clear { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: #f1f5f9; border: none; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .search-clear svg { width: 12px; height: 12px; color: #64748b; }
    .search-clear:hover { background: #fee2e2; color: #ef4444; }

    .view-toggles { display: flex; gap: 4px; background: #f1f5f9; border-radius: 12px; padding: 4px; }
    .view-btn { background: transparent; border: none; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #94a3b8; transition: all 0.25s ease; }
    .view-btn svg { width: 18px; height: 18px; }
    .view-btn.active { background: #fff; color: #10b981; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

    /* ── Grid ── */
    .types-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 18px; }
    .types-grid.list-view { grid-template-columns: 1fr; gap: 8px; }

    /* ── Skeleton Loading ── */
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    .skeleton-card { background: #fff; border-radius: 18px; padding: 24px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .skeleton-circle { width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(90deg, #f1f5f9 25%, #e8ecf3 37%, #f1f5f9 63%); background-size: 200% 100%; animation: shimmer 1.5s ease-in-out infinite; flex-shrink: 0; }
    .skeleton-lines { flex: 1; }
    .skeleton-line { height: 12px; border-radius: 6px; background: linear-gradient(90deg, #f1f5f9 25%, #e8ecf3 37%, #f1f5f9 63%); background-size: 200% 100%; animation: shimmer 1.5s ease-in-out infinite; margin-bottom: 8px; }
    .skeleton-line.w80 { width: 80%; }
    .skeleton-line.w50 { width: 50%; }

    /* ── Type Card ── */
    @keyframes cardFadeIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    .type-card { background: #fff; border-radius: 18px; padding: 22px 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; cursor: pointer; animation: cardFadeIn 0.4s ease both; min-height: 145px; display: flex; flex-direction: column; }
    .type-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 18px 18px 0 0; background: linear-gradient(90deg, #10b981, #34d399); opacity: 0; transition: opacity 0.3s ease; }
    .type-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,0.08); }
    .type-card:hover::before { opacity: 1; }
    
    /* Decorative Accent Icon */
    .card-accent-icon {
        position: absolute;
        bottom: -20px;
        right: -10px;
        width: 100px;
        height: 100px;
        opacity: 0.03;
        color: #10b981;
        transform: rotate(-15deg);
        pointer-events: none;
        transition: all 0.5s ease;
    }
    .type-card:hover .card-accent-icon {
        opacity: 0.08;
        transform: rotate(0deg) scale(1.1);
    }

    /* Hover Arrow Indicator */
    .card-hover-arrow {
        position: absolute;
        top: 22px;
        right: 20px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.1);
    }
    .type-card:hover .card-hover-arrow {
        opacity: 1;
        transform: translateX(0);
    }
    .card-hover-arrow svg { width: 14px; height: 14px; }

    .type-avatar { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: 800; flex-shrink: 0; background: #f0fdf4; color: #10b981; transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
    .type-card:hover .type-avatar { transform: scale(1.08); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15); }

    .type-name { font-size: 0.94rem; font-weight: 700; color: #1e293b; letter-spacing: -0.01em; line-height: 1.3; margin-bottom: 5px; }

    .type-stats { display: flex; align-items: center; gap: 6px; padding-top: 14px; margin-top: auto; border-top: 1px solid #f8fafc; justify-content: flex-end; }
    .stat-value { font-size: 0.82rem; font-weight: 800; color: #10b981; }
    .stat-label { font-size: 0.7rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.02em; }
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* ── List View Styles ── */
    .types-grid.list-view .type-card { border-radius: 14px; padding: 16px 24px; display: flex; align-items: center; gap: 20px; }
    .types-grid.list-view .type-card .type-info { display: flex; align-items: center; gap: 16px; flex: 1; }
    .types-grid.list-view .type-card .type-stats { margin-top: 0; padding-top: 0; border-top: none; flex-shrink: 0; }

    /* ── Empty State ── */
    .empty-state { text-align: center; padding: 80px 20px; }
    .empty-icon-wrap { position: relative; width: 100px; height: 100px; margin: 0 auto 24px; }
    .empty-icon-ring { position: absolute; inset: -6px; border-radius: 30px; border: 2px dashed #e2e8f0; animation: spin 20s linear infinite; }
    .empty-icon { width: 100px; height: 100px; background: linear-gradient(135deg, #f1f5f9, #e8ecf3); border-radius: 26px; display: flex; align-items: center; justify-content: center; }
    .empty-icon svg { width: 40px; height: 40px; color: #94a3b8; }
    .empty-title { font-size: 1.1rem; color: #334155; font-weight: 700; margin-bottom: 6px; }
    .empty-text { color: #94a3b8; font-size: 0.84rem; margin-bottom: 20px; }
    .empty-reset-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border: 1.5px solid #e2e8f0; border-radius: 12px; background: #fff; color: #10b981; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.25s; }
    .empty-reset-btn:hover { background: #10b981; color: #fff; border-color: #10b981; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3); }

    /* ── Modal Design ── */
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; pointer-events: none; transition: all 0.35s ease; }
    .modal-overlay.open { opacity: 1; pointer-events: auto; }
    .modal-container { background: #fff; width: 92%; max-width: 1300px; border-radius: 20px; box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0,0,0,0.03); transform: scale(0.96) translateY(20px); transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); max-height: 88vh; display: flex; flex-direction: column; overflow: hidden; }
    .modal-overlay.open .modal-container { transform: scale(1) translateY(0); }
    .modal-header { padding: 20px 28px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 16px; background: linear-gradient(180deg, #fafbff 0%, #fff 100%); }
    .modal-header-left { display: flex; align-items: center; gap: 14px; min-width: 0; }
    .type-avatar-modal { width: 46px; height: 46px; border-radius: 14px; background: linear-gradient(135deg, #10b981, #34d399); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; flex-shrink: 0; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .modal-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .modal-subtitle { font-size: 0.72rem; color: #94a3b8; font-weight: 500; }
    .modal-actions { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .modal-search-wrapper { position: relative; }
    .modal-search-wrapper svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #94a3b8; }
    .modal-search-wrapper input { padding: 9px 14px 9px 34px; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.8rem; width: 220px; outline: none; transition: all 0.25s; }
    .modal-search-wrapper input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08); }
    .modal-date-wrapper { position: relative; }
    .modal-date-wrapper svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #94a3b8; pointer-events: none; }
    .modal-date-wrapper input { padding: 9px 14px 9px 34px; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.8rem; width: 150px; outline: none; transition: all 0.25s; color: #475569; background: #fff; cursor: pointer; }
    .modal-date-wrapper input::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; transition: 0.2s; }
    .modal-date-wrapper input::-webkit-calendar-picker-indicator:hover { opacity: 1; }
    .modal-date-wrapper input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08); }

    .modal-close { background: #f8fafc; border: none; width: 38px; height: 38px; border-radius: 12px; color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .modal-close:hover { background: #fee2e2; color: #ef4444; }
    .modal-body { padding: 0; overflow-y: auto; flex: 1; }
    .record-table { width: 100%; border-collapse: collapse; }
    .record-table th { background: #f8fafc; padding: 14px 20px; text-align: left; font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.06em; position: sticky; top: 0; z-index: 10; border-bottom: 2px solid #eef2ff; }
    .record-table td { padding: 14px 20px; font-size: 0.82rem; color: #475569; border-bottom: 1px solid #f1f5f9; }
    .record-table tr:hover td { background: #fafaff; }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-edit { background: #f0fdf4; color: #16a34a; }
    .btn-edit:hover { background: #16a34a; color: #fff; transform: scale(1.1); }

    .btn-delete { background: #fef2f2; color: #dc2626; }
    .btn-delete:hover { background: #dc2626; color: #fff; transform: scale(1.1); }
    .badge { font-size: 0.7rem; padding: 4px 10px; border-radius: 20px; font-weight: 700; display: inline-block; }
    .badge-green { background: #ecfdf5; color: #059669; }
    .badge-red { background: #fef2f2; color: #dc2626; }
    .badge-violet { background: #f5f3ff; color: #7c3aed; }
    .badge-yellow { background: #fffbeb; color: #d97706; }
    .badge-gray { background: #f1f5f9; color: #64748b; }
    @media (max-width: 768px) { .page-header { flex-direction: column; align-items: flex-start; gap: 14px; } .search-filter-bar { flex-direction: column; align-items: stretch; } .view-toggles { display: none; } .modal-actions { flex-wrap: wrap; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allTypes = [];
    let currentTypeForModal = '';

    const typesGrid = document.getElementById('typesGrid');
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('typeCount');
    const modal = document.getElementById('typeModal');
    const loadingSkeleton = document.getElementById('loadingSkeleton');

    fetch('/leave-records/types')
        .then(res => res.json())
        .then(data => {
            allTypes = data;
            loadingSkeleton.style.display = 'none';
            renderTypes();
        })
        .catch(err => {
            console.error('Error fetching types:', err);
            loadingSkeleton.style.display = 'none';
            typesGrid.innerHTML = '<p style="text-align:center; color:#ef4444; padding: 40px;">Error loading leave types</p>';
        });

    function getInitials(name) {
        return name.split(' ').filter(w => w.length > 2).slice(0, 2).map(w => w[0]).join('');
    }

    function renderTypes(filter = '') {
        const filtered = allTypes.filter(p => p.type_of_leave.toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;
        searchClear.style.display = filter ? 'flex' : 'none';

        if (filtered.length === 0) {
            typesGrid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        typesGrid.innerHTML = filtered.map((item, i) => `
            <div class="type-card" onclick="openTypeModal('${item.type_of_leave.replace(/'/g, "\\'")}')" style="animation-delay: ${Math.min(i * 0.03, 0.6)}s">
                <div class="card-accent-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                    </svg>
                </div>
                <div class="type-info">
                    <div class="type-avatar">${getInitials(item.type_of_leave) || item.type_of_leave[0]}</div>
                    <div class="type-name text-truncate" title="${item.type_of_leave}">${item.type_of_leave}</div>
                </div>
                <div class="type-stats">
                    <span class="stat-label">Record${item.leave_count !== 1 ? 's' : ''}</span>
                    <span class="stat-value">${item.leave_count}</span>
                </div>
                <div class="card-hover-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
        `).join('');
    }

    searchInput.addEventListener('input', function() { renderTypes(this.value); });
    window.clearSearch = function() { searchInput.value = ''; renderTypes(); searchInput.focus(); };
    window.setView = function(view) {
        document.getElementById('viewGrid').classList.toggle('active', view === 'grid');
        document.getElementById('viewList').classList.toggle('active', view === 'list');
        typesGrid.classList.toggle('list-view', view === 'list');
    };

    window.openTypeModal = function(typeName) {
        modal.classList.add('open');
        currentTypeForModal = typeName;
        document.getElementById('modalTypeName').textContent = typeName;
        document.getElementById('modalTypeAvatar').textContent = getInitials(typeName) || typeName[0];
        document.getElementById('modalSearch').value = '';
        document.getElementById('modalFilterDate').value = '';
        fetchTypeRecords();
    };

    window.fetchTypeRecords = function() {
        const typeName = currentTypeForModal;
        const date = document.getElementById('modalFilterDate').value;
        const url = `/leave-records/by-type?type=${encodeURIComponent(typeName)}&date=${encodeURIComponent(date)}`;
        
        const tbody = document.getElementById('typeTableBody');
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 40px; color: #94a3b8;"><div style="display:inline-flex; align-items:center; gap:10px;"><svg style="width:18px;height:18px;animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" /></svg> Loading records...</div></td></tr>';

        fetch(url).then(res => res.json()).then(data => {
            document.getElementById('modalTypeSubtitle').textContent = `${data.length} Leave Record${data.length !== 1 ? 's' : ''}`;
            if (data.length === 0) { tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 40px; color: #94a3b8;">No records found.</td></tr>'; return; }
            tbody.innerHTML = data.map(r => {
                let remarkClass = 'badge-gray';
                const rem = (r.remarks || '').toLowerCase();
                if (rem.includes('with pay') && rem.includes('without pay')) remarkClass = 'badge-violet';
                else if (rem.includes('without pay') || rem === 'disapproved' || rem === 'cancelled') remarkClass = 'badge-red';
                else if (rem.includes('with pay') || rem === 'approved') remarkClass = 'badge-green';
                else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'badge-yellow';
                const remarkBadge = r.remarks ? `<span class="badge ${remarkClass}">${r.remarks}</span>` : '-';
                return `<tr><td style="font-weight: 600; color:#1e293b;">${r.name}</td><td style="color:#475569;">${r.position || '-'}</td><td style="color:#475569;">${r.school || '-'}</td><td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.inclusive_dates || '-'}</td><td>${remarkBadge}</td><td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.date_of_action || '-'}</td><td style="color:#64748b; font-size: 0.8rem;">${r.deduction_remarks || '-'}</td><td style="color:#475569; font-weight: 500;">${r.incharge || '-'}</td><td><div style="display: flex; gap: 8px; justify-content: center;"><button onclick="editRecord(${r.id})" class="btn-action btn-edit" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg></button><button onclick="deleteRecord(${r.id})" class="btn-action btn-delete" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></button></div></td></tr>`;
            }).join('');
            if (document.getElementById('modalSearch').value) filterModalRecords();
        });
    };

    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#typeTableBody tr');
        let visibleCount = 0;
        rows.forEach(row => { if (row.cells.length < 2) return; const text = row.textContent.toLowerCase(); const isMatch = text.includes(q); row.style.display = isMatch ? '' : 'none'; if (isMatch) visibleCount++; });
        const tbody = document.getElementById('typeTableBody');
        const existingNoResults = document.getElementById('noResultsRow');
        if (visibleCount === 0 && rows.length > 0) { if (!existingNoResults) { const noResultsRow = document.createElement('tr'); noResultsRow.id = 'noResultsRow'; noResultsRow.innerHTML = `<td colspan="7" style="text-align:center; padding: 40px; color: #94a3b8;">No records matching "${q}"</td>`; tbody.appendChild(noResultsRow); } } else if (existingNoResults) { existingNoResults.style.display = 'none'; }
    }
    document.getElementById('modalSearch').addEventListener('input', filterModalRecords);
    window.editRecord = function(id) {
        window.location.href = `/form?edit=${id}`;
    };

    window.deleteRecord = function(id) {
        if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) return;

        fetch(`/leave-records/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchTypeRecords();
            } else {
                alert('Error deleting record.');
            }
        })
        .catch(() => alert('Error deleting record.'));
    };

    window.closeTypeModal = function() { modal.classList.remove('open'); };
    modal.addEventListener('click', function(e) { if (e.target === modal) closeTypeModal(); });
});
</script>

</body>
</html>
