<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form - DepEd Manager</title>
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

            <!-- Form Container -->
            <div class="form-container">

                <!-- Left: Form -->
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-header-left">
                            <div class="form-header-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="form-card-title">Employee Leave Record</h2>
                                <p class="form-card-subtitle">Fill in the details to record an employee leave</p>
                            </div>
                        </div>
                        <div class="form-header-right">
                            <div class="records-counter">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span id="totalRecords">0</span> Records
                            </div>
                            <div class="form-badge">
                                <span class="badge-dot"></span>
                                New Entry
                            </div>
                        </div>
                    </div>

                    <form id="leaveForm" class="leave-form" autocomplete="off">
                        @csrf

                        <!-- Section: Employee Info -->
                        <div class="form-section">
                            <div class="section-label">
                                <div class="section-line"></div>
                                <span>Employee Information</span>
                                <div class="section-line"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label class="form-label" for="nameInput">Name</label>
                                    <div class="combobox-wrapper" id="nameComboWrapper">
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="nameInput" class="form-input has-icon" placeholder="Search or type employee name" autocomplete="off" required>
                                            <span class="ghost-text" id="nameGhost"></span>
                                            <input type="hidden" id="employeeName" name="name">
                                            <button type="button" class="combobox-toggle" data-target="nameDropdown" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="combobox-dropdown" id="nameDropdown"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="positionInput">Position</label>
                                    <div class="combobox-wrapper" id="posComboWrapper">
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="positionInput" class="form-input has-icon" placeholder="Search or type a position" autocomplete="off" required>
                                            <span class="ghost-text" id="posGhost"></span>
                                            <input type="hidden" id="position" name="position">
                                            <button type="button" class="combobox-toggle" data-target="posDropdown" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="combobox-dropdown" id="posDropdown"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="schoolInput">School</label>
                                    <div class="combobox-wrapper">
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="schoolInput" class="form-input has-icon" placeholder="Search or type a school name" autocomplete="off" required>
                                            <span class="ghost-text" id="schoolGhost"></span>
                                            <input type="hidden" id="school" name="school">
                                            <button type="button" class="combobox-toggle" id="comboboxToggle" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="combobox-dropdown" id="schoolDropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Leave Details -->
                        <div class="form-section">
                            <div class="section-label">
                                <div class="section-line"></div>
                                <span>Leave Details</span>
                                <div class="section-line"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="leaveInput">Type of Leave</label>
                                    <div class="combobox-wrapper" id="leaveComboWrapper">
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="leaveInput" class="form-input has-icon" placeholder="Search or type leave type" autocomplete="off" required>
                                            <span class="ghost-text" id="leaveGhost"></span>
                                            <input type="hidden" id="typeOfLeave" name="type_of_leave">
                                            <button type="button" class="combobox-toggle" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="combobox-dropdown" id="leaveDropdown"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="remarksInput">Remarks</label>
                                    <div class="combobox-wrapper" id="remarksComboWrapper">
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="remarksInput" class="form-input has-icon" placeholder="Search or type remarks" autocomplete="off">
                                            <span class="ghost-text" id="remarksGhost"></span>
                                            <input type="hidden" id="remarks" name="remarks">
                                            <button type="button" class="combobox-toggle" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="combobox-dropdown" id="remarksDropdown"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="inclusiveDates">Inclusive Dates</label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                        </div>
                                        <input type="text" id="inclusiveDates" name="inclusive_dates" class="form-input has-icon" placeholder="e.g. January 10–15, 2026" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="dateOfAction">Date of Action</label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input type="date" id="dateOfAction" name="date_of_action" class="form-input has-icon" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label class="form-label" for="deductionRemarks">Deduction Remarks</label>
                                    <div class="input-wrapper">
                                        <div class="input-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </div>
                                        <input type="text" id="deductionRemarks" name="deduction_remarks" class="form-input has-icon" placeholder="Enter deduction remarks">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-ghost" onclick="resetForm()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                                </svg>
                                Clear Form
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </main>

