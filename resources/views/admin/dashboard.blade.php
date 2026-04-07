<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f1f5f9; }
    </style>
</head>
<body>
    @include('partials.sidebar')
    <main class="main-content">
        @include('partials.navigation')
        <div class="bento-wrap">
            <div class="bento">

                <!-- HERO BANNER (incharge-style) -->
                <div class="hero-banner">
                    <div class="hero-dots"></div>
                    <div class="hero-left">
                        <div class="hero-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                            </svg>
                            Admin Dashboard
                        </div>
                        <h1 class="hero-title">Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name ?? 'Admin' }}</h1>
                        <p class="hero-desc">Your system overview and activity at a glance. Manage leave records, employees, and more.</p>
                        <div class="hero-meta">
                            <div class="hero-meta-item">
                                <div class="hmi-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="hmi-num" id="totalRecords">0</span>
                                    <span class="hmi-label">Total Records</span>
                                </div>
                            </div>
                            <div class="hero-meta-divider"></div>
                            <div class="hero-meta-item">
                                <div class="hmi-icon hmi-icon-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="hmi-num hmi-num-green" id="todayRecords">0</span>
                                    <span class="hmi-label">Added Today</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hero-right">
                        <div class="hero-clock-card">
                            <p class="hcc-label">Current Time</p>
                            <div class="hcc-time"><span id="bTime">00:00</span><span class="hcc-secs" id="bSecs">:00</span></div>
                            <div class="hcc-date" id="bDate">—</div>
                        </div>
                    </div>
                </div>

                <!-- STAT CARDS ROW -->
                <div class="stat-row">
                    <div class="stat-mini stat-amber">
                        <div class="sm-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg></div>
                        <div class="sm-info">
                            <div class="sm-num" id="totalEmployees">0</div>
                            <div class="sm-label">Employees</div>
                        </div>
                    </div>
                    <div class="stat-mini stat-emerald">
                        <div class="sm-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></svg></div>
                        <div class="sm-info">
                            <div class="sm-num" id="totalSchools">0</div>
                            <div class="sm-label">Schools</div>
                        </div>
                    </div>
                    <div class="stat-mini stat-indigo">
                        <div class="sm-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg></div>
                        <div class="sm-info">
                            <div class="sm-num" id="totalPositions">0</div>
                            <div class="sm-label">Positions</div>
                        </div>
                    </div>
                    <div class="stat-mini stat-purple">
                        <div class="sm-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .415.139.778.332 1.078 2.182.441 3.315 1.485 3.315 2.608 0 1.036-.898 2.099-2.738 2.57M12 3.75a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H12.75a.75.75 0 0 1-.75-.75V3.75Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25V9m3 0a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H12.75a.75.75 0 0 1-.75-.75V9Z"/></svg></div>
                        <div class="sm-info">
                            <div class="sm-num" id="totalLeaveTypes">0</div>
                            <div class="sm-label">Leave Types</div>
                        </div>
                    </div>
                </div>

                <!-- MODULE USAGE CHART (Trends) -->
                <div class="tile tile-chart tile-full">
                    <div class="tc-head">
                        <div>
                            <div class="tc-title">System Activity Trends</div>
                            <div class="tc-sub">Module usage volume over time</div>
                        </div>
                        <div class="tc-pills">
                            <button class="tc-pill active" onclick="updateUsageChart('day',this)">Day</button>
                            <button class="tc-pill" onclick="updateUsageChart('month',this)">Month</button>
                            <button class="tc-pill" onclick="updateUsageChart('year',this)">Year</button>
                        </div>
                    </div>
                    <div class="tc-canvas"><canvas id="moduleUsageChart"></canvas></div>
                </div>

                <!-- STAFF PRODUCTIVITY (Horizontal Bar) -->
                <div class="tile tile-chart">
                    <div class="tc-head">
                        <div>
                            <div class="tc-title">Staff Productivity</div>
                            <div class="tc-sub">Records processed by user</div>
                        </div>
                        <div class="tc-pills">
                            <button class="tc-pill active" onclick="updateProdChart('day',this)">Day</button>
                            <button class="tc-pill" onclick="updateProdChart('month',this)">Month</button>
                            <button class="tc-pill" onclick="updateProdChart('year',this)">Year</button>
                        </div>
                    </div>
                    <div class="tc-canvas"><canvas id="prodChart"></canvas></div>
                </div>

                <!-- REMARK STATS (Doughnut) -->
                <div class="tile tile-chart">
                    <div class="tc-head">
                        <div>
                            <div class="tc-title">Remarks Overview</div>
                            <div class="tc-sub">Leave payment categories</div>
                        </div>
                        <div class="tc-pills">
                            <button class="tc-pill active" onclick="updateRemarkChart('day',this)">Day</button>
                            <button class="tc-pill" onclick="updateRemarkChart('month',this)">Month</button>
                            <button class="tc-pill" onclick="updateRemarkChart('year',this)">Year</button>
                        </div>
                    </div>
                    <div class="tc-canvas" style="height: 240px;"><canvas id="remarkChart"></canvas></div>
                </div>

                <!-- ACTIVITY TIMELINE -->
                <div class="tile tile-audit">
                    <div class="au-head">
                        <div>
                            <div class="tc-title">Activity Timeline</div>
                            <div class="tc-sub">Today's system events</div>
                        </div>
                        <div class="au-head-actions">
                            <div class="au-live"><span class="au-dot"></span>Live</div>
                            <button class="au-btn-list" onclick="openActivityModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                                View List
                            </button>
                        </div>
                    </div>
                    <div class="au-timeline" id="auditLogList">
                        <div class="au-empty">Loading activity…</div>
                    </div>
                </div>

                <!-- QUICK ACTIONS -->
                <div class="tile tile-actions">
                    <div class="ta-title">Quick Actions</div>
                    <div class="ta-grid">
                        <a href="{{ url('/admin/form') }}" class="ta-btn" style="--ac:#818cf8;--ag:rgba(99,102,241,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg></div>
                            <span>New Record</span>
                        </a>
                        <a href="{{ url('/admin/incharge') }}" class="ta-btn" style="--ac:#fbbf24;--ag:rgba(217,119,6,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg></div>
                            <span>Incharge</span>
                        </a>
                        <a href="{{ url('/admin/leave-records') }}" class="ta-btn" style="--ac:#34d399;--ag:rgba(5,150,105,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg></div>
                            <span>History</span>
                        </a>
                        <a href="{{ url('/admin/employee-management') }}" class="ta-btn" style="--ac:#fb7185;--ag:rgba(225,29,72,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg></div>
                            <span>Accounts</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ACTIVITY LOGS MODAL -->
    <div class="modal-backdrop" id="activityLogsModal" onclick="handleBackdropClick(event)">
        <div class="modal-sheet">
            <!-- Left Panel -->
            <div class="modal-panel">
                <div class="panel-avatar">
                   @if(auth()->user() && auth()->user()->profile_image)
                       <img src="/storage/{{ auth()->user()->profile_image }}" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
                   @else
                       {{ auth()->user() ? strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name ?? 'A', 0, 1)) : 'A' }}
                   @endif
                </div>
                <h2 class="panel-name">System Activity</h2>
                <p class="panel-role">Administrator</p>
                <div class="panel-stat-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px; color:#6366f1;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="ps-label">Total Logs:</span>
                    <span class="ps-num" id="modalHistoryCount">0</span>
                </div>
                <div class="panel-divider"></div>
                <div class="panel-filters">
                    <div class="pf-group" style="margin-bottom: 12px;">
                        <label class="pf-label">Filter by User</label>
                        <div class="pf-input-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <select id="actUserFilter" onchange="applyActivityFilters()">
                                <option value="all">All Users</option>
                            </select>
                        </div>
                    </div>
                    <div class="pf-group">
                        <label class="pf-label">Filter by Date</label>
                        <div class="pf-input-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <input type="date" id="actDateFilter" onchange="applyActivityFilters()">
                        </div>
                    </div>
                </div>
                <button class="panel-close-btn" onclick="closeActivityModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    Close
                </button>
            </div>
            <!-- Right Main Panel -->
            <div class="modal-main">
                <div class="modal-main-header">
                    <h3 class="mm-title">System Transactions</h3>
                    <div class="mm-search">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" id="actSearchInput" placeholder="Search logs..." oninput="applyActivityFilters()">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="au-timeline" id="fullActivityLogList" style="padding-left: 28px;">
                        <div class="au-empty">Loading history…</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.bento-wrap { padding: 20px 24px 40px; }

