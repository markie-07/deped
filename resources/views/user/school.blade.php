
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Schools - DepEd Manager</title>
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
                    <h1 class="hero-title">School Directory</h1>
                    <p class="hero-desc">All registered schools, sections, and units under the DepEd Division — organized by type.</p>
                    <div class="hero-meta">
                        <div class="hero-meta-item">
                            <div class="hmi-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num" id="schoolCount">—</span>
                                <span class="hmi-label">Schools</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-search-card">
                        <p class="hsc-label">Find School</p>
                        <div class="hero-search">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input type="text" id="searchInput" placeholder="Search schools, sections, or units...">
                            <button id="searchClear" onclick="clearSearch()" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="hero-filter">
                            <div class="filter-select-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                                </svg>
                                <select id="typeFilter" onchange="renderSchools(document.getElementById('searchInput').value)">
                                    <option value="all">All School Types</option>
                                    <option value="section/unit">Sections & Units</option>
                                    <option value="elementary">Elementary Schools</option>
                                    <option value="high school">High Schools</option>
                                </select>
                            </div>
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
                <div class="skeleton-section-bar" style="margin-top: 36px;"></div>
                <div class="schools-grid">
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                    <div class="skeleton-card"><div class="sk-banner"></div><div class="sk-content"><div class="sk-avatar"></div><div class="sk-line sk-l1"></div><div class="sk-line sk-l2"></div></div></div>
                </div>
            </div>

            <!-- Sections/Units Section -->
            <div id="sectionUnitSection" style="display: none;">
                <div class="section-header">
                    <div class="section-header-line"></div>
                    <h3 class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                        Sections & Units
                    </h3>
                    <span class="section-count" id="sectionUnitCount">0</span>
                </div>
                <div class="schools-grid" id="sectionUnitGrid"></div>
            </div>

            <!-- High Schools Section -->
            <div id="highSchoolSection" style="display: none;">
                <div class="section-header">
                    <div class="section-header-line"></div>
                    <h3 class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        High Schools & Integrated
                    </h3>
                    <span class="section-count" id="highSchoolCount">0</span>
                </div>
                <div class="schools-grid" id="highSchoolGrid"></div>
            </div>

            <!-- Elementary Schools Section -->
            <div id="elementarySection" style="display: none;">
                <div class="section-header">
                    <div class="section-header-line"></div>
                    <h3 class="section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        Elementary Schools
                    </h3>
                    <span class="section-count" id="elementaryCount">0</span>
                </div>
                <div class="schools-grid" id="elementarySchoolGrid"></div>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon-wrap">
                    <div class="empty-icon-ring"></div>
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                    </div>
                </div>
                <h3 class="empty-title">No Results Found</h3>
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

    <!-- Modal for School Records -->
    <div class="modal-backdrop" id="schoolModal" onclick="handleBackdropClick(event)">
        <div class="modal-sheet">
            <!-- Left Panel -->
            <div class="modal-panel">
                <div class="panel-avatar" id="modalSchoolAvatar"></div>
                <h2 class="panel-name" id="modalSchoolName">—</h2>
                <p class="panel-role">School / Section</p>
                <div class="panel-stat-wrap">
                    <div class="panel-stat">
                        <span class="ps-num" id="modalSchoolRecordCount">0</span>
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
                        <input type="date" id="modalFilterDate" value="{{ date('Y-m-d') }}" onchange="fetchSchoolRecords()">
                    </div>
                </div>
                <button class="panel-close-btn" onclick="closeSchoolModal()">
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
                                <th>Type of Leave</th>
                                <th>Inclusive Dates</th>
                                <th>Remarks</th>
                                <th>Date of Action</th>
                                <th>Deduction Remarks</th>
                                <th>Incharge</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="schoolTableBody">
                            <tr><td colspan="9" style="text-align:center;padding:40px;color:#94a3b8;">Loading records...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    /* SCHOOLS PAGE — BANNER REDESIGN */
    .hero-banner { position: relative; background: #fff; border-radius: 22px; border: 1.5px solid #e8edf5; display: flex; align-items: stretch; overflow: hidden; margin-bottom: 28px; box-shadow: 0 4px 24px rgba(16,185,129,0.07); }
    .hero-dots { position: absolute; inset: 0; background-image: radial-gradient(circle, #a7f3d0 1px, transparent 1px); background-size: 22px 22px; opacity: 0.45; pointer-events: none; border-radius: 22px; }
    .hero-left { flex: 1; padding: 32px 36px; position: relative; z-index: 1; }
    .hero-tag { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; background: #ecfdf5; color: #059669; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px; }
    .hero-tag svg { width: 13px; height: 13px; }
    .hero-title { font-size: 1.65rem; font-weight: 900; color: #1e1b4b; letter-spacing: -0.035em; line-height: 1.1; margin-bottom: 10px; }
    .hero-desc { font-size: 0.82rem; color: #64748b; line-height: 1.6; max-width: 420px; margin-bottom: 24px; }
    .hero-meta { display: flex; align-items: center; gap: 20px; }
    .hero-meta-item { display: flex; align-items: center; gap: 10px; }
    .hmi-icon { width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .hmi-icon svg { width: 16px; height: 16px; color: #10b981; }
    .hmi-num { display: block; font-size: 1.2rem; font-weight: 900; color: #1e1b4b; line-height: 1; }
    .hmi-label { display: block; font-size: 0.63rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }
    .hero-right { width: 300px; flex-shrink: 0; background: linear-gradient(145deg, #ecfdf5 0%, #d1fae5 100%); border-left: 1.5px solid #a7f3d0; display: flex; align-items: center; justify-content: center; padding: 24px; position: relative; z-index: 1; }
    .hero-search-card { width: 100%; }
    .hsc-label { font-size: 0.72rem; font-weight: 700; color: #059669; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; }
    .hero-search { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(16,185,129,0.12); display: flex; align-items: center; padding: 0 14px; gap: 8px; border: 1.5px solid #a7f3d0; transition: border-color 0.2s, box-shadow 0.2s; }
    .hero-search:focus-within { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
    .hero-search svg { width: 16px; height: 16px; color: #6ee7b7; flex-shrink: 0; }
    .hero-search:focus-within svg:first-child { color: #10b981; }
    .hero-search input { flex: 1; border: none; outline: none; padding: 13px 0; font-size: 0.84rem; font-family: 'Inter', sans-serif; color: #1e293b; background: transparent; }
    .hero-search input::placeholder { color: #6ee7b7; }
    .hero-search button { background: #f1f5f9; border: none; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; }
    .hero-search button svg { width: 10px; height: 10px; color: #64748b; }
    .hero-search button:hover { background: #fee2e2; }
    .hero-search button:hover svg { color: #ef4444; }

    .hero-filter { margin-top: 10px; }
    .filter-select-wrap { position: relative; display: flex; align-items: center; background: #fff; border-radius: 14px; border: 1.5px solid #a7f3d0; padding: 0 14px; box-shadow: 0 4px 16px rgba(16,185,129,0.08); transition: all 0.2s; }
    .filter-select-wrap:focus-within { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
    .filter-select-wrap svg { position: absolute; left: 14px; width: 14px; height: 14px; color: #6ee7b7; pointer-events: none; }
    .filter-select-wrap:focus-within svg { color: #10b981; }
    .filter-select-wrap select { flex: 1; border: none; outline: none; padding: 11px 0 11px 26px; font-size: 0.78rem; font-weight: 700; font-family: inherit; color: #1e293b; background: transparent; cursor: pointer; }

    .hsc-toggles { display: flex; gap: 4px; margin-top: 10px; background: #d1fae5; border-radius: 10px; padding: 3px; }
    .view-btn { background: transparent; border: none; flex: 1; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #065f46; transition: all 0.2s; }
    .view-btn svg { width: 16px; height: 16px; }
    .view-btn.active { background: #fff; color: #059669; box-shadow: 0 2px 6px rgba(0,0,0,0.06); }

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
        border: 1px solid rgba(99, 102, 241, 0.08);
    }

    .count-badge svg { width: 16px; height: 16px; }
    .count-badge span { font-weight: 800; font-size: 0.92rem; }

    /* ── Grid ── */
    .schools-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:24px; padding-bottom:40px; }

    /* ── Skeleton ── */
    @keyframes shimmer { 0%{background-position:-400px 0;} 100%{background-position:400px 0;} }
    .skeleton-card { background:#fff; border-radius:24px; overflow:hidden; border:1px solid #f1f5f9; display:flex; flex-direction:column; }
    .sk-banner { width:100%; height:80px; background:linear-gradient(90deg,#f1f5f9 25%,#f8fafc 50%,#f1f5f9 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-content { padding: 20px; }
    .sk-avatar { width:72px; height:72px; border-radius:20px; margin-top:-56px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; border:4px solid #fff; margin-bottom: 12px; }
    .sk-line { height:12px; border-radius:6px; margin-bottom:12px; background:linear-gradient(90deg,#e8ecf3 25%,#f1f5f9 50%,#e8ecf3 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; }
    .sk-l1 { width:70%; } .sk-l2 { width:45%; }
    .skeleton-section-bar { width:180px; height:16px; border-radius:8px; background:linear-gradient(90deg,#f1f5f9 25%,#f8fafc 50%,#f1f5f9 75%); background-size:400px 100%; animation:shimmer 1.6s ease-in-out infinite; margin-bottom:20px; }

    /* ── School Card — Premium Redesign ── */
    @keyframes cardReady { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .school-card {
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
    }

    .school-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -12px rgba(16, 185, 129, 0.15);
        border-color: #10b981;
    }

    .card-banner {
        height: 80px;
        width: 100%;
        transition: all 0.5s ease;
    }

    .school-card:hover .card-banner {
        height: 85px;
        filter: saturate(1.1);
    }

    .card-avatar-container {
        padding: 0 20px;
        margin-top: -56px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .card-avatar {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        border: 4px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.25rem;
        color: #fff;
        box-shadow: 0 8px 16px -4px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .school-card:hover .card-avatar {
        transform: scale(1.08) rotate(-3deg);
        box-shadow: 0 12px 24px -6px rgba(0,0,0,0.15);
    }

    .card-badge {
        background: #f0fdf4;
        color: #10b981;
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.68rem;
        font-weight: 700;
        border: 1px solid #d1fae5;
        margin-bottom: 4px;
        transition: all 0.3s ease;
    }

    .school-card:hover .card-badge {
        background: #10b981;
        color: #fff;
        border-color: #10b981;
        transform: translateY(-2px);
    }

    .card-main {
        padding: 8px 20px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-name {
        font-size: 0.88rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
        line-height: 1.35;
        letter-spacing: -0.01em;
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
    }

    .detail-row svg {
        width: 14px;
        height: 14px;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .detail-text {
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
        color: #10b981;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .action-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f0fdf4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        transition: all 0.3s ease;
    }

    .school-card:hover .action-icon {
        background: #10b981;
        color: #fff;
        transform: rotate(-45deg);
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
    .empty-reset-btn { display:inline-flex; align-items:center; gap:6px; padding:10px 20px; border:1.5px solid #e2e8f0; border-radius:12px; background:#fff; color:#10b981; font-size:0.8rem; font-weight:600; cursor:pointer; transition:all 0.25s; font-family:'Inter',sans-serif; }
    .empty-reset-btn:hover { background:#10b981; color:#fff; border-color:#10b981; }

    /* ── Modal (split-panel, emerald) ── */
    .modal-backdrop { position:fixed; inset:0; background:rgba(15,23,42,0.5); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); display:flex; align-items:center; justify-content:center; z-index:1000; opacity:0; pointer-events:none; transition:opacity 0.3s ease; }
    .modal-backdrop.open { opacity:1; pointer-events:auto; }
    .modal-sheet { width:94%; max-width:1160px; max-height:90vh; display:flex; border-radius:24px; overflow:hidden; box-shadow:0 32px 80px -12px rgba(0,0,0,0.25); transform:scale(0.95) translateY(24px); transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1); }
    .modal-backdrop.open .modal-sheet { transform:scale(1) translateY(0); }
    .modal-panel { width:240px; flex-shrink:0; background:linear-gradient(160deg,#ecfdf5 0%,#d1fae5 60%,#a7f3d0 100%); padding:36px 24px 28px; display:flex; flex-direction:column; align-items:center; position:relative; overflow:hidden; border-right:1px solid #a7f3d0; }
    .modal-panel::before { content:''; position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(16,185,129,0.15); top:-60px; right:-60px; }
    .modal-panel::after { content:''; position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(16,185,129,0.1); bottom:40px; left:-40px; }
    .panel-avatar { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,#10b981,#059669); border:4px solid #fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:900; color:#fff; position:relative; z-index:1; box-shadow:0 8px 24px rgba(16,185,129,0.3); }
    .panel-name { font-size:0.9rem; font-weight:700; color:#1e1b4b; text-align:center; margin-top:14px; line-height:1.35; position:relative; z-index:1; }
    .panel-role { font-size:0.68rem; color:#059669; text-align:center; margin-top:4px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; position:relative; z-index:1; }
    .panel-stat-wrap { margin-top:20px; background:rgba(255,255,255,0.7); border:1px solid rgba(16,185,129,0.3); border-radius:14px; padding:14px 20px; text-align:center; width:100%; position:relative; z-index:1; }
    .ps-num { display:block; font-size:1.6rem; font-weight:900; color:#065f46; }
    .ps-label { font-size:0.65rem; color:#059669; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
    .panel-divider { width:100%; height:1px; background:rgba(16,185,129,0.25); margin:20px 0; position:relative; z-index:1; }
    .panel-filters { width:100%; position:relative; z-index:1; }
    .pf-label { display:block; font-size:0.65rem; color:#059669; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px; }
    .pf-date-wrap { position:relative; background:rgba(255,255,255,0.75); border:1.5px solid rgba(16,185,129,0.4); border-radius:12px; display:flex; align-items:center; padding:0 12px; }
    .pf-date-wrap svg { width:14px; height:14px; color:#10b981; flex-shrink:0; }
    .pf-date-wrap input { flex:1; border:none; outline:none; background:transparent; padding:10px 8px; font-size:0.78rem; color:#1e1b4b; font-family:'Inter',sans-serif; cursor:pointer; min-width:0; }
    .pf-clear { width:100%; margin-top:8px; padding:8px; border-radius:10px; border:1.5px solid rgba(16,185,129,0.4); background:rgba(255,255,255,0.7); color:#059669; font-size:0.72rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; }
    .pf-clear:hover { background:#fee2e2; color:#ef4444; border-color:#fca5a5; }
    .panel-close-btn { margin-top:28px; display:flex; align-items:center; justify-content:center; gap:6px; width:100%; padding:11px; border-radius:12px; border:1.5px solid rgba(16,185,129,0.4); background:rgba(255,255,255,0.7); color:#065f46; font-size:0.8rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; position:relative; z-index:1; }
    .panel-close-btn svg { width:16px; height:16px; }
    .panel-close-btn:hover { background:#fee2e2; border-color:#fca5a5; color:#ef4444; }
    .modal-main { flex:1; background:#fff; display:flex; flex-direction:column; overflow:hidden; min-width:0; }
    .modal-main-header { display:flex; align-items:center; justify-content:space-between; padding:20px 26px; border-bottom:1px solid #f1f5f9; background:#f0fdf4; flex-shrink:0; gap:14px; }
    .mm-title { font-size:1rem; font-weight:700; color:#1e293b; }
    .mm-search { position:relative; display:flex; align-items:center; background:#f1f5f9; border-radius:12px; padding:0 14px; gap:8px; border:1.5px solid transparent; transition:all 0.2s; }
    .mm-search:focus-within { background:#fff; border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.08); }
    .mm-search svg { width:14px; height:14px; color:#94a3b8; flex-shrink:0; }
    .mm-search:focus-within svg { color:#10b981; }
    .mm-search input { border:none; outline:none; background:transparent; padding:9px 0; font-size:0.8rem; font-family:'Inter',sans-serif; color:#1e293b; width:200px; }
    .mm-search input::placeholder { color:#b0bac9; }
    .modal-table-wrap { flex:1; overflow-y:auto; }
    .modal-table { width:100%; border-collapse:collapse; text-align:left; }
    .modal-table tbody tr:hover td { background:#fafbff; }
    .modal-table tbody tr:last-child td { border-bottom:none; }
    
    .badge { font-size:0.7rem; padding:4px 10px; border-radius:20px; font-weight:700; display:inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .badge-green { background:#ecfdf5; color:#059669; border: 1px solid rgba(5,150,105,0.1); } 
    .badge-red { background:#fef2f2; color:#dc2626; border: 1px solid rgba(220,38,38,0.1); }
    .badge-violet { background:#f5f3ff; color:#7c3aed; border: 1px solid rgba(124,58,237,0.1); } 
    .badge-yellow { background:#fffbeb; color:#d97706; border: 1px solid rgba(217,119,6,0.1); }
    .badge-gray { background:#f1f5f9; color:#64748b; border: 1px solid rgba(100,116,139,0.1); } 
    .badge-leave { font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:8px; background:#eef2ff; color:#6366f1; display:inline-block; }

    /* Legacy Search Bar Removal (kept empty for clean structure) */
    .search-filter-bar { display:none; }

    .view-btn:hover:not(.active) {
        color: #64748b;
    }

    /* ── Skeleton Loading ── */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* ── Section Headers ── */
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        margin-top: 36px;
    }

    .section-header-line {
        flex: 0 0 3px;
        height: 22px;
        border-radius: 2px;
        background: linear-gradient(180deg, #6366f1, #8b5cf6);
    }

    .section-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title svg {
        color: #6366f1;
    }

    .section-count {
        font-size: 0.68rem;
        font-weight: 700;
        background: #f5f3ff;
        color: #6366f1;
        padding: 2px 10px;
        border-radius: 10px;
    }

    /* ── Schools Grid ── */
    .schools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        gap: 18px;
    }

    /* ── List View Layout ── */
    .schools-grid.list-view {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .schools-grid.list-view .school-card {
        flex-direction: row;
        align-items: center;
        padding: 12px 20px;
        width: 100%;
        height: auto;
        min-height: 80px;
    }

    .schools-grid.list-view .card-banner {
        display: none;
    }

    .schools-grid.list-view .card-avatar-container {
        margin-top: 0;
        padding: 0;
        margin-right: 20px;
    }

    .schools-grid.list-view .card-avatar {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        font-size: 1rem;
        border: none;
        box-shadow: none;
    }

    .schools-grid.list-view .card-badge {
        display: none;
    }

    .schools-grid.list-view .card-main {
        padding: 0;
        flex-direction: row;
        align-items: center;
        flex: 1;
        gap: 24px;
    }

    .schools-grid.list-view .card-name {
        margin-bottom: 0;
        min-height: auto;
        -webkit-line-clamp: 1;
        width: 320px;
        flex-shrink: 0;
    }

    .schools-grid.list-view .card-details {
        margin-bottom: 0;
        flex-direction: row;
        flex: 1;
        gap: 32px;
    }

    .schools-grid.list-view .detail-row {
        width: auto;
        min-width: 150px;
    }

    .schools-grid.list-view .card-action-bar {
        margin-top: 0;
        padding-top: 0;
        border-top: none;
        width: auto;
    }

    .schools-grid.list-view .action-label {
        display: none;
    }

    /* ── Responsive Refinements ── */
    @media (max-width: 1024px) {
        .schools-grid.list-view .card-details {
            gap: 16px;
        }
        .schools-grid.list-view .detail-row {
            min-width: 120px;
        }
    }


    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

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

    .modal-panel { width:240px; flex-shrink:0; background:linear-gradient(160deg,#ecfdf5 0%,#d1fae5 60%,#a7f3d0 100%); padding:36px 24px 28px; display:flex; flex-direction:column; align-items:center; position:relative; overflow:hidden; border-right:1px solid #a7f3d0; }
    .modal-panel::before { content:''; position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(16,185,129,0.15); top:-60px; right:-60px; }
    .modal-panel::after { content:''; position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(16,185,129,0.1); bottom:40px; left:-40px; }
    .panel-avatar { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,#10b981,#059669); border:4px solid #fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:900; color:#fff; position:relative; z-index:1; box-shadow:0 8px 24px rgba(16,185,129,0.3); }
    .panel-name { font-size:0.9rem; font-weight:700; color:#064e3b; text-align:center; margin-top:14px; line-height:1.35; position:relative; z-index:1; }
    .panel-role { font-size:0.68rem; color:#059669; text-align:center; margin-top:4px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; position:relative; z-index:1; }
    .panel-stat-wrap { margin-top:20px; background:rgba(255,255,255,0.7); border:1px solid rgba(16,185,129,0.3); border-radius:14px; padding:14px 20px; text-align:center; width:100%; position:relative; z-index:1; }
    .ps-num { display:block; font-size:1.6rem; font-weight:900; color:#064e3b; }
    .ps-label { font-size:0.65rem; color:#059669; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
    .panel-divider { width:100%; height:1px; background:rgba(16,185,129,0.25); margin:20px 0; position:relative; z-index:1; }
    .panel-filters { width:100%; position:relative; z-index:1; }
    .pf-label { display:block; font-size:0.65rem; color:#059669; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px; }
    .pf-date-wrap { position:relative; background:rgba(255,255,255,0.75); border:1.5px solid rgba(16,185,129,0.4); border-radius:12px; display:flex; align-items:center; padding:0 12px; }
    .pf-date-wrap svg { width:14px; height:14px; color:#10b981; flex-shrink:0; }
    .pf-date-wrap input { flex:1; border:none; outline:none; background:transparent; padding:10px 8px; font-size:0.78rem; color:#064e3b; font-family:'Inter',sans-serif; cursor:pointer; min-width:0; }
    .pf-clear { width:100%; margin-top:8px; padding:8px; border-radius:10px; border:1.5px solid rgba(16,185,129,0.4); background:rgba(255,255,255,0.7); color:#10b981; font-size:0.72rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; }
    .pf-clear:hover { background:#fee2e2; color:#ef4444; border-color:#fca5a5; }
    .panel-close-btn { margin-top:28px; display:flex; align-items:center; justify-content:center; gap:6px; width:100%; padding:11px; border-radius:12px; border:1.5px solid rgba(16,185,129,0.4); background:rgba(255,255,255,0.7); color:#064e3b; font-size:0.8rem; font-weight:600; font-family:'Inter',sans-serif; cursor:pointer; transition:all 0.2s; position:relative; z-index:1; }
    .panel-close-btn svg { width:16px; height:16px; }
    .panel-close-btn:hover { background:#fee2e2; border-color:#fca5a5; color:#ef4444; }
    .modal-main { flex:1; background:#fff; display:flex; flex-direction:column; overflow:hidden; min-width:0; }
    .modal-main-header { display:flex; align-items:center; justify-content:space-between; padding:20px 26px; border-bottom:1px solid #f1f5f9; background:#f8fafc; flex-shrink:0; gap:14px; }
    .mm-title { font-size:1rem; font-weight:700; color:#1e293b; }
    .mm-search { position:relative; display:flex; align-items:center; background:#f1f5f9; border-radius:12px; padding:0 14px; gap:8px; border:1.5px solid transparent; transition:all 0.2s; }
    .mm-search:focus-within { background:#fff; border-color:#10b981; box-shadow:0 0 0 3px rgba(16,185,129,0.08); }
    .mm-search svg { width:14px; height:14px; color:#94a3b8; flex-shrink:0; }
    .mm-search:focus-within svg { color:#10b981; }
    .mm-search input { border:none; outline:none; background:transparent; padding:9px 0; font-size:0.8rem; font-family:'Inter',sans-serif; color:#1e293b; width:200px; }
    .mm-search input::placeholder { color:#b0bac9; }
    .modal-body { 
        padding: 0; 
        overflow-y: auto; 
        overflow-x: auto; 
        flex: 1; 
        scrollbar-width: none; 
        -ms-overflow-style: none;
    }
    .modal-body::-webkit-scrollbar { display: none; }


    .modal-table-wrap { 
        flex: 1; 
        overflow-y: auto; 
        overflow-x: auto; 
        padding-bottom: 20px; 
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .modal-table-wrap::-webkit-scrollbar { display: none; }
    .modal-table { width: 100%; border-collapse: collapse; text-align: left; table-layout: fixed; }
    .modal-table thead th { background: #f8fafc; padding: 12px 18px; font-size: 0.68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; position: sticky; top: 0; z-index: 5; border-bottom: 2px solid #eef2ff; white-space: normal; vertical-align: middle; }
    .modal-table tbody td { padding: 13px 18px; font-size: 0.81rem; color: #475569; border-bottom: 1px solid #f8fafc; word-break: break-all; overflow-wrap: anywhere; vertical-align: top; line-height: 1.4; }

    /* Column widths for School Modal */
    .modal-table th:nth-child(1), .modal-table td:nth-child(1) { width: 12%; } /* Name */
    .modal-table th:nth-child(2), .modal-table td:nth-child(2) { width: 10%; } /* Position */
    .modal-table th:nth-child(3), .modal-table td:nth-child(3) { width: 6%; }  /* Type */
    .modal-table th:nth-child(4), .modal-table td:nth-child(4) { width: 14%; } /* Dates */
    .modal-table th:nth-child(5), .modal-table td:nth-child(5) { width: 14%; } /* Remarks */
    .modal-table th:nth-child(6), .modal-table td:nth-child(6) { width: 11%; } /* Action Date */
    .modal-table th:nth-child(7), .modal-table td:nth-child(7) { width: 18%; } /* Deduction Remarks */
    .modal-table th:nth-child(8), .modal-table td:nth-child(8) { width: 7%; }  /* Incharge - Reduced */
    .modal-table th:nth-child(9), .modal-table td:nth-child(9) { width: 8%; }  /* Actions - Increased */

    .modal-table tbody tr:hover td { background: #f8fafc; }
    .modal-table tbody tr:last-child td { border-bottom: none; }

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

    /* ── Badges ── */
    .badge {
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
    }

    .badge-green { background: #ecfdf5; color: #059669; }
    .badge-red { background: #fef2f2; color: #dc2626; }
    .badge-violet { background: #f5f3ff; color: #7c3aed; }
    .badge-yellow { background: #fffbeb; color: #d97706; }
    .badge-gray { background: #f1f5f9; color: #64748b; }

    .badge-leave {
        font-size: 0.7rem; font-weight: 600; padding: 4px 10px;
        border-radius: 8px; background: #eef2ff; color: #6366f1;
        display: inline-block;
    }

    /* ── School Card Dark Mode ── */
    body.dark-mode .school-card { 
        background: transparent; 
        border: 1.5px solid var(--card-color, #334155); 
        box-shadow: none; 
    }
    body.dark-mode .card-name { color: #f1f5f9; }
    body.dark-mode .card-details { color: #94a3b8; }
    body.dark-mode .action-label { color: var(--card-color, #818cf8); }
    body.dark-mode .action-icon { background: rgba(255,255,255,0.05); color: var(--card-color, #818cf8); }
    body.dark-mode .school-card:hover { 
        background: rgba(30, 41, 59, 0.3); 
        transform: translateY(-8px); 
        box-shadow: 0 0 24px rgba(var(--card-color-rgb, 16, 185, 129), 0.15); 
    }
    body.dark-mode .school-card:hover .action-icon { background: var(--card-color, #10b981); color: #fff; }
    body.dark-mode .card-action-bar { border-top-color: rgba(255,255,255,0.06); }
    body.dark-mode .card-badge { background: rgba(15, 23, 42, 0.7); color: var(--card-color, #818cf8); border-color: var(--card-color, #334155); }
    /* Dark Mode Core */
    body.dark-mode { background: #0f172a; color: #cbd5e1; }
    body.dark-mode .hero-banner { background: #1e293b; border-color: #334155; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
    body.dark-mode .hero-dots { opacity: 0.1; }
    body.dark-mode .hero-title { color: #f8fafc; }
    body.dark-mode .hero-desc { color: #94a3b8; }
    body.dark-mode .hero-tag { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    body.dark-mode .hmi-icon { background: rgba(16, 185, 129, 0.15); }
    body.dark-mode .hmi-num { color: #f8fafc; }
    body.dark-mode .hero-right { background: #1a1f35; border-left-color: #334155; }
    body.dark-mode .hero-search { background: #0f172a; border-color: #334155; }
    body.dark-mode .hero-search input { color: #f1f5f9; }
    body.dark-mode .filter-select-wrap { background: #0f172a; border-color: #334155; }
    body.dark-mode .filter-select-wrap select { color: #f1f5f9; }
    body.dark-mode .filter-select-wrap select option { background: #1e293b; color: #f1f5f9; }
    body.dark-mode .filter-select-wrap svg { color: #10b981; }
    body.dark-mode .hsc-toggles { background: rgba(0,0,0,0.3); }
    body.dark-mode .view-btn { color: #94a3b8; }
    body.dark-mode .view-btn.active { background: #334155; color: #34d399; }

    body.dark-mode .card-avatar { border: 4px solid #0f172a !important; }

    /* Modal Dark Mode */
    body.dark-mode .modal-sheet { background: #0f172a; border: 1px solid #1e293b; color: #f1f5f9; }
    body.dark-mode .modal-panel { background: linear-gradient(160deg, #064e3b 0%, #022c22 100%); border-right-color: #1e293b; }
    body.dark-mode .panel-avatar { border-color: #1e293b; }
    body.dark-mode .panel-name { color: #f1f5f9; }
    body.dark-mode .panel-role { color: #34d399; }
    body.dark-mode .panel-stat-wrap { background: rgba(255,255,255,0.05); border-color: rgba(16, 185, 129, 0.2); }
    body.dark-mode .ps-num { color: #f1f5f9; }
    body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(16, 185, 129, 0.3); }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; }
    body.dark-mode .pf-clear, body.dark-mode .panel-close-btn { background: rgba(255,255,255,0.05); border-color: rgba(16,185,129,0.2); color: #f1f5f9; }
    body.dark-mode .panel-divider { background: rgba(16,185,129,0.2); }

    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #111827; border-bottom-color: #1e293b; }
    body.dark-mode .mm-title { color: #f1f5f9; }
    body.dark-mode .mm-search { background: #0a0f1e; border-color: #334155; }
    body.dark-mode .mm-search input { color: #f1f5f9; }
    body.dark-mode .modal-table thead th { background: #111827; border-bottom-color: #1e293b; color: #cbd5e1; }
    body.dark-mode .modal-table tbody td { border-bottom-color: #1e293b; color: #cbd5e1; }
    
    /* Custom classes for JS dynamic rows */
    .cell-name { font-weight: 600; color: #1e293b; }
    .cell-meta { font-family: monospace; font-size: 0.75rem; color: #64748b; }
    .cell-subtext { font-size: 0.8rem; color: #64748b; }
    .cell-school { color: #475569; }

    body.dark-mode .cell-name { color: #f1f5f9 !important; }
    body.dark-mode .cell-meta { color: #cbd5e1 !important; }
    body.dark-mode .cell-subtext { color: #94a3b8 !important; }
    body.dark-mode .cell-school { color: #cbd5e1 !important; }
    body.dark-mode .modal-table tbody tr:hover td { background: #1e293b !important; color: #ffffff !important; }
    body.dark-mode .modal-table tbody tr:hover .cell-name { color: #ffffff !important; }
    body.dark-mode .modal-table tbody tr:hover .cell-meta { color: #94a3b8 !important; }
    body.dark-mode .badge-leave { background: rgba(16, 185, 129, 0.15); color: #34d399; }
    body.dark-mode .btn-edit { background: rgba(22, 163, 74, 0.15); color: #4ade80; border-color: rgba(34, 197, 94, 0.3); box-shadow: none; }
    body.dark-mode .btn-edit:hover { background: #16a34a; color: #fff; box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4); }
    body.dark-mode .btn-delete { background: rgba(220, 38, 38, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3); box-shadow: none; }
    body.dark-mode .btn-delete:hover { background: #dc2626; color: #fff; box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4); }
    body.dark-mode .view-only-tag { background: rgba(255,255,255,0.05); border-color: #334155; color: #64748b; }
    body.dark-mode .pf-date-wrap { background: rgba(0,0,0,0.2); border-color: rgba(16, 185, 129, 0.3); }
    body.dark-mode .pf-date-wrap svg { color: #fff !important; }
    body.dark-mode .pf-date-wrap input { color: #f1f5f9; color-scheme: dark; }
    body.dark-mode .pf-date-wrap input::-webkit-calendar-picker-indicator { filter: brightness(0) invert(1) !important; }
    
    /* Loading Skeleton Dark Mode */
    body.dark-mode .skeleton-card { background: #1e293b; border-color: #334155; }
    body.dark-mode .sk-banner { background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%); background-size: 400px 100%; }
    body.dark-mode .sk-avatar { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; border-color: #1e293b; }
    body.dark-mode .sk-line { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 400px 100%; }
    body.dark-mode .skeleton-section-bar { background: linear-gradient(90deg, #1e293b 25%, #334155 37%, #1e293b 63%); }

    /* Responsive */
    @media (max-width: 768px) {
        .content-body { padding: 12px 14px !important; }
        .hero-banner { flex-direction: column; border-radius: 22px; }
        .hero-left { padding: 24px 20px; }
        .hero-title { font-size: 1.35rem; }
        .hero-right { width: 100%; border-left: none; border-top: 1.5px solid #a7f3d0; padding: 20px; }
        
        .page-header { flex-direction: column; align-items: flex-start; gap: 14px; }
        .search-filter-bar { flex-direction: column; align-items: stretch; }
        .search-input-wrapper { max-width: 100%; }
        .view-toggles { display: none; }
        
        .schools-grid { 
            grid-template-columns: repeat(2, 1fr) !important; 
            gap: 10px !important; 
        }
        .school-card { 
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

        .schools-grid.list-view { grid-template-columns: 1fr !important; }
        .schools-grid.list-view .school-card { 
            flex-direction: row !important; 
            align-items: center !important; 
            padding: 10px 16px !important; 
            gap: 12px !important;
            min-height: auto !important;
        }
        .schools-grid.list-view .card-avatar-container { margin: 0 !important; flex-shrink: 0 !important; }
        .schools-grid.list-view .card-avatar { width: 44px !important; height: 44px !important; border-radius: 12px !important; }
        .schools-grid.list-view .card-main { 
            display: grid !important;
            grid-template-columns: 1fr auto !important;
            align-items: center !important;
            width: 100% !important;
            padding: 0 !important;
            flex: 1 !important;
            gap: 2px 12px !important;
        }
        .schools-grid.list-view .card-name { 
            grid-column: 1 !important;
            width: 100% !important; 
            font-size: 0.82rem !important;
            margin: 0 !important;
        }
        .schools-grid.list-view .card-details { 
            grid-column: 1 !important;
            flex-direction: column !important; 
            gap: 1px !important; 
            width: 100% !important; 
        }
        .schools-grid.list-view .detail-row { min-width: 0 !important; font-size: 0.68rem !important; }
        .schools-grid.list-view .detail-row svg { width: 12px !important; height: 12px !important; }
        .schools-grid.list-view .card-action-bar {
            grid-column: 2 !important;
            grid-row: 1 / 2 !important;
            display: flex !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            width: auto !important;
        }
        .schools-grid.list-view .action-label { display: none !important; }
        .schools-grid.list-view .action-icon { width: 24px !important; height: 24px !important; border-radius: 8px !important; background: #f1f5f9 !important; }

        .modal-sheet {
            width: 95% !important;
            height: 85vh !important;
            border-radius: 24px !important;
            flex-direction: column !important;
            max-height: none !important;
            overflow-y: auto !important;
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
            border-bottom: 1px solid #a7f3d0;
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
        }
        .modal-main-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
            padding: 12px 16px !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 50 !important;
            background: #f8fafc !important;
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
</style>

<script>
const AUTH_USER_ID = "{{ auth()->id() }}";
const AUTH_USERNAME = "{{ auth()->user()->username ?? '' }}";
const AUTH_NAME = "{{ auth()->user()->name ?? '' }}";
const AUTH_ROLE = "{{ auth()->user()->role ?? 'user' }}";

document.addEventListener('DOMContentLoaded', function() {
    let allSchools = [];

    const sectionUnitGrid = document.getElementById('sectionUnitGrid');
    const sectionUnitSection = document.getElementById('sectionUnitSection');
    const highSchoolGrid = document.getElementById('highSchoolGrid');
    const elementarySchoolGrid = document.getElementById('elementarySchoolGrid');
    const highSchoolSection = document.getElementById('highSchoolSection');
    const elementarySection = document.getElementById('elementarySection');
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('schoolCount');
    const modal = document.getElementById('schoolModal');
    const loadingSkeleton = document.getElementById('loadingSkeleton');

    // Fetch schools from API
    fetch('{{ url("/leave-records/schools") }}')
        .then(res => res.json())
        .then(data => {
            console.log('Fetched schools:', data);
            allSchools = Array.isArray(data) ? data : [];
            if (countEl) countEl.textContent = allSchools.length;
            loadingSkeleton.style.display = 'none';
            renderSchools();
        })
        .catch(err => {
            console.error('Error fetching schools:', err);
            loadingSkeleton.style.display = 'none';
            allSchools = [];
            renderSchools();
            const errorMsg = '<p style="text-align:center; color:#ef4444; grid-column: 1/-1; padding: 40px; background:white; border-radius:12px; border:1px solid #fee2e2;">Error loading school data. Please try refreshing the page.</p>';
            highSchoolGrid.innerHTML = errorMsg;
            highSchoolSection.style.display = 'block';
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
        return name.split(' ').filter(w => w.length > 2).slice(0, 2).map(w => w[0]).join('');
    }

    function determineType(name) {
        const cleanName = name.trim();
        const upper = cleanName.toUpperCase();
        
        const schoolSuffixes = [
            'SCHOOL', 'ELEMENTARY SCHOOL', 'ES', 'E.S', 'E/S', 
            'HIGH SCHOOL', 'SHS', 'HS', 'H/S', 'H.S', 'ELEMENTARY',
            'NHS', 'SNHS', 'JHS', 'J.H.S', 'B.S.H.S', 'C.H.S', 'IS'
        ];
        
        const upperNoDot = upper.endsWith('.') ? upper.slice(0, -1) : upper;
        
        const isSchool = schoolSuffixes.some(suffix => {
            return upper.endsWith(suffix) || upperNoDot.endsWith(suffix);
        });

        if (!isSchool) {
            const forcedSchools = ['HS', 'H.S', 'SHS', 'NHS', 'SNHS'];
            const isForcedSchool = forcedSchools.some(fs => upper.includes(fs) && (upper.endsWith(fs) || upperNoDot.endsWith(fs)));
            
            if (!isForcedSchool) {
                return { type: 'Section/Unit', class: 'section-unit' };
            }
        }

        const lower = cleanName.toLowerCase();
        
        const hsIndicators = ['high school', 'secondary', 'nhs', 'snhs', 'jhs', 'shs', 'hs', 'h.s', 'h/s'];
        const isHighSchool = hsIndicators.some(ind => lower.includes(ind));

        if (isHighSchool) return { type: 'High School', class: 'high-school' };
        if (lower.includes('integrated') || lower.endsWith(' is')) return { type: 'Integrated', class: 'integrated' };
        if (lower.includes('elementary') || lower.includes('es')) return { type: 'Elementary', class: 'elementary' };
        
        return { type: 'School', class: 'elementary' };
    }
    
    const PALETTES = [
        ['#10b981', '#059669'], ['#34d399', '#10b981'], ['#059669', '#047857'],
        ['#6ee7b7', '#34d399'], ['#14b8a6', '#0f766e'], ['#2dd4bf', '#14b8a6']
    ];
    function getGrad(name) { const i = name.charCodeAt(0) % PALETTES.length; return PALETTES[i]; }

    function createSchoolCard(item, index) {
        const [c1, c2] = getGrad(item.school);
        const initials = getInitials(item.school);
        const typeInfo = determineType(item.school);
        
        return `
            <div class="school-card" onclick="openSchoolModal('${item.school.replace(/'/g, "\\'")}')" style="animation-delay: ${Math.min(index * 0.03, 0.6)}s; --card-color: ${c1}">
                <div class="card-banner" style="background: linear-gradient(135deg, ${c1}, ${c2})"></div>
                <div class="card-avatar-container">
                    <div class="card-avatar" style="background: linear-gradient(135deg, ${c1}, ${c2})">${initials}</div>
                    <div class="card-badge">${item.leave_count} Record${item.leave_count !== 1 ? 's' : ''}</div>
                </div>
                <div class="card-main">
                    <h3 class="card-name" title="${item.school}">${item.school}</h3>
                    <div class="card-details">
                        <div class="detail-row">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                            <span class="school-type ${typeInfo.class}">${typeInfo.type}</span>
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
            </div>
        `;
    }

    window.renderSchools = function(filter = '') {
        const typeFilter = document.getElementById('typeFilter').value;
        const q = filter.toLowerCase();
        
        let filtered = allSchools.filter(s => s.school.toLowerCase().includes(q));
        
        // Secondary Filter by Type
        if (typeFilter !== 'all') {
            filtered = filtered.filter(s => {
                const typeInfo = determineType(s.school);
                const type = typeInfo.type.toLowerCase();
                if (typeFilter === 'section/unit') return type === 'section/unit';
                if (typeFilter === 'elementary') return type === 'elementary' || type === 'school';
                if (typeFilter === 'high school') return type === 'high school' || type === 'integrated';
                return true;
            });
        }

        countEl.textContent = filtered.length;
        searchClear.style.display = q ? 'flex' : 'none';

        if (filtered.length === 0) {
            sectionUnitSection.style.display = 'none';
            highSchoolSection.style.display = 'none';
            elementarySection.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        
        const highSchools = [];
        const elementarySchools = [];
        const sectionUnits = [];

        filtered.forEach(school => {
            const typeInfo = determineType(school.school);
            if (typeInfo.type === 'High School' || typeInfo.type === 'Integrated') {
                highSchools.push(school);
            } else if (typeInfo.type === 'Section/Unit') {
                sectionUnits.push(school);
            } else {
                elementarySchools.push(school);
            }
        });

        // Render Sections/Units
        if (sectionUnits.length > 0) {
            sectionUnitSection.style.display = 'block';
            document.getElementById('sectionUnitCount').textContent = sectionUnits.length;
            sectionUnitGrid.innerHTML = sectionUnits.map((item, i) => createSchoolCard(item, i)).join('');
        } else {
            sectionUnitSection.style.display = 'none';
        }

        // Render High Schools
        if (highSchools.length > 0) {
            highSchoolSection.style.display = 'block';
            document.getElementById('highSchoolCount').textContent = highSchools.length;
            highSchoolGrid.innerHTML = highSchools.map((item, i) => createSchoolCard(item, i)).join('');
        } else {
            highSchoolSection.style.display = 'none';
        }

        // Render Elementary Schools
        if (elementarySchools.length > 0) {
            elementarySection.style.display = 'block';
            document.getElementById('elementaryCount').textContent = elementarySchools.length;
            elementarySchoolGrid.innerHTML = elementarySchools.map((item, i) => createSchoolCard(item, i)).join('');
        } else {
            elementarySection.style.display = 'none';
        }
    };

    searchInput.addEventListener('input', function() {
        renderSchools(this.value);
    });

    window.clearSearch = function() {
        searchInput.value = '';
        document.getElementById('typeFilter').value = 'all';
        renderSchools();
        searchInput.focus();
    };

    window.setView = function(view) {
        document.getElementById('viewGrid').classList.toggle('active', view === 'grid');
        document.getElementById('viewList').classList.toggle('active', view === 'list');
        document.querySelectorAll('.schools-grid').forEach(grid => {
            grid.classList.toggle('list-view', view === 'list');
        });
    };

    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#schoolTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.cells.length < 2) return;
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(q);
            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        const tbody = document.getElementById('schoolTableBody');
        const existingNoResults = document.getElementById('noResultsRow');
        
        if (visibleCount === 0 && rows.length > 0 && rows[0].cells.length >= 2) {
            if (!existingNoResults) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = `<td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">No records matching "${q}"</td>`;
                tbody.appendChild(noResultsRow);
            } else {
                existingNoResults.innerHTML = `<td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">No records matching "${q}"</td>`;
                existingNoResults.style.display = '';
            }
        } else if (existingNoResults) {
            existingNoResults.style.display = 'none';
        }
    }

    document.getElementById('modalSearch').addEventListener('input', filterModalRecords);

    let currentSchoolForModal = '';

    window.openSchoolModal = function(schoolName) {
        modal.classList.add('open');
        currentSchoolForModal = schoolName;
        document.getElementById('modalSchoolName').textContent = schoolName;
        const [c1, c2] = getGrad(schoolName);
        document.getElementById('modalSchoolAvatar').textContent = getInitials(schoolName);
        document.getElementById('modalSchoolAvatar').style.background = `linear-gradient(135deg, ${c1}, ${c2})`;
        document.getElementById('modalSearch').value = '';
        
        // Clear the date filter to show all records by default
        // Set the date filter to today's date by default
        document.getElementById('modalFilterDate').value = "{{ date('Y-m-d') }}";
        
        fetchSchoolRecords();
    };

    window.fetchSchoolRecords = function() {
        const schoolName = currentSchoolForModal;
        const date = document.getElementById('modalFilterDate').value;

        const url = `{{ url("/leave-records/by-school") }}?school=${encodeURIComponent(schoolName)}&date=${encodeURIComponent(date)}`;
        const tbody = document.getElementById('schoolTableBody');
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding: 40px; color: #94a3b8;">Loading...</td></tr>';
        document.getElementById('modalSchoolRecordCount').textContent = '...';

        fetch(url).then(res => res.json()).then(data => {
                document.getElementById('modalSchoolRecordCount').textContent = data.length;
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
                        <td><span class="badge-leave">${r.type_of_leave}</span></td>
                        <td class="cell-meta cell-dates" style="font-family:monospace;font-size:0.75rem;">${r.inclusive_dates || '-'}</td>
                        <td>${remarkBadge}</td>
                        <td class="cell-meta" style="font-family:monospace;font-size:0.75rem;">${formatDate(r.date_of_action)}</td>
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
                    </tr>`;
                }).join('');
                if (document.getElementById('modalSearch').value) filterModalRecords();
            })
            .catch(() => {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding: 40px; color: #ef4444;">Error loading records.</td></tr>';
            });
    };


    window.handleBackdropClick = function(e) {
        if (e.target.id === 'schoolModal') closeSchoolModal();
    };

    window.editRecord = function(id) {
        window.location.href = "{{ url('/user/form') }}?edit=" + id + "&source=school&schoolName=" + encodeURIComponent(currentSchoolForModal);
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
                fetchSchoolRecords();
                // Refresh main grid data
                fetch('{{ url("/leave-records/schools") }}')
                    .then(res => res.json())
                    .then(data => {
                        allSchools = Array.isArray(data) ? data : [];
                        if (countEl) countEl.textContent = allSchools.length;
                        renderSchools();
                    });
            } else {
                alert('Error deleting record.');
            }
        })
        .catch(() => alert('Error deleting record.'));
    };

    window.closeSchoolModal = function() {
        modal.classList.remove('open');
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) closeSchoolModal();
    });

    // Check for openModal URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const openModal = urlParams.get('openModal');
    if (openModal) {
        // We need to wait for schools to be loaded so initials and gradients work properly
        const checkInterval = setInterval(() => {
            if (allSchools.length > 0) {
                clearInterval(checkInterval);
                openSchoolModal(openModal);
            }
        }, 100);
    }
});
</script>

</body>
</html>
