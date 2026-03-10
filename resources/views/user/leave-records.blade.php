<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leave Records - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f1f5f9; color: #1e293b; }
        .batch-header-row { background: #f8fafc !important; height: 30px; border-bottom: 1px solid #e2e8f0; }
        .batch-header-row:hover { background: #f8fafc !important; }
        .batch-header-row td { padding: 0 !important; }
    </style>
</head>
<body>
    @include('partials.user-sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">

            <!-- Page Header -->
            <div class="page-header-card" id="pageHeaderCard">
                <div class="header-left">
                    <div class="header-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="header-title">Leave Records Registry</h2>
                        <p class="header-subtitle">Review and manage all historical leave records</p>
                    </div>
                    <div class="header-stats" id="headerStats">
                        <div class="stat-chip">
                            <span class="stat-dot green"></span>
                            <span class="stat-label">Total</span>
                            <span class="stat-value" id="statTotal">0</span>
                        </div>
                    </div>
                </div>
                <div class="header-filters">
                    <div class="filter-input-wrap search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" id="masterSearch" placeholder="Search records...">
                    </div>
                    <div class="filter-input-wrap date-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <input type="date" id="dateFilter" onchange="fetchMasterRecords()">
                    </div>
                    <div class="filter-input-wrap select-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                        <select id="remarkFilter" onchange="filterRecords()">
                            <option value="all">All Remarks</option>
                            <option value="with pay">With Pay</option>
                            <option value="without pay">Without Pay</option>
                            <option value="with pay & without pay">With Pay & Without Pay</option>
                        </select>
                    </div>
                    <div class="filter-input-wrap select-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <select id="inchargeFilter" onchange="fetchMasterRecords()">
                            <option value="">All Incharge</option>
                        </select>
                    </div>
                    
                    <button class="btn-import-excel" onclick="document.getElementById('excelInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Import Excel</span>
                    </button>
                    <button class="btn-export-excel" onclick="toggleSelectionMode()" id="btnMainExport">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 12 12 16.5m0 0L16.5 12M12 16.5V3" />
                        </svg>
                        <span>Export Excel</span>
                    </button>
                    <input type="file" id="excelInput" hidden accept=".xlsx, .xls" onchange="handleExcelImport(event)">
                </div>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <table class="master-table">
                    <thead>
                        <tr>
                            <th class="col-checkbox" style="display: none;"></th>
                            <th class="col-index">#</th>
                            <th class="col-name">Name</th>
                            <th>Position</th>
                            <th>School</th>
                            <th>Type of Leave</th>
                            <th>Inclusive Dates</th>
                            <th>Remarks</th>
                            <th>Date of Action</th>
                            <th>Deduction Remarks</th>
                            <th>Incharge</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="masterTableBody">
                        <tr>
                            <td colspan="12" class="loading-state">
                                <div class="loading-content">
                                    <div class="spinner"></div>
                                    <p>Loading records...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Export Actions Bar -->
    <div class="export-actions-bar" id="exportBar">
        <div class="selection-info">
            <svg style="width: 18px; height: 18px; vertical-align: middle; margin-right: 4px; color: #818cf8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Selected <span id="selectedCount">0</span> records
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <button class="btn-cancel-selection" onclick="toggleSelectionMode(false)">Cancel</button>
            <button class="btn-download-selected" onclick="downloadSelectedExcel()">
                <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M7 10l5 5m0 0l5-5m-5 5V3" />
                </svg>
                Download Excel
            </button>
        </div>
    </div>

    <!-- Import Preview Modal -->
    <div class="import-modal" id="importModal">
        <div class="import-modal-content">
            <div class="modal-header">
                <div>
                    <h3>Review Excel Data</h3>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Verified <span id="previewCount">0</span> records found in the file.</p>
                </div>
                <button onclick="closeImportModal()" style="background: none; border: none; cursor: pointer; color: #94a3b8;">
                    <svg style="width: 24px; height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>School</th>
                            <th>Type of Leave</th>
                            <th>Inclusive Dates</th>
                            <th>Remarks</th>
                            <th>Date of Action</th>
                            <th>Deduction Remarks</th>
                            <th>Incharge</th>
                        </tr>
                    </thead>
                    <tbody id="previewTableBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn-modal btn-cancel" onclick="closeImportModal()">Cancel</button>
                <button class="btn-modal btn-confirm" id="btnConfirmImport" onclick="confirmImport()">
                    <div class="import-loader"></div>
                    <span>Confirm & Save Records</span>
                </button>
            </div>
        </div>
    </div>

<style>
    /* ═══════════════════════════════════════
       PAGE HEADER CARD
       ═══════════════════════════════════════ */
    .page-header-card {
        background: #fff;
        padding: 20px 28px;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
        position: sticky;
        top: 68px;
        z-index: 30;
        transition: all 0.25s ease;
        gap: 20px;
    }
    .page-header-card.is-stuck {
        box-shadow: 0 8px 32px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
        border-radius: 0 0 16px 16px;
        border-top-color: transparent;
    }

    .header-left { display: flex; align-items: center; gap: 16px; flex-shrink: 0; }

    .header-icon-box {
        width: 46px; height: 46px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        box-shadow: 0 4px 12px -2px rgba(99, 102, 241, 0.5);
        flex-shrink: 0;
    }
    .header-icon-box svg { width: 24px; height: 24px; }

    .header-title {
        font-size: 1.15rem; font-weight: 700; color: #0f172a;
        letter-spacing: -0.02em; line-height: 1.3;
    }
    .header-subtitle { font-size: 0.78rem; color: #94a3b8; margin-top: 1px; }

    /* Stats chip */
    .header-stats { display: flex; gap: 8px; margin-left: 8px; }
    .stat-chip {
        display: flex; align-items: center; gap: 6px;
        padding: 6px 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        font-size: 0.75rem;
    }
    .stat-dot {
        width: 7px; height: 7px; border-radius: 50%;
    }
    .stat-dot.green { background: #22c55e; box-shadow: 0 0 6px rgba(34,197,94,0.4); }
    .stat-label { color: #94a3b8; font-weight: 500; }
    .stat-value { color: #1e293b; font-weight: 700; }

    /* ═══════════════════════════════════════
       FILTER BAR
       ═══════════════════════════════════════ */
    .header-filters {
        display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
    }
    .filter-input-wrap {
        position: relative; display: flex; align-items: center;
    }
    .filter-input-wrap svg {
        position: absolute; left: 12px; width: 16px; height: 16px; color: #94a3b8;
        pointer-events: none; z-index: 1;
    }
    .filter-input-wrap input,
    .filter-input-wrap select {
        padding: 9px 14px 9px 36px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.82rem;
        font-family: inherit;
        outline: none;
        color: #334155;
        background: #fff;
        transition: all 0.2s ease;
    }
    .filter-input-wrap input:focus,
    .filter-input-wrap select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }
    .search-wrap input { width: 240px; }
    .select-wrap select { width: 170px; cursor: pointer; }

    /* ═══════════════════════════════════════
       TABLE CARD
       ═══════════════════════════════════════ */
    .table-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
        overflow-y: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
        scrollbar-width: none; 
        -ms-overflow-style: none;
    }
    .table-card::-webkit-scrollbar { display: none; }

    .master-table {
        width: 100%; min-width: 1400px; border-collapse: collapse; text-align: left;
    }

    /* ── Table Header ── */
    .master-table th {
        background: #f8fafc;
        padding: 12px 14px;
        font-size: 0.65rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .master-table th.col-index { width: 50px; text-align: center; }
    .master-table th.col-name { min-width: 160px; }
    .master-table th.col-actions { width: 100px; text-align: center; }

    /* ── Table Cells ── */
    .master-table td {
        padding: 12px 14px;
        font-size: 0.8rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* ── Row Styles ── */
    .master-table tbody tr:not(.forwarded-header-row) {
        transition: background 0.15s ease;
    }
    .master-table tbody tr:not(.forwarded-header-row):hover td {
        background: #f8f7ff;
    }
    .master-table tbody tr:not(.forwarded-header-row):nth-child(even):not(:hover) td {
        background: #fafbfc;
    }

    /* ── Row entrance animation ── */
    @keyframes rowSlideIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .master-table tbody tr.animate-in {
        animation: rowSlideIn 0.3s ease forwards;
    }

    /* ═══════════════════════════════════════
       FORWARDED HEADER ROW
       ═══════════════════════════════════════ */
    .forwarded-header-row {
        position: sticky;
        z-index: 10;
    }
    .forwarded-header-row td {
        background: #f1f5f9 !important;
        padding: 10px 20px !important;
        border-bottom: 1px solid #e2e8f0;
        border-top: 1px solid #e2e8f0;
    }
    .forwarded-header-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
    }
    .forwarded-badge {
        background: #fff;
        color: #374151;
        padding: 5px 14px;
        border-radius: 8px;
        border: 1.5px solid #d1d5db;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 0.02em;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .forwarded-badge svg {
        color: #6366f1;
        width: 14px;
        height: 14px;
    }
    .forwarded-count {
        background: #eef2ff;
        color: #6366f1;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.68rem;
        font-weight: 700;
        margin-left: 4px;
    }
    .btn-add-forwarded-record {
        background: #eef2ff;
        color: #6366f1;
        border: 1.5px solid #c7d2fe;
        border-radius: 6px;
        padding: 3px 10px;
        font-size: 0.7rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
        text-decoration: none;
        position: absolute;
        right: 0;
    }
    .btn-add-forwarded-record:hover {
        background: #6366f1;
        color: white;
        border-color: #6366f1;
        transform: scale(1.03);
    }
    .btn-add-forwarded-record svg {
        width: 13px;
        height: 13px;
    }

    /* Batch/Forwarded header checkbox styling */
    .batch-checkbox, .forwarded-checkbox {
        width: 15px;
        height: 15px;
        cursor: pointer;
        accent-color: #6366f1;
    }
    .batch-header-row .col-checkbox,
    .forwarded-header-row .col-checkbox {
        text-align: center;
        vertical-align: middle;
    }

    /* ═══════════════════════════════════════
       CELL-SPECIFIC STYLES
       ═══════════════════════════════════════ */
    .cell-index {
        font-family: 'SF Mono', 'Fira Code', monospace;
        font-size: 0.72rem;
        color: #cbd5e1;
        text-align: center;
        font-weight: 500;
    }
    .cell-name {
        font-weight: 600;
        color: #0f172a;
        letter-spacing: -0.01em;
    }
    .cell-position {
        font-weight: 500;
        color: #475569;
        font-size: 0.82rem;
    }
    .cell-school {
        color: #64748b;
        font-size: 0.82rem;
    }
    .cell-dates {
        font-family: 'SF Mono', 'Fira Code', monospace;
        font-size: 0.75rem;
        color: #475569;
        letter-spacing: -0.01em;
    }
    .cell-action-date {
        font-family: 'SF Mono', 'Fira Code', monospace;
        font-size: 0.78rem;
        font-weight: 600;
        color: #1e293b;
    }
    .cell-deduction {
        font-size: 0.78rem;
        color: #94a3b8;
        font-style: italic;
    }
    .cell-incharge {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 500;
    }

    /* ═══════════════════════════════════════
       BADGES
       ═══════════════════════════════════════ */
    .badge-leave {
        font-size: 0.7rem; font-weight: 600; padding: 4px 10px;
        border-radius: 6px; background: #eef2ff; color: #4f46e5;
        display: inline-block; white-space: nowrap;
        letter-spacing: 0.01em;
    }
    .remark-badge {
        font-size: 0.7rem; font-weight: 600; padding: 4px 10px;
        border-radius: 6px; display: inline-flex; align-items: center; gap: 5px;
        white-space: nowrap;
    }
    .remark-badge::before {
        content: '';
        width: 6px; height: 6px; border-radius: 50%;
        flex-shrink: 0;
    }
    .remark-badge.green {
        background: #f0fdf4; color: #16a34a;
    }
    .remark-badge.green::before { background: #22c55e; }
    .remark-badge.red {
        background: #fef2f2; color: #dc2626;
    }
    .remark-badge.red::before { background: #ef4444; }
    .remark-badge.yellow {
        background: #fffbeb; color: #d97706;
    }
    .remark-badge.yellow::before { background: #f59e0b; }
    .remark-badge.violet {
        background: #f5f3ff; color: #7c3aed;
    }
    .remark-badge.violet::before { background: #8b5cf6; }
    .remark-badge.gray {
        background: #f1f5f9; color: #64748b;
    }
    .remark-badge.gray::before { background: #94a3b8; }

    /* ═══════════════════════════════════════
       ACTION BUTTONS
       ═══════════════════════════════════════ */
    .btn-action-group {
        display: flex; gap: 6px; justify-content: center;
    }
    .btn-action {
        width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid transparent;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s ease;
        position: relative;
    }
    .btn-action svg { width: 15px; height: 15px; }
    .btn-edit {
        background: #f0fdf4; color: #16a34a; border-color: #bbf7d0;
    }
    .btn-edit:hover {
        background: #16a34a; color: #fff; border-color: #16a34a;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        transform: translateY(-1px);
    }
    .btn-delete {
        background: #fef2f2; color: #dc2626; border-color: #fecaca;
    }
    .btn-delete:hover {
        background: #dc2626; color: #fff; border-color: #dc2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        transform: translateY(-1px);
    }

    /* ═══════════════════════════════════════
       LOADING & EMPTY STATES
       ═══════════════════════════════════════ */
    .loading-state {
        text-align: center;
        padding: 80px 24px !important;
    }
    .loading-content {
        display: flex; flex-direction: column;
        align-items: center; gap: 8px;
    }
    .spinner {
        width: 28px; height: 28px; border: 3px solid #e2e8f0;
        border-top-color: #6366f1; border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    .loading-text {
        color: #475569; font-weight: 600; font-size: 0.88rem;
    }
    .loading-sub {
        color: #94a3b8; font-size: 0.78rem;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .empty-state {
        text-align: center; padding: 80px 24px !important;
    }
    .empty-icon {
        width: 56px; height: 56px; margin: 0 auto 16px;
        background: #f1f5f9; border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        color: #94a3b8;
    }
    .empty-icon svg { width: 28px; height: 28px; }
    .empty-title { color: #475569; font-weight: 600; font-size: 0.92rem; }
    .empty-sub { color: #94a3b8; font-size: 0.8rem; margin-top: 4px; }

    /* ── Import Button ── */
    .btn-import-excel {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 18px;
        height: 42px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .btn-import-excel:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-export-excel {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 18px;
        height: 42px;
        background: #fff;
        color: #6366f1;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-export-excel:hover {
        background: #f8faff;
        border-color: #6366f1;
        color: #4f46e5;
    }

    .btn-export-excel svg {
        width: 18px;
        height: 18px;
    }

    /* ── Export Floating Bar ── */
    .export-actions-bar {
        position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%) translateY(100px);
        background: #1e293b; color: #fff; padding: 12px 24px; border-radius: 16px;
        display: flex; align-items: center; gap: 24px; z-index: 1000;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .export-actions-bar.active { transform: translateX(-50%) translateY(0); }

    .selection-info { font-size: 0.88rem; font-weight: 500; }
    .selection-info span { color: #818cf8; font-weight: 700; margin: 0 4px; }

    .btn-download-selected {
        background: #6366f1; color: #fff; border: none; padding: 8px 18px;
        border-radius: 8px; font-size: 0.82rem; font-weight: 600; cursor: pointer;
        transition: all 0.2s; display: flex; align-items: center; gap: 8px;
    }
    .btn-download-selected:hover { background: #4f46e5; transform: translateY(-1px); }

    .btn-cancel-selection {
        background: transparent; color: #94a3b8; border: none; cursor: pointer;
        font-size: 0.82rem; font-weight: 500;
    }
    .btn-cancel-selection:hover { color: #fff; }

    /* Checkbox Styling */
    .col-checkbox { width: 44px; text-align: center; }
    .row-checkbox { width: 18px; height: 18px; cursor: pointer; accent-color: #6366f1; }

    .btn-import-excel svg {
        width: 18px;
        height: 18px;
    }

    /* ── Import Modal ── */
    .import-modal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(8px);
        display: none; align-items: center; justify-content: center;
        z-index: 1000; padding: 20px;
    }
    .import-modal.active { display: flex; }
    
    .import-modal-content {
        background: #fff; width: 100%; max-width: 1400px; max-height: 90vh;
        border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        display: flex; flex-direction: column; overflow: hidden;
        animation: modalScale 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes modalScale {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-header {
        padding: 24px 32px; background: #fff; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-header h3 { font-size: 1.25rem; font-weight: 700; color: #1e293b; }
    
    .modal-body { 
        padding: 0; 
        overflow: auto; 
        flex: 1; 
        background: #f8fafc;
        /* Hide scrollbars but keep functionality */
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .modal-body::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }

    .preview-table {
        width: 100%; 
        min-width: 1600px; 
        border-collapse: collapse; 
        font-size: 0.82rem;
    }
    .preview-table th {
        background: #f1f5f9; position: sticky; top: 0; padding: 14px 16px;
        text-align: left; font-weight: 600; color: #64748b; z-index: 10;
        border-bottom: 1px solid #e2e8f0; white-space: nowrap;
    }
    .preview-table td {
        padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #475569;
        background: #fff;
    }
    .preview-table tr:hover td { background: #f8faff; }

    .modal-footer {
        padding: 20px 32px; background: #fff; border-top: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: flex-end; gap: 12px;
    }
    .btn-modal {
        padding: 10px 24px; border-radius: 10px; font-size: 0.88rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; border: none;
    }
    .btn-cancel { background: #f1f5f9; color: #64748b; }
    .btn-cancel:hover { background: #e2e8f0; color: #1e293b; }
    
    .btn-confirm { 
        background: #10b981; color: #fff;
        display: flex; align-items: center; gap: 8px;
    }
    .btn-confirm:hover { background: #059669; transform: translateY(-1px); }
    .btn-confirm:disabled { opacity: 0.6; cursor: not-allowed; pointer-events: none; }

    .import-loader {
        display: none; width: 18px; height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff; border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    .btn-confirm.loading .import-loader { display: block; }
    .btn-confirm.loading span { opacity: 0.7; }

    .preview-forwarded-row {
        background: #f8fafc !important;
    }
    .preview-forwarded-row td {
        background: #f8fafc !important;
        color: #6366f1 !important;
        font-weight: 700 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 10px 16px !important;
        border-bottom: 1px solid #e2e8f0 !important;
        text-align: center;
    }
    .preview-batch-row {
        background: #f8fafc !important;
        border-top: 2px solid #e2e8f0;
    }
    .preview-batch-row td {
        padding: 6px 16px !important;
        background: #f8fafc !important;
    }

    /* ═══════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════ */
    @media (max-width: 1200px) {
        .page-header-card { flex-direction: column; align-items: stretch; gap: 16px; }
        .header-filters { flex-wrap: wrap; }
        .search-wrap input { width: 100%; }
    }
    @media (max-width: 768px) {
        .header-stats { display: none; }
        .header-filters { flex-direction: column; }
        .filter-input-wrap input,
        .filter-input-wrap select { width: 100%; }
    }

    /* ══════════════════════════════════════════
       DARK MODE — LEAVE RECORDS
       ══════════════════════════════════════════ */

    /* Page Header Card */
    body.dark-mode .page-header-card {
        background: #0f172a;
        border-color: #1e293b;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    body.dark-mode .page-header-card.is-stuck {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        border-top-color: transparent;
    }
    body.dark-mode .header-title { color: #fff; }
    body.dark-mode .header-subtitle { color: #64748b; }

    /* Stat Chips */
    body.dark-mode .stat-chip { background: #111827; border-color: #1e293b; }
    body.dark-mode .stat-label { color: #64748b; }
    body.dark-mode .stat-value { color: #f1f5f9; }

    /* Filters */
    body.dark-mode .filter-input-wrap input,
    body.dark-mode .filter-input-wrap select {
        background: #111827;
        border-color: #64748b;
        color: #f1f5f9;
    }
    body.dark-mode .filter-input-wrap input::placeholder { color: #94a3b8; }
    body.dark-mode .filter-input-wrap input:focus,
    body.dark-mode .filter-input-wrap select:focus { border-color: #818cf8; }
    body.dark-mode .filter-input-wrap svg { color: #fff !important; }
    body.dark-mode .filter-input-wrap select option { background: #0f172a; color: #f1f5f9; }

    /* Date picker specific dark mode adjustments */
    body.dark-mode input[type="date"]::-webkit-calendar-picker-indicator {
        filter: brightness(0) invert(1) !important;
        -webkit-filter: brightness(0) invert(1) !important;
        cursor: pointer;
        opacity: 1 !important;
    }
    body.dark-mode .filter-input-wrap input[type="date"] {
        color-scheme: dark;
    }
    body.dark-mode .date-wrap svg { color: #fff !important; opacity: 1 !important; }

    /* Import/Export Buttons */
    body.dark-mode .btn-export-excel { background: #111827; color: #818cf8; border-color: #334155; }
    body.dark-mode .btn-export-excel:hover { background: #1e293b; border-color: #818cf8; color: #a5b4fc; }

    /* Table Card */
    body.dark-mode .table-card {
        background: #0f172a;
        border-color: #1e293b;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    /* Table Header */
    body.dark-mode .master-table th {
        background: #111827;
        color: #94a3b8;
        border-bottom-color: #1e293b;
    }

    /* Table Cells */
    body.dark-mode .master-table td {
        color: #cbd5e1;
        border-bottom-color: #1e293b;
        background: #0f172a;
    }
    body.dark-mode .master-table tbody tr:not(.forwarded-header-row):hover td { background: #111827; }
    body.dark-mode .master-table tbody tr:not(.forwarded-header-row):nth-child(even):not(:hover) td { background: #0c1322; }

    /* Cell-Specific */
    body.dark-mode .cell-index { color: #475569; }
    body.dark-mode .cell-name { color: #f1f5f9; }
    body.dark-mode .cell-position { color: #94a3b8; }
    body.dark-mode .cell-school { color: #94a3b8; }
    body.dark-mode .cell-dates { color: #94a3b8; }
    body.dark-mode .cell-action-date { color: #cbd5e1; }
    body.dark-mode .cell-deduction { color: #64748b; }
    body.dark-mode .cell-incharge { color: #94a3b8; }

    /* Forwarded Header Rows — Colored */
    body.dark-mode .forwarded-header-row td {
        background: rgba(99, 102, 241, 0.08) !important;
        border-color: rgba(99, 102, 241, 0.15);
    }
    body.dark-mode .forwarded-badge { background: rgba(99, 102, 241, 0.12); color: #fff; border-color: rgba(99, 102, 241, 0.25); }
    body.dark-mode .forwarded-badge svg { color: #fff; }
    body.dark-mode .forwarded-count { background: rgba(99, 102, 241, 0.15); color: #a5b4fc; }
    body.dark-mode .btn-add-forwarded-record { background: rgba(99, 102, 241, 0.1); color: #fff; border-color: rgba(99, 102, 241, 0.25); }
    body.dark-mode .btn-add-forwarded-record:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
    body.dark-mode .batch-header-row { background: #0a0f1e !important; }
    body.dark-mode .batch-header-row:hover { background: #0a0f1e !important; }
    body.dark-mode .batch-header-row td { border-bottom-color: #1e293b; }

    /* Date badge in forwarded header */
    body.dark-mode .header-date-badge { background: #111827 !important; border-color: #334155 !important; color: #94a3b8 !important; }
    body.dark-mode .forwarded-incharge-name { color: #fff !important; opacity: 1 !important; }

    .forwarded-incharge-name { color: #6366f1; opacity: 0.8; font-size: 0.65rem; margin-left: 4px; }

    /* Badges */
    body.dark-mode .badge-leave { background: rgba(99, 102, 241, 0.15); color: #fff; }
    body.dark-mode .remark-badge.green { background: rgba(16, 185, 129, 0.1); color: #34d399; }
    body.dark-mode .remark-badge.red { background: rgba(239, 68, 68, 0.1); color: #f87171; }
    body.dark-mode .remark-badge.yellow { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
    body.dark-mode .remark-badge.violet { background: rgba(139, 92, 246, 0.1); color: #a78bfa; }
    body.dark-mode .remark-badge.gray { background: rgba(30, 41, 59, 0.5); color: #94a3b8; }

    /* Action Buttons */
    body.dark-mode .btn-edit { background: rgba(16, 185, 129, 0.1); color: #34d399; border-color: rgba(16, 185, 129, 0.2); }
    body.dark-mode .btn-edit:hover { background: #059669; color: #fff; border-color: #059669; }
    body.dark-mode .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; border-color: rgba(239, 68, 68, 0.2); }
    body.dark-mode .btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

    /* Loading & Empty States */
    body.dark-mode .loading-state { color: #94a3b8; }
    body.dark-mode .spinner { border-color: #1e293b; border-top-color: #818cf8; }
    body.dark-mode .loading-text { color: #94a3b8; }
    body.dark-mode .loading-sub { color: #475569; }
    body.dark-mode .empty-icon { background: #111827; color: #475569; }
    body.dark-mode .empty-title { color: #94a3b8; }
    body.dark-mode .empty-sub { color: #475569; }

    /* Import Modal */
    body.dark-mode .import-modal-content { background: #0f172a; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7); }
    body.dark-mode .import-modal .modal-header { background: #0f172a; border-bottom-color: #1e293b; }
    body.dark-mode .import-modal .modal-header h3 { color: #fff; }
    body.dark-mode .import-modal .modal-body { background: #0c1322; }
    body.dark-mode .preview-table th { background: #111827; color: #fff; border-bottom-color: #1e293b; font-size: 0.7rem; }
    body.dark-mode .preview-table td { background: #0f172a; color: #cbd5e1; border-bottom-color: #1e293b; }
    body.dark-mode .preview-table tr:hover td { background: #111827; }
    body.dark-mode .preview-forwarded-row,
    body.dark-mode .preview-forwarded-row td { 
        background-color: rgba(99, 102, 241, 0.08) !important; 
        color: #fff !important; 
        border-bottom-color: rgba(99, 102, 241, 0.15) !important;
    }
    body.dark-mode .preview-forwarded-row svg { color: #fff !important; }
    body.dark-mode .preview-batch-row { border-top-color: #1e293b !important; }
    body.dark-mode .preview-batch-row td { background: #0a0f1e !important; border-bottom: none !important; }
    body.dark-mode .import-modal .modal-footer { background: #0f172a; border-top-color: #1e293b; }
    body.dark-mode .btn-cancel { background: #1e293b; color: #94a3b8; }
    body.dark-mode .btn-cancel:hover { background: #334155; color: #fff; }

    /* Export Floating Bar */
    body.dark-mode .export-actions-bar { background: #111827; border: 1px solid #1e293b; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5); }

    /* Checkbox */
    body.dark-mode .row-checkbox { accent-color: #818cf8; }
    body.dark-mode .batch-checkbox, body.dark-mode .forwarded-checkbox { accent-color: #818cf8; }

    /* Content body */
    body.dark-mode .content-body { background: transparent; }

    /* Fix the name color and text in preview */
    body.dark-mode .preview-table .cell-name { color: #f1f5f9 !important; font-weight: 600; }
    body.dark-mode .preview-table .cell-index { color: #94a3b8 !important; }
    body.dark-mode .preview-table .badge-leave { color: #fff !important; background: rgba(99, 102, 241, 0.2) !important; font-size: 0.7rem; padding: 2px 6px; border-radius: 4px; }
    
    body.dark-mode .remark-badge-preview.green { background: rgba(16, 185, 129, 0.1) !important; color: #34d399 !important; }
    body.dark-mode .remark-badge-preview.red { background: rgba(239, 68, 68, 0.1) !important; color: #f87171 !important; }
    body.dark-mode .remark-badge-preview.yellow { background: rgba(245, 158, 11, 0.1) !important; color: #fbbf24 !important; }
    body.dark-mode .remark-badge-preview.violet { background: rgba(139, 92, 246, 0.1) !important; color: #a78bfa !important; }

    body.dark-mode .btn-confirm { background-color: #10b981 !important; color: #fff !important; }
    body.dark-mode .btn-confirm:hover { background-color: #059669 !important; }

    .forwarded-preview-content { display: flex; align-items: center; justify-content: center; gap: 8px; }
    .forwarded-preview-content svg { width: 14px; height: 14px; color: #6366f1; }
    .remark-badge-preview.green { color: #16a34a; background: #f0fdf4; }
    .remark-badge-preview.red { color: #dc2626; background: #fef2f2; }
    .remark-badge-preview.yellow { color: #ca8a04; background: #fefce8; }
    .remark-badge-preview.violet { color: #7c3aed; background: #f5f3ff; }

    .preview-table .badge-leave { font-size: 0.7rem; padding: 2px 6px; border-radius: 4px; background: #eef2ff; color: #4338ca; }
    .preview-table .cell-name { font-weight: 600; color: #1e293b; }
    .preview-table .cell-index { color: #94a3b8; font-weight: 500; }

</style>

<script>
const AUTH_USER_ID = "{{ auth()->id() }}";
const AUTH_USERNAME = "{{ auth()->user()->username ?? '' }}";
const AUTH_NAME = "{{ auth()->user()->name ?? '' }}";
document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default for date filter
    const now = new Date();
    const today = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
    document.getElementById('dateFilter').value = today;

    fetchMasterRecords();
    setupStickyObserver();

    document.getElementById('masterSearch').addEventListener('input', filterRecords);
    document.getElementById('remarkFilter').addEventListener('change', filterRecords);
});

function filterRecords() {
    const searchVal = document.getElementById('masterSearch').value.trim().toLowerCase();
    const remarkFilter = document.getElementById('remarkFilter').value;
    const inchargeFilter = document.getElementById('inchargeFilter')?.value || 'all';
    const rows = document.querySelectorAll('#masterTableBody tr');
    
    // If no filters active, just show everything (including all headers) and exit
    if (searchVal === '' && (remarkFilter === 'all' || !remarkFilter) && (inchargeFilter === 'all' || !inchargeFilter)) {
        rows.forEach(row => row.style.display = '');
        return;
    }

    let currentHeader = null;
    let currentBatchHeader = null;
    let hasVisibleInGroup = false;
    let hasVisibleInBatch = false;

    rows.forEach(row => {
        if (row.classList.contains('batch-header-row')) {
            // Hide previous batch/group headers if no visible records
            if (currentBatchHeader && !hasVisibleInBatch) currentBatchHeader.style.display = 'none';
            if (currentHeader && !hasVisibleInGroup) currentHeader.style.display = 'none';
            
            currentBatchHeader = row;
            hasVisibleInBatch = false;
            currentHeader = null;
            hasVisibleInGroup = false;
            row.style.display = ''; 
        } else if (row.classList.contains('forwarded-header-row')) {
            if (currentHeader && !hasVisibleInGroup) currentHeader.style.display = 'none';
            
            currentHeader = row;
            hasVisibleInGroup = false;
            row.style.display = ''; 
        } else if (row.cells.length > 1) { // Data row
            const textContent = row.textContent.toLowerCase();
            const matchesSearch = searchVal === '' || textContent.includes(searchVal);
            
            let matchesRemark = true;
            const rowRemarks = (row.getAttribute('data-remarks') || '').toLowerCase();
            if (remarkFilter === 'with pay') {
                matchesRemark = (rowRemarks.includes('with pay') && !rowRemarks.includes('without pay')) || (rowRemarks.includes('approved') && !rowRemarks.includes('disapproved'));
            } else if (remarkFilter === 'without pay') {
                matchesRemark = (rowRemarks.includes('without pay') && !rowRemarks.includes('with pay')) || rowRemarks.includes('disapproved');
            } else if (remarkFilter === 'with pay & without pay') {
                matchesRemark = rowRemarks.includes('with pay') && rowRemarks.includes('without pay');
            }
            
            let matchesIncharge = true;
            if (inchargeFilter !== 'all') {
                const rowIncharge = row.getAttribute('data-incharge') || '';
                matchesIncharge = rowIncharge === inchargeFilter;
            }
            
            const isVisible = matchesSearch && matchesRemark && matchesIncharge;
            row.style.display = isVisible ? '' : 'none';
            
            if (isVisible) {
                hasVisibleInGroup = true;
                hasVisibleInBatch = true;
            }
        }
    });

    // Handle last headers
    if (currentHeader && !hasVisibleInGroup) currentHeader.style.display = 'none';
    if (currentBatchHeader && !hasVisibleInBatch) currentBatchHeader.style.display = 'none';
}

function fetchMasterRecords(exportModeOverride = null) {
    const tbody = document.getElementById('masterTableBody');
    const dateFilter = document.getElementById('dateFilter').value;
    const inchargeFilter = document.getElementById('inchargeFilter').value;
    const baseUrl = '{{ url("/leave-records") }}';
    const params = [];
    if (dateFilter) params.push(`date=${encodeURIComponent(dateFilter)}`);
    if (inchargeFilter) params.push(`incharge=${encodeURIComponent(inchargeFilter)}`);
    const finalUrl = baseUrl + (params.length ? '?' + params.join('&') : '');

    fetch(finalUrl, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="12" class="empty-state">No records found</td></tr>`;
                document.getElementById('statTotal').textContent = '0';
                return;
            }

            document.getElementById('statTotal').textContent = data.length;
            
            // Group records by incharge + forwarded WITHIN each batch
            const grouped = {};
            data.forEach(r => {
                const batchId = r.batch_id || 1;
                const incharge = r.incharge || 'System';
                const forwarded = r.forwarded || '';
                const groupKey = `${incharge}|${forwarded}`;

                if (!grouped[batchId]) grouped[batchId] = { groupOrder: [], groups: {} };
                if (!grouped[batchId].groups[groupKey]) {
                    grouped[batchId].groups[groupKey] = [];
                    grouped[batchId].groupOrder.push(groupKey);
                }
                grouped[batchId].groups[groupKey].push(r);
            });
            // Flatten back to sorted array
            const sortedData = [];
            const batchIds = Object.keys(grouped).map(Number).sort((a, b) => a - b);
            batchIds.forEach(batchId => {
                const batch = grouped[batchId];
                batch.groupOrder.forEach(key => {
                    batch.groups[key].forEach(r => sortedData.push(r));
                });
            });
            data = sortedData;

            const colCheckboxHeader = document.querySelector('th.col-checkbox');
            const isExportMode = exportModeOverride !== null ? exportModeOverride : (colCheckboxHeader && colCheckboxHeader.style.display !== 'none');
            let html = '';
            let lastBatchId = null;
            let lastInchargeName = null;
            let lastDept = null;
            let rowIndex = 0;

            // Count unique logical batches (batch_id + incharge)
            const uniqueLogicalBatches = [...new Set(data.map(r => `${r.batch_id || 1}|${r.incharge || ''}`))];
            const showBatchHeaders = uniqueLogicalBatches.length > 1;

            const myRecords = data.filter(r => {
                const inc = (r.incharge || '').toLowerCase();
                return inc === AUTH_USERNAME.toLowerCase() || inc === AUTH_NAME.toLowerCase();
            });
            const myLatestBatch = myRecords.length > 0 ? Math.max(...myRecords.map(r => r.batch_id || 1)) : -1;

            data.forEach((r, i) => {
                const batchId = r.batch_id || 1;
                const currentIncharge = r.incharge || 'System';
                const forwarded = r.forwarded || '';
                const inc = (r.incharge || '').toLowerCase();
                const isMyRecord = inc === AUTH_USERNAME.toLowerCase() || inc === AUTH_NAME.toLowerCase();
                const shouldCheck = isExportMode && isMyRecord && batchId === myLatestBatch;

                // Add batch separator when batch OR incharge changes
                if (batchId !== lastBatchId || currentIncharge.toLowerCase().trim() !== (lastInchargeName || '').toLowerCase().trim()) {
                    const isFirstBatch = lastBatchId === null;
                    lastDept = null; 
                    html += `
                        <tr class="batch-header-row" data-batch="${batchId}">
                            <td class="col-checkbox" style="display: ${isExportMode ? '' : 'none'};">
                                <input type="checkbox" class="batch-checkbox" data-batch="${batchId}" ${shouldCheck ? 'checked' : ''} onchange="toggleBatchCheckbox(${batchId}, this.checked)">
                            </td>
                            <td colspan="${isExportMode ? '11' : '11'}" style="vertical-align: middle; padding: ${isFirstBatch ? '0' : '20px 40px'} !important;">
                                ${!isFirstBatch ? `
                                <div style="display: flex; align-items: center; gap: 20px;">
                                    <div style="flex: 1; height: 2px; background: linear-gradient(90deg, transparent, #6366f1); border-radius: 4px;"></div>
                                    <div style="display: flex; gap: 6px;">
                                        <div style="width: 6px; height: 6px; border-radius: 50%; background: #6366f1; box-shadow: 0 0 8px rgba(99,102,241,0.4);"></div>
                                        <div style="width: 6px; height: 6px; border-radius: 50%; background: #a5b4fc;"></div>
                                        <div style="width: 6px; height: 6px; border-radius: 50%; background: #6366f1; box-shadow: 0 0 8px rgba(99,102,241,0.4);"></div>
                                    </div>
                                    <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #6366f1, transparent); border-radius: 4px;"></div>
                                </div>
                                ` : ''}
                            </td>
                        </tr>
                    `;
                    lastBatchId = batchId;
                    lastInchargeName = currentIncharge;
                }

                const isProcessed = r.is_processed == 1 || r.is_processed === true;

                const groupKey = `${r.incharge || 'System'}|${forwarded}`;
                if (forwarded && forwarded !== 'No Forwarded' && groupKey !== lastDept) {
                    const groupDate = r.date_of_action ? formatDate(r.date_of_action) : '-';
                    html += `
                        <tr class="forwarded-header-row" data-forwarded="${forwarded}" data-batch="${batchId}" data-incharge="${r.incharge || ''}">
                            <td class="col-checkbox" style="display: ${isExportMode ? '' : 'none'};"></td>
                            <td colspan="${isExportMode ? '11' : '11'}">
                                <div class="forwarded-header-content">
                                    <input type="checkbox" class="forwarded-checkbox" data-forwarded="${forwarded}" data-batch="${batchId}" ${shouldCheck ? 'checked' : ''} onchange="toggleForwardedCheckbox('${forwarded.replace(/'/g, "\\'")}', ${batchId}, this.checked)" style="display: ${isExportMode ? '' : 'none'};">
                                    <div class="forwarded-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                        </svg>
                                        <span>${forwarded} ${!isProcessed ? ` - <span class="forwarded-incharge-name">(${r.incharge || 'Unknown'})</span>` : ''}</span>
                                    </div>
                                    <div class="header-date-badge" style="margin-left: 10px; display: ${isProcessed ? 'flex' : 'none'}; align-items: center; gap: 6px; padding: 4px 12px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; font-family: 'SF Mono', 'Fira Code', monospace; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 13px; height: 13px; color: #6366f1;">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                         ${r.processed_at ? formatDate(r.processed_at) : groupDate}
                                     </div>
                                    ${isMyRecord ? `
                                    <a href="/user/form?forwarded=${encodeURIComponent(forwarded)}&batch=${batchId}&source=leave-records" class="btn-add-forwarded-record">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Add
                                    </a>
                                    ` : ''}
                                </div>
                            </td>
                        </tr>
                    `;
                    lastDept = groupKey;
                }

                rowIndex++;
                let remarkClass = 'gray';
                const rem = (r.remarks || '').toLowerCase();
                if (rem.includes('with pay') && rem.includes('without pay')) remarkClass = 'violet';
                else if (rem.includes('approved') || rem.includes('with pay')) remarkClass = 'green';
                else if (rem.includes('disapproved') || rem.includes('without pay')) remarkClass = 'red';
                else if (rem.includes('pending')) remarkClass = 'yellow';

                html += `
                    <tr data-forwarded="${forwarded}" data-batch="${batchId}" data-remarks="${rem}" data-incharge="${r.incharge || ''}">
                        <td class="col-checkbox" style="display: ${isExportMode ? '' : 'none'};">
                            <input type="checkbox" class="row-checkbox" ${shouldCheck ? 'checked' : ''} onchange="onRowCheckboxChange('${forwarded.replace(/'/g, "\\'")}', ${batchId})">
                        </td>
                        <td class="cell-index">${rowIndex}</td>
                        <td class="cell-name">${r.name}</td>
                        <td class="cell-position">${r.position || '-'}</td>
                        <td class="cell-school">${r.school || '-'}</td>
                        <td><span class="badge-leave">${r.type_of_leave || '-'}</span></td>
                        <td class="cell-dates">${r.inclusive_dates || '-'}</td>
                        <td><span class="remark-badge ${remarkClass}">${r.remarks || '-'}</span></td>
                        <td class="cell-action-date">${isProcessed ? formatDate(r.date_of_action) : '-'}</td>
                        <td class="cell-deduction">${r.deduction_remarks || '-'}</td>
                        <td class="cell-incharge">${r.incharge || '-'}</td>
                        <td class="col-actions">
                            ${isMyRecord ? `
                            <div class="btn-action-group">
                                <button onclick="editRecord(${r.id})" class="btn-action btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button onclick="deleteRecord(${r.id})" class="btn-action btn-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.244 2.244 0 0 1-2.244 2.077H8.084a2.244 2.244 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                            ` : '-'}
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
            // updateStickyPositions(); // Temporarily disabled to bypass layout shifts
            filterRecords();
            updateSelectionCount();
        });

    // Populate Incharge filter once
    const inchargeSelect = document.getElementById('inchargeFilter');
    if (inchargeSelect && inchargeSelect.options.length <= 1) {
        fetch('{{ url("/leave-records/incharges") }}')
            .then(res => res.json())
            .then(data => {
                data.forEach(i => {
                    const opt = document.createElement('option');
                    opt.value = i.incharge;
                    opt.textContent = i.incharge;
                    
                    // Default to current user's name or username
                    if (i.incharge === AUTH_NAME || i.incharge === AUTH_USERNAME) {
                        opt.selected = true;
                    }
                    
                    inchargeSelect.appendChild(opt);
                });
                // Trigger filter update to apply the default selection
                filterRecords();
            });
    }
}

function editRecord(id) {
    window.location.href = "{{ url('/user/form') }}?edit=" + id + "&source=leave-records";
}

function deleteRecord(id) {
    if (!confirm('Are you sure you want to delete this record?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`{{ url("/leave-records") }}/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            fetchMasterRecords();
        } else {
            alert('Error deleting record');
        }
    });
}


function updateStickyPositions() {
    return; // Disabled for debugging
}

function setupStickyObserver() {
    const headerCard = document.querySelector('.page-header-card');
    if (!headerCard) return;

    const sentinel = document.createElement('div');
    sentinel.style.height = '1px';
    sentinel.style.marginBottom = '-1px';
    sentinel.style.visibility = 'hidden';
    headerCard.parentNode.insertBefore(sentinel, headerCard);

    const observer = new IntersectionObserver(([entry]) => {
        headerCard.classList.toggle('is-stuck', !entry.isIntersecting);
    }, { threshold: 0, rootMargin: '-69px 0px 0px 0px' });

    observer.observe(sentinel);

    window.addEventListener('resize', updateStickyPositions);
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            setTimeout(updateStickyPositions, 400);
        });
    }
}

let pendingImportData = [];

function handleExcelImport(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { 
            type: 'array',
            cellDates: true,
            dateNF: 'm/d/yy'
        });
        const firstSheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheetName];
        const jsonData = XLSX.utils.sheet_to_json(worksheet, { raw: false });

        if (jsonData.length > 0) {
            processImportedData(jsonData);
        }
    };
    reader.readAsArrayBuffer(file);
    event.target.value = '';
}

function processImportedData(data) {
    const formatExcelValue = (val) => {
        if (!val) return '';
        // If it's already a string, return it trimmed
        if (typeof val === 'string') return val.trim();
        // If it's a date object from SheetJS
        if (val instanceof Date) {
            const mm = val.getMonth() + 1;
            const dd = val.getDate();
            const yyyy = val.getFullYear();
            return `${mm}-${dd}-${yyyy}`;
        }
        return String(val).trim();
    };

    const getVal = (row, possibleNames) => {
        for (const name of possibleNames) {
            const key = Object.keys(row).find(k => k.toLowerCase().trim() === name.toLowerCase());
            if (key !== undefined) return row[key];
        }
        return '';
    };

    let currentForwarded = ''; 
    pendingImportData = [];

    data.forEach(r => {
        const rawName = getVal(r, ['name', 'full name', 'employee name']);
        const name = formatExcelValue(rawName);
        const dates = formatExcelValue(getVal(r, ['dates', 'inclusive dates', 'duration']));
        const inlineForwarded = formatExcelValue(getVal(r, ['forwarded', 'dept', 'department', 'division']));
        
        if (!name || name === '-' || name === '0' || name === '') {
            const values = Object.values(r).filter(v => v && String(v).trim().length > 0 && String(v).trim() !== '-');
            
            // Check if it's likely a header row (exactly one value and no data fields found)
            const hasDataFields = !!(inlineForwarded || getVal(r, ['position', 'designation']) || getVal(r, ['school', 'office', 'station']));
            
            if (values.length === 1 && !hasDataFields) {
                currentForwarded = formatExcelValue(values[0]);
                return;
            }
            if (!name && !dates) return;
        }

        pendingImportData.push({
            name: name || '-',
            position: formatExcelValue(getVal(r, ['position', 'designation'])) || '-',
            school: formatExcelValue(getVal(r, ['school', 'office', 'station'])) || '-',
            forwarded: inlineForwarded || currentForwarded || '',
            type_of_leave: formatExcelValue(getVal(r, ['type', 'type of leave', 'leave type'])) || '-',
            inclusive_dates: dates || '-',
            remarks: formatExcelValue(getVal(r, ['remarks', 'remark', 'status'])) || '-',
            date_of_action: formatExcelValue(getVal(r, ['date of action', 'date', 'action date'])) || '-',
            deduction_remarks: formatExcelValue(getVal(r, ['deduction', 'deduction remarks'])) || '-',
            incharge: formatExcelValue(getVal(r, ['incharge', 'recorded by', 'person incharge', 'person inchage', 'person in-charge', 'person in charge', 'prepared by'])) || '-'
        });
    });

    renderPreview();
}

function renderPreview() {
    const tbody = document.getElementById('previewTableBody');
    const countSpan = document.getElementById('previewCount');
    countSpan.textContent = pendingImportData.length;
    
    let html = '';
    let lastForwarded = null;
    let seenForwardeds = [];
    let batchNum = 1;
    let rowIndex = 0;

    // Detect how many batches there will be
    let tempSeenDepts = [];
    let tempLastDept = null;
    let totalBatches = 1;

    pendingImportData.forEach(r => {
        const forwarded = r.forwarded;
        if (forwarded !== tempLastDept && tempSeenDepts.includes(forwarded)) {
            totalBatches++;
            tempSeenDepts = [];
        }
        if (!tempSeenDepts.includes(forwarded)) tempSeenDepts.push(forwarded);
        tempLastDept = forwarded;
    });

    const showBatchHeaders = totalBatches > 1;

    let lastBatchNum = 0; // Track last emitted batch header

    pendingImportData.forEach((r, i) => {
        const forwarded = r.forwarded;

        // Detect batch change: forwarded repeats after other forwardeds
        if (forwarded !== lastForwarded && seenForwardeds.includes(forwarded)) {
            batchNum++;
            seenForwardeds = [];
        }
        if (!seenForwardeds.includes(forwarded)) seenForwardeds.push(forwarded);

        // Show batch header when batch number changes
        if (showBatchHeaders && batchNum !== lastBatchNum) {
            const isFirstBatch = lastBatchNum === 0;
            lastBatchNum = batchNum;
            html += `
                <tr class="preview-batch-row" style="height: ${isFirstBatch ? '10px' : '50px'};">
                    <td colspan="10" style="vertical-align: middle; padding: 0 32px;">
                        ${!isFirstBatch ? `
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, transparent, #6366f1);"></div>
                            <div style="width: 6px; height: 6px; border-radius: 50%; background: #6366f1;"></div>
                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #6366f1, transparent);"></div>
                        </div>
                        ` : ''}
                    </td>
                </tr>
            `;
        }

        if (forwarded && forwarded !== 'No Forwarded' && forwarded !== lastForwarded) {
            html += `
                <tr class="preview-forwarded-row">
                    <td colspan="10">
                        <div class="forwarded-preview-content">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                            <span>${forwarded}</span>
                        </div>
                    </td>
                </tr>
            `;
            lastForwarded = forwarded;
        }

        rowIndex++;
        
        let remarkType = '';
        const rem = (r.remarks || '').toLowerCase();
        if (rem.includes('with pay') && rem.includes('without pay')) remarkType = 'violet';
        else if (rem.includes('approved') || rem.includes('with pay')) remarkType = 'green';
        else if (rem.includes('disapproved') || rem.includes('without pay')) remarkType = 'red';
        else if (rem.includes('pending')) remarkType = 'yellow';
        
        html += `
            <tr>
                <td class="cell-index">${rowIndex}</td>
                <td class="cell-name">${r.name}</td>
                <td>${r.position}</td>
                <td>${r.school}</td>
                <td><span class="badge-leave">${r.type_of_leave}</span></td>
                <td>${r.inclusive_dates}</td>
                <td><span class="remark-badge-preview ${remarkType}">${r.remarks}</span></td>
                <td>${r.date_of_action}</td>
                <td>${r.deduction_remarks}</td>
                <td>${r.incharge}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
    document.getElementById('importModal').classList.add('active');
}

function closeImportModal() {
    document.getElementById('importModal').classList.remove('active');
    pendingImportData = [];
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const importModal = document.getElementById('importModal');
        if (importModal && importModal.classList.contains('active')) {
            closeImportModal();
        }
    }
});


function confirmImport() {
    if (pendingImportData.length === 0) return;

    const btn = document.getElementById('btnConfirmImport');
    btn.disabled = true;
    btn.classList.add('loading');

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ url("/leave-records/bulk") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ records: pendingImportData, source: 'leave-records' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Unknown error occurred'));
            btn.disabled = false;
            btn.classList.remove('loading');
        }
    })
    .catch(err => {
        alert('Failed to connect to server');
        btn.disabled = false;
        btn.classList.remove('loading');
    });
}
function formatDate(dateStr, includeTime = false) {
    if (!dateStr) return '-';
    try {
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return dateStr;
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        const yyyy = date.getFullYear();
        
        let formatted = `${mm}-${dd}-${yyyy}`;
        if (includeTime) {
            const h = date.getHours();
            const hh = String(h > 12 ? h - 12 : (h === 0 ? 12 : h)).padStart(2, '0');
            const min = String(date.getMinutes()).padStart(2, '0');
            const ampm = h >= 12 ? 'PM' : 'AM';
            formatted += ` ${hh}:${min} ${ampm}`;
        }
        return formatted;
    } catch (e) {
        return dateStr;
    }
}

// ── Export Logic ──
function toggleSelectionMode(force = null) {
    const checksums = document.querySelectorAll('.col-checkbox');
    const isVisible = force !== null ? force : (checksums[0].style.display === 'none');
    
    checksums.forEach(c => c.style.display = isVisible ? '' : 'none');
    // Also show/hide inline forwarded checkboxes (inside forwarded-header-content)
    document.querySelectorAll('.forwarded-checkbox').forEach(cb => cb.style.display = isVisible ? '' : 'none');
    
    const exportBar = document.getElementById('exportBar');
    if (!isVisible) {
        exportBar.classList.remove('active');
    } else {
        // Show the bar immediately so user sees feedback
        exportBar.classList.add('active');
        document.getElementById('selectedCount').textContent = '...';
    }
    
    // Refresh table — updateSelectionCount is called after the table rebuilds
    fetchMasterRecords(isVisible);
}

function updateSelectionCount() {
    const checked = document.querySelectorAll('.row-checkbox:checked').length;
    const bar = document.getElementById('exportBar');
    const countSpan = document.getElementById('selectedCount');
    const colCheckboxHeader = document.querySelector('th.col-checkbox');
    const isExportMode = colCheckboxHeader && colCheckboxHeader.style.display !== 'none';
    
    countSpan.textContent = checked;
    if (isExportMode) {
        bar.classList.add('active');
    } else {
        bar.classList.remove('active');
    }
}

function toggleAllCheckboxes(checked) {
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.checked = checked;
    });
    document.querySelectorAll('.forwarded-checkbox').forEach(cb => {
        cb.checked = checked;
    });
    document.querySelectorAll('.batch-checkbox').forEach(cb => {
        cb.checked = checked;
    });
    updateSelectionCount();
}

function toggleBatchCheckbox(batchId, checked) {
    // Toggle all forwarded checkboxes and row checkboxes in this batch
    document.querySelectorAll(`.forwarded-checkbox[data-batch="${batchId}"]`).forEach(cb => {
        cb.checked = checked;
    });
    document.querySelectorAll(`tr[data-batch="${batchId}"]:not(.batch-header-row):not(.forwarded-header-row) .row-checkbox`).forEach(cb => {
        cb.checked = checked;
    });
    updateSelectionCount();
}

function toggleForwardedCheckbox(forwarded, batchId, checked) {
    // Toggle all row checkboxes matching this forwarded AND batch
    document.querySelectorAll(`tr[data-forwarded="${forwarded}"][data-batch="${batchId}"]:not(.forwarded-header-row) .row-checkbox`).forEach(cb => {
        cb.checked = checked;
    });
    // Sync batch checkbox
    syncBatchCheckbox(batchId);
    updateSelectionCount();
}

function onRowCheckboxChange(forwarded, batchId) {
    // Sync forwarded checkbox state
    syncForwardedCheckbox(forwarded, batchId);
    // Sync batch checkbox state
    syncBatchCheckbox(batchId);
    updateSelectionCount();
}

function syncForwardedCheckbox(forwarded, batchId) {
    const rows = document.querySelectorAll(`tr[data-forwarded="${forwarded}"][data-batch="${batchId}"]:not(.forwarded-header-row) .row-checkbox`);
    const allChecked = Array.from(rows).every(cb => cb.checked);
    const forwardedCb = document.querySelector(`.forwarded-checkbox[data-forwarded="${forwarded}"][data-batch="${batchId}"]`);
    if (forwardedCb) forwardedCb.checked = allChecked;
}

function syncBatchCheckbox(batchId) {
    const forwardedCbs = document.querySelectorAll(`.forwarded-checkbox[data-batch="${batchId}"]`);
    const allChecked = Array.from(forwardedCbs).every(cb => cb.checked);
    const batchCb = document.querySelector(`.batch-checkbox[data-batch="${batchId}"]`);
    if (batchCb) batchCb.checked = allChecked;
}

function downloadSelectedExcel() {
    const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    if (selectedCheckboxes.length === 0) return alert('Please select records to export');

    let html = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta charset="utf-8">
            <!--[if gte mso 9]>
            <xml>
            <${'x' + ':'}ExcelWorkbook>
                <${'x' + ':'}ExcelWorksheets>
                    <${'x' + ':'}ExcelWorksheet>
                        <${'x' + ':'}Name>Leave Records</${'x' + ':'}Name>
                        <${'x' + ':'}WorksheetOptions>
                            <${'x' + ':'}DisplayGridlines/>
                        </${'x' + ':'}WorksheetOptions>
                    </${'x' + ':'}ExcelWorksheet>
                </${'x' + ':'}ExcelWorksheets>
            </${'x' + ':'}ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                body { font-family: Arial, sans-serif; font-size: 10pt; }
                table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 10pt; }
                th { background-color: #f1f5f9; color: #1e293b; font-weight: bold; border: 1px solid #cbd5e1; padding: 10px; font-family: Arial, sans-serif; font-size: 10pt; }
                td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; font-family: Arial, sans-serif; font-size: 10pt; }
                .forwarded-header { background-color: #f8fafc; font-weight: bold; text-align: center; border: 1px solid #e2e8f0; }
                .batch-spacer { height: 20px; background-color: transparent; border: none; }
                
                /* Remark Colors */
                .remark-with-pay { color: #16a34a; font-weight: 600; }
                .remark-without-pay { color: #dc2626; font-weight: 600; }
                .remark-both { color: #7c3aed; font-weight: 600; }
            </style>
        </head>
        <body>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>School</th>
                        <th>Type of Leave</th>
                        <th>Inclusive Dates</th>
                        <th>Remarks</th>
                        <th>Date of Action</th>
                        <th>Deduction Remarks</th>
                        <th>Incharge</th>
                    </tr>
                </thead>
                <tbody>
    `;

    const rows = document.querySelectorAll('#masterTableBody tr');
    let counter = 1;
    let lastExportedBatch = null;
    
    // Color mapping for consistent forwarded headers
    const forwardedColorMap = {};
    const pastelColors = [
        '#e0f2fe', // light blue
        '#fef2f2', // light red
        '#f0fdf4', // light green
        '#f5f3ff', // light purple
        '#fff7ed', // light yellow
        '#ecfeff', // light cyan
        '#fdf2f8', // light pink
        '#ffedd5', // light orange
    ];
    let nextColorIdx = 0;

    function getForwardedColor(name) {
        const cleanName = (name || '').trim().toLowerCase();
        if (!forwardedColorMap[cleanName]) {
            forwardedColorMap[cleanName] = pastelColors[nextColorIdx % pastelColors.length];
            nextColorIdx++;
        }
        return forwardedColorMap[cleanName];
    }

    // Walk through rows in order - emit headers exactly as they appear on screen
    rows.forEach(row => {
        const batchId = row.getAttribute('data-batch');

        if (row.classList.contains('batch-header-row')) {
            // Check if any selected rows exist in this batch
            let hasSelected = false;
            let next = row.nextElementSibling;
            while (next && !next.classList.contains('batch-header-row')) {
                const cb = next.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    hasSelected = true;
                    break;
                }
                next = next.nextElementSibling;
            }
            
            // If it's not the first batch we are exporting and it has selected items, add a spacer row
            if (hasSelected && lastExportedBatch !== null) {
                html += `<tr class="batch-spacer"><td colspan="10" style="border:none; height:20px;"></td></tr>`;
            }
            if (hasSelected) lastExportedBatch = batchId;

        } else if (row.classList.contains('forwarded-header-row')) {
            const forwardedName = row.getAttribute('data-forwarded');
            let hasSelected = false;
            let next = row.nextElementSibling;
            while (next && !next.classList.contains('forwarded-header-row') && !next.classList.contains('batch-header-row')) {
                const cb = next.querySelector('.row-checkbox');
                if (cb && cb.checked) {
                    hasSelected = true;
                    break;
                }
                next = next.nextElementSibling;
            }
            
            if (hasSelected) {
                const dateEl = row.querySelector('.header-date-badge');
                const groupDate = (dateEl && dateEl.style.display !== 'none') ? dateEl.textContent.trim() : '';
                const headerText = groupDate ? `${forwardedName}    -    ${groupDate}` : forwardedName;
                const bgColor = getForwardedColor(forwardedName);
                
                html += `<tr><td colspan="10" class="forwarded-header" style="background-color: ${bgColor}; border: 1px solid #cbd5e1;">${headerText}</td></tr>`;
            }
        } else if (row.getAttribute('data-remarks')) {
            const cb = row.querySelector('.row-checkbox');
            if (cb && cb.checked) {
                const cells = row.cells;
                const remarksText = cells[7].textContent.trim();
                const lowerRemarks = remarksText.toLowerCase();
                
                let remarkStyleClass = '';
                if (lowerRemarks.includes('with pay') && lowerRemarks.includes('without pay')) {
                    remarkStyleClass = 'remark-both';
                } else if (lowerRemarks.includes('with pay') || lowerRemarks.includes('approved')) {
                    remarkStyleClass = 'remark-with-pay';
                } else if (lowerRemarks.includes('without pay') || lowerRemarks.includes('disapproved')) {
                    remarkStyleClass = 'remark-without-pay';
                }

                html += `
                    <tr>
                        <td>${counter++}</td>
                        <td>${cells[2].textContent.trim()}</td>
                        <td>${cells[3].textContent.trim()}</td>
                        <td>${cells[4].textContent.trim()}</td>
                        <td>${cells[5].textContent.trim()}</td>
                        <td>${cells[6].textContent.trim()}</td>
                        <td class="${remarkStyleClass}">${remarksText}</td>
                        <td>${cells[8].textContent.trim()}</td>
                        <td>${cells[9].textContent.trim()}</td>
                        <td>${cells[10].textContent.trim()}</td>
                    </tr>
                `;
            }
        }
    });

    html += `
                </tbody>
            </table>
        </body>
        </html>
    `;

    const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    
    const timestamp = new Date().toISOString().slice(0, 10);
    a.href = url;
    a.download = `Leave_Records_Master_Export_${timestamp}.xls`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    toggleSelectionMode(false);
}
</script>

</body>
</html>