.bento {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    grid-auto-rows: auto;
}
/* ─── Hero Banner (incharge-style) ─── */
.hero-banner {
    grid-column: span 4;
    position: relative;
    background: #fff;
    border-radius: 22px;
    border: 1.5px solid #e8edf5;
    display: flex;
    flex-wrap: wrap; /* Allow stacking on small screens */
    align-items: stretch;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(99,102,241,0.07);
}
.hero-dots {
    position: absolute; inset: 0;
    background-image: radial-gradient(circle, #c7d2fe 1px, transparent 1px);
    background-size: 22px 22px;
    opacity: 0.45;
    pointer-events: none;
    border-radius: 22px;
}
.hero-left {
    flex: 1;
    padding: 28px 32px;
    position: relative; z-index: 1;
}
.hero-tag {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 20px;
    background: #eef2ff; color: #6366f1;
    font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.05em;
    margin-bottom: 12px;
}
.hero-tag svg { width: 13px; height: 13px; }
.hero-title {
    font-size: 1.55rem; font-weight: 900; color: #1e1b4b;
    letter-spacing: -0.035em; line-height: 1.1; margin-bottom: 8px;
}
.hero-desc {
    font-size: 0.82rem; color: #64748b;
    line-height: 1.6; max-width: 480px; margin-bottom: 20px;
}
.hero-meta { display: flex; align-items: center; gap: 20px; }
.hero-meta-item { display: flex; align-items: center; gap: 10px; }
.hmi-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #eef2ff;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.hmi-icon svg { width: 16px; height: 16px; color: #6366f1; }
.hmi-icon-green { background: #ecfdf5; }
.hmi-icon-green svg { color: #10b981; }
.hmi-num { display: block; font-size: 1.2rem; font-weight: 900; color: #1e1b4b; line-height: 1; }
.hmi-num-green { color: #059669; }
.hmi-label { display: block; font-size: 0.63rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }
.hero-meta-divider { width: 1px; height: 36px; background: #e2e8f0; }
.hero-right {
    width: 280px; flex-shrink: 0;
    background: linear-gradient(145deg, #f5f3ff 0%, #ede9fe 100%);
    border-left: 1.5px solid #e0e7ff;
    display: flex; align-items: center; justify-content: center;
    padding: 24px; position: relative; z-index: 1;
    min-width: 280px;
}
.hero-clock-card { width: 100%; text-align: center; }
.hcc-label {
    font-size: 0.7rem; font-weight: 700; color: #4f46e5;
    text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;
}
.hcc-time { font-size: 2.6rem; font-weight: 900; color: #1e1b4b; letter-spacing: 2px; line-height: 1; font-variant-numeric: tabular-nums; }
.hcc-secs { font-size: 0.85rem; font-weight: 700; color: #818cf8; font-variant-numeric: tabular-nums; }
.hcc-date { font-size: 0.75rem; color: #6366f1; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-top: 10px; }

/* ─── Compact Stat Row ─── */
.stat-row {
    grid-column: span 4;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
.stat-mini {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px;
    background: #fff; border-radius: 14px;
    border: 1.5px solid #e8edf5;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}
.stat-mini:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.05); border-color: #cbd5e1; }
.sm-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.stat-mini:hover .sm-icon { transform: scale(1.15) rotate(5deg); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.sm-icon svg { width: 17px; height: 17px; transition: all 0.3s; }
.stat-mini:hover .sm-icon svg { transform: scale(1.1); }

.sm-num { font-size: 1.3rem; font-weight: 900; color: #0f172a; line-height: 1; letter-spacing: -0.02em; }
.sm-label { font-size: 0.62rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 1px; }

.stat-indigo { border-color: #e0e7ff; }
.stat-indigo:hover { border-color: #a5b4fc; }
.stat-indigo .sm-icon { background: #eef2ff; color: #6366f1; }

.stat-amber { border-color: #fef3c7; }
.stat-amber:hover { border-color: #fcd34d; }
.stat-amber .sm-icon { background: #fffbeb; color: #d97706; }

.stat-emerald { border-color: #d1fae5; }
.stat-emerald:hover { border-color: #6ee7b7; }
.stat-emerald .sm-icon { background: #ecfdf5; color: #059669; }

.stat-rose { border-color: #ffe4e6; }
.stat-rose:hover { border-color: #fda4af; }
.stat-rose .sm-icon { background: #fff1f2; color: #e11d48; }

.stat-purple { border-color: #f3e8ff; }
.stat-purple:hover { border-color: #d8b4fe; }
.stat-purple .sm-icon { background: #faf5ff; color: #9333ea; }

@keyframes blink { 0%,100%{opacity:1}50%{opacity:.3} }

/* ─── Tile Base ─── */
.tile {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    overflow: hidden;
    position: relative;
}
.tile:hover { border-color: #cbd5e1; box-shadow: 0 4px 20px rgba(0,0,0,0.04); }

/* ─── Chart ─── */
.tile-chart {
    grid-column: span 2;
    background: #fff; border: 1px solid #e2e8f0;
}
.tile-full {
    grid-column: span 4;
}
.tc-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.tc-title { font-size: 0.95rem; font-weight: 800; color: #0f172a; }
.tc-sub { font-size: 0.72rem; color: #94a3b8; margin-top: 2px; }
.tc-pills { display: flex; background: #f1f5f9; padding: 3px; border-radius: 10px; border: 1px solid #e2e8f0; }
.tc-pill {
    padding: 6px 16px; border: none; background: transparent;
    font-size: 0.7rem; font-weight: 700; color: #94a3b8; border-radius: 8px;
    cursor: pointer; transition: all 0.25s; font-family: 'Inter';
}
.tc-pill.active { background: #6366f1; color: #fff; box-shadow: 0 2px 12px rgba(99,102,241,0.35); }
.tc-pill:hover:not(.active) { color: #64748b; background: #f8fafc; }
.tc-canvas { height: 280px; }

/* ─── Actions ─── */
.tile-actions {
    grid-column: span 2;
    background: #fff; border: 1px solid #e2e8f0;
    padding: 24px;
    display: flex; flex-direction: column;
}
.ta-title { font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; }
.ta-grid { 
    display: flex; 
    flex-direction: column;
    gap: 12px; 
    flex: 1;
}
.ta-btn {
    display: flex; flex-direction: row; align-items: center; gap: 16px;
    padding: 16px 20px; border-radius: 16px;
    background: #f8fafc; border: 1.5px solid #f1f5f9;
    text-decoration: none; transition: all 0.3s;
    flex: 1; /* Stretch to fill vertical space */
}
.ta-btn:hover { transform: translateX(6px); border-color: #6366f1; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: #fff; }
.ta-ico {
    width: 42px; height: 42px; border-radius: 12px;
    background: #fff; color: var(--ac);
    display: flex; align-items: center; justify-content: center;
    transition: all 0.3s; border: 1.5px solid #f1f5f9;
}
.ta-ico svg { width: 20px; height: 20px; stroke-width: 2.2; }
.ta-btn:hover .ta-ico { transform: scale(1.1); box-shadow: 0 4px 12px var(--ag); border-color: var(--ac); }
.ta-btn span { font-size: 0.85rem; font-weight: 800; color: #475569; }
.ta-btn:hover span { color: #1e1b4b; }

/* ─── Activity Timeline ─── */
.tile-audit {
    grid-column: span 2;
    background: #fff; border: 1px solid #e2e8f0;
}
.au-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.au-head-actions { display: flex; align-items: center; gap: 10px; }
.au-live {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px;
    background: #ecfdf5; border: 1px solid #bbf7d0;
    font-size: 0.68rem; font-weight: 800; color: #059669;
    text-transform: uppercase; letter-spacing: 0.04em;
}
.au-btn-list {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 10px;
    background: #fff; border: 1.5px solid #e2e8f0;
    font-size: 0.7rem; font-weight: 700; color: #64748b;
    cursor: pointer; transition: all 0.2s;
    text-decoration: none;
}
.au-btn-list:hover { background: #f8fafc; border-color: #6366f1; color: #6366f1; transform: translateY(-1px); }
.au-btn-list svg { width: 14px; height: 14px; }
.au-dot { width: 6px; height: 6px; border-radius: 50%; background: #059669; box-shadow: 0 0 6px rgba(5,150,105,0.4); animation: blink 1.2s infinite; }
.au-timeline {
    display: flex; flex-direction: column; gap: 0;
    max-height: 380px; overflow-y: auto; padding-left: 28px;
    position: relative;
}
.au-timeline::before {
    content: ''; position: absolute; left: 14px; top: 8px; bottom: 8px;
    width: 2px; background: linear-gradient(to bottom, #e0e7ff, #f1f5f9);
    border-radius: 2px;
}
.au-timeline::-webkit-scrollbar { width: 3px; }
.au-timeline::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.au-entry {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 12px 16px 12px 22px; position: relative;
    transition: all 0.2s; border-radius: 12px; margin: 1px 0;
}
.au-entry:hover { background: #f8fafc; }
.au-entry::before {
    content: ''; position: absolute; left: -20px; top: 18px;
    width: 10px; height: 10px; border-radius: 50%;
    border: 2px solid #fff; box-shadow: 0 0 0 1px #e2e8f0;
    z-index: 1;
}
.au-entry.e-login::before { background: #059669; }
.au-entry.e-create::before { background: #6366f1; }
.au-entry.e-update::before { background: #d97706; }
.au-entry.e-delete::before { background: #e11d48; }
.au-entry.e-bulk::before { background: #9333ea; }
.au-av { flex-shrink: 0; }
.au-av img { width: 36px; height: 36px; border-radius: 10px; object-fit: cover; border: 2px solid #e2e8f0; }
.au-body { flex: 1; min-width: 0; }
.au-act { font-size: 0.78rem; font-weight: 700; color: #0f172a; line-height: 1.4; }
.au-act b { color: #6366f1; font-weight: 700; }
.au-meta { display: flex; align-items: center; gap: 8px; margin-top: 3px; flex-wrap: wrap; }
.au-tag {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 8px; border-radius: 6px;
    font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em;
}
.t-login { background: #ecfdf5; color: #059669; }
.t-create { background: #eef2ff; color: #6366f1; }
.t-update { background: #fffbeb; color: #d97706; }
.t-delete { background: #fff1f2; color: #e11d48; }
.t-bulk { background: #faf5ff; color: #9333ea; }
.au-det { font-size: 0.66rem; color: #64748b; font-weight: 500; }
.au-tm { font-size: 0.7rem; font-weight: 700; color: #64748b; }
.au-tm-full { font-size: 0.68rem; font-weight: 600; color: #94a3b8; margin-left: auto; }
.au-empty { text-align: center; color: #94a3b8; padding: 40px; font-weight: 600; }

/* ═══════ RESPONSIVE ═══════ */
@media (max-width: 1400px) {
    .stat-row { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1200px) {
    .bento { grid-template-columns: repeat(2, 1fr); }
    .hero-banner { grid-column: span 2; }
    .stat-row { grid-column: span 2; grid-template-columns: repeat(2, 1fr); }
    .stat-row .stat-mini:last-child { grid-column: span 1; }
    .tile-chart, .tile-audit, .tile-actions { grid-column: span 2; }
}
@media (max-width: 900px) {
    .hero-banner { flex-direction: column; }
    .hero-right { width: 100%; border-left: none; border-top: 1.5px solid #e0e7ff; padding: 40px 24px; min-width: unset; }
    .hero-left { padding: 32px 24px; }
    .hero-title { font-size: 1.4rem; }
    .hero-meta { flex-wrap: wrap; gap: 15px; }
    .hero-meta-divider { display: none; }
    .stat-row { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .bento { grid-template-columns: 1fr !important; gap: 12px; }
    .hero-banner, .stat-row, .tile-chart, .tile-actions, .tile-audit { grid-column: span 1 !important; }
    .stat-row { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .stat-mini { padding: 14px; gap: 10px; }
    .sm-num { font-size: 1.2rem; }
    .sm-icon { width: 34px; height: 34px; }
    .ta-grid { grid-template-columns: 1fr; }
    .bento-wrap { padding: 12px 14px; }
    .tc-head { flex-direction: column; align-items: flex-start; gap: 12px; }
    .tc-pills { width: 100%; justify-content: space-between; }
    .tc-pill { flex: 1; text-align: center; padding: 6px 0; }
    .hero-title { font-size: 1.3rem; }
    .hero-desc { font-size: 0.8rem; margin-bottom: 24px; }
    .hero-meta { justify-content: space-between; width: 100%; }
    .hero-meta-item { flex: 1; }
    .hmi-num { font-size: 1.1rem; }
    .tile-audit { max-height: 500px; }
    .au-timeline { max-height: 400px; }
    .au-tm-full { display: none; }
}

@media (max-width: 480px) {
    .stat-row { grid-template-columns: 1fr; }
    .hero-meta { flex-direction: column; align-items: flex-start; gap: 16px; }
}

    /* ── Modal Backdrop ── */
    .modal-backdrop {
        position: fixed; inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000; opacity: 0; pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .modal-backdrop.open { opacity: 1; pointer-events: auto; }

    .modal-sheet {
        background: #fff; width: 94%; max-width: 900px;
        height: 80vh; border-radius: 24px; overflow: hidden;
        box-shadow: 0 32px 80px -12px rgba(0,0,0,0.25);
        transform: scale(0.95) translateY(24px);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex; auto;
    }
    .modal-backdrop.open .modal-sheet { transform: scale(1) translateY(0); }

    /* ── Modal (split-panel, indigo) ── */
    .modal-panel { width:240px; flex-shrink:0; background:linear-gradient(160deg,#eef2ff 0%,#e0e7ff 60%,#c7d2fe 100%); padding:36px 24px 28px; display:flex; flex-direction:column; align-items:center; position:relative; overflow:hidden; border-right:1px solid #c7d2fe; }
    .modal-panel::before { content:''; position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(99,102,241,0.15); top:-60px; right:-60px; }
    .modal-panel::after { content:''; position:absolute; width:140px; height:140px; border-radius:50%; background:rgba(99,102,241,0.1); bottom:40px; left:-40px; }
    .panel-avatar { width:76px; height:76px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#4f46e5); border:4px solid #fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:900; color:#fff; position:relative; z-index:1; box-shadow:0 8px 24px rgba(99,102,241,0.3); }
    .panel-name { font-size:0.9rem; font-weight:700; color:#1e1b4b; text-align:center; margin-top:14px; line-height:1.35; position:relative; z-index:1; }
    .panel-role { font-size:0.68rem; color:#4f46e5; text-align:center; margin-top:4px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; position:relative; z-index:1; }
    .panel-stat-wrap { margin-top:20px; background:rgba(255,255,255,0.7); border:1.5px solid rgba(99,102,241,0.4); border-radius:12px; padding:11px 16px; display:flex; align-items:center; justify-content:center; gap:8px; width:100%; position:relative; z-index:1; }
    .ps-num { font-size:1.1rem; font-weight:800; color:#1e1b4b; }
    .ps-label { font-size:0.75rem; color:#1e1b4b; font-weight:600; }
    .panel-divider { width:100%; height:1px; background:rgba(99,102,241,0.25); margin:20px 0; position:relative; z-index:1; }
    .panel-filters { width:100%; position:relative; z-index:1; }
    .pf-label { display:block; font-size:0.65rem; color:#6366f1; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px; }
    .pf-input-wrap { position:relative; background:rgba(255,255,255,0.75); border:1.5px solid rgba(99,102,241,0.4); border-radius:12px; display:flex; align-items:center; padding:0 12px; transition:all 0.2s; }
    .pf-input-wrap:focus-within { border-color:#6366f1; background:#fff; box-shadow:0 0 0 4px rgba(99,102,241,0.1); }
    .pf-input-wrap svg { width:14px; height:14px; color:#6366f1; flex-shrink:0; }
    .pf-input-wrap select, .pf-input-wrap input { flex:1; border:none; outline:none; background:transparent; padding:10px 8px; font-size:0.78rem; color:#1e1b4b; font-family:'Inter',sans-serif; cursor:pointer; min-width:0; }
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

    /* ── Dark Mode (Modal Overrides) ── */
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
    body.dark-mode .pf-input-wrap { background: rgba(15,23,42,0.4); border-color: #334155; }
    body.dark-mode .pf-input-wrap input, body.dark-mode .pf-input-wrap select { color: #f1f5f9; color-scheme: dark; }
    body.dark-mode .pf-input-wrap select option { background: #0f172a; color: #fff; }
    body.dark-mode .pf-input-wrap svg { color: #818cf8; }
    body.dark-mode .panel-close-btn { background: rgba(30,41,59,0.5); border-color: #334155; color: #cbd5e1; }
    body.dark-mode .panel-close-btn:hover { background: rgba(239,68,68,0.1); border-color: #f87171; color: #f87171; }
    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #111827; border-bottom: 1px solid #1e293b; }
    body.dark-mode .mm-title { color: #f1f5f9; }
    body.dark-mode .mm-search { background: #1e293b; }
    body.dark-mode .mm-search input { color: #f1f5f9; }
    body.dark-mode .mm-search svg { color: #64748b; }
    body.dark-mode .modal-body::-webkit-scrollbar-thumb { background: #334155; }

    .modal-body { flex: 1; overflow-y: auto; padding: 24px; scrollbar-width: thin; }
    .modal-body::-webkit-scrollbar { width: 5px; }
    .modal-body::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    @media (max-width: 768px) {
        .modal-sheet { width: 100%; height: 100vh; border-radius: 0; flex-direction: column; max-height: none; overflow-y: auto; }
        .modal-panel { width: 100%; flex-shrink: 0; padding: 24px 20px; flex-direction: column; align-items: center; gap: 4px; border-right: none; border-bottom: 1px solid #c7d2fe; position: relative; }
        .modal-main { flex: none; overflow-y: visible; }
        .modal-panel::before, .modal-panel::after { display: none; }
        .panel-avatar { width: 64px; height: 64px; font-size: 1.2rem; margin-bottom: 4px; }
        .panel-name { font-size: 1rem; margin-top: 8px; text-align: center; }
        .panel-role, .panel-divider { display: none; }
        .panel-stat-wrap { margin-top: 0; padding: 11px 20px; width: 100%; }
        .ps-num { font-size: 1.1rem; }
        .panel-filters { display: flex; flex-direction: column; gap: 12px; width: 100%; margin-top: 20px; }
        .pf-label { display: block; margin-bottom: 4px; }
        .pf-input-wrap { width: 100%; }
        .panel-close-btn { margin-top: 12px; width: 100%; padding: 11px; border-radius: 12px; position: static; height: auto; font-size: 0.8rem; }
        .panel-close-btn svg { width: 16px; height: 16px; margin-right: 6px; }
        
        .modal-main-header { flex-direction: column; align-items: stretch; gap: 8px; padding: 12px 16px; }
        .mm-search { width: 100%; }
        .mm-search input { width: 100%; }
        body.dark-mode .modal-panel { border-bottom-color: #1e293b; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clock
    function tick(){
        const n=new Date();
        document.getElementById('bTime').textContent=n.toLocaleTimeString('en-US',{hour12:true,hour:'2-digit',minute:'2-digit'}).replace(/\s?[APM]{2}$/, '');
        document.getElementById('bSecs').textContent=':'+String(n.getSeconds()).padStart(2,'0') + ' ' + (n.getHours() >= 12 ? 'PM' : 'AM');
        document.getElementById('bDate').textContent=n.toLocaleDateString('en-US',{weekday:'long',month:'long',day:'numeric',year:'numeric'});
    }
    setInterval(tick,1000);tick();

    // Stats
    function loadStats(){
        fetch('{{ url("/api/dashboard/stats") }}').then(r=>r.json()).then(d=>{
            // Hero banner stats
            cUp('totalRecords',d.total_records);
            document.getElementById('todayRecords').textContent=d.today_records;
            // Mini stat cards
            cUp('totalEmployees',d.total_employees);
            cUp('totalSchools',d.total_schools);
            cUp('totalPositions',d.total_positions);
            cUp('totalLeaveTypes',d.total_types_of_leave);
        });
    }
    function cUp(id,end){
        const el=document.getElementById(id);let c=0;if(!end){el.textContent='0';return;}
        const s=Math.ceil(end/20);
        const t=setInterval(()=>{c+=s;if(c>=end){c=end;clearInterval(t);}el.textContent=c.toLocaleString();},30);
    }
    loadStats();setInterval(loadStats,300000);

    // Usage Chart
    let usageCh = null;
    window.updateUsageChart = function(p, btn) {
        if(btn) {
            document.querySelectorAll('.tc-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        fetch(`{{ url("/api/dashboard/module-usage") }}?period=${p}`).then(r => r.json()).then(data => {
            if(usageCh) usageCh.destroy();
            const ctx = document.getElementById('moduleUsageChart').getContext('2d');
            
            // Get unique actions and time keys
            const actions = [...new Set(data.map(i => i.action))];
            let timeKeys = [];
            if (p === 'day') for(let i=0; i<24; i++) timeKeys.push(i);
            else if (p === 'month') for(let i=1; i<=31; i++) timeKeys.push(i);
            else for(let i=1; i<=12; i++) timeKeys.push(i);

            const colors = {
                'Created': { start: '#6366f1', end: 'rgba(99,102,241,0)' },
                'Updated': { start: '#f59e0b', end: 'rgba(245,158,11,0)' },
                'Deleted': { start: '#ef4444', end: 'rgba(239,68,68,0)' },
                'Logged in': { start: '#10b981', end: 'rgba(16,185,129,0)' },
                'default': { start: '#8b5cf6', end: 'rgba(139,92,246,0)' }
            };

            const datasets = actions.map(action => {
                const config = colors[Object.keys(colors).find(k => action.includes(k))] || colors.default;
                
                // Map data to timeKeys (fill zeros)
                const seriesData = timeKeys.map(tk => {
                    const match = data.find(i => i.action === action && i.time_key == tk);
                    return match ? match.total : 0;
                });

                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, config.start + '55');
                gradient.addColorStop(1, config.end);

                return {
                    label: action,
                    data: seriesData,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: config.start,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: config.start,
                    pointHoverRadius: 5,
                    pointRadius: 2,
                    tension: 0.4, // Smooth curves
                };
            });

            usageCh = new Chart(ctx, {
                type: 'line',
                data: { labels: timeKeys, datasets },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { 
                            display: true, position: 'top', align: 'end',
                            labels: { boxWidth: 6, usePointStyle: true, font: { family: 'Inter', size: 10, weight: 600 }, color: '#94a3b8' }
                        },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            padding: 12,
                            cornerRadius: 12,
                            titleFont: { family: 'Inter', size: 12, weight: 800 },
                            bodyFont: { family: 'Inter', size: 11 },
                            usePointStyle: true
                        }
                    },
                    scales: {
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { family: 'Inter', size: 10, weight: 600 }, color: '#94a3b8', stepSize: 1 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 10, weight: 600 }, color: '#64748b',
                                callback: function(value, index) {
                                    const val = timeKeys[index];
                                    if (p === 'day') {
                                        const h = val % 12 || 12;
                                        const ampm = val >= 12 ? 'PM' : 'AM';
                                        return h + ampm;
                                    }
                                    if (p === 'month') return index % 5 === 0 ? 'D' + val : '';
                                    const m = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                                    return m[val - 1] || val;
                                }
                            }
                        }
                    }
                }
            });
        });
    };
    updateUsageChart('day');

    // Productivity Chart (Horizontal Bar)
    let prodCh = null;
    window.updateProdChart = function(p, btn) {
        if(btn) {
            btn.closest('.tc-pills').querySelectorAll('.tc-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        fetch(`{{ url("/api/dashboard/incharge-stats") }}?period=${p}`).then(r => r.json()).then(data => {
            if(prodCh) prodCh.destroy();
            const ctx = document.getElementById('prodChart').getContext('2d');
            
            const labels = data.map(i => '@' + i.incharge);
            const values = data.map(i => i.total_count);
            
            prodCh = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Records',
                        data: values,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(chartArea.left, 0, chartArea.right, 0);
                            gradient.addColorStop(0, '#6366f122');
                            gradient.addColorStop(1, '#6366f1ee');
                            return gradient;
                        },
                        borderColor: '#6366f1',
                        borderWidth: 1.5,
                        borderRadius: 30, // Fully rounded caps
                        borderSkipped: false,
                        barThickness: 18,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            padding: 12,
                            cornerRadius: 12,
                            titleFont: { family: 'Inter', size: 12, weight: 800 },
                            bodyFont: { family: 'Inter', size: 11 },
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { display: true, color: document.body.classList.contains('dark-mode') ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.03)' },
                            ticks: { display: false }
                        },
                        y: {
                            grid: { display: false },
                            border: { display: true, color: document.body.classList.contains('dark-mode') ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)' },
                            ticks: { 
                                font: { family: 'Inter', size: 11, weight: 700 }, 
                                color: document.body.classList.contains('dark-mode') ? '#94a3b8' : '#475569',
                                padding: 10
                            }
                        }
                    },
                    layout: {
                        padding: { right: 40 }
                    }
                },
                plugins: [{
                    id: 'valueLabels',
                    afterDraw: (chart) => {
                        const { ctx, data } = chart;
                        ctx.save();
                        data.datasets.forEach((dataset, i) => {
                            chart.getDatasetMeta(i).data.forEach((bar, index) => {
                                const isDark = document.body.classList.contains('dark-mode');
                                const val = dataset.data[index];
                                ctx.font = '700 11px Inter';
                                ctx.fillStyle = isDark ? '#f1f5f9' : '#6366f1';
                                ctx.textAlign = 'left';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(val + (val === 1 ? ' record' : ' records'), bar.x + 10, bar.y);
                            });
                        });
                        ctx.restore();
                    }
                }]
            });
        });
    };
    updateProdChart('day');

    // Remark Chart (Doughnut)
    let remarkCh = null;
    window.updateRemarkChart = function(p, btn) {
        if(btn) {
            btn.closest('.tc-pills').querySelectorAll('.tc-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        fetch(`{{ url("/api/dashboard/remark-stats") }}?period=${p}`).then(r => r.json()).then(data => {
            if(remarkCh) remarkCh.destroy();
            const ctx = document.getElementById('remarkChart').getContext('2d');
            
            const labels = ['With Pay', 'Without Pay', 'With Pay & Without Pay'];
            const colors = ['#10b981', '#ef4444', '#8b5cf6'];
            
            // Map data to ensure all labels exist even if count is 0
            const values = labels.map(label => {
                const match = data.find(i => i.remarks === label);
                return match ? match.total : 0;
            });

            const total = values.reduce((a, b) => a + b, 0);

            remarkCh = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        hoverBackgroundColor: colors,
                        borderWidth: 0,
                        borderRadius: 10,
                        spacing: 8,
                        hoverOffset: 20
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                padding: 25,
                                usePointStyle: true,
                                boxWidth: 8,
                                font: { family: 'Inter', size: 10, weight: 600 },
                                color: '#64748b'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            padding: 12,
                            cornerRadius: 12,
                            titleFont: { family: 'Inter', size: 12, weight: 800 },
                            bodyFont: { family: 'Inter', size: 11 },
                            usePointStyle: true
                        }
                    }
                },
                plugins: [{
                    id: 'centerText',
                    beforeDraw: (chart) => {
                        const { ctx, width, height } = chart;
                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        
                        const isDark = document.body.classList.contains('dark-mode');
                        
                        // Main Number
                        ctx.font = '800 24px Inter';
                        ctx.fillStyle = isDark ? '#ffffff' : '#1e1b4b';
                        ctx.fillText(total, width / 2, height / 2 - 5);
                        
                        // Label
                        ctx.font = '600 10px Inter';
                        ctx.fillStyle = isDark ? '#94a3b8' : '#64748b';
                        ctx.fillText('RECORDS', width / 2, height / 2 + 15);
                        ctx.restore();
                    }
                }]
            });
        });
    };
    updateRemarkChart('day');

    // Activity Timeline
    function timeAgo(date){
        const s=Math.floor((Date.now()-date)/1000);
        if(s<60) return 'just now';
        if(s<3600) return Math.floor(s/60)+'m ago';
        if(s<86400) return Math.floor(s/3600)+'h ago';
        if(s<604800) return Math.floor(s/86400)+'d ago';
        return date.toLocaleDateString('en-US',{month:'short',day:'numeric'});
    }
    let activityLogs = [];
    function loadAudit(limit = 15, containerId = 'auditLogList', todayOnly = false){
        const container = document.getElementById(containerId);
        let url = `{{ url("/api/dashboard/audit-logs") }}?limit=${limit}`;
        if (todayOnly) url += '&today=1';
        
        fetch(url).then(r=>r.json()).then(logs=>{
            if (containerId === 'fullActivityLogList') {
                activityLogs = logs;
                if (typeof populateUserFilter === 'function') populateUserFilter(logs);
                applyActivityFilters();
            } else {
                renderLogs(logs, container);
            }
        });
    }

    function renderLogs(logs, container) {
        if (container.id === 'fullActivityLogList') {
            const countEl = document.getElementById('modalHistoryCount');
            if (countEl) countEl.textContent = logs.length;
        }
        if(!logs.length){container.innerHTML='<div class="au-empty">No matching activity</div>';return;}
        container.innerHTML = logs.map(l => {
            const t = new Date(l.created_at);
            const ago = timeAgo(t);
            let tcls = 't-create', tag = 'Created';
            let icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>';
            
            if (l.action.includes('Updated')) { tcls='t-update'; tag='Updated'; icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>'; }
            else if (l.action.includes('Deleted')) { tcls='t-delete'; tag='Deleted'; icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>'; }
            else if (l.action.includes('Bulk')) { tcls='t-bulk'; tag='Bulk'; icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>'; }

            const eCls = tcls.replace('t-', 'e-');
            const user = l.user ? l.user.username : 'system';
            const av=l.user&&l.user.profile_image?`/storage/${l.user.profile_image}`:`https://ui-avatars.com/api/?name=${encodeURIComponent(user)}&background=eef2ff&color=6366f1&bold=true&size=64`;

            return `
            <div class="au-entry ${eCls}">
                <div class="au-av"><img src="${av}"></div>
                <div class="au-body">
                    <div class="au-act"><b>@${user}</b> ${l.action}</div>
                    <div class="au-meta">
                        <span class="au-tag ${tcls}">${tag}</span>
                        ${l.details?`<span class="au-det">${l.details}</span>`:''}
                        <span class="au-tm">${ago}</span>
                        <div class="au-tm-full">${t.toLocaleDateString()} at ${t.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    function populateUserFilter(logs) {
        const select = document.getElementById('actUserFilter');
        const currentVal = select.value;
        const users = [...new Set(logs.map(l => l.user ? l.user.username : 'system'))].sort();
        
        let html = '<option value="all">All Users</option>';
        users.forEach(u => {
            html += `<option value="${u}">@${u}</option>`;
        });
        select.innerHTML = html;
        select.value = currentVal;
    }

    window.applyActivityFilters = function() {
        const userVal = document.getElementById('actUserFilter').value;
        const dateVal = document.getElementById('actDateFilter').value;
        const searchVal = (document.getElementById('actSearchInput') ? document.getElementById('actSearchInput').value : '').toLowerCase();
        
        let filtered = activityLogs;
        
        if (userVal !== 'all') {
            filtered = filtered.filter(l => (l.user ? l.user.username : 'system') === userVal);
        }
        
        if (dateVal) {
            filtered = filtered.filter(l => {
                const logDate = new Date(l.created_at).toISOString().split('T')[0];
                return logDate === dateVal;
            });
        }

        if (searchVal) {
            filtered = filtered.filter(l => {
                return (l.action || '').toLowerCase().includes(searchVal) || 
                       (l.details || '').toLowerCase().includes(searchVal) ||
                       (l.user ? l.user.username : 'system').toLowerCase().includes(searchVal);
            });
        }
        
        renderLogs(filtered, document.getElementById('fullActivityLogList'));
    };

    window.openActivityModal = function() {
        document.getElementById('activityLogsModal').classList.add('open');
        document.body.style.overflow = 'hidden';
        
        // Default to today's date in the filter
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('actDateFilter').value = today;
        
        loadAudit(100, 'fullActivityLogList');
    };

    window.closeActivityModal = function() {
        document.getElementById('activityLogsModal').classList.remove('open');
        document.body.style.overflow = '';
    };

    window.handleBackdropClick = function(e) {
        if (e.target.classList.contains('modal-backdrop')) closeActivityModal();
    };

    // Close on Esc
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('activityLogsModal');
            if (modal.classList.contains('open')) closeActivityModal();
        }
    });

    loadAudit(15, 'auditLogList', true);setInterval(()=>loadAudit(15, 'auditLogList', true),60000);
});
</script>
</body>
</html>
