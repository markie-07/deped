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
                        <h1 class="page-title">Types of Leave</h1>
                        <p class="page-subtitle">Directory of leave categories and statistics</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="count-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
                        </svg>
                        <span id="typeCount">0</span> Types
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search leave types...">
                </div>
            </div>

            <!-- Leave Types Grid -->
            <div class="types-grid" id="typesGrid"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                    </svg>
                </div>
                <h3 class="empty-title">No Leave Types Found</h3>
                <p class="empty-text">Try adjusting your search term</p>
            </div>

        </div>
    </main>

<style>
    /* ═══════════════════════════════════════
       LEAVE TYPES PAGE — MODERN DESIGN
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
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
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
        background: #ecfdf5;
        color: #059669;
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
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.08);
    }

    /* ── Grid ── */
    .types-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 18px;
    }

    /* ── Leave Type Card ── */
    .type-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: relative;
        overflow: hidden;
    }

    .type-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .type-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #34d399);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .type-card:hover::after {
        opacity: 1;
    }

    .type-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .type-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f0fdf4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-weight: 700;
        font-size: 1rem;
    }

    .type-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.01em;
        line-height: 1.2;
    }

    .type-stats {
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
        color: #10b981;
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

<!-- Leave Type Modal -->
<div class="modal-overlay" id="typeModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">
                <div class="type-avatar-modal" id="modalTypeAvatar"></div>
                <span id="modalTypeName">Leave Type</span>
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
                    <input type="date" id="modalFilterDate" class="form-input" style="padding: 8px 12px; width: auto; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.84rem; outline: none;" onchange="fetchTypeRecords()">
                </div>
            </div>
            <button class="modal-close" onclick="closeTypeModal()">
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
                        <th>Inclusive Dates</th>
                        <th>Remarks</th>
                        <th>Date of Action</th>
                        <th>Deduction Remarks</th>
                    </tr>
                </thead>
                <tbody id="typeTableBody">
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
    .type-avatar-modal {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #10b981, #34d399);
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allTypes = [];
    let currentTypeForModal = '';

    const typesGrid = document.getElementById('typesGrid');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('typeCount');
    const modal = document.getElementById('typeModal');

    // Fetch leave types from API
    fetch('/leave-records/types')
        .then(res => res.json())
        .then(data => {
            allTypes = data;
            renderTypes();
        })
        .catch(err => {
            console.error('Error fetching types:', err);
            typesGrid.innerHTML = '<p style="text-align:center; color:#ef4444;">Error loading leave types</p>';
        });

    function getInitials(name) {
        return name.split(' ').filter(w => w.length > 2).slice(0, 2).map(w => w[0]).join('');
    }

    function renderTypes(filter = '') {
        const filtered = allTypes.filter(p => p.type_of_leave.toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;

        if (filtered.length === 0) {
            typesGrid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        typesGrid.innerHTML = filtered.map(item => `
            <div class="type-card" onclick="openTypeModal('${item.type_of_leave.replace(/'/g, "\\'")}')">
                <div class="type-info">
                    <div class="type-avatar">${getInitials(item.type_of_leave) || item.type_of_leave[0]}</div>
                    <div class="type-name">${item.type_of_leave}</div>
                </div>
                <div class="type-stats">
                    <span class="stat-value">${item.leave_count}</span>
                    <span class="stat-label">Record${item.leave_count !== 1 ? 's' : ''}</span>
                </div>
            </div>
        `).join('');
    }

    searchInput.addEventListener('input', function() {
        renderTypes(this.value);
    });

    window.openTypeModal = function(typeName) {
        modal.classList.add('open');
        currentTypeForModal = typeName;
        document.getElementById('modalTypeName').textContent = typeName;
        document.getElementById('modalTypeAvatar').textContent = getInitials(typeName) || typeName[0];
        document.getElementById('modalSearch').value = '';
        
        // Default date is empty to show all records
        document.getElementById('modalFilterDate').value = '';
        
        fetchTypeRecords();
    };

    window.fetchTypeRecords = function() {
        const typeName = currentTypeForModal;
        const date = document.getElementById('modalFilterDate').value;
        const url = `/leave-records/by-type?type=${encodeURIComponent(typeName)}&date=${encodeURIComponent(date)}`;
        
        const tbody = document.getElementById('typeTableBody');
        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 30px; color: #94a3b8;">Loading records...</td></tr>';

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
                            <td style="color:#475569;">${r.school || '-'}</td>
                            <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.inclusive_dates || '-'}</td>
                            <td>${remarkBadge}</td>
                            <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.date_of_action || '-'}</td>
                            <td style="color:#64748b; font-size: 0.8rem;">${r.deduction_remarks || '-'}</td>
                        </tr>
                    `;
                }).join('');

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
        const rows = document.querySelectorAll('#typeTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.cells.length < 2) return;
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(q);
            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        const tbody = document.getElementById('typeTableBody');
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

    window.closeTypeModal = function() {
        modal.classList.remove('open');
    };

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeTypeModal();
    });
});
</script>

</body>
</html>
