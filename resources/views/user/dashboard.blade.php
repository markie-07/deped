<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard - DepEd Manager</title>
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
    @include('partials.user-sidebar')
    <main class="main-content">
        @include('partials.navigation')
        <div class="bento-wrap">
            <div class="bento">

                <!-- HERO BANNER -->
                <div class="hero-banner">
                    <div class="hero-dots"></div>
                    <div class="hero-left">
                        <div class="hero-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            User Dashboard
                        </div>
                        <h1 class="hero-title">Welcome back, {{ Auth::user()->first_name ?? Auth::user()->username ?? 'User' }}</h1>
                        <p class="hero-desc">Your personal overview and activity at a glance. Manage your forms and view system history.</p>
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
                    <div class="stat-mini stat-rose">
                        <div class="sm-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg></div>
                        <div class="sm-info">
                            <div class="sm-num" id="totalRemarks">0</div>
                            <div class="sm-label">Remarks</div>
                        </div>
                    </div>
                </div>

                <!-- MODULE USAGE CHART (Full Width) -->
                <div class="tile tile-chart tile-full">
                    <div class="tc-head">
                        <div>
                            <div class="tc-title">My Usage Trends</div>
                            <div class="tc-sub">My system activity patterns</div>
                        </div>
                        <div class="tc-pills">
                            <button class="tc-pill active" onclick="updateUsageChart('day',this)">Day</button>
                            <button class="tc-pill" onclick="updateUsageChart('month',this)">Month</button>
                            <button class="tc-pill" onclick="updateUsageChart('year',this)">Year</button>
                        </div>
                    </div>
                    <div class="tc-canvas"><canvas id="moduleUsageChart"></canvas></div>
                </div>

                <!-- REMARK STATS (Doughnut) -->
                <div class="tile tile-chart">
                    <div class="tc-head">
                        <div>
                            <div class="tc-title">My Remarks</div>
                            <div class="tc-sub">Leave payment distribution</div>
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
                            <div class="tc-title">My Activity</div>
                            <div class="tc-sub">Today's transactions</div>
                        </div>
                        <div class="au-head-actions">
                            <div class="au-live"><span class="au-dot"></span>Live</div>
                            <button class="au-btn-list" onclick="openActivityModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                                View History
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
                        <a href="{{ url('/user/form') }}" class="ta-btn" style="--ac:#818cf8;--ag:rgba(99,102,241,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg></div>
                            <span>New Record</span>
                        </a>
                        <a href="{{ url('/user/leave-records') }}" class="ta-btn" style="--ac:#34d399;--ag:rgba(5,150,105,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg></div>
                            <span>History</span>
                        </a>
                        <a href="{{ url('/user/profile') }}" class="ta-btn" style="--ac:#fb7185;--ag:rgba(225,29,72,0.25)">
                            <div class="ta-ico"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg></div>
                            <span>My Profile</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ACTIVITY LOGS MODAL -->
    <div id="activityLogsModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-header-container" style="width: 100%;">
                    <div class="modal-header-top" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div class="modal-icon-box">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:20px; height:20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div class="modal-title">My Activity History</div>
                        </div>
                        <button class="modal-close" onclick="closeActivityModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="modal-header-bottom" style="display: flex; align-items: center; gap: 12px; padding: 12px 0 0; border-top: 1px solid #f1f5f9;">
                        <!-- User filter removed for users as they only see themselves -->
                        <div class="filter-group" style="display: flex; align-items: center; gap: 8px;">
                            <span class="filter-label" style="font-size: 0.65rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Date:</span>
                            <input type="date" id="actDateFilter" class="act-filter-input" onchange="applyActivityFilters()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="au-timeline" id="fullActivityLogList" style="padding-left: 28px;">
                    <div class="au-empty">Loading history…</div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-done" onclick="closeActivityModal()">Done</button>
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
/* ─── Hero Banner ─── */
.hero-banner {
    grid-column: span 4;
    position: relative;
    background: #fff;
    border-radius: 22px;
    border: 1.5px solid #e8edf5;
    display: flex;
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
    line-height: 1.6; max-width: 420px; margin-bottom: 20px;
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
    grid-template-columns: repeat(5, 1fr);
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
    grid-column: span 4;
    background: #fff; border: 1px solid #e2e8f0;
    padding: 24px;
}
.ta-title { font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; }
.ta-grid { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); 
    gap: 16px; 
}
.ta-btn {
    display: flex; flex-direction: row; align-items: center; gap: 16px;
    padding: 16px 20px; border-radius: 16px;
    background: #f8fafc; border: 1.5px solid #f1f5f9;
    text-decoration: none; transition: all 0.3s;
}
.ta-btn:hover { transform: translateY(-4px); border-color: #6366f1; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: #fff; }
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

@media (max-width: 900px) {
    .ta-grid { grid-template-columns: 1fr; }
}

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
    .stat-row .stat-mini:last-child { grid-column: span 2; }
    .tile-chart { grid-column: span 2; }
    .tile-audit { grid-column: span 2; }
    .tile-actions { grid-column: span 2; }
}
@media (max-width: 768px) {
    .bento { grid-template-columns: 1fr; }
    .hero-banner { grid-column: span 1; flex-direction: column; }
    .hero-right { width: 100%; border-left: none; border-top: 1.5px solid #e0e7ff; }
    .stat-row { grid-column: span 1; grid-template-columns: repeat(2, 1fr); }
    .stat-row .stat-mini:last-child { grid-column: span 2; }
    .tile-chart, .tile-actions, .tile-audit { grid-column: span 1; }
    .ta-grid { grid-template-columns: repeat(2, 1fr); }
    .bento-wrap { padding: 12px; }
}

/* ── Modal Overlay ── */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s ease;
    backdrop-filter: blur(4px);
}
.modal-overlay.open { opacity: 1; pointer-events: auto; }

