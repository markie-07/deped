<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Positions - DepEd Manager</title>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="page-title">Positions Directory</h1>
                        <p class="page-subtitle">Manage and view professional roles in the division</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="count-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        <span id="positionCount">0</span> Positions
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search positions...">
                </div>
            </div>

            <!-- Positions Grid -->
            <div class="positions-grid" id="positionsGrid"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="empty-title">No Positions Found</h3>
                <p class="empty-text">Try adjusting your search term</p>
            </div>

        </div>
    </main>

<style>
    /* ═══════════════════════════════════════
       POSITIONS PAGE — MODERN DESIGN
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

    .count-badge {
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
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    /* ── Grid ── */
    .positions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }

    /* ── Position Card ── */
    .position-card {
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

    .position-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .position-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .position-card:hover::after {
        opacity: 1;
    }

    .position-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .position-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .position-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.01em;
        line-height: 1.2;
    }

    .position-stats {
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .stat-value {
        font-size: 0.85rem;
        font-weight: 800;
        color: #3b82f6;
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

<!-- Position Modal -->
<div class="modal-overlay" id="positionModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">
                <div class="position-avatar-modal" id="modalPosAvatar"></div>
                <span id="modalPosName">Position Name</span>
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
                    <input type="date" id="modalFilterDate" class="form-input" style="padding: 8px 12px; width: auto; border: 1.5px solid #e8ecf4; border-radius: 12px; font-size: 0.84rem; outline: none;" onchange="fetchPositionRecords()">
                </div>
            </div>
            <button class="modal-close" onclick="closePositionModal()">
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
                        <th>School</th>
                        <th>Type of Leave</th>
                        <th>Inclusive Dates</th>
                        <th>Remarks</th>
                        <th>Date of Action</th>
                        <th>Deduction Remarks</th>
                    </tr>
                </thead>
                <tbody id="positionTableBody">
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
        max-width: 1200px;
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
    .position-avatar-modal {
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
    let allPositions = [];
    let currentPosForModal = '';

    const positionsGrid = document.getElementById('positionsGrid');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('positionCount');
    const modal = document.getElementById('positionModal');

    // Fetch positions from API
    fetch('/leave-records/positions')
        .then(res => res.json())
        .then(data => {
            allPositions = data;
            renderPositions();
        })
        .catch(err => {
            console.error('Error fetching positions:', err);
            positionsGrid.innerHTML = '<p style="text-align:center; color:#ef4444;">Error loading positions</p>';
        });

    function getInitials(name) {
        return name.split(' ').filter(w => w.length > 1).slice(0, 2).map(w => w[0]).join('');
    }

    function renderPositions(filter = '') {
        const filtered = allPositions.filter(p => p.position.toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;

        if (filtered.length === 0) {
            positionsGrid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        positionsGrid.innerHTML = filtered.map(item => `
            <div class="position-card" onclick="openPositionModal('${item.position.replace(/'/g, "\\'")}')">
                <div class="position-info">
                    <div class="position-avatar">${getInitials(item.position)}</div>
                    <div class="position-name">${item.position}</div>
                </div>
                <div class="position-stats">
                    <span class="stat-value">${item.leave_count}</span>
                    <span class="stat-label">Leave${item.leave_count !== 1 ? 's' : ''}</span>
                </div>
            </div>
        `).join('');
    }

    searchInput.addEventListener('input', function() {
        renderPositions(this.value);
    });

    window.openPositionModal = function(posName) {
        modal.classList.add('open');
        currentPosForModal = posName;
        document.getElementById('modalPosName').textContent = posName;
        document.getElementById('modalPosAvatar').textContent = getInitials(posName);
        document.getElementById('modalSearch').value = '';
        
        // Default date is empty to show all records
        document.getElementById('modalFilterDate').value = '';
        
        fetchPositionRecords();
    };

    window.fetchPositionRecords = function() {
        const posName = currentPosForModal;
        const date = document.getElementById('modalFilterDate').value;
        const url = `/leave-records/by-position?position=${encodeURIComponent(posName)}&date=${encodeURIComponent(date)}`;
        
        const tbody = document.getElementById('positionTableBody');
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
                            <td style="color:#475569;">${r.school || '-'}</td>
                            <td><span style="font-size:0.75rem; font-weight:600; background:#eff6ff; color:#3b82f6; padding:4px 8px; border-radius:12px;">${r.type_of_leave}</span></td>
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
        const rows = document.querySelectorAll('#positionTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.cells.length < 2) return;
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(q);
            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        const tbody = document.getElementById('positionTableBody');
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

    window.closePositionModal = function() {
        modal.classList.remove('open');
    };

    modal.addEventListener('click', function(e) {
        if (e.target === modal) closePositionModal();
    });
});
</script>

</body>
</html>
