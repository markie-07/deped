<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Incharge Registry - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f8fafc; color: #1e293b; }
    </style>
</head>
<body>
    @include('partials.sidebar')

    <main class="main-content">
        @include('partials.navigation')
        <div class="content-body">

            <!-- Page Header -->
            <div class="page-header-card">
                <div class="header-main">
                    <div class="header-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75c-2.213 0-4.204.957-5.592 2.486m11.582 0a7.488 7.488 0 0 1-5.99 2.764c-2.213 0-4.204-.957-5.593-2.487m11.583 0a7.488 7.488 0 0 0-2.235-4.521M4.508 18.725a7.488 7.488 0 0 1 2.235-4.521M12 12.75A3.75 3.75 0 1 0 12 5.25a3.75 3.75 0 0 0 0 7.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="header-title">Incharge Registry</h2>
                        <p class="header-subtitle">Authorized personnel who processed leave records</p>
                    </div>
                </div>
                <div class="header-actions">
                    <div class="incharge-count-badge">
                        <span id="inchargeCount">0</span> Incharges
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="search-section">
                <div class="search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" id="inchargeSearch" placeholder="Filter incharges by name...">
                </div>
            </div>

            <!-- Incharge Grid -->
            <div class="incharge-grid" id="inchargeGrid">
                <!-- Data populated via JS -->
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="empty-state" style="display: none;">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h3>No Incharge Personnel Found</h3>
                <p>Try searching for a different name</p>
            </div>

        </div>
    </main>

    <!-- Incharge Records Modal -->
    <div class="modal-overlay" id="inchargeModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-avatar" id="modalAvatar"></div>
                    <div>
                        <h3 id="modalInchargeName">Incharge Name</h3>
                        <p id="modalInchargeCount">0 records found</p>
                    </div>
                </div>
                <div class="modal-header-right">
                    <div class="modal-search">
                        <input type="text" id="modalSearch" placeholder="Search within records...">
                    </div>
                    <div class="modal-date-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <input type="date" id="modalFilterDate" onchange="fetchInchargeRecords()" title="Filter by date">
                    </div>
                    <button class="modal-close" onclick="closeInchargeModal()">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="records-table">
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inchargeTableBody">
                            <!-- Data populated via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    /* ── Incharge Page CSS ── */
    .page-header-card {
        background: #fff; padding: 24px 32px; border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px; border: 1px solid #f1f5f9;
    }
    .header-main { display: flex; align-items: center; gap: 20px; }
    .header-icon-box {
        width: 54px; height: 54px; background: linear-gradient(135deg, #10b981, #06b6d4);
        border-radius: 16px; display: flex; align-items: center; justify-content: center;
        color: #fff; box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.4);
    }
    .header-icon-box svg { width: 28px; height: 28px; }
    .header-title { font-size: 1.4rem; font-weight: 800; color: #1e293b; letter-spacing: -0.02em; }
    .header-subtitle { font-size: 0.85rem; color: #64748b; margin-top: 2px; }

    .incharge-count-badge {
        padding: 8px 16px; background: #ecfdf5; color: #059669;
        border-radius: 12px; font-weight: 700; font-size: 0.9rem;
    }

    .search-section { margin-bottom: 32px; }
    .search-box { position: relative; max-width: 400px; }
    .search-box svg {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        width: 18px; height: 18px; color: #94a3b8;
    }
    .search-box input {
        width: 100%; padding: 12px 16px 12px 42px;
        border: 1.5px solid #e2e8f0; border-radius: 14px;
        font-size: 0.9rem; outline: none; transition: all 0.2s;
    }
    .search-box input:focus { border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }

    .incharge-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    .incharge-card {
        background: #fff; padding: 14px 18px; border-radius: 14px;
        border: 1px solid #f1f5f9; cursor: pointer; transition: all 0.25s ease;
        display: flex; align-items: center; gap: 16px;
        position: relative; overflow: hidden;
    }
    .incharge-card:hover { 
        background: #fdfdfd;
        border-color: #10b981; 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04);
        transform: translateX(4px);
    }

    .card-avatar {
        width: 44px; height: 44px; border-radius: 12px;
        background: #f1f5f9; color: #64748b; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; flex-shrink: 0; transition: all 0.25s;
    }
    .incharge-card:hover .card-avatar { 
        background: #10b981; color: #fff;
    }

    .card-info-wrap { flex: 1; min-width: 0; }
    .card-name { font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    
    .card-meta { display: flex; align-items: center; gap: 6px; }
    .meta-item { display: flex; align-items: center; gap: 4px; font-size: 0.72rem; color: #94a3b8; font-weight: 600; }
    .incharge-card:hover .meta-item { color: #10b981; }
    .meta-icon { width: 12px; height: 12px; }

    .card-action-indicator {
        width: 28px; height: 28px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #cbd5e1; transition: all 0.25s;
    }
    .incharge-card:hover .card-action-indicator { 
        background: #ecfdf5; color: #10b981;
    }

    /* ── Modal Design ── */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center; z-index: 1000;
    }
    .modal-overlay.open { display: flex; }

    .modal-container {
        background: #fff; width: 92%; max-width: 1100px; border-radius: 24px;
        max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        padding: 24px 32px; border-bottom: 1px solid #f1f5f9;
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-header-left { display: flex; align-items: center; gap: 16px; }
    .modal-avatar {
        width: 48px; height: 48px; border-radius: 12px;
        background: #10b981; color: #fff; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
    }
    .modal-header-left h3 { font-size: 1.25rem; font-weight: 800; color: #1e293b; }
    .modal-header-left p { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }

    .modal-header-right { display: flex; align-items: center; gap: 16px; }
    .modal-search input {
        padding: 8px 16px; border: 1.5px solid #f1f5f9; border-radius: 10px;
        font-size: 0.85rem; width: 220px; outline: none;
    }
    .modal-close {
        background: #f1f5f9; border: none; width: 36px; height: 36px;
        border-radius: 10px; color: #64748b; font-size: 1.5rem;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
    .modal-close:hover { background: #fee2e2; color: #ef4444; }

    .modal-date-wrapper { position: relative; }
    .modal-date-wrapper svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #94a3b8; pointer-events: none; }
    .modal-date-wrapper input { padding: 9px 14px 9px 34px; border: 1.5px solid #f1f5f9; border-radius: 10px; font-size: 0.85rem; width: 150px; outline: none; transition: all 0.25s; color: #475569; background: #fff; cursor: pointer; }
    .modal-date-wrapper input::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; transition: 0.2s; }
    .modal-date-wrapper input::-webkit-calendar-picker-indicator:hover { opacity: 1; }
    .modal-date-wrapper input:focus { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08); }

    .modal-body { padding: 0; overflow-y: auto; flex: 1; }
    .table-responsive { width: 100%; border-collapse: collapse; }
    .records-table { width: 100%; border-collapse: collapse; text-align: left; }
    .records-table th {
        background: #f8fafc; padding: 16px 24px; font-size: 0.7rem;
        font-weight: 700; color: #64748b; text-transform: uppercase;
        letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9;
        position: sticky; top: 0; z-index: 10;
    }
    .records-table td { padding: 16px 24px; border-bottom: 1px solid #f8fafc; font-size: 0.85rem; color: #475569; }

    /* ── Reuse Badges ── */
    .badge-leave {
        font-size: 0.7rem; font-weight: 600; padding: 4px 8px;
        border-radius: 8px; background: #eff6ff; color: #3b82f6;
    }
    .remark-badge {
        font-size: 0.72rem; font-weight: 700; padding: 4px 10px;
        border-radius: 8px; display: inline-block;
    }
    .remark-badge.green { background: #ecfdf5; color: #10b981; }
    .remark-badge.red { background: #fef2f2; color: #ef4444; }
    .remark-badge.yellow { background: #fffbeb; color: #f59e0b; }
    .remark-badge.gray { background: #f1f5f9; color: #64748b; }

    .empty-state { text-align: center; padding: 100px 20px; color: #94a3b8; }
    .empty-icon { width: 80px; height: 80px; background: #f1f5f9; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
    .empty-icon svg { width: 40px; height: 40px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allIncharges = [];
    const grid = document.getElementById('inchargeGrid');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('inchargeCount');

    // Fetch incharges
    fetch('/leave-records/incharges')
        .then(res => res.json())
        .then(data => {
            allIncharges = data;
            renderGrid();
        });

    function getInitials(name) {
        return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    }

    function renderGrid(filter = '') {
        const filtered = allIncharges.filter(i => (i.incharge || '').toLowerCase().includes(filter.toLowerCase()));
        countEl.textContent = filtered.length;

        if (filtered.length === 0) {
            grid.innerHTML = '';
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';
        grid.innerHTML = filtered.map(i => `
            <div class="incharge-card" onclick="openInchargeModal('${i.incharge.replace(/'/g, "\\'")}')">
                <div class="card-avatar">${getInitials(i.incharge)}</div>
                <div class="card-info-wrap">
                    <div class="card-name">${i.incharge}</div>
                    <div class="card-meta">
                        <div class="meta-item">
                            <svg class="meta-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>${i.leave_count} Record${i.leave_count !== 1 ? 's' : ''}</span>
                        </div>
                    </div>
                </div>
                <div class="card-action-indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" style="width: 14px; height: 14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
        `).join('');
    }

    document.getElementById('inchargeSearch').addEventListener('input', (e) => renderGrid(e.target.value));

    // Modal Logic
    const modal = document.getElementById('inchargeModal');
    let currentIncharge = '';

    window.openInchargeModal = function(name) {
        currentIncharge = name;
        modal.classList.add('open');
        document.getElementById('modalInchargeName').textContent = name;
        document.getElementById('modalAvatar').textContent = getInitials(name);
        document.getElementById('modalSearch').value = '';
        document.getElementById('modalFilterDate').value = '';
        fetchInchargeRecords();
    };

    window.closeInchargeModal = function() {
        modal.classList.remove('open');
    };

    function fetchInchargeRecords() {
        const tbody = document.getElementById('inchargeTableBody');
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding: 40px;">Loading records...</td></tr>';

        const date = document.getElementById('modalFilterDate').value;
        fetch(`/leave-records/by-incharge?incharge=${encodeURIComponent(currentIncharge)}&date=${encodeURIComponent(date)}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalInchargeCount').textContent = `${data.length} record${data.length !== 1 ? 's' : ''} found`;
                tbody.innerHTML = data.map((r, index) => {
                    let remarkClass = 'gray';
                    const rem = (r.remarks || '').toLowerCase();
                    if (rem.includes('approved') || rem.includes('with pay')) remarkClass = 'green';
                    else if (rem.includes('disapproved') || rem.includes('without pay') || rem.includes('cancelled')) remarkClass = 'red';
                    else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'yellow';

                    return `
                        <tr>
                            <td style="color:#94a3b8; font-family:monospace; font-size:0.75rem;">${index + 1}</td>
                            <td style="font-weight:700; color:#1e293b;">${r.name}</td>
                            <td>${r.position || '-'}</td>
                            <td>${r.school || '-'}</td>
                            <td><span class="badge-leave">${r.type_of_leave || '-'}</span></td>
                            <td style="font-family:monospace; font-size:0.75rem;">${r.inclusive_dates || '-'}</td>
                            <td><span class="remark-badge ${remarkClass}">${r.remarks || '-'}</span></td>
                            <td style="font-family:monospace; font-size:0.75rem;">${r.date_of_action || '-'}</td>
                            <td>
                                <div style="display:flex; gap:8px;">
                                    <button onclick="editRecord(${r.id})" style="border:none; background:#f0fdf4; color:#22c55e; padding:6px; border-radius:8px; cursor:pointer;" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            });
    }

    // Modal search
    document.getElementById('modalSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#inchargeTableBody tr');
        rows.forEach(row => {
            if (row.cells.length > 1) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            }
        });
    });

    window.editRecord = function(id) {
        window.location.href = `/form?edit=${id}`;
    };

    modal.addEventListener('click', (e) => { if(e.target === modal) closeInchargeModal(); });
});
</script>

</body>
</html>