.modal-container {
    background: #fff;
    width: 96%;
    max-width: 800px;
    border-radius: 22px;
    transform: translateY(20px);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    border: 1px solid #e2e8f0;
}
.modal-overlay.open .modal-container { transform: translateY(0); }

.modal-header {
    flex-direction: column;
    padding: 20px 28px;
    border-bottom: 1.5px solid #f1f5f9;
    background: #fff;
}
.act-filter-select, .act-filter-input {
    padding: 6px 10px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.75rem;
    font-family: 'Inter';
    color: #1e293b;
    outline: none;
    background: #f8fafc;
}
.act-filter-select:focus, .act-filter-input:focus { border-color: #6366f1; background: #fff; }
.modal-icon-box {
    width: 40px; height: 40px; border-radius: 12px;
    background: #eef2ff; color: #6366f1;
    display: flex; align-items: center; justify-content: center;
}
.modal-title { font-size: 1.1rem; font-weight: 900; color: #1e1b4b; letter-spacing: -0.02em; }
.modal-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid #e2e8f0; background: transparent;
    color: #94a3b8; cursor: pointer; transition: all 0.2s;
    display: flex; align-items: center; justify-content: center;
}
.modal-close:hover { background: #fef2f2; color: #ef4444; border-color: #fecaca; transform: rotate(90deg); }
.modal-body { flex: 1; overflow-y: auto; padding: 24px; scrollbar-width: thin; }
.modal-body::-webkit-scrollbar { width: 5px; }
.modal-body::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.modal-footer { padding: 16px 28px; border-top: 1.5px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: flex-end; }
.btn-done {
    padding: 10px 32px; border-radius: 12px;
    background: #1e1b4b; color: #fff; border: none;
    font-size: 0.85rem; font-weight: 700; cursor: pointer;
    transition: all 0.25s; box-shadow: 0 4px 12px rgba(30,27,75,0.2);
}
.btn-done:hover { background: #6366f1; transform: translateY(-1px); box-shadow: 0 6px 15px rgba(99,102,241,0.3); }
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
            cUp('totalRecords',d.total_records);
            document.getElementById('todayRecords').textContent=d.today_records;
            cUp('totalEmployees',d.total_employees);
            cUp('totalSchools',d.total_schools);
            cUp('totalPositions',d.total_positions);
            cUp('totalLeaveTypes',d.total_types_of_leave);
            cUp('totalRemarks',d.total_remarks);
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
                    tension: 0.4
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
                            titleFont: { family: 'Inter', size: 11, weight: 800 },
                            bodyFont: { family: 'Inter', size: 10 },
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
                            titleFont: { family: 'Inter', size: 11, weight: 800 },
                            bodyFont: { family: 'Inter', size: 10 },
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
                applyActivityFilters();
            } else {
                renderLogs(logs, container);
            }
        });
    }

    function renderLogs(logs, container) {
        if(!logs.length){container.innerHTML='<div class="au-empty">No matching activity</div>';return;}
        container.innerHTML=logs.map(l=>{
            const a=l.action.toLowerCase();
            let ecls='e-create',tag='Created',tcls='t-create';
            if(a.includes('logged')){ecls='e-login';tag='Login';tcls='t-login';}
            else if(a.includes('updated')){ecls='e-update';tag='Updated';tcls='t-update';}
            else if(a.includes('deleted')){ecls='e-delete';tag='Deleted';tcls='t-delete';}
            else if(a.includes('bulk')){ecls='e-bulk';tag='Bulk';tcls='t-bulk';}
            const t=new Date(l.created_at);
            const ago=timeAgo(t);
            const av=l.user&&l.user.profile_image?`/storage/${l.user.profile_image}`:`https://ui-avatars.com/api/?name=${encodeURIComponent(l.user?l.user.username:'S')}&background=eef2ff&color=6366f1&bold=true&size=64`;
            const user=l.user?l.user.username:'system';
            return `<div class="au-entry ${ecls}">
                <div class="au-av"><img src="${av}"></div>
                <div class="au-body">
                    <div class="au-act"><b>@${user}</b> ${l.action.replace(/^[A-Z]/, c=>c.toLowerCase())}</div>
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

    window.applyActivityFilters = function() {
        const dateVal = document.getElementById('actDateFilter').value;
        let filtered = activityLogs;
        
        if (dateVal) {
            filtered = filtered.filter(l => {
                const logDate = new Date(l.created_at).toISOString().split('T')[0];
                return logDate === dateVal;
            });
        }
        
        renderLogs(filtered, document.getElementById('fullActivityLogList'));
    };

    window.openActivityModal = function() {
        document.getElementById('activityLogsModal').classList.add('open');
        document.body.style.overflow = 'hidden';
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('actDateFilter').value = today;
        loadAudit(100, 'fullActivityLogList');
    };

    window.closeActivityModal = function() {
        document.getElementById('activityLogsModal').classList.remove('open');
        document.body.style.overflow = '';
    };

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
