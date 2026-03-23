<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Account Management - DepEd Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f5f6fa; overflow-x: hidden; width: 100%; }
        html { overflow-x: hidden; }
    </style>
</head>
<body>
    @include('partials.sidebar')

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
                        System Administration
                    </div>
                    <h1 class="hero-title">Account Management</h1>
                    <p class="hero-desc">Create, manage, and control user accounts for the DepEd Manager system.</p>
                    <div class="hero-meta">
                        <div class="hero-meta-item">
                            <div class="hmi-icon hmi-icon-indigo">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num" id="totalAccounts">—</span>
                                <span class="hmi-label">Total Accounts</span>
                            </div>
                        </div>
                        <div class="hero-meta-divider"></div>
                        <div class="hero-meta-item">
                            <div class="hmi-icon hmi-icon-green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num hmi-num-green" id="activeAccounts">—</span>
                                <span class="hmi-label">Active</span>
                            </div>
                        </div>
                        <div class="hero-meta-divider"></div>
                        <div class="hero-meta-item">
                            <div class="hmi-icon hmi-icon-red">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </div>
                            <div>
                                <span class="hmi-num hmi-num-red" id="inactiveAccounts">—</span>
                                <span class="hmi-label">Inactive</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-search-card">
                        <p class="hsc-label">Quick Actions</p>
                        <button class="btn-add-account" onclick="openCreateModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Create New Account
                        </button>
                        <div class="hero-filter">
                            <div class="filter-select-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                </svg>
                                <select id="statusFilter" onchange="renderAccounts()">
                                    <option value="all">All Accounts</option>
                                    <option value="active">Active Only</option>
                                    <option value="inactive">Inactive Only</option>
                                </select>
                            </div>
                        </div>
                        <p class="hsc-hint">Manage system access for all users</p>
                    </div>
                </div>
            </div>

            <!-- Accounts Table -->
            <div class="accounts-table-card">
                <div class="table-header">
                    <div class="table-header-left">
                        <h3 class="table-title">User Accounts</h3>
                        <span class="table-count" id="tableCount">0 accounts</span>
                    </div>
                    <div class="table-search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" id="tableSearch" placeholder="Search accounts..." oninput="renderAccounts()">
                    </div>
                </div>
                <!-- Role Tabs -->
                <div class="table-tabs">
                    <button class="table-tab active" data-role="user" onclick="setRoleFilter('user')">Standard Users</button>
                    <button class="table-tab" data-role="admin" onclick="setRoleFilter('admin')">Administrators</button>
                    <button class="table-tab" data-role="pending" onclick="setRoleFilter('pending')" style="position:relative;">
                        Pending Approval
                        <span id="pendingDot" style="display:none; position:absolute; top:-2px; right:-2px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid var(--card-bg, #fff);"></span>
                    </button>
                </div>
                <div class="table-wrap">
                    <table class="accounts-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="accountsTableBody">
                            <tr><td colspan="7" class="table-loading">Loading accounts...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="emptyState" style="display:none;" class="empty-wrap">
                    <div class="empty-art">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <h3>No Accounts Found</h3>
                    <p>Try a different search or filter</p>
                </div>
            </div>

        </div>
    </main>

    <!-- ═══════════ CREATE / EDIT MODAL ═══════════ -->
    <div class="modal-backdrop" id="accountModal" onclick="handleBackdropClick(event)">
        <div class="modal-card">
            <!-- Removed modal-close-x to force use of Cancel button -->
            <div class="modal-layout">
                <!-- LEFT PANEL: Profile -->
                <div class="modal-left">
                    <div class="modal-left-content">
                        <div class="profile-upload" id="profileUploadArea" onclick="document.getElementById('inputProfileImage').click()">
                            <img id="profilePreview" src="" alt="" style="display:none;">
                            <div class="profile-upload-placeholder" id="profilePlaceholder">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" /></svg>
                                <span>Upload Photo</span>
                            </div>
                            <input type="file" id="inputProfileImage" accept="image/*" style="display:none;" onchange="previewImage(this)">
                        </div>
                        <p class="modal-left-hint">Click to upload a profile photo</p>
                        <div class="modal-left-icon-row">
                            <div class="modal-card-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" /></svg></div>
                        </div>
                        <h2 class="modal-card-title" id="modalTitle">Create New Account</h2>
                        <p class="modal-card-desc" id="modalDesc">Fill in the details to create a new user account.</p>
                    </div>
                </div>
                <!-- RIGHT PANEL: Form -->
                <div class="modal-right">
                    <div class="modal-card-body">
                        <input type="hidden" id="editId" value="">
                        <div class="form-field"><label class="form-label">Username <span class="req">*</span></label><div class="form-input-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg><input type="text" id="inputUsername" placeholder="e.g. jdelacruz"></div></div>
                        <div class="form-row">
                            <div class="form-field"><label class="form-label">Last Name <span class="req">*</span></label><div class="form-input-wrap"><input type="text" id="inputLastName" placeholder="Dela Cruz"></div></div>
                            <div class="form-field"><label class="form-label">First Name <span class="req">*</span></label><div class="form-input-wrap"><input type="text" id="inputFirstName" placeholder="Juan"></div></div>
                        </div>
                        <div class="form-row">
                            <div class="form-field"><label class="form-label">Middle Name</label><div class="form-input-wrap"><input type="text" id="inputMiddleName" placeholder="Santos"></div></div>
                            <div class="form-field"><label class="form-label">Suffix</label><div class="form-input-wrap"><input type="text" id="inputSuffix" placeholder="Jr., III"></div></div>
                        </div>
                        <div class="form-field"><label class="form-label">Position</label><div class="form-input-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" /></svg><input type="text" id="inputPosition" placeholder="e.g. Administrative Officer"></div></div>
                        <div class="form-row">
                            <div class="form-field"><label class="form-label">System Role <span class="req">*</span></label><div class="form-input-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg><select id="inputRole" style="flex:1;border:none;outline:none;background:transparent;padding:11px 0;font-size:0.82rem;font-family:inherit;color:#1e293b;"><option value="user">User</option><option value="admin">Administrator</option></select></div></div>
                            <div class="form-field" id="statusFieldArea"><label class="form-label">Account Status <span class="req">*</span></label><div class="form-input-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg><select id="inputStatus" style="flex:1;border:none;outline:none;background:transparent;padding:11px 0;font-size:0.82rem;font-family:inherit;color:#1e293b;"><option value="1">Active</option><option value="0">Inactive</option></select></div></div>
                        </div>
                        <div class="form-field" id="approvalFieldArea"><label class="form-label">Approval Status <span class="req">*</span></label><div class="form-input-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg><select id="inputApproved" style="flex:1;border:none;outline:none;background:transparent;padding:11px 0;font-size:0.82rem;font-family:inherit;color:#1e293b;"><option value="1">Approved</option><option value="0">Pending</option></select></div></div>
                        <div class="form-field"><label class="form-label">Email Address <span class="req">*</span></label><div class="form-input-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg><input type="email" id="inputEmail" placeholder="e.g. juan@deped.gov.ph"></div></div>
                        <div class="form-row">
                            <div class="form-field">
                                <label class="form-label" id="passwordLabel">Password <span class="req">*</span></label>
                                <div class="form-input-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                                    <input type="password" id="inputPassword" placeholder="Min 8 chars">
                                    <button type="button" class="pw-toggle-btn" onclick="toggleModalPassword('inputPassword', this)" title="Show password">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="eye-open"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="eye-closed" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-field">
                                <label class="form-label" id="confirmLabel">Confirm Password <span class="req">*</span></label>
                                <div class="form-input-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                                    <input type="password" id="inputConfirmPassword" placeholder="Repeat password">
                                    <button type="button" class="pw-toggle-btn" onclick="toggleModalPassword('inputConfirmPassword', this)" title="Show password">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="eye-open"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="eye-closed" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p class="form-hint" id="passwordHint">Must be at least 8 characters long.</p>
                        <div class="modal-error" id="modalError" style="display:none;"></div>
                    </div>
                    <div class="modal-card-footer">
                        <button class="btn-cancel" onclick="closeModal()">Cancel</button>
                        <button class="btn-save" id="btnSave" onclick="saveAccount()"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> Create Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   ACCOUNT MANAGEMENT PAGE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