<style>
    /* ═══════════════════════════════════════
       FORM PAGE — MODERN DESIGN
       ═══════════════════════════════════════ */

    .form-container {
        width: 100%;
    }

    /* ── Form Card ── */
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow:
            0 1px 2px rgba(0, 0, 0, 0.04),
            0 4px 12px rgba(0, 0, 0, 0.04),
            0 16px 40px rgba(99, 102, 241, 0.06),
            0 24px 60px rgba(0, 0, 0, 0.04);
        overflow: hidden
    }

    .form-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px 32px;
        background: linear-gradient(135deg, #fafbff 0%, #f5f3ff 100%);
        border-bottom: 1px solid #eee8ff;
    }

    .form-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .form-header-icon {
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

    .form-header-icon svg {
        width: 24px;
        height: 24px;
        color: #fff;
    }

    .form-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.025em;
    }

    .form-card-subtitle {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 3px;
    }

    .form-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        background: #ecfdf5;
        color: #059669;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .form-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .records-counter {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        background: #eff6ff;
        color: #3b82f6;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .records-counter svg {
        width: 14px;
        height: 14px;
    }

    .records-counter span {
        font-weight: 800;
        font-size: 0.82rem;
    }

    .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* ── Form Body ── */
    .leave-form {
        padding: 32px;
    }

    .form-section {
        margin-bottom: 28px;
    }

    .section-label {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .section-label span {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6366f1;
        white-space: nowrap;
    }

    .section-line {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, #e2e8f0, transparent);
    }

    .section-label .section-line:last-child {
        background: linear-gradient(90deg, transparent, #e2e8f0);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        font-size: 0.76rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
        letter-spacing: 0.01em;
    }

    .input-wrapper {
        position: relative;
    }

    .ghost-text {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 12px 16px;
        padding-left: 42px;
        font-size: 0.84rem;
        font-family: 'Inter', sans-serif;
        color: #c0c7d6;
        pointer-events: none;
        white-space: nowrap;
        overflow: hidden;
        line-height: normal;
        display: flex;
        align-items: center;
        z-index: 1;
        border: 1.5px solid transparent;
        border-radius: 12px;
    }

    .ghost-text .ghost-typed {
        visibility: hidden;
    }

    .ghost-text .ghost-suggestion {
        color: #b4bdd0;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: #94a3b8;
        pointer-events: none;
        z-index: 1;
        transition: color 0.2s ease;
    }

    .input-icon svg {
        width: 18px;
        height: 18px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e8ecf4;
        border-radius: 12px;
        font-size: 0.84rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        background: #fafbff;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
    }

    .form-input.has-icon {
        padding-left: 42px;
    }

    .form-input::placeholder {
        color: #c0c7d6;
    }

    .form-input:hover {
        border-color: #c7d0e0;
        background: #fff;
    }

    .form-input:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    .input-wrapper:focus-within .input-icon {
        color: #6366f1;
    }

    .form-select {
        appearance: none;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m19.5 8.25-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 15px;
        padding-right: 42px;
    }

    /* ── Action Buttons ── */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 28px;
        border-top: 1px solid #f1f5f9;
        margin-top: 4px;
    }

    .btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn svg {
        width: 18px;
        height: 18px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1, #7c3aed);
        color: #fff;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 24px rgba(99, 102, 241, 0.45);
        transform: translateY(-2px);
    }

    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    .btn-ghost {
        background: transparent;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .btn-ghost:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #475569;
    }

    /* ── Toast ── */
    .toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        border-radius: 14px;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
    }

    .toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast-success { background: linear-gradient(135deg, #10b981, #059669); }
    .toast-error { background: linear-gradient(135deg, #ef4444, #dc2626); }

    /* ── Combobox ── */
    .combobox-wrapper {
        position: relative;
    }

    .combobox-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        color: #94a3b8;
        transition: color 0.2s, transform 0.25s;
        z-index: 2;
    }

    .combobox-toggle svg {
        width: 15px;
        height: 15px;
    }

    .combobox-toggle.open {
        transform: translateY(-50%) rotate(180deg);
        color: #6366f1;
    }

    .combobox-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.04);
        max-height: 260px;
        overflow-y: auto;
        z-index: 100;
        display: none;
        padding: 6px;
    }

    .combobox-dropdown.show {
        display: block;
        animation: comboSlide 0.2s ease;
    }

    @keyframes comboSlide {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .combobox-group-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        padding: 8px 12px 4px;
        user-select: none;
    }

    .combobox-option {
        padding: 9px 12px;
        font-size: 0.82rem;
        color: #334155;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.15s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .combobox-option:hover,
    .combobox-option.highlighted {
        background: #f1f5f9;
        color: #1e293b;
    }

    .combobox-option.add-new {
        color: #6366f1;
        font-weight: 600;
        border-top: 1px solid #f1f5f9;
        margin-top: 4px;
    }

    .combobox-option.add-new svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .combobox-no-results {
        padding: 14px 12px;
        font-size: 0.78rem;
        color: #94a3b8;
        text-align: center;
    }

    .combobox-dropdown::-webkit-scrollbar {
        width: 5px;
    }

    .combobox-dropdown::-webkit-scrollbar-track {
        background: transparent;
    }

    .combobox-dropdown::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 20px 24px;
        }

        .leave-form {
            padding: 24px;
        }

        .form-header-right {
            flex-wrap: wrap;
        }
    }
    /* ── Modal ── */
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
        max-width: 2000px;
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
    }
    .modal-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
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
    .badge-leave {
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        background: #eff6ff;
        color: #3b82f6;
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

    .records-counter {
        cursor: pointer;
        transition: background 0.2s;
        user-select: none;
    }
    .records-counter:hover {
        background: #dbeafe;
    }
</style>

<div class="toast" id="toast"></div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `toast toast-${type} show`;
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function resetForm() {
        document.getElementById('leaveForm').reset();
        document.getElementById('employeeName').value = '';
        document.getElementById('nameInput').value = '';
        document.getElementById('position').value = '';
        document.getElementById('positionInput').value = '';
        document.getElementById('school').value = '';
        document.getElementById('schoolInput').value = '';
        document.getElementById('typeOfLeave').value = '';
        document.getElementById('leaveInput').value = '';
        document.getElementById('remarks').value = '';
        document.getElementById('remarksInput').value = '';
        setTodayDate();
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('submitBtn').innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            Save Record
        `;
    }

    function setTodayDate() {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        document.getElementById('dateOfAction').value = `${yyyy}-${mm}-${dd}`;
    }

    function updateRecordCount() {
        fetch('/leave-records/count')
            .then(res => res.json())
            .then(data => {
                document.getElementById('totalRecords').textContent = data.count;
            })
            .catch(() => {});
    }

    // ── Form submission via AJAX ──
    document.getElementById('leaveForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="animation: spin 1s linear infinite;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
            </svg>
            Saving...
        `;

        const record = {
            name: document.getElementById('employeeName').value,
            position: document.getElementById('position').value,
            school: document.getElementById('school').value,
            type_of_leave: document.getElementById('typeOfLeave').value,
            inclusive_dates: document.getElementById('inclusiveDates').value,
            remarks: document.getElementById('remarks').value,
            date_of_action: document.getElementById('dateOfAction').value,
            deduction_remarks: document.getElementById('deductionRemarks').value,
        };

        fetch('/leave-records', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(record),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message);
                updateRecordCount();
                loadDropdownData();
                resetForm();
            } else {
                showToast('Error saving record', 'error');
                resetForm();
            }
        })
        .catch(() => {
            showToast('Error saving record. Please try again.', 'error');
            resetForm();
        });
    });

    // ── Generic combobox factory ──
    function initCombobox(inputId, hiddenId, dropdownId, items, opts = {}) {
        const input = document.getElementById(inputId);
        const hidden = document.getElementById(hiddenId);
        const dropdown = document.getElementById(dropdownId);
        const wrapper = input.closest('.combobox-wrapper');
        const toggle = wrapper.querySelector('.combobox-toggle');
        const grouped = opts.grouped || false;
        let allItems = [];
        let groupedItems = {};

        function flattenItems() {
            if (grouped) {
                allItems = [];
                Object.values(groupedItems).forEach(list => allItems.push(...list));
            }
        }

        if (grouped && typeof items === 'object' && !Array.isArray(items)) {
            groupedItems = items;
            flattenItems();
        } else {
            allItems = [...items];
        }

        function render(filter = '') {
            const q = filter.toLowerCase();
            let html = '';
            let hasResults = false;

            if (grouped && Object.keys(groupedItems).length > 0) {
                Object.entries(groupedItems).forEach(([group, list]) => {
                    const filtered = list.filter(s => s.toLowerCase().includes(q));
                    if (filtered.length > 0) {
                        hasResults = true;
                        html += `<div class="combobox-group-label">${group}</div>`;
                        filtered.forEach(s => {
                            html += `<div class="combobox-option" data-value="${s}">${s}</div>`;
                        });
                    }
                });
            } else {
                const filtered = allItems.filter(s => s.toLowerCase().includes(q));
                if (filtered.length > 0) {
                    hasResults = true;
                    filtered.forEach(s => {
                        html += `<div class="combobox-option" data-value="${s}">${s}</div>`;
                    });
                }
            }

            if (!hasResults) {
                html = '<div class="combobox-no-results">No results found</div>';
            }

            dropdown.innerHTML = html;

            dropdown.querySelectorAll('.combobox-option').forEach(opt => {
                opt.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    const val = this.getAttribute('data-value');
                    input.value = val;
                    hidden.value = val;
                    if (opts.onSelect) opts.onSelect(val);
                    close();
                });
            });
        }

        function open() {
            dropdown.classList.add('show');
            toggle.classList.add('open');
            render(input.value);
        }

        function close() {
            dropdown.classList.remove('show');
            toggle.classList.remove('open');
        }

        // Ghost text element
        const ghost = wrapper.querySelector('.ghost-text');

        function updateGhost() {
            if (!ghost) return;
            const val = input.value;
            if (!val) {
                ghost.innerHTML = '';
                return;
            }
            const lower = val.toLowerCase();
            const match = allItems.find(s => s.toLowerCase().startsWith(lower) && s.toLowerCase() !== lower);
            if (match) {
                const typed = match.substring(0, val.length);
                const rest = match.substring(val.length);
                ghost.innerHTML = `<span class="ghost-typed">${typed}</span><span class="ghost-suggestion">${rest}</span>`;
            } else {
                ghost.innerHTML = '';
            }
        }

        input.addEventListener('focus', open);
        input.addEventListener('input', function() {
            // Auto Title Case: capitalize first letter of every word
            const pos = this.selectionStart;
            this.value = this.value.replace(/\b\w/g, c => c.toUpperCase());
            this.setSelectionRange(pos, pos);
            hidden.value = this.value;
            if (opts.onInput) opts.onInput(this.value);
            updateGhost();
            open();
        });

        // Accept ghost suggestion with Tab or Right Arrow
        input.addEventListener('keydown', function(e) {
            if ((e.key === 'Tab' || e.key === 'ArrowRight') && ghost && ghost.innerHTML) {
                const suggestionEl = ghost.querySelector('.ghost-suggestion');
                if (suggestionEl && suggestionEl.textContent) {
                    e.preventDefault();
                    const fullText = input.value + suggestionEl.textContent;
                    input.value = fullText;
                    hidden.value = fullText;
                    if (opts.onInput) opts.onInput(fullText);
                    ghost.innerHTML = '';
                    close();
                }
            }
        });

        input.addEventListener('blur', function() {
            if (ghost) ghost.innerHTML = '';
        });

        toggle.addEventListener('click', function() {
            if (dropdown.classList.contains('show')) {
                close();
                input.blur();
            } else {
                input.focus();
            }
        });

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) close();
        });

        return {
            updateItems: function(newItems) {
                allItems = [...newItems];
            },
            updateGroupedItems: function(newGroups) {
                groupedItems = newGroups;
                flattenItems();
            }
        };
    }

    // ── Initialize comboboxes ──
    let nameCombo, posCombo, schoolCombo, leaveCombo, remarksCombo;
    let employeeDataMap = {};

    const leaveTypes = ['Vacation Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave', 'Special Privilege Leave', 'Solo Parent Leave', 'Study Leave', 'Terminal Leave', 'Adoption Leave', 'Rehabilitation Leave', 'Special Leave Benefits for Women', 'Forced Leave', 'Special Emergency Leave'];
    const remarksList = ['Approved', 'Disapproved', 'Pending', 'For Review', 'With Pay', 'Without Pay', 'Half Day', 'Cancelled'];

    function autoFillEmployee(name) {
        if (!name) return;
        const info = employeeDataMap[name];
        if (info) {
            if (info.position) {
                document.getElementById('positionInput').value = info.position;
                document.getElementById('position').value = info.position;
            }
            if (info.school) {
                document.getElementById('schoolInput').value = info.school;
                document.getElementById('school').value = info.school;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        nameCombo = initCombobox('nameInput', 'employeeName', 'nameDropdown', [], {
            onSelect: function(val) { autoFillEmployee(val); },
            onInput: function(val) { autoFillEmployee(val); }
        });
        posCombo = initCombobox('positionInput', 'position', 'posDropdown', []);
        schoolCombo = initCombobox('schoolInput', 'school', 'schoolDropdown', {}, { grouped: true });
        leaveCombo = initCombobox('leaveInput', 'typeOfLeave', 'leaveDropdown', leaveTypes);
        remarksCombo = initCombobox('remarksInput', 'remarks', 'remarksDropdown', remarksList);

        // Load from database
        updateRecordCount();
        loadDropdownData();
        setTodayDate();
    });

    function loadDropdownData() {
        fetch('/leave-records/dropdown-data')
            .then(res => res.json())
            .then(data => {
                if (nameCombo) nameCombo.updateItems(data.names || []);
                if (posCombo) posCombo.updateItems(data.positions || []);
                if (schoolCombo) schoolCombo.updateGroupedItems(data.schools || {});
                
                employeeDataMap = data.employee_map || {};

                if (leaveCombo) {
                    const dbLeaves = data.leave_types || [];
                    const mergedLeaves = [...new Set([...leaveTypes, ...dbLeaves])];
                    leaveCombo.updateItems(mergedLeaves);
                }

                if (remarksCombo) {
                    const dbRemarks = data.remarks || [];
                    const mergedRemarks = [...new Set([...remarksList, ...dbRemarks])];
                    remarksCombo.updateItems(mergedRemarks);
                }
            })
            .catch(() => {});
    }
</script>

<!-- Records Modal -->
<div class="modal-overlay" id="recordsModal">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="text-indigo-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Leave Records
            </h2>
            <div style="display: flex; align-items: center; gap: 16px; margin-left: auto; margin-right: 16px;">
                <div class="input-wrapper" style="width: 280px;">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input type="text" id="modalSearch" class="form-input has-icon" placeholder="Search records..." style="padding: 8px 12px 8px 38px;">
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label for="filterDate" style="font-size: 0.8rem; font-weight: 600; color: #64748b; white-space: nowrap;">Date:</label>
                    <input type="date" id="filterDate" class="form-input" style="padding: 8px 12px; width: auto;" onchange="fetchRecordsList()">
                </div>
            </div>
            <button class="modal-close" onclick="closeRecordsModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <table class="record-table">
                <thead>
                    <tr>
                        <th style="width: 15%">Name</th>
                        <th style="width: 10%">Position</th>
                        <th style="width: 15%">School</th>
                        <th style="width: 12%">Type of Leave</th>
                        <th style="width: 13%">Inclusive Dates</th>
                        <th style="width: 10%">Remarks</th>
                        <th style="width: 12%">Date of Action</th>
                        <th style="width: 13%">Deduction Remarks</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    <tr><td colspan="8" style="text-align:center; padding: 30px; color: #94a3b8;">Loading records...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const recordsModal = document.getElementById('recordsModal');
    const recordsCounter = document.querySelector('.records-counter');
    const filterDateInput = document.getElementById('filterDate');

    recordsCounter.addEventListener('click', openRecordsModal);

    function openRecordsModal() {
        recordsModal.classList.add('open');
        document.getElementById('modalSearch').value = ''; // Clear search when opening
        // Set default date to today if not set
        if (!filterDateInput.value) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            filterDateInput.value = `${yyyy}-${mm}-${dd}`;
        }
        fetchRecordsList();
    }

    function closeRecordsModal() {
        recordsModal.classList.remove('open');
    }

    recordsModal.addEventListener('click', function(e) {
        if (e.target === recordsModal) {
            closeRecordsModal();
        }
    });

    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#recordsTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.cells.length < 2) return; // Skip "No records" or "Loading" rows
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(q);
            row.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        // Handle case where all rows are filtered out
        const tbody = document.getElementById('recordsTableBody');
        const existingNoResults = document.getElementById('noResultsRow');
        
        if (visibleCount === 0 && rows.length > 0 && rows[0].cells.length >= 2) {
            if (!existingNoResults) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = `<td colspan="8" style="text-align:center; padding: 30px; color: #94a3b8;">No records matching "${q}"</td>`;
                tbody.appendChild(noResultsRow);
            } else {
                existingNoResults.innerHTML = `<td colspan="8" style="text-align:center; padding: 30px; color: #94a3b8;">No records matching "${q}"</td>`;
                existingNoResults.style.display = '';
            }
        } else if (existingNoResults) {
            existingNoResults.style.display = 'none';
        }
    }

    document.getElementById('modalSearch').addEventListener('input', filterModalRecords);

    function fetchRecordsList() {
        const date = filterDateInput.value;
        const url = date ? `/leave-records?date=${encodeURIComponent(date)}` : '/leave-records';

        fetch(url)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('recordsTableBody');
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 30px; color: #94a3b8;">No records found.</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map(r => {
                    // Styles for remarks badges
                    let remarkClass = 'badge-gray';
                    const rem = (r.remarks || '').toLowerCase();
                    if (rem === 'approved' || rem === 'with pay') remarkClass = 'badge-green';
                    else if (rem === 'disapproved' || rem === 'without pay' || rem === 'cancelled') remarkClass = 'badge-red';
                    else if (rem === 'pending' || rem === 'for review') remarkClass = 'badge-yellow';
                    
                    const remarkBadge = r.remarks ? `<span class="badge ${remarkClass}">${r.remarks}</span>` : '<span style="color:#cbd5e1">-</span>';

                    return `
                    <tr>
                        <td style="font-weight: 600; color:#1e293b;">${r.name}</td>
                        <td style="color:#475569; font-size: 0.8rem;">${r.position || '-'}</td>
                        <td style="color:#475569;">${r.school || '-'}</td>
                        <td><span class="badge-leave">${r.type_of_leave}</span></td>
                        <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.inclusive_dates || '-'}</td>
                        <td>${remarkBadge}</td>
                        <td style="font-family:monospace; font-size:0.75rem; color:#64748b;">${r.date_of_action || '-'}</td>
                        <td style="color:#64748b; font-size: 0.8rem;">${r.deduction_remarks || '-'}</td>
                    </tr>
                `}).join('');

                // Apply search filter if there's an active query
                if (document.getElementById('modalSearch').value) {
                    filterModalRecords();
                }
            })
            .catch(() => {
                document.getElementById('recordsTableBody').innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 30px; color: #ef4444;">Error loading records.</td></tr>';
            });
    }
</script>
</body>
</html>

