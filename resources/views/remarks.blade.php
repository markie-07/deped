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
    @include('partials.sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left">
                    <div class="page-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="page-title">Remarks Analysis</h1>
                        <p class="page-subtitle">Track and manage action outcomes and comments</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="count-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                        </svg>
                        <span id="remarkCount">0</span> Remarks
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search remarks...">
                </div>
            </div>

            <!-- Remarks Grid -->
            <div class="remarks-grid" id="remarksGrid"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
                <h3 class="empty-title">No Remarks Found</h3>
                <p class="empty-text">Try adjusting your search term</p>
            </div>

        </div>
    </main>

<style>
    /* ═══════════════════════════════════════
       REMARKS PAGE — MODERN DESIGN
       ═══════════════════════════════════════ */

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
        background: linear-gradient(135deg, #f59e0b, #d97706);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
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

    .count-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 24px;
        background: #fffbeb;
        color: #d97706;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .count-badge svg {
        width: 16px;
        height: 16px;
    }

    .count-badge span {
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

    .search-input:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.08);
    }

    /* ── Grid ── */
    .remarks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }

    /* ── Remark Card ── */
    .remark-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 14px;
        position: relative;
        overflow: hidden;
    }

    .remark-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .remark-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .remark-card:hover::after {
        opacity: 1;
    }

    .remark-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .remark-badge-type {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 800;
        background: #fff7ed;
        color: #f97316;
    }

    .remark-content {
        flex: 1;
        min-width: 0;
    }

    .remark-text {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.01em;
        line-height: 1.2;
    }

    .remark-stats {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .stat-value {
        font-size: 0.9rem;
        font-weight: 800;
        color: #d97706;
    }

    .stat-label {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 600;
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
</style>

<!-- Remark Modal -->
<div class="modal-overlay" id="remarkModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">
                <div class="remark-avatar-modal" id="modalRemarkAvatar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px; height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
                <span id="modalRemarkText">Remark Details</span>
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
                    <input type="date" id="modalFilterDate" class="form-input" style="padding: 8px 12px; width: auto; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.84rem; outline: none;" onchange="fetchRemarkRecords()">
                </div>
            </div>
            <button class="modal-close" onclick="closeRemarkModal()">
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
                        <th>School</th>
                        <th>Type of Leave</th>
                        <th>Inclusive Dates</th>
                        <th>Date of Action</th>
                        <th>Deduction Remarks</th>
                    </tr>
                </thead>
                <tbody id="remarkTableBody">
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
        max-width: 1300px;
        border-radius: 16px;
        padding: 24px;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
    .remark-avatar-modal {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
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
    .record-table tr:hover td {
        background: #fcfcfc;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allRemarks = [];
    let currentRemarkForModal = '';

    const remarksGrid = document.getElementById('remarksGrid');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('remarkCount');
    const modal = document.getElementById('remarkModal');

    // Fetch remarks from API
    fetch('/leave-records/remarks-list')
        .then(res => res.json())
        .then(data => {
            allRemarks = data;
            renderRemarks();
        })
        .catch(err => {
            console.error('Error fetching remarks:', err);
            remarksGrid.innerHTML = '<p style="text-align:center; color:#ef4444;">Error loading remarks</p>';
        });

    function getInitial(text) {
        return text[0].toUpperCase();
    }

    function getRemarkClass(remark) {
        const lower = remark.toLowerCase();
        if (lower.includes('approved') || lower.includes('with pay')) return 'badge-green';
        if (lower.includes('disapproved') || lower.includes('cancelled') || lower.includes('without pay')) return 'badge-red';
        if (lower.includes('pending') || lower.includes('review')) return 'badge-yellow';
        return 'badge-gray';
    }

    function renderRemarks(filter = '') {
        const filtered = allRemarks.filter(r => r.remarks.toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;

        if (filtered.length === 0) {
            remarksGrid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        remarksGrid.innerHTML = filtered.map(item => `
            <div class="remark-card" onclick="openRemarkModal('${item.remarks.replace(/'/g, "\\'")}')">
                <div class="remark-info">
                    <div class="remark-badge-type">${getInitial(item.remarks)}</div>
                    <div class="remark-content">
                        <div class="remark-text">${item.remarks}</div>
                    </div>
                </div>
                <div class="remark-stats">
                    <span class="stat-value">${item.leave_count}</span>
                    <span class="stat-label">Occurrence${item.leave_count !== 1 ? 's' : ''}</span>
                </div>
            </div>
        `).join('');
    }

    searchInput.addEventListener('input', function() {
        renderRemarks(this.value);
    });

    window.openRemarkModal = function(remarkText) {
        modal.classList.add('open');
        currentRemarkForModal = remarkText;
        document.getElementById('modalRemarkText').textContent = remarkText;
        document.getElementById('modalSearch').value = '';
        
        // Default date is empty to show all records
        document.getElementById('modalFilterDate').value = '';
        
        fetchRemarkRecords();
    };

    window.fetchRemarkRecords = function() {
        const remark = currentRemarkForModal;
        const date = document.getElementById('modalFilterDate').value;
        const url = `/leave-records/by-remark?remark=${encodeURIComponent(remark)}&date=${encodeURIComponent(date)}`;
        
        const tbody = document.getElementById('remarkTableBody');
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">Loading records...</td></tr>';

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">No records found.</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map(r => `
                    <tr>
                        <td style="font-weight: 600; color:#1e293b;">${r.name}</td>
                        <td style="color:#475569;">${r.position || '-'}</td>
                        <td style="color:#475569;">${r.school || '-'}</td>
                        <td><span style="font-size:0.75rem; font-weight:600; background:#eff6ff; color:#3b82f6; padding:4px 8px; border-radius:12px;">${r.type_of_leave}</span></td>
                        <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.inclusive_dates || '-'}</td>
                        <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.date_of_action || '-'}</td>
                        <td style="color:#64748b; font-size: 0.8rem;">${r.deduction_remarks || '-'}</td>
                    </tr>
                `).join('');

                if (document.getElementById('modalSearch').value) {
                    filterModalRecords();
                }
            })
            .catch(() => {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #ef4444;">Error loading records.</td></tr>';
            });
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

    window.closeRemarkModal = function() {
        modal.classList.remove('open');
    };

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeRemarkModal();
    });
});
</script>

</body>
</html>