/* ── Hero Banner ── */
.hero-banner {
    position: relative;
    background: #fff;
    border-radius: 22px;
    border: 1.5px solid #e8edf5;
    display: flex;
    align-items: stretch;
    overflow: hidden;
    margin-bottom: 28px;
    box-shadow: 0 4px 24px rgba(99,102,241,0.07);
}
.hero-dots {
    position: absolute; inset: 0;
    background-image: radial-gradient(circle, #c7d2fe 1px, transparent 1px);
    background-size: 22px 22px;
    opacity: 0.45; pointer-events: none; border-radius: 22px;
}
.hero-left { flex: 1; padding: 32px 36px; position: relative; z-index: 1; }
.hero-tag {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 20px;
    background: #eef2ff; color: #6366f1;
    font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px;
}
.hero-tag svg { width: 13px; height: 13px; }
.hero-title { font-size: 1.65rem; font-weight: 900; color: #1e1b4b; letter-spacing: -0.035em; line-height: 1.1; margin-bottom: 10px; }
.hero-desc { font-size: 0.82rem; color: #64748b; line-height: 1.6; max-width: 420px; margin-bottom: 24px; }
.hero-meta { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
.hero-meta-item { display: flex; align-items: center; gap: 10px; }
.hmi-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.hmi-icon svg { width: 16px; height: 16px; }
.hmi-icon-indigo { background: #eef2ff; }
.hmi-icon-indigo svg { color: #6366f1; }
.hmi-icon-green { background: #ecfdf5; }
.hmi-icon-green svg { color: #10b981; }
.hmi-icon-red { background: #fef2f2; }
.hmi-icon-red svg { color: #ef4444; }
.hmi-num { display: block; font-size: 1.2rem; font-weight: 900; color: #1e1b4b; line-height: 1; }
.hmi-num-green { color: #059669; }
.hmi-num-red { color: #ef4444; }
.hmi-label { display: block; font-size: 0.63rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 2px; }
.hero-meta-divider { width: 1px; height: 36px; background: #e2e8f0; }

.hero-right {
    width: 340px; flex-shrink: 0;
    background: linear-gradient(145deg, #f5f3ff 0%, #ede9fe 100%);
    border-left: 1.5px solid #e0e7ff;
    display: flex; align-items: center; justify-content: center;
    padding: 24px; position: relative; z-index: 1;
}
.hero-search-card { width: 100%; }
.hsc-label { font-size: 0.72rem; font-weight: 700; color: #4f46e5; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; }
.hsc-hint { font-size: 0.68rem; color: #a5b4fc; margin-top: 12px; text-align: center; }

/* Add Account Button */
.btn-add-account {
    width: 100%;
    padding: 13px 20px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border: none; border-radius: 14px;
    color: #fff; font-size: 0.84rem; font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 16px rgba(99,102,241,0.3);
    transition: all 0.3s ease;
}
.btn-add-account svg { width: 16px; height: 16px; }
.btn-add-account:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(99,102,241,0.4);
}

/* Filter Dropdown */
.hero-filter { margin-top: 10px; }
.filter-select-wrap {
    position: relative; display: flex; align-items: center;
    background: #fff; border-radius: 14px; border: 1.5px solid #ddd6fe;
    padding: 0 14px; box-shadow: 0 4px 16px rgba(99,102,241,0.08); transition: all 0.2s;
}
.filter-select-wrap:focus-within { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.filter-select-wrap svg { position: absolute; left: 14px; width: 14px; height: 14px; color: #a5b4fc; pointer-events: none; }
.filter-select-wrap:focus-within svg { color: #6366f1; }
.filter-select-wrap select {
    flex: 1; border: none; outline: none;
    padding: 11px 0 11px 26px; font-size: 0.78rem; font-weight: 700;
    font-family: inherit; color: #1e293b; background: transparent; cursor: pointer;
}

/* ── Accounts Table Card ── */
.accounts-table-card {
    background: #fff;
    border-radius: 22px;
    border: 1.5px solid #f1f5f9;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.04);
}
.table-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 28px;
    border-bottom: 1.5px solid #f1f5f9;
    gap: 16px;
}
.table-header-left { display: flex; align-items: center; gap: 12px; }
.table-title { font-size: 1rem; font-weight: 700; color: #1e293b; }
.table-count {
    font-size: 0.7rem; font-weight: 700;
    background: #eef2ff; color: #6366f1;
    padding: 3px 12px; border-radius: 20px;
}
.table-search-wrap {
    position: relative; display: flex; align-items: center;
    background: #f8fafc; border-radius: 12px; padding: 0 14px; gap: 8px;
    border: 1.5px solid transparent; transition: all 0.2s;
}
.table-search-wrap:focus-within { background: #fff; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.table-search-wrap svg { width: 14px; height: 14px; color: #94a3b8; flex-shrink: 0; }
.table-search-wrap:focus-within svg { color: #6366f1; }
.table-search-wrap input {
    border: none; outline: none; background: transparent;
    padding: 10px 0; font-size: 0.8rem;
    font-family: 'Inter', sans-serif; color: #1e293b; width: 220px;
}
.table-search-wrap input::placeholder { color: #b0bac9; }

/* ── Table Tabs ── */
.table-tabs {
    display: flex;
    gap: 32px;
    padding: 0 28px;
    background: #fff;
    border-bottom: 2px solid #f1f5f9;
}
.table-tab {
    padding: 16px 4px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #64748b;
    border: none;
    background: none;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
    font-family: inherit;
}
.table-tab:hover { color: #4f46e5; }
.table-tab.active { color: #4f46e5; }
.table-tab.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background: #4f46e5;
    border-radius: 4px;
}

.table-wrap {
    overflow-x: auto; scrollbar-width: none; -ms-overflow-style: none;
}
.table-wrap::-webkit-scrollbar { display: none; }

.accounts-table { width: 100%; border-collapse: collapse; text-align: left; }
.accounts-table thead th {
    background: #f8fafc; padding: 14px 20px;
    font-size: 0.68rem; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 0.06em;
    position: sticky; top: 0; z-index: 5;
    border-bottom: 2px solid #eef2ff; white-space: nowrap;
}
.accounts-table tbody td {
    padding: 16px 20px; font-size: 0.82rem; color: #475569;
    border-bottom: 1px solid #f8fafc; vertical-align: middle;
}
.accounts-table tbody tr { transition: background 0.15s; }
.accounts-table tbody tr:hover td { background: #fafaff; }
.accounts-table tbody tr:last-child td { border-bottom: none; }
.table-loading { text-align: center; padding: 60px !important; color: #94a3b8; font-size: 0.85rem; }

/* ── User cell ── */
.user-cell { display: flex; align-items: center; gap: 12px; min-width: 180px; }
.user-avatar, .user-avatar-img {
    width: 40px; height: 40px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 0.85rem; color: #fff;
    flex-shrink: 0;
    object-fit: cover;
}
.user-name { font-weight: 700; color: #1e293b; font-size: 0.85rem; display: block; line-height: 1.3; }

/* ── Status Badge ── */
.status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px;
    font-size: 0.7rem; font-weight: 700;
}
.status-badge .dot { width: 6px; height: 6px; border-radius: 50%; }
.status-badge.active { background: #ecfdf5; color: #059669; }
.status-badge.active .dot { background: #10b981; }
.status-badge.inactive { background: #fef2f2; color: #dc2626; }
.status-badge.inactive .dot { background: #ef4444; }
.status-badge.role-admin { background: #eef2ff; color: #6366f1; border: 1px solid #e0e7ff; }
.status-badge.role-user { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

/* ── Action Buttons ── */
.action-group { display: flex; gap: 8px; }
.btn-action {
    width: 34px; height: 34px; border-radius: 10px; border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.25s ease;
}
.btn-action svg { width: 14px; height: 14px; }
.btn-edit { background: #eef2ff; color: #6366f1; }
.btn-edit:hover { background: #6366f1; color: #fff; transform: scale(1.1); }
.btn-toggle-active { background: #fffbeb; color: #d97706; }
.btn-toggle-active:hover { background: #d97706; color: #fff; transform: scale(1.1); }
.btn-toggle-inactive { background: #ecfdf5; color: #10b981; }
.btn-toggle-inactive:hover { background: #10b981; color: #fff; transform: scale(1.1); }
.btn-delete { background: #fef2f2; color: #dc2626; }
.btn-delete:hover { background: #dc2626; color: #fff; transform: scale(1.1); }

/* ── Empty State ── */
.empty-wrap { text-align: center; padding: 60px 20px; }
.empty-art {
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
    border-radius: 24px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.empty-art svg { width: 44px; height: 44px; color: #a5b4fc; }
.empty-wrap h3 { font-size: 1.05rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
.empty-wrap p { font-size: 0.8rem; color: #94a3b8; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MODAL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(15,23,42,0.5);
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    z-index: 1000; opacity: 0; pointer-events: none;
    transition: opacity 0.3s ease;
}
.modal-backdrop.open { opacity: 1; pointer-events: auto; }

.modal-card {
    background: #fff; width: 94%; max-width: 920px;
    border-radius: 24px; overflow: hidden;
    box-shadow: 0 32px 80px -12px rgba(0,0,0,0.25);
    transform: scale(0.95) translateY(24px);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    display: flex; flex-direction: column;
}
.modal-backdrop.open .modal-card { transform: scale(1) translateY(0); }

.modal-layout { display: flex; flex: 1; min-height: 520px; overflow: hidden; }

/* Left Panel */
.modal-left {
    width: 240px; flex-shrink: 0;
    background: linear-gradient(160deg, #4f46e5 0%, #7c3aed 50%, #a78bfa 100%);
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
}
.modal-left::before {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 18px 18px; pointer-events: none;
}
.modal-left-content {
    position: relative; z-index: 1; text-align: center; padding: 32px 24px;
    display: flex; flex-direction: column; align-items: center; gap: 14px;
}
.modal-left-hint { font-size: 0.68rem; color: rgba(255,255,255,0.6); font-weight: 500; margin: 0; }
.modal-left-icon-row { margin-top: 8px; }
.modal-card-title { font-size: 1.05rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; text-align: center; }
.modal-card-desc { font-size: 0.72rem; color: rgba(255,255,255,0.65); margin-top: 0; text-align: center; }

.modal-card-icon {
    width: 42px; height: 42px; border-radius: 14px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.modal-card-icon svg { width: 20px; height: 20px; color: #fff; }

/* Right Panel */
.modal-right { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; position: relative; }

.modal-close-x {
    position: absolute; top: 16px; right: 16px; z-index: 10;
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(248,250,252,0.9); border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #94a3b8; transition: all 0.2s;
}
.modal-close-x svg { width: 16px; height: 16px; }
.modal-close-x:hover { background: #fee2e2; color: #ef4444; }

.modal-card-body { padding: 28px 28px 12px; flex: 1; overflow-y: auto; overflow-x: hidden !important; scrollbar-width: thin; }

.form-field { margin-bottom: 14px; }
.form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 5px; }
.form-input-wrap {
    position: relative; display: flex; align-items: center;
    background: #f8fafc; border: 1.5px solid #e8ecf4; border-radius: 12px;
    padding: 0 12px; gap: 8px; transition: all 0.2s;
}
.form-input-wrap:focus-within { background: #fff; border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.form-input-wrap svg { width: 15px; height: 15px; color: #94a3b8; flex-shrink: 0; }
.form-input-wrap:focus-within svg { color: #6366f1; }
.form-input-wrap input {
    flex: 1; border: none; outline: none; background: transparent;
    padding: 11px 0; font-size: 0.82rem;
    font-family: 'Inter', sans-serif; color: #1e293b;
}
.form-input-wrap input::placeholder { color: #c0c7d6; }
.form-hint { font-size: 0.65rem; color: #94a3b8; margin-top: 4px; }
.req { color: #ef4444; }
.form-row { display: flex; gap: 12px; flex-wrap: wrap; }
.form-row .form-field { flex: 1; min-width: 140px; }

/* Profile Upload */
.profile-upload {
    width: 110px; height: 110px; border-radius: 50%;
    background: rgba(255,255,255,0.12);
    border: 3px dashed rgba(255,255,255,0.35);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    cursor: pointer; overflow: hidden;
    transition: all 0.3s ease; position: relative;
}
.profile-upload:hover { border-color: #fff; background: rgba(255,255,255,0.2); transform: scale(1.05); }
.profile-upload img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; position: absolute; inset: 0; }
.profile-upload-placeholder { display: flex; flex-direction: column; align-items: center; gap: 6px; }
.profile-upload-placeholder svg { width: 30px; height: 30px; color: rgba(255,255,255,0.7); }
.profile-upload-placeholder span { font-size: 0.65rem; color: rgba(255,255,255,0.6); font-weight: 600; }

.modal-error {
    background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px;
    padding: 12px 16px; font-size: 0.8rem; color: #dc2626;
    margin-top: 4px;
}

.modal-card-footer {
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    padding: 0 28px 24px;
}
.btn-cancel {
    padding: 11px 24px; border-radius: 12px;
    border: 1.5px solid #e2e8f0; background: #fff;
    color: #64748b; font-size: 0.82rem; font-weight: 600;
    font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s;
}
.btn-cancel:hover { border-color: #cbd5e1; background: #f8fafc; }
.btn-save {
    padding: 11px 24px; border-radius: 12px; border: none;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-size: 0.82rem; font-weight: 700;
    font-family: 'Inter', sans-serif; cursor: pointer;
    display: flex; align-items: center; gap: 6px;
    box-shadow: 0 4px 14px rgba(99,102,241,0.3);
    transition: all 0.3s ease;
}
.btn-save svg { width: 14px; height: 14px; }
.btn-save:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(99,102,241,0.4); }

.pw-toggle-btn {
    background: none; border: none; padding: 0 4px;
    cursor: pointer; color: #94a3b8; display: flex; align-items: center; justify-content: center;
    transition: color 0.2s;
}
.pw-toggle-btn:hover { color: #6366f1; }
.pw-toggle-btn svg { width: 16px; height: 16px; }

/* ── Responsive ── */
/* Dynamic Classes */
.cell-idx { color: #cbd5e1; font-size: 0.75rem; font-family: monospace; }
.cell-username, .cell-email { color: #64748b; font-size: 0.8rem; }
.cell-created { font-family: monospace; font-size: 0.75rem; color: #94a3b8; }
.cell-pos { display: block; font-size: 0.7rem; color: #94a3b8; }

@media (max-width: 768px) {
    .content-body { padding: 12px 14px !important; }
    .hero-banner { flex-direction: column; border-radius: 22px; }
    .hero-left { padding: 24px 20px; }
    .hero-title { font-size: 1.35rem; }
    .hero-right { width: 100%; border-left: none; border-top: 1.5px solid #e0e7ff; padding: 20px; }
    .hero-meta { gap: 12px; }
    .hero-meta-divider { display: none; }
    
    .table-header { flex-direction: column; align-items: stretch; gap: 12px; padding: 16px 20px; }
    .table-tabs { gap: 16px; padding: 0 20px; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table-tab { white-space: nowrap; padding: 12px 4px; font-size: 0.75rem; }
    .table-search-wrap input { width: 100%; }
    
    .accounts-table { min-width: 800px !important; }
    .user-cell { min-width: 180px !important; }
    
    .modal-card {
        width: 95% !important;
        height: 85vh !important;
        margin: auto !important;
        border-radius: 20px !important;
        flex-direction: column !important;
        max-height: none !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }
    .modal-layout { flex-direction: column !important; min-height: 0 !important; overflow: visible !important; }
    
    .modal-left {
        width: 100% !important;
        height: auto !important;
        padding: 16px 20px !important;
        flex-shrink: 0 !important;
    }
    .modal-left::before { display: none; }
    .modal-left-content { 
        padding: 0 !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 12px !important;
        width: 100%;
        text-align: left !important;
    }
    .profile-upload { width: 44px !important; height: 44px !important; border-width: 2px !important; }
    .profile-upload-placeholder svg { width: 18px !important; height: 18px !important; }
    .profile-upload-placeholder span { display: none !important; }
    .modal-left-hint { display: none !important; }
    .modal-left-icon-row { display: none !important; }
    .modal-card-title { font-size: 0.85rem !important; text-align: left !important; }
    .modal-card-desc { display: none !important; }
    
    .modal-right { flex: 1 !important; display: flex !important; flex-direction: column !important; background: #fff !important; }
    .modal-card-body { padding: 16px 20px !important; }
    .form-row { flex-direction: column !important; gap: 0 !important; }
    .modal-card-footer { padding: 12px 20px 20px !important; background: #fff !important; }
    .btn-cancel, .btn-save { flex: 1 !important; padding: 11px !important; font-size: 0.78rem !important; }
    
    body.dark-mode .modal-card { background: #0f172a !important; border: 1px solid #1e293b !important; }
    body.dark-mode .modal-right { background: #0f172a !important; }
    body.dark-mode .modal-card-footer { background: #0f172a !important; border-top-color: #1e293b !important; }
    body.dark-mode .hero-right { border-top-color: #334155; }
}

/* ── Dark Mode Overrides ── */
body.dark-mode { background: #0f172a; color: #cbd5e1; }

body.dark-mode .hero-banner { background: #1e293b; border-color: #334155; box-shadow: 0 4px 24px rgba(0,0,0,0.3); }
body.dark-mode .hero-dots { opacity: 0.1; }
body.dark-mode .hero-title { color: #f8fafc; }
body.dark-mode .hero-meta-divider { background: #334155; }
body.dark-mode .hmi-num { color: #f8fafc; }
body.dark-mode .hero-right { background: #1a1f35; border-left-color: #334155; }
body.dark-mode .hsc-label { color: #818cf8; }
body.dark-mode .hsc-hint { color: #64748b; }
body.dark-mode .filter-select-wrap { background: #0f172a; border-color: #334155; }
body.dark-mode .filter-select-wrap select { color: #f1f5f9; }
body.dark-mode .filter-select-wrap select option { background: #1e293b; color: #f1f5f9; }

body.dark-mode .accounts-table-card { 
    background: transparent; 
    border: 1.5px solid #334155; 
    box-shadow: none; 
}
body.dark-mode .table-header { border-bottom-color: #334155; }
body.dark-mode .table-title { color: #f1f5f9; }
body.dark-mode .table-count { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
body.dark-mode .table-search-wrap { background: #0f172a; }
body.dark-mode .table-search-wrap input { color: #f1f5f9; }
body.dark-mode .table-tabs { background: transparent; border-bottom-color: #334155; }
body.dark-mode .table-tab { color: #94a3b8; }
body.dark-mode .table-tab.active { color: #818cf8; }
body.dark-mode .table-tab.active::after { background: #818cf8; }

body.dark-mode .accounts-table thead th { background: #0f172a; border-bottom-color: #334155; color: #f8fafc; }
body.dark-mode .accounts-table tbody td { border-bottom-color: #334155; color: #cbd5e1; }
body.dark-mode .accounts-table tbody tr:hover td { background: #1a1f35; }
body.dark-mode .user-name { color: #f1f5f9; }
body.dark-mode .cell-idx { color: #475569; }
body.dark-mode .cell-username, body.dark-mode .cell-email { color: #94a3b8; }
body.dark-mode .cell-created, body.dark-mode .cell-pos { color: #64748b; }

body.dark-mode .modal-card { background: #0f172a; border: 1px solid rgba(255,255,255,0.1); }
body.dark-mode .modal-right { background: #0f172a; }
body.dark-mode .form-label { color: #8892a4; }
body.dark-mode .form-input-wrap { background: #0a0f1e; border: 1.5px solid rgba(255, 255, 255, 0.15); box-shadow: inset 0 2px 4px rgba(0,0,0,0.2); }
body.dark-mode .form-input-wrap:focus-within { border-color: #6366f1; background: #050812; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
body.dark-mode .form-input-wrap input { color: #f1f5f9; }
body.dark-mode .form-input-wrap input::placeholder { color: #334155; }
body.dark-mode .form-input-wrap select { color: #f1f5f9 !important; }
body.dark-mode .form-input-wrap select option { background: #0a0f1e; color: #f1f5f9; }

body.dark-mode .modal-left { background: linear-gradient(160deg, #1e1b4b 0%, #0f172a 100%); border-right: 1px solid rgba(255,255,255,0.05); }
body.dark-mode .modal-left-hint { color: #64748b; }
body.dark-mode .modal-card-desc { color: #64748b; }
body.dark-mode .modal-card-title { color: #f8fafc; }
body.dark-mode .profile-upload { border-color: rgba(255,255,255,0.1); background: rgba(255,255,255,0.02); }
body.dark-mode .profile-upload:hover { border-color: #6366f1; background: rgba(99,102,241,0.05); }

body.dark-mode .btn-cancel { background: transparent; border-color: #1e293b; color: #64748b; }
body.dark-mode .btn-cancel:hover { background: #1e293b; color: #f1f5f9; }
body.dark-mode .modal-card-footer { border-top: 1px solid #1e293b; padding-top: 20px; }
body.dark-mode .modal-error { background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
body.dark-mode .pw-toggle-btn { color: #334155; }
body.dark-mode .pw-toggle-btn:hover { color: #818cf8; }
body.dark-mode .form-hint { color: #475569; }
body.dark-mode .empty-wrap h3 { color: #f1f5f9; }
body.dark-mode .empty-art { background: rgba(99, 102, 241, 0.1); }

body.dark-mode .status-badge.role-admin { background: rgba(99, 102, 241, 0.15); color: #818cf8; border-color: rgba(99, 102, 241, 0.2); }
body.dark-mode .status-badge.role-user { background: rgba(148, 163, 184, 0.1); color: #94a3b8; border-color: #334155; }
body.dark-mode .status-badge.active { background: rgba(16, 185, 129, 0.15); color: #34d399; }
body.dark-mode .status-badge.inactive { background: rgba(239, 68, 68, 0.15); color: #f87171; }

body.dark-mode .btn-edit { background: rgba(99, 102, 241, 0.15); color: #818cf8; }
body.dark-mode .btn-edit:hover { background: #6366f1; color: #fff; }
body.dark-mode .btn-delete { background: rgba(239, 68, 68, 0.15); color: #f87171; }
body.dark-mode .btn-delete:hover { background: #ef4444; color: #fff; }
body.dark-mode .btn-toggle-active { background: rgba(245, 158, 11, 0.15); color: #fbbf24; }
body.dark-mode .btn-toggle-inactive { background: rgba(16, 185, 129, 0.15); color: #34d399; }
</style>

<script>
window.toggleModalPassword = function(id, btn) {
    const input = document.getElementById(id);
    const eyeOpen = btn.querySelector('.eye-open');
    const eyeClosed = btn.querySelector('.eye-closed');
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    } else {
        input.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const PALETTES = [
        ['#6366f1','#4f46e5'], ['#818cf8','#6366f1'], ['#ec4899','#db2777'],
        ['#10b981','#059669'], ['#f59e0b','#d97706'], ['#0ea5e9','#0284c7'],
        ['#8b5cf6','#7c3aed'], ['#14b8a6','#0d9488'],
    ];
    let allAccounts = [];
    let currentRoleTab = 'user';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const currentUserId = parseInt('{{ auth()->id() }}') || null;

    window.setRoleFilter = function(role) {
        currentRoleTab = role;
        document.querySelectorAll('.table-tab').forEach(btn => btn.classList.toggle('active', btn.dataset.role === role));
        
        let title = 'Standard User Accounts';
        if (role === 'admin') title = 'Administrator Accounts';
        if (role === 'pending') title = 'Pending Registration Requests';
        
        document.querySelector('.table-title').textContent = title;
        renderAccounts();
    };

    function getGrad(name) { if (!name) return PALETTES[0]; return PALETTES[name.charCodeAt(0) % PALETTES.length]; }
    function getInitials(name) { if (!name) return '??'; return name.split(' ').filter(n => n.length).map(n => n[0]).slice(0,2).join('').toUpperCase(); }

    window.previewImage = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('profilePreview');
                img.src = e.target.result; img.style.display = 'block';
                document.getElementById('profilePlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    function fetchAccounts() {
        fetch('/api/user-accounts').then(r => r.json()).then(data => { allAccounts = data; updateStats(); renderAccounts(); });
    }

    function updateStats() {
        const active = allAccounts.filter(a => a.is_active).length;
        const pending = allAccounts.filter(a => !a.is_approved).length;
        document.getElementById('totalAccounts').textContent = allAccounts.length;
        document.getElementById('activeAccounts').textContent = active;
        document.getElementById('inactiveAccounts').textContent = allAccounts.length - active;
        
        const dot = document.getElementById('pendingDot');
        if (dot) dot.style.display = pending > 0 ? 'block' : 'none';
    }

    window.renderAccounts = function() {
        const filter = document.getElementById('statusFilter').value;
        const search = (document.getElementById('tableSearch').value || '').toLowerCase();
        let list = allAccounts.filter(a => {
            if (currentRoleTab === 'pending') return !a.is_approved;
            return a.is_approved && (a.role || 'user') === currentRoleTab;
        });
        if (filter === 'active') list = list.filter(a => a.is_active);
        else if (filter === 'inactive') list = list.filter(a => !a.is_active);
        if (search) list = list.filter(a => (a.name||'').toLowerCase().includes(search) || (a.email||'').toLowerCase().includes(search) || (a.username||'').toLowerCase().includes(search));

        document.getElementById('tableCount').textContent = list.length + ' account' + (list.length !== 1 ? 's' : '');
        const tbody = document.getElementById('accountsTableBody');
        const emptyEl = document.getElementById('emptyState');
        const tableWrap = document.querySelector('.table-wrap');
        
        if (!list.length) { 
            tableWrap.style.display = 'none'; 
            emptyEl.style.display = 'block'; 
            return; 
        }
        
        tableWrap.style.display = 'block'; 
        emptyEl.style.display = 'none';

        tbody.innerHTML = list.map((acc, idx) => {
            const [c1, c2] = getGrad(acc.name);
            const isApproved = acc.is_approved;
            const created = acc.created_at ? new Date(acc.created_at).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' }) : '—';
            const avatarHtml = acc.profile_image
                ? `<img src="/storage/${acc.profile_image}" class="user-avatar-img" style="width:40px;height:40px;border-radius:12px;object-fit:cover;">`
                : `<div class="user-avatar" style="background:linear-gradient(135deg,${c1},${c2})">${getInitials(acc.name)}</div>`;
            const posLabel = acc.position ? `<span class="cell-pos">${acc.position}</span>` : '';
            
            const isActive = acc.is_active;
            let statusBadge = isActive ? `<span class="status-badge active"><span class="dot"></span>Active</span>` : `<span class="status-badge inactive"><span class="dot"></span>Inactive</span>`;
            if (!isApproved) {
                statusBadge = `<span class="status-badge inactive" style="background:rgba(245,158,11,0.1);color:#d97706;border-color:rgba(245,158,11,0.2);"><span class="dot" style="background:#d97706;"></span>Pending Approval</span>`;
            }

            let actionGroup = '';
            if (currentRoleTab === 'pending') {
                actionGroup = `
                    <button class="btn-action" title="Approve" style="background:rgba(16,185,129,0.1);color:#10b981;border-color:rgba(16,185,129,0.2);" onclick="approveAccount(${acc.id})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                    </button>
                    <button class="btn-action" title="Reject" style="background:rgba(239,68,68,0.1);color:#ef4444;border-color:rgba(239,68,68,0.2);" onclick="rejectAccount(${acc.id})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                `;
            } else {
                actionGroup = `
                    <button class="btn-action btn-edit" title="Edit" onclick="editAccountById(${acc.id})"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg></button>
                    <button class="btn-action ${isActive?'btn-toggle-active':'btn-toggle-inactive'}" title="${isActive?'Deactivate':'Activate'}" onclick="toggleAccount(${acc.id})">${isActive?'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>':'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>'}</button>
                `;
            }

            return `<tr>
                <td class="cell-idx">${idx+1}</td>
                <td><div class="user-cell">${avatarHtml}<div><span class="user-name">${acc.name}</span>${posLabel}</div></div></td>
                <td class="cell-username">${acc.username || '—'}</td>
                <td class="cell-email">${acc.email}</td>
                <td>${statusBadge}</td>
                <td><span class="status-badge ${acc.role==='admin'?'role-admin':'role-user'}">${acc.role==='admin'?'Admin':'User'}</span></td>
                <td class="cell-created">${created}</td>
                <td><div class="action-group">
                    ${actionGroup}
                </div></td></tr>`;
        }).join('');
    };

    function resetForm() {
        ['editId','inputUsername','inputLastName','inputFirstName','inputMiddleName','inputSuffix','inputPosition','inputEmail','inputPassword','inputConfirmPassword'].forEach(id => document.getElementById(id).value = '');
        document.getElementById('inputRole').value = 'user';
        document.getElementById('inputStatus').value = '1';
        document.getElementById('inputApproved').value = '1';
        document.getElementById('inputProfileImage').value = '';
        document.getElementById('profilePreview').style.display = 'none';
        document.getElementById('profilePlaceholder').style.display = 'flex';
        document.getElementById('modalError').style.display = 'none';
    }

    window.openCreateModal = function() {
        resetForm();
        document.getElementById('modalTitle').textContent = 'Create New Account';
        document.getElementById('modalDesc').textContent = 'Fill in the details below to create a new user account.';
        document.getElementById('btnSave').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> Create Account';
        document.getElementById('passwordLabel').innerHTML = 'Password <span class="req">*</span>';
        document.getElementById('confirmLabel').innerHTML = 'Confirm Password <span class="req">*</span>';
        document.getElementById('passwordHint').textContent = 'Must be at least 8 characters long.';
        document.getElementById('statusFieldArea').style.display = 'none';
        document.getElementById('approvalFieldArea').style.display = 'none';
        document.getElementById('inputStatus').value = '1';
        document.getElementById('inputApproved').value = '1';
        document.getElementById('accountModal').classList.add('open');
    };

    window.editAccountById = function(id) {
        const acc = allAccounts.find(a => a.id === id);
        if (!acc) return;
        resetForm();

        // Intelligently parse names for legacy records that might have empty first/last name fields
        let firstName = acc.first_name || '';
        let lastName = acc.last_name || '';
        
        if (!firstName && !lastName && acc.name) {
            const parts = acc.name.trim().split(' ');
            if (parts.length >= 2) {
                lastName = parts.pop();
                firstName = parts.join(' ');
            } else {
                firstName = acc.name;
            }
        }

        document.getElementById('editId').value = acc.id;
        document.getElementById('inputUsername').value = acc.username || '';
        document.getElementById('inputLastName').value = lastName;
        document.getElementById('inputFirstName').value = firstName;
        document.getElementById('inputMiddleName').value = acc.middle_name || '';
        document.getElementById('inputSuffix').value = acc.suffix || '';
        document.getElementById('inputPosition').value = acc.position || '';
        document.getElementById('inputEmail').value = acc.email || '';
        document.getElementById('inputRole').value = acc.role || 'user';
        document.getElementById('inputStatus').value = acc.is_active ? '1' : '0';
        document.getElementById('inputApproved').value = acc.is_approved ? '1' : '0';
        if (acc.profile_image) {
            document.getElementById('profilePreview').src = '/storage/' + acc.profile_image;
            document.getElementById('profilePreview').style.display = 'block';
            document.getElementById('profilePlaceholder').style.display = 'none';
        }
        document.getElementById('modalTitle').textContent = 'Edit Account';
        document.getElementById('modalDesc').textContent = 'Update the account details below.';
        document.getElementById('btnSave').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> Save Changes';
        document.getElementById('passwordLabel').textContent = 'New Password (optional)';
        document.getElementById('confirmLabel').textContent = 'Confirm New Password';
        document.getElementById('passwordHint').textContent = 'Leave blank to keep current password.';
        document.getElementById('statusFieldArea').style.display = 'block';
        document.getElementById('approvalFieldArea').style.display = 'block';
        document.getElementById('accountModal').classList.add('open');
    };

    window.closeModal = function() { document.getElementById('accountModal').classList.remove('open'); };
    window.handleBackdropClick = function(e) { if (e.target.id === 'accountModal') closeModal(); };

    window.saveAccount = async function() {
        const id = document.getElementById('editId').value;
        const errEl = document.getElementById('modalError');
        const username = document.getElementById('inputUsername').value.trim();
        const lastName = document.getElementById('inputLastName').value.trim();
        const firstName = document.getElementById('inputFirstName').value.trim();
        const email = document.getElementById('inputEmail').value.trim();
        const password = document.getElementById('inputPassword').value;
        const confirmPass = document.getElementById('inputConfirmPassword').value;

        if (!username || !lastName || !firstName || !email) { errEl.textContent = 'Username, last name, first name, and email are required.'; errEl.style.display = 'block'; return; }
        if (!id && (!password || password.length < 8)) { errEl.textContent = 'Password must be at least 8 characters.'; errEl.style.display = 'block'; return; }
        if (password && password !== confirmPass) { errEl.textContent = 'Passwords do not match.'; errEl.style.display = 'block'; return; }
        if (id && password && password.length < 8) { errEl.textContent = 'Password must be at least 8 characters.'; errEl.style.display = 'block'; return; }

        const formData = new FormData();
        formData.append('username', username);
        formData.append('last_name', lastName);
        formData.append('first_name', firstName);
        formData.append('middle_name', document.getElementById('inputMiddleName').value.trim());
        formData.append('suffix', document.getElementById('inputSuffix').value.trim());
        formData.append('position', document.getElementById('inputPosition').value.trim());
        formData.append('role', document.getElementById('inputRole').value);
        formData.append('is_active', document.getElementById('inputStatus').value);
        formData.append('is_approved', document.getElementById('inputApproved').value);
        formData.append('email', email);
        if (password) formData.append('password', password);
        const fileInput = document.getElementById('inputProfileImage');
        if (fileInput.files.length > 0) formData.append('profile_image', fileInput.files[0]);

        const url = id ? `/api/user-accounts/${id}/update` : '/api/user-accounts';
        try {
            const res = await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: formData });
            const data = await res.json();
            if (!res.ok) { errEl.textContent = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error occurred.'); errEl.style.display = 'block'; return; }
            closeModal();
            const newRole = formData.get('role');
            
            // If the user updated their own account, redirect to profile to refresh sidebars/navigation
            if (id && parseInt(id) == currentUserId) {
                window.location.replace('/profile');
                return;
            }

            if (newRole) {
                currentRoleTab = newRole;
                document.querySelectorAll('.table-tab').forEach(btn => btn.classList.toggle('active', btn.dataset.role === newRole));
                document.querySelector('.table-title').textContent = newRole === 'admin' ? 'Administrator Accounts' : 'Standard User Accounts';
            }
            fetchAccounts();
        } catch (err) { errEl.textContent = 'Network error. Please try again.'; errEl.style.display = 'block'; }
    };

    window.toggleAccount = async function(id) {
        if (!confirm("Change this account's status?")) return;
        await fetch(`/api/user-accounts/${id}/toggle`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
        fetchAccounts();
    };

    window.approveAccount = async function(id) {
        if (!confirm('Approve this account?')) return;
        try {
            const res = await fetch(`/api/user-accounts/${id}/approve`, {
                method: 'PUT',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Approved!',
                    text: 'Account has been activated and moved to Standard Users.',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                // Optimistic Update: Update local state immediately
                const userIndex = allAccounts.findIndex(a => a.id == id);
                if (userIndex !== -1) {
                    allAccounts[userIndex].is_approved = true;
                    allAccounts[userIndex].is_active = true;
                }
                
                updateStats();
                setRoleFilter('user'); // This will call renderAccounts()
            }
        } catch (err) { console.error(err); }
    };

    window.rejectAccount = async function(id) {
        if (!confirm('Are you sure you want to REJECT and DELETE this registration request? This action cannot be undone.')) return;
        try {
            const res = await fetch(`/api/user-accounts/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Rejected',
                    text: 'The registration request has been deleted.',
                    showConfirmButton: false,
                    timer: 1500
                });
                
                // Optimistic Update: Remove from local state immediately
                allAccounts = allAccounts.filter(a => a.id != id);
                
                updateStats();
                renderAccounts();
            } else {
                Swal.fire('Error', data.message || 'Failed to reject account', 'error');
            }
        } catch (err) { 
            console.error(err);
            Swal.fire('Error', 'Server error occurred', 'error');
        }
    };

    document.addEventListener('keydown', e => { if (e.key === 'Escape' && document.getElementById('accountModal').classList.contains('open')) closeModal(); });
    
    // Initial fetch
    fetchAccounts();
    
    // Real-time polling: Refresh the list every 10 seconds to detect new registrations automatically
    setInterval(fetchAccounts, 10000);
});
</script>

</body>
