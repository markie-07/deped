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
    @include('partials.sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left">
                    <div class="page-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="page-title">Schools Directory</h1>
                        <p class="page-subtitle">All registered schools under DepEd Division</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="school-count-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        <span id="schoolCount">0</span> Schools
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search schools...">
                </div>
            </div>

            <!-- High Schools Section -->
            <div id="highSchoolSection">
                <h3 class="section-title">High Schools & Integrated</h3>
                <div class="schools-grid" id="highSchoolGrid"></div>
            </div>

            <!-- Elementary Schools Section -->
            <div id="elementarySection" style="margin-top: 40px;">
                <h3 class="section-title">Elementary Schools</h3>
                <div class="schools-grid" id="elementarySchoolGrid"></div>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                </div>
                <h3 class="empty-title">No Schools Found</h3>
                <p class="empty-text">Try adjusting your search term</p>
            </div>

        </div>
    </main>

<style>
    /* ═══════════════════════════════════════
       SCHOOLS PAGE — MODERN DESIGN
       ═══════════════════════════════════════ */

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }

    .page-header-icon svg {
        width: 24px;
        height: 24px;
        color: #fff;
    }

    .page-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.03em;
    }

    .page-subtitle {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    .page-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .school-count-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 24px;
        background: #eff6ff;
        color: #3b82f6;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .school-count-badge svg {
        width: 16px;
        height: 16px;
    }

    .school-count-badge span {
        font-weight: 800;
        font-size: 0.88rem;
    }

    /* ── Search Bar ── */
    .search-bar {
        margin-bottom: 24px;
    }

    .search-input-wrapper {
        position: relative;
        max-width: 400px;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: #94a3b8;
        pointer-events: none;
        transition: color 0.2s;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 46px;
        border: 1.5px solid #e8ecf4;
        border-radius: 14px;
        font-size: 0.84rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        background: #fff;
        outline: none;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .search-input::placeholder { color: #c0c7d6; }

    .search-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    .search-input-wrapper:focus-within .search-icon {
        color: #6366f1;
    }

    /* ── Schools Grid ── */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .schools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 18px;
    }

    /* ── School Card ── */
    .school-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        cursor: default;
    }

    .school-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 18px 18px 0 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .school-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }

    .school-card:hover::before {
        opacity: 1;
    }

    /* Color variants for top accent bar */
    .school-card:nth-child(6n+1)::before { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
    .school-card:nth-child(6n+2)::before { background: linear-gradient(90deg, #3b82f6, #06b6d4); }
    .school-card:nth-child(6n+3)::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .school-card:nth-child(6n+4)::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .school-card:nth-child(6n+5)::before { background: linear-gradient(90deg, #ef4444, #f97316); }
    .school-card:nth-child(6n+6)::before { background: linear-gradient(90deg, #ec4899, #a855f7); }

    .school-card-top {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 16px;
    }

    .school-avatar {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 800;
        flex-shrink: 0;
        letter-spacing: -0.03em;
    }

    /* Avatar color variants */
    .school-card:nth-child(6n+1) .school-avatar { background: #eef2ff; color: #6366f1; }
    .school-card:nth-child(6n+2) .school-avatar { background: #eff6ff; color: #3b82f6; }
    .school-card:nth-child(6n+3) .school-avatar { background: #ecfdf5; color: #10b981; }
    .school-card:nth-child(6n+4) .school-avatar { background: #fffbeb; color: #f59e0b; }
    .school-card:nth-child(6n+5) .school-avatar { background: #fef2f2; color: #ef4444; }
    .school-card:nth-child(6n+6) .school-avatar { background: #fdf4ff; color: #a855f7; }

    .school-card-info {
        flex: 1;
        min-width: 0;
    }

    .school-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.01em;
        line-height: 1.3;
        margin-bottom: 4px;
    }

    .school-type {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    .school-type.elementary { background: #ecfdf5; color: #059669; }
    .school-type.high-school { background: #eff6ff; color: #2563eb; }
    .school-type.integrated { background: #faf5ff; color: #7c3aed; }

    .school-card-stats {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .school-stat {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .school-stat svg {
        width: 15px;
        height: 15px;
        color: #94a3b8;
    }

    .school-stat-value {
        font-size: 0.78rem;
        font-weight: 700;
        color: #475569;
    }

    .school-stat-label {
        font-size: 0.68rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 20px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon svg {
        width: 36px;
        height: 36px;
        color: #94a3b8;
    }

    .empty-title {
        font-size: 1rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    .empty-text {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .search-input-wrapper {
            max-width: 100%;
        }

        .schools-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="modal-overlay" id="schoolModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">
                <div class="school-avatar-modal" id="modalSchoolAvatar"></div>
                <span id="modalSchoolName">School Name</span>
            </h2>
            <div style="display: flex; align-items: center; gap: 16px; margin-left: auto; margin-right: 16px;">
                <div class="input-wrapper" style="width: 280px; position: relative;">
                    <div class="input-icon" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input type="text" id="modalSearch" class="form-input" placeholder="Search records..." style="padding: 8px 12px 8px 38px; width: 100%; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.84rem; outline: none;">
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label for="modalFilterDate" style="font-size: 0.8rem; font-weight: 600; color: #64748b; white-space: nowrap;">Date:</label>
                    <input type="date" id="modalFilterDate" class="form-input" style="padding: 8px 12px; width: auto; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.84rem; outline: none;" onchange="fetchSchoolRecords()">
                </div>
            </div>
            <button class="modal-close" onclick="closeSchoolModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <table class="record-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Type of Leave</th>
                        <th>Inclusive Dates</th>
                        <th>Remarks</th>
                        <th>Date of Action</th>
                        <th>Deduction Remarks</th>
                    </tr>
                </thead>
                <tbody id="schoolTableBody">
                    <tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">Loading records...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* ── Modal Styles ── */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(2px);
    }
    .modal-overlay.open {
        opacity: 1;
        pointer-events: auto;
    }
    .modal-container {
        background: white;
        width: 90%;
        max-width: 1100px;
        border-radius: 16px;
        padding: 24px;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .modal-overlay.open .modal-container {
        transform: translateY(0);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
        gap: 16px;
    }
    .modal-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .school-avatar-modal {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }
    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .modal-close:hover {
        background: #f1f5f9;
        color: #64748b;
    }
    .modal-body {
        overflow-y: auto;
        flex: 1;
    }
    .record-table {
        width: 100%;
        border-collapse: collapse;
    }
    .record-table th {
        text-align: left;
        padding: 12px 16px;
        font-size: 0.76rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748b;
        background: #f8fafc;
        position: sticky;
        top: 0;
    }
    .record-table td {
        padding: 14px 16px;
        font-size: 0.84rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    .record-table tr:last-child td {
        border-bottom: none;
    }
    .record-table tr:hover td {
        background: #fcfcfc;
    }
    .badge {
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-green { background: #ecfdf5; color: #059669; }
    .badge-red { background: #fef2f2; color: #dc2626; }
    .badge-yellow { background: #fffbeb; color: #d97706; }
    .badge-gray { background: #f1f5f9; color: #64748b; }
    
    .school-card { cursor: pointer; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allSchools = [];

    const highSchoolGrid = document.getElementById('highSchoolGrid');
    const elementarySchoolGrid = document.getElementById('elementarySchoolGrid');
    const highSchoolSection = document.getElementById('highSchoolSection');
    const elementarySection = document.getElementById('elementarySection');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('schoolCount');
    const modal = document.getElementById('schoolModal');

    // Fetch schools from API
    fetch('/leave-records/schools')
        .then(res => res.json())
        .then(data => {
            allSchools = data;
            renderSchools();
        })
        .catch(err => {
            console.error('Error fetching schools:', err);
            highSchoolGrid.innerHTML = '<p style="text-align:center; color:#ef4444;">Error loading schools</p>';
        });


    function getInitials(name) {
        return name.split(' ').filter(w => w.length > 2).slice(0, 2).map(w => w[0]).join('');
    }

    function determineType(name) {
        const lower = name.toLowerCase();
        if (lower.includes('high school') || lower.includes('secondary') || lower.includes('nhs')) return { type: 'High School', class: 'high-school' };
        if (lower.includes('integrated')) return { type: 'Integrated', class: 'integrated' };
        if (lower.includes('elementary') || lower.includes('es')) return { type: 'Elementary', class: 'elementary' };
        return { type: 'School', class: 'elementary' }; // Default
    }
    
    function createSchoolCard(item) {
        const typeInfo = determineType(item.school);
        const leaveCount = item.leave_count;
        
        return `
            <div class="school-card" onclick="openSchoolModal('${item.school.replace(/'/g, "\\'")}')">
                <div class="school-card-top">
                    <div class="school-avatar">${getInitials(item.school)}</div>
                    <div class="school-card-info">
                        <div class="school-name">${item.school}</div>
                        <span class="school-type ${typeInfo.class}">${typeInfo.type}</span>
                    </div>
                </div>
                <div class="school-card-stats">
                    <div class="school-stat" style="margin-left: auto;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span class="school-stat-value">${leaveCount}</span>
                        <span class="school-stat-label">Leave${leaveCount !== 1 ? 's' : ''}</span>
                    </div>
                </div>
            </div>
        `;
    }

    window.renderSchools = function(filter = '') {
        const filtered = allSchools.filter(s => s.school.toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;

        if (filtered.length === 0) {
            highSchoolSection.style.display = 'none';
            elementarySection.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        
        const highSchools = [];
        const elementarySchools = [];

        filtered.forEach(school => {
            const type = determineType(school.school).type;
            if (type === 'High School' || type === 'Integrated') {
                highSchools.push(school);
            } else {
                elementarySchools.push(school);
            }
        });

        // Render High Schools
        if (highSchools.length > 0) {
            highSchoolSection.style.display = 'block';
            highSchoolGrid.innerHTML = highSchools.map(item => createSchoolCard(item)).join('');
        } else {
            highSchoolSection.style.display = 'none';
        }

        // Render Elementary Schools
        if (elementarySchools.length > 0) {
            elementarySection.style.display = 'block';
            elementarySchoolGrid.innerHTML = elementarySchools.map(item => createSchoolCard(item)).join('');
        } else {
            elementarySection.style.display = 'none';
        }
    };

    searchInput.addEventListener('input', function() {
        renderSchools(this.value);
    });

    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#schoolTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.cells.length < 2) return; // Skip "No records" or "Loading" rows
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
                noResultsRow.innerHTML = `<td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">No records matching "${q}"</td>`;
                tbody.appendChild(noResultsRow);
            } else {
                existingNoResults.innerHTML = `<td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">No records matching "${q}"</td>`;
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
        document.getElementById('modalSchoolAvatar').textContent = getInitials(schoolName);
        document.getElementById('modalSearch').value = ''; // Clear search when opening
        
        // Default date is empty to show all records
        document.getElementById('modalFilterDate').value = '';
        
        fetchSchoolRecords();
    };

    window.fetchSchoolRecords = function() {
        const schoolName = currentSchoolForModal;
        const date = document.getElementById('modalFilterDate').value;
        const url = `/leave-records/by-school?school=${encodeURIComponent(schoolName)}&date=${encodeURIComponent(date)}`;
        
        const tbody = document.getElementById('schoolTableBody');
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">Loading records...</td></tr>';

        // Fetch employees for this school
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">No records found.</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map(r => {
                    let remarkClass = 'badge-gray';
                    const rem = (r.remarks || '').toLowerCase();
                    if (rem === 'approved' || rem === 'with pay') remarkClass = 'badge-green';
                    else if (rem === 'disapproved' || rem === 'without pay' || rem === 'cancelled') remarkClass = 'badge-red';
                    else if (rem === 'pending' || rem === 'for review') remarkClass = 'badge-yellow';
                    
                    const remarkBadge = r.remarks ? `<span class="badge ${remarkClass}">${r.remarks}</span>` : '-';

                    return `
                        <tr>
                            <td style="font-weight: 600; color:#1e293b;">${r.name}</td>
                            <td style="color:#475569;">${r.position || '-'}</td>
                            <td><span style="font-size:0.75rem; font-weight:600; background:#eff6ff; color:#3b82f6; padding:4px 8px; border-radius:12px;">${r.type_of_leave}</span></td>
                            <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.inclusive_dates || '-'}</td>
                            <td>${remarkBadge}</td>
                            <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.date_of_action || '-'}</td>
                            <td style="color:#64748b; font-size: 0.8rem;">${r.deduction_remarks || '-'}</td>
                        </tr>
                    `;
                }).join('');

                // Apply search filter if there's an active query
                if (document.getElementById('modalSearch').value) {
                    filterModalRecords();
                }
            })
            .catch(() => {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #ef4444;">Error loading records.</td></tr>';
            });
    };

    window.closeSchoolModal = function() {
        modal.classList.remove('open');
    };

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeSchoolModal();
    });
});
</script>

</body>
</html>
