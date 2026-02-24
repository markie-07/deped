<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees - DepEd Manager</title>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="page-title">Employee Directory</h1>
                        <p class="page-subtitle">All registered personnel with submitted leave records</p>
                    </div>
                </div>
                <div class="page-header-right">
                    <div class="count-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        <span id="employeeCount">0</span> Employees
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-input-wrapper">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" id="searchInput" class="search-input" placeholder="Search employees by name, school, or position...">
                </div>
            </div>

            <!-- Employees Grid -->
            <div class="employees-grid" id="employeesGrid"></div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h3 class="empty-title">No Employees Found</h3>
                <p class="empty-text">Try adjusting your search term</p>
            </div>

        </div>
    </main>

    <!-- Modal for Employee Records -->
    <div class="modal-overlay" id="employeeModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2 class="modal-title">
                    <div class="employee-avatar-modal" id="modalEmployeeAvatar">JD</div>
                    <span id="modalEmployeeName">Employee Name</span>
                </h2>
                <div class="modal-actions" style="margin-left: auto; display: flex; align-items: center; gap: 12px;">
                     <div class="modal-search-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input type="text" id="modalSearch" placeholder="Filter details...">
                    </div>
                    <button class="modal-close" onclick="closeEmployeeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="record-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Type of Leave</th>
                                <th>Inclusive Dates</th>
                                <th>Remarks</th>
                                <th>Date of Action</th>
                                <th>Deduction Remarks</th>
                                <th>Incharge</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody">
                            <tr><td colspan="10" style="text-align:center; padding: 40px; color: #94a3b8;">Loading details...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<style>
    /* ═══════════════════════════════════════
       EMPLOYEES PAGE — MODERN CARD DESIGN
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
    .search-bar { margin-bottom: 28px; }
    .search-input-wrapper { position: relative; max-width: 550px; }
    .search-icon {
        position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
        width: 20px; height: 20px; color: #cbd5e1; pointer-events: none;
    }
    .search-input {
        width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0;
        border-radius: 16px; font-size: 0.88rem; font-family: 'Inter', sans-serif;
        color: #1e293b; background: #fff; outline: none; transition: all 0.25s ease;
    }
    .search-input:focus {
        border-color: #6366f1; box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.08);
    }

    /* ── Employees Grid ── */
    .employees-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    /* ── Employee Card ── */
    .employee-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }

    .employee-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.06);
        border-color: #e2e8f0;
    }

    .employee-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0; width: 45px; height: 45px;
        background: linear-gradient(135deg, transparent 50%, #eff6ff 50%);
        border-bottom-left-radius: 100%;
        opacity: 0; transition: opacity 0.3s ease;
    }

    .employee-card:hover::after { opacity: 1; }

    .employee-card-header {
        display: flex; align-items: center; gap: 16px; margin-bottom: 20px;
    }

    .employee-avatar {
        width: 50px; height: 50px; border-radius: 15px;
        background: #f1f5f9; color: #64748b;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.1rem; flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .employee-card:hover .employee-avatar {
        background: #6366f1; color: #fff;
    }

    .employee-info { flex: 1; min-width: 0; }
    .employee-name {
        font-size: 1rem; font-weight: 700; color: #1e293b;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    .employee-meta {
        font-size: 0.72rem; font-weight: 500; color: #94a3b8; text-transform: uppercase;
        letter-spacing: 0.05em; display: block;
    }

    .employee-card-details {
        display: flex; flex-direction: column; gap: 8px;
        padding-top: 15px; border-top: 1px solid #f8fafc;
    }

    .detail-item {
        display: flex; align-items: center; gap: 10px; font-size: 0.78rem; color: #64748b;
    }

    .detail-item svg { width: 14px; height: 14px; color: #cbd5e1; }

    .record-count-tag {
        position: absolute; bottom: 20px; right: 24px;
        padding: 4px 12px; background: #f5f3ff; color: #6366f1;
        border-radius: 12px; font-size: 0.68rem; font-weight: 700;
    }

    /* ── Modal Design ── */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px);
        display: flex; justify-content: center; align-items: center;
        z-index: 1000; opacity: 0; pointer-events: none; transition: all 0.4s ease;
    }
    .modal-overlay.open { opacity: 1; pointer-events: auto; }

    .modal-container {
        background: #fff; width: 92%; max-width: 1150px; border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        transform: scale(0.95) translateY(30px); transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;
    }
    .modal-overlay.open .modal-container { transform: scale(1) translateY(0); }

    .modal-header {
        padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center;
    }
    .employee-avatar-modal {
        width: 48px; height: 48px; border-radius: 14px; background: #6366f1; color: #fff;
        display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;
    }
    .modal-title {
        font-size: 1.25rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 16px;
    }

    .modal-search-wrapper { position: relative; margin-right: 15px; }
    .modal-search-wrapper svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; color: #94a3b8;
    }
    .modal-search-wrapper input {
        padding: 8px 12px 8px 34px; border: 1.5px solid #f1f5f9; border-radius: 10px;
        font-size: 0.8rem; width: 220px; outline: none; transition: border 0.2s;
    }
    .modal-search-wrapper input:focus { border-color: #6366f1; }

    .modal-close {
        background: #f8fafc; border: none; width: 40px; height: 40px; border-radius: 12px;
        color: #94a3b8; cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .modal-close:hover { background: #fee2e2; color: #ef4444; }

    .modal-body { padding: 0; overflow-y: auto; flex: 1; }

    /* ── Record Table ── */
    .table-responsive { width: 100%; border-collapse: collapse; }
    .record-table { width: 100%; border-collapse: collapse; }
    .record-table th {
        background: #f8fafc; padding: 16px 24px; text-align: left;
        font-size: 0.72rem; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.05em;
        position: sticky; top: 0; z-index: 10;
        border-bottom: 1px solid #f1f5f9;
    }
    .record-table td {
        padding: 16px 24px; font-size: 0.84rem; color: #475569; border-bottom: 1px solid #f1f5f9;
    }
    .record-table tr:hover td { background: #fafbff; }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-edit {
        background: #f0fdf4;
        color: #16a34a;
    }

    .btn-edit:hover {
        background: #16a34a;
        color: #fff;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: #fff;
    }

    .badge-leave {
        font-size: 0.72rem; font-weight: 600; padding: 4px 10px;
        border-radius: 8px; background: #eef2ff; color: #6366f1;
    }

    .remark-badge {
        font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px;
    }
    .remark-badge.green { background: #ecfdf5; color: #10b981; }
    .remark-badge.red { background: #fef2f2; color: #ef4444; }
    .remark-badge.yellow { background: #fffbeb; color: #f59e0b; }
    .remark-badge.gray { background: #f8fafc; color: #94a3b8; }

    /* ── Empty State ── */
    .empty-state { text-align: center; padding: 100px 0; }
    .empty-icon { width: 100px; height: 100px; background: #f1f5f9; border-radius: 30px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; }
    .empty-icon svg { width: 40px; height: 40px; color: #cbd5e1; }
    .empty-title { font-size: 1.1rem; color: #475569; font-weight: 700; margin-bottom: 8px; }
    .empty-text { color: #94a3b8; font-size: 0.9rem; }

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let allEmployees = [];
    const grid = document.getElementById('employeesGrid');
    const searchInput = document.getElementById('searchInput');
    const emptyState = document.getElementById('emptyState');
    const countEl = document.getElementById('employeeCount');
    const modal = document.getElementById('employeeModal');

    // Fetch Unique Employees
    fetch('/api/employees')
        .then(res => res.json())
        .then(data => {
            allEmployees = data;
            renderEmployees();
        })
        .catch(err => {
            console.error('Error:', err);
            grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 50px; color: #ef4444;">Error loading employee list.</p>';
        });

    function getInitials(name) {
        return name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
    }

    function renderEmployees(filter = '') {
        const q = filter.toLowerCase();
        const filtered = allEmployees.filter(e => 
            e.name.toLowerCase().includes(q) ||
            (e.school && e.school.toLowerCase().includes(q)) ||
            (e.position && e.position.toLowerCase().includes(q))
        );

        countEl.textContent = filtered.length;

        if (filtered.length === 0) {
            grid.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        grid.style.display = 'grid';
        emptyState.style.display = 'none';

        grid.innerHTML = filtered.map(emp => `
            <div class="employee-card" onclick="openEmployeeModal('${emp.name.replace(/'/g, "\\'")}')">
                <div class="employee-card-header">
                    <div class="employee-avatar">${getInitials(emp.name)}</div>
                    <div class="employee-info">
                        <div class="employee-name">${emp.name}</div>
                        <span class="employee-meta">Teacher Personnel</span>
                    </div>
                </div>
                <div class="employee-card-details">
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        <span>${emp.position || 'No Position Set'}</span>
                    </div>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        <span>${emp.school || 'Unassigned School'}</span>
                    </div>
                </div>
                <div class="record-count-tag">${emp.record_count} Record${emp.record_count !== 1 ? 's' : ''}</div>
            </div>
        `).join('');
    }

    searchInput.addEventListener('input', function() {
        renderEmployees(this.value);
    });

    // Modal Logic
    let currentEmployeeForModal = '';

    window.openEmployeeModal = function(name) {
        currentEmployeeForModal = name;
        modal.classList.add('open');
        document.getElementById('modalEmployeeName').textContent = name;
        document.getElementById('modalEmployeeAvatar').textContent = getInitials(name);
        document.getElementById('modalSearch').value = '';
        fetchEmployeeRecords();
    };

    window.closeEmployeeModal = function() {
        modal.classList.remove('open');
    };

    function fetchEmployeeRecords() {
        const tbody = document.getElementById('employeeTableBody');
        tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 60px; color: #94a3b8;"><div class="loading-spinner"></div> Loading details for ' + currentEmployeeForModal + '...</td></tr>';

        fetch(`/api/employees/records?name=${encodeURIComponent(currentEmployeeForModal)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                throw new Error(text || 'Server Error');
            }
            return res.json();
        })
        .then(data => {
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 60px; color: #94a3b8;">No records found.</td></tr>';
                return;
            }

            tbody.innerHTML = data.map((r, index) => {
                let remarkClass = 'gray';
                const rem = (r.remarks || '').toLowerCase();
                if (rem.includes('approved') || rem.includes('with pay')) remarkClass = 'green';
                else if (rem.includes('disapproved') || rem.includes('without pay') || rem.includes('cancelled')) remarkClass = 'red';
                else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'yellow';

                return `
                    <tr>
                        <td style="color:#94a3b8; font-family:monospace; font-size:0.75rem;">${index + 1}</td>
                        <td style="font-weight: 600; color: #1e293b;">${r.position || '-'}</td>
                        <td style="color: #475569;">${r.school || '-'}</td>
                        <td><span class="badge-leave">${r.type_of_leave || '-'}</span></td>
                        <td style="font-family: monospace; font-size: 0.75rem;">${r.inclusive_dates || '-'}</td>
                        <td><span class="remark-badge ${remarkClass}">${r.remarks || '-'}</span></td>
                        <td style="font-family: monospace; font-size: 0.75rem;">${r.date_of_action || '-'}</td>
                        <td style="font-size: 0.8rem; color: #64748b;">${r.deduction_remarks || '-'}</td>
                        <td style="font-size: 0.8rem; color: #64748b;">${r.incharge || '-'}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button onclick="editRecord(${r.id})" class="btn-action btn-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button onclick="deleteRecord(${r.id})" class="btn-action btn-delete" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px; height:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        })
        .catch((err) => {
            console.error('Fetch error:', err);
            tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding: 60px; color: #ef4444;">Error loading records: ' + err.message.substring(0, 100) + '...</td></tr>';
        });
    }

    window.editRecord = function(id) {
        // Redirect to form with edit parameter
        window.location.href = `/form?edit=${id}`;
    };

    window.deleteRecord = function(id) {
        if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/leave-records/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                fetchEmployeeRecords(); // Refresh modal
                fetchEmployees(); // Refresh cards in background
            } else {
                alert('Error deleting record');
            }
        })
        .catch(() => {
            alert('Error deleting record. Please try again.');
        });
    };

    // Modal interior search
    document.getElementById('modalSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#employeeTableBody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeEmployeeModal();
    });
});
</script>

</body>
</html>
