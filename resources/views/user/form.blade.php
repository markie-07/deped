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
    @include('partials.user-sidebar')

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
                        <input type="hidden" id="recordId">

                        <!-- Section: Employee Info -->
                        <div class="form-section">
                            <div class="section-label">
                                <div class="section-line"></div>
                                <span>Employee Information</span>
                                <div class="section-line"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="forwardedInput">Forwarded</label>
                                    <div class="combobox-wrapper" id="forwardedComboWrapper">
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="forwardedInput" class="form-input has-icon" placeholder="Search or type forwarded" autocomplete="off">
                                            <span class="ghost-text" id="forwardedGhost"></span>
                                            <input type="hidden" id="forwarded" name="forwarded">
                                            <button type="button" class="combobox-toggle" data-target="forwardedDropdown" tabindex="-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="combobox-dropdown" id="forwardedDropdown"></div>
                                    </div>
                                </div>

                                <div class="form-group">
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
                                        <div id="leaveTags" class="selected-tags-container"></div>
                                        <div class="input-wrapper">
                                            <div class="input-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="leaveInput" class="form-input has-icon" placeholder="Search or type leave type" autocomplete="off" >
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
                                            <input type="text" id="remarksInput" class="form-input has-icon" placeholder="Search or type remarks" autocomplete="off" required>
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
        padding-bottom: 250px;
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

    .combobox-option.selected {
        background: #f1f5f9;
        color: #6366f1;
        font-weight: 600;
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

    /* ── Multi-select Tags ── */
    .selected-tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 10px;
    }

    .combobox-tag {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        color: #3b82f6;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.76rem;
        font-weight: 700;
        border: 1px solid #dbeafe;
        transition: all 0.2s ease;
    }

    .combobox-tag:hover {
        background: #dbeafe;
    }

    .tag-remove {
        cursor: pointer;
        display: flex;
        align-items: center;
        color: #94a3b8;
        transition: color 0.2s;
    }

    .tag-remove:hover {
        color: #ef4444;
    }

    .tag-remove svg {
        width: 14px;
        height: 14px;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .content-body {
            padding: 12px 14px !important;
        }

        .form-container {
            padding-bottom: 120px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .form-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
        }

        .form-header-right {
            width: 100%;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 10px;
        }

        .leave-form {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
    /* ══════════════════════════════════════════
       MODAL — PREMIUM SPLIT DESIGN
       ══════════════════════════════════════════ */

    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-backdrop.open {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-sheet {
        background: #fff;
        width: 98%;
        max-width: none;
        height: 92vh;
        border-radius: 32px;
        display: flex;
        overflow: hidden;
        transform: scale(0.95) translateY(30px);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 
            0 30px 60px -12px rgba(0, 0, 0, 0.3),
            0 18px 36px -18px rgba(0, 0, 0, 0.2);
    }

    .modal-backdrop.open .modal-sheet {
        transform: scale(1) translateY(0);
    }

    /* ── Left Panel (Indigo Gradient) ── */
    .modal-panel {
        width: 280px;
        flex-shrink: 0;
        background: linear-gradient(160deg, #f5f7ff 0%, #eef2ff 50%, #e0e7ff 100%);
        padding: 40px 28px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        position: relative;
        overflow: hidden;
        border-right: 1px solid #e0e7ff;
    }

    .modal-panel::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.08);
        top: -100px;
        right: -100px;
    }

    .modal-panel::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(139, 92, 246, 0.06);
        bottom: -50px;
        left: -50px;
    }

    .panel-icon-box {
        width: 54px;
        height: 54px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        position: relative;
        z-index: 1;
    }

    .panel-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e1b4b;
        line-height: 1.3;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
        letter-spacing: -0.01em;
    }

    .panel-subtitle {
        font-size: 0.78rem;
        color: #6366f1;
        font-weight: 600;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .panel-divider {
        width: 100%;
        height: 1px;
        background: rgba(99, 102, 241, 0.15);
        margin: 24px 0;
        position: relative;
        z-index: 1;
    }

    .panel-stat-card {
        width: 100%;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .panel-stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(99, 102, 241, 0.4);
    }

    .ps-count {
        display: block;
        font-size: 2rem;
        font-weight: 900;
        color: #1e1b4b;
        line-height: 1;
        margin-bottom: 6px;
    }

    .ps-label {
        font-size: 0.7rem;
        color: #6366f1;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .panel-filters-group {
        width: 100%;
        position: relative;
        z-index: 1;
    }

    .filter-item {
        margin-bottom: 20px;
    }

    .filter-item:last-child {
        margin-bottom: 0;
    }

    .fi-label {
        display: block;
        font-size: 0.7rem;
        color: #4338ca;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
        padding-left: 2px;
    }

    .fi-select-wrap {
        position: relative;
        background: #fff;
        border: 1.5px solid #dbeafe;
        border-radius: 14px;
        transition: all 0.25s ease;
    }

    .fi-select-wrap:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    .fi-select {
        width: 100%;
        padding: 11px 16px;
        padding-right: 36px;
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.82rem;
        font-weight: 600;
        color: #1e1b4b;
        cursor: pointer;
        appearance: none;
        font-family: 'Inter', sans-serif;
    }

    .fi-select-wrap::after {
        content: '';
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%236366f1'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m19.5 8.25-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: contain;
        pointer-events: none;
    }

    .panel-actions {
        margin-top: auto;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .btn-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 13px;
        border-radius: 14px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
        border: 1.5px solid transparent;
    }

    .btn-panel-primary {
        background: #6366f1;
        color: #fff;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.2);
    }

    .btn-panel-primary:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }

    .btn-panel-done {
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        border: none;
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.2);
    }

    .btn-panel-done:hover {
        background: linear-gradient(135deg, #047857, #059669);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-panel-secondary {
        background: #fff;
        color: #4338ca;
        border-color: #dbeafe;
    }

    .btn-panel-secondary:hover {
        background: #f5f7ff;
        border-color: #6366f1;
    }

    .btn-panel-danger {
        background: #fff;
        color: #94a3b8;
        border-color: #e2e8f0;
    }

    .btn-panel-danger:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #ef4444;
    }

    /* ── Main Content Area ── */
    .modal-main {
        flex: 1;
        background: #fff;
        display: flex;
        flex-direction: column;
        min-width: 0;
        position: relative;
    }

    .modal-main-header {
        padding: 24px 32px;
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }

    .mm-title {
        font-size: 1rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.01em;
    }

    .mm-search-bar {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .mm-search-bar svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: #94a3b8;
        pointer-events: none;
    }

    .mm-search-input {
        width: 100%;
        padding: 11px 16px 11px 40px;
        background: #f8fafc;
        border: 1.5px solid #f1f5f9;
        border-radius: 14px;
        font-size: 0.84rem;
        color: #1e293b;
        outline: none;
        transition: all 0.25s ease;
        font-family: 'Inter', sans-serif;
    }

    .mm-search-input:focus {
        background: #fff;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    }

    .modal-main-body {
        flex: 1;
        overflow: auto;
        padding: 0;
        background: #fff;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .modal-main-body::-webkit-scrollbar {
        display: none;
    }

    /* ── Table Styling ── */
    .record-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    .record-table th {
        background: #f8fafc;
        padding: 12px 15px;
        text-align: left;
        font-size: 0.65rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        position: sticky;
        top: 0;
        z-index: 50;
        border-bottom: 2px solid #f1f5f9;
        white-space: nowrap;
    }

    .forwarded-header {
        background: #f3f4f6 !important;
        font-weight: 700;
        color: #374151;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 10px 20px !important;
        border-top: 1px solid #e5e7eb !important;
        border-bottom: 1px solid #e5e7eb !important;
        text-align: center !important;
        position: sticky;
        top: 42px;
        z-index: 40;
    }

    .record-table td {
        padding: 12px 15px;
        font-size: 0.78rem;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        transition: all 0.2s ease;
        word-wrap: break-word;
        vertical-align: top;
        line-height:1.4;
    }

    /* Column specific adjustments for Registry Modal */
    .record-table th:nth-child(1), .record-table td:nth-child(1) { width: 40px; } /* Selection */
    .record-table th:nth-child(2), .record-table td:nth-child(2) { width: 40px; } /* # */
    .record-table th:nth-child(3), .record-table td:nth-child(3) { min-width: 180px; } /* Name - give it more space */
    .record-table th:nth-child(12), .record-table td:nth-child(12) { width: 100px; text-align: center; } /* Actions */

    .record-row:hover td {
        background: #f8fbff;
    }

    .record-row.selected-row td {
        background: #f0f4ff;
    }

    /* Selection Badge and other elements should remain same but sized for this view */

    /* Modal Main Footer (for selection count) */
    .modal-main-footer {
        padding: 14px 32px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
    }

    .selection-badge {
        background: #6366f1;
        color: #fff;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 800;
    }

    /* ── Print/Export Adjustments ── */
    .printing-mode .selection-col {
        display: table-cell !important;
    }
    .selection-col {
        width: 50px;
        text-align: center !important;
        padding: 0 !important;
        vertical-align: middle !important;
    }

    .custom-checkbox {
        width: 20px; height: 20px;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s;
        margin: 0 auto;
    }
    .custom-checkbox.checked {
        background: #6366f1; border-color: #6366f1;
    }
    .custom-checkbox svg { width: 12px; height: 12px; color: #fff; display: none; }
    .custom-checkbox.checked svg { display: block; }

    /* Hide specific controls unless in printing mode */
    .modal-main-footer:not(.active) {
        display: none;
    }
    .modal-search-box .search-icon {
        position: absolute;
        left: 10px;
        width: 16px;
        height: 16px;
        color: #9ca3af;
        pointer-events: none;
    }
    .modal-search-input {
        width: 100%;
        padding: 7px 12px 7px 34px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.82rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        background: #fff;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .modal-search-input::placeholder {
        color: #9ca3af;
    }
    .modal-search-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }

    .forwarded-header-content {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin: 0 auto;
    }
    .forwarded-badge {
        background: #fff;
        color: #374151;
        padding: 4px 14px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        display: flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        margin: 0;
        font-weight: 700;
        font-size: 0.72rem;
        transition: all 0.2s ease;
    }
    .forwarded-header-row:hover .forwarded-badge {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4338ca;
    }
    .forwarded-badge svg {
        color: #6b7280;
        transition: color 0.2s ease;
    }
    .forwarded-header-row:hover .forwarded-badge svg {
        color: #6366f1;
    }

    .empty-registry-message {
        text-align: center;
        padding: 80px 40px !important;
        color: #94a3b8;
        background: #f8fafc !important;
        font-size: 0.95rem;
        font-weight: 500;
        border: none !important;
    }

    body.dark-mode .empty-registry-message {
        background: #1e293b !important;
        color: #64748b;
    }

    /* ── Badges ── */
    .badge-leave {
        font-size: 0.72rem;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        background: #f3f4f6;
        color: #374151;
        display: inline-block;
        border: 1px solid #e5e7eb;
        letter-spacing: 0.02em;
        transition: all 0.2s ease;
    }
    .record-table tbody tr.record-row:hover .badge-leave {
        background: #eef2ff;
        color: #4338ca;
        border-color: #c7d2fe;
    }
    .badge {
        font-size: 0.72rem;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .badge-green { background: #ecfdf5; color: #059669; border: 1px solid rgba(5,150,105,0.1); }
    .badge-red { background: #fef2f2; color: #dc2626; border: 1px solid rgba(220,38,38,0.1); }
    .badge-yellow { background: #fffbeb; color: #d97706; border: 1px solid rgba(217,119,6,0.1); }
    .badge-violet { background: #f5f3ff; color: #7c3aed; border: 1px solid rgba(124,58,237,0.1); }
    .badge-gray { background: #f1f5f9; color: #64748b; border: 1px solid rgba(100,116,139,0.1); }
    .badge-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid rgba(29,78,216,0.1); }
    .badge-orange { background: #fff7ed; color: #c2410c; border: 1px solid rgba(194,65,12,0.1); }

    /* ── Action Buttons (Table) ── */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
    }
    .btn-action:hover {
        transform: scale(1.1);
    }
    .btn-edit {
        color: #059669;
        border-color: #d1fae5;
        background: #ecfdf5;
    }
    .btn-edit:hover {
        background: #059669;
        color: #fff;
        border-color: #059669;
    }
    .btn-delete {
        color: #dc2626;
        border-color: #fecaca;
        background: #fef2f2;
    }
    .btn-delete:hover {
        background: #dc2626;
        color: #fff;
        border-color: #dc2626;
    }
    .nowrap {
        white-space: nowrap;
    }

    /* ── Excel / Print Button ── */
    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #6366f1;
        color: #fff;
        border: 1px solid #6366f1;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-print:hover {
        background: #4f46e5;
        border-color: #4f46e5;
    }
    .btn-print.active {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
    }
    .btn-print.btn-gray {
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #d1d5db;
    }
    .btn-print.btn-gray:hover {
        background: #e5e7eb;
        border-color: #9ca3af;
    }

    /* ── Selection Checkboxes ── */
    .selection-col {
        display: none;
        width: 60px;
        text-align: center !important;
        padding: 0 16px !important;
    }
    .printing-mode .selection-col {
        display: table-cell;
    }
    .custom-checkbox {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1.5px solid #d1d5db;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        background: #fff;
        margin: 0 auto;
    }
    .custom-checkbox.checked {
        background: #6366f1;
        border-color: #6366f1;
    }
    .custom-checkbox svg {
        width: 10px;
        height: 10px;
        color: white;
        display: none;
    }
    .custom-checkbox.checked svg {
        display: block;
    }
    .custom-checkbox.dept-select-all {
        display: none;
    }
    .printing-mode .custom-checkbox.dept-select-all {
        display: flex;
    }

    /* ── Modal Footer ── */
    .modal-footer {
        display: flex;
        background: #fff;
        padding: 14px 28px;
        border-top: 1px solid #e5e7eb;
        justify-content: space-between;
        align-items: center;
    }
    .modal-footer-info {
        display: none;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.82rem;
    }
    .printing-mode .modal-footer-info {
        display: flex;
    }
    #selectedCount {
        background: #6366f1;
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-family: 'Inter', monospace;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .export-actions {
        display: none;
        gap: 10px;
    }
    .printing-mode .export-actions {
        display: flex;
    }
    .printing-mode #excelModeBtn {
        display: none;
    }

    /* ── Print Styles ── */
    @media print {
        body * {
            visibility: hidden;
        }
        #recordsModal, #recordsModal * {
            visibility: visible;
        }
        #recordsModal {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: auto;
            max-height: none;
            overflow: visible;
            box-shadow: none;
            border: none;
            background: white;
        }
        .modal-container {
            width: 100%;
            max-width: none;
            height: auto;
            max-height: none;
            overflow: visible;
            box-shadow: none;
            border: none;
            transform: none !important;
        }
        .modal-header, .print-controls, .btn-action, .selection-col, .modal-close {
            display: none !important;
        }
        .modal-body {
            overflow: visible !important;
            padding: 0 !important;
        }
        .record-table tr:not(.print-selected):not(.dept-header-row) {
            display: none !important;
        }
        .dept-header-row {
            display: table-row !important;
        }
        .dept-header-row.no-selected {
            display: none !important;
        }
        .record-table th, .record-table td {
            border-bottom: 1px solid #e5e7eb !important;
            padding: 10px 8px !important;
        }
    }

    .records-counter {
        cursor: pointer;
        transition: background 0.2s;
        user-select: none;
    }
    .records-counter:hover {
        background: #dbeafe;
    }

    /* Hide selection column by default */
    .selection-col {
        display: none !important;
    }
    .printing-mode .selection-col {
        display: table-cell !important;
    }
    .forwarded-select-all {
        display: none !important;
    }
    .printing-mode .forwarded-select-all {
        display: flex !important;
    }
    /* ══════════════════════════════════════════
       DARK MODE — FORM PAGE
       ══════════════════════════════════════════ */

    /* Form Card */
    body.dark-mode .form-card {
        background: #0f172a;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        border: 1px solid #1e293b;
    }

    /* Form Header */
    body.dark-mode .form-card-header {
        background: linear-gradient(135deg, rgba(30, 27, 75, 0.3) 0%, rgba(15, 23, 42, 0.5) 100%);
        border-bottom: 1px solid #1e293b;
    }
    body.dark-mode .form-card-title { color: #fff; }
    body.dark-mode .form-card-subtitle { color: #94a3b8; }
    body.dark-mode .form-badge { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
    body.dark-mode .records-counter { background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); }
    body.dark-mode .records-counter:hover { background: rgba(99, 102, 241, 0.2); }

    /* Section Labels */
    body.dark-mode .section-label span { color: #818cf8; }
    body.dark-mode .section-line { background: linear-gradient(90deg, #334155, transparent) !important; }
    body.dark-mode .section-label .section-line:last-child { background: linear-gradient(90deg, transparent, #334155) !important; }

    /* Form Labels */
    body.dark-mode .form-label { color: #cbd5e1; }

    /* Form Inputs — visible white lines */
    body.dark-mode .form-input {
        background: #111827 !important;
        border: 1.5px solid #475569 !important;
        color: #f1f5f9 !important;
    }
    body.dark-mode .form-input::placeholder { color: #64748b !important; }
    body.dark-mode .form-input:hover { border-color: #64748b !important; background: #1e293b !important; }
    body.dark-mode .form-input:focus { border-color: #818cf8 !important; background: #1e293b !important; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important; }
    body.dark-mode .input-icon { color: #fff !important; }
    body.dark-mode .input-wrapper:focus-within .input-icon { color: #818cf8 !important; }
    body.dark-mode input[type="date"] { color-scheme: dark; }
    body.dark-mode input[type="date"]::-webkit-calendar-picker-indicator { filter: brightness(0) invert(1) !important; }
    body.dark-mode .ghost-text { color: #475569; }
    body.dark-mode .ghost-text .ghost-suggestion { color: #475569; }

    /* Combobox */
    body.dark-mode .combobox-toggle { color: #64748b; }
    body.dark-mode .combobox-toggle.open { color: #818cf8; }
    body.dark-mode .combobox-dropdown {
        background: #111827;
        border: 1px solid #334155;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
    }
    body.dark-mode .combobox-option { color: #cbd5e1; }
    body.dark-mode .combobox-option:hover,
    body.dark-mode .combobox-option.highlighted { background: #1e293b; color: #fff; }
    body.dark-mode .combobox-option.selected { background: rgba(99, 102, 241, 0.1); color: #818cf8; }
    body.dark-mode .combobox-option.add-new { color: #818cf8; border-top-color: #334155; }
    body.dark-mode .combobox-group-label { color: #64748b; }
    body.dark-mode .combobox-no-results { color: #64748b; }
    body.dark-mode .combobox-dropdown::-webkit-scrollbar-thumb { background: #475569; }

    /* Multi-Select Tags */
    body.dark-mode .combobox-tag { background: rgba(99, 102, 241, 0.1); color: #818cf8; border-color: rgba(99, 102, 241, 0.3); }
    body.dark-mode .combobox-tag:hover { background: rgba(99, 102, 241, 0.2); }
    body.dark-mode .tag-remove { color: #64748b; }
    body.dark-mode .tag-remove:hover { color: #f87171; }

    /* Action Buttons */
    body.dark-mode .form-actions { border-top: 1px solid #1e293b; }
    body.dark-mode .btn-ghost { background: transparent; color: #94a3b8; border: 1.5px solid #334155; }
    body.dark-mode .btn-ghost:hover { background: #1e293b; border-color: #475569; color: #fff; }

    /* ── Modal Dark Mode ── */
    body.dark-mode .modal-backdrop { 
        background: rgba(0, 0, 0, 0.75); 
    }
    body.dark-mode .modal-sheet { 
        background: #0f172a; 
        border: 1px solid #1e293b; 
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.8); 
    }

    body.dark-mode .modal-panel {
        background: linear-gradient(160deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
        border-right: 1px solid #1e293b;
    }
    body.dark-mode .panel-title { color: #fff; }
    body.dark-mode .panel-stat-card { background: rgba(30, 41, 59, 0.5); border-color: #334155; }
    body.dark-mode .ps-count { color: #fff; }
    body.dark-mode .fi-select-wrap { background: #0f172a; border-color: #334155; }
    body.dark-mode .fi-select { color: #f1f5f9; background: #0f172a; }
    body.dark-mode .fi-select option { background: #0f172a; color: #fff; }
    body.dark-mode .btn-panel-secondary { background: #1e293b; color: #818cf8; border-color: #334155; }
    body.dark-mode .btn-panel-secondary:hover { background: #334155; color: #fff; }
    body.dark-mode .btn-panel-danger { background: #1e293b; color: #94a3b8; border-color: #334155; }
    body.dark-mode .btn-panel-danger:hover { background: rgba(239, 68, 68, 0.1); border-color: #f87171; color: #f87171; }

    body.dark-mode .modal-main { background: #0f172a; }
    body.dark-mode .modal-main-header { background: #0f172a; border-bottom-color: #1e293b; }
    body.dark-mode .mm-title { color: #fff; }
    body.dark-mode .mm-search-input { background: #111827; border-color: #1e293b; color: #fff; }
    body.dark-mode .mm-search-input:focus { border-color: #6366f1; }
    body.dark-mode .modal-main-body { background: #0f172a; }
    body.dark-mode .modal-main-footer { background: #111827; border-top-color: #1e293b; }
    
    body.dark-mode .record-table th { background: #111827; color: #94a3b8; border-bottom: 1px solid #1e293b; }
    body.dark-mode .record-table td { color: #cbd5e1; border-bottom: 1px solid #1e293b; background: transparent; }
    body.dark-mode .record-row:hover td { background: #1e293b; }

    /* Table */
    body.dark-mode .record-table th { background: #111827; color: #94a3b8; border-bottom: 1px solid #1e293b; }
    body.dark-mode .record-table td { color: #cbd5e1 !important; border-bottom: 1px solid #1e293b; background: #0f172a; }
    body.dark-mode .record-table tbody tr.record-row { background: #0f172a; }
    body.dark-mode .record-table tbody tr.record-row:hover { border-left-color: #818cf8; }
    body.dark-mode .record-table tbody tr.record-row:hover td { background: #111827; }
    body.dark-mode .record-table .cell-name { color: #fff !important; }
    body.dark-mode .record-table .cell-action-date { color: #fff !important; }
    body.dark-mode .record-table .cell-position { color: #cbd5e1 !important; }
    body.dark-mode .record-table .cell-school { color: #cbd5e1 !important; }
    body.dark-mode .record-table .cell-dates { color: #94a3b8 !important; }
    body.dark-mode .record-table .cell-deduction { color: #cbd5e1 !important; }
    body.dark-mode .record-table .cell-incharge { color: #94a3b8 !important; }

    /* Forwarded Headers — Colored */
    body.dark-mode .forwarded-header { background: rgba(99, 102, 241, 0.08) !important; color: #818cf8; border-color: rgba(99, 102, 241, 0.15) !important; }
    body.dark-mode .batch-header-row { background: #0f172a !important; }
    body.dark-mode .batch-header-row:hover { background: #0f172a !important; }
    body.dark-mode .forwarded-header-row { background: #0f172a !important; }
    body.dark-mode .forwarded-badge { background: rgba(99, 102, 241, 0.15); color: #fff; border-color: rgba(99, 102, 241, 0.3); }
    body.dark-mode .forwarded-header-row:hover .forwarded-badge { background: rgba(99, 102, 241, 0.25); border-color: rgba(99, 102, 241, 0.5); color: #fff; }
    body.dark-mode .forwarded-badge svg { color: #fff; }
    body.dark-mode .forwarded-header-row:hover .forwarded-badge svg { color: #fff; }

    /* Badges - Premium White Text Style (Matches Position view) */
    body.dark-mode .badge-leave { background: rgba(99, 102, 241, 0.25); color: #fff; border: 1px solid rgba(99, 102, 241, 0.3); }
    
    body.dark-mode .badge-green { background: #059669; color: #fff; border: none; box-shadow: 0 4px 10px rgba(5,150,105,0.3); }
    body.dark-mode .badge-red { background: #dc2626; color: #fff; border: none; box-shadow: 0 4px 10px rgba(220,38,38,0.3); }
    body.dark-mode .badge-yellow { background: #d97706; color: #fff; border: none; box-shadow: 0 4px 10px rgba(217,119,6,0.3); }
    body.dark-mode .badge-violet { background: #7c3aed; color: #fff; border: none; box-shadow: 0 4px 10px rgba(124,58,237,0.3); }
    body.dark-mode .badge-gray { background: #475569; color: #fff; border: none; }

    /* Table Action Buttons */
    body.dark-mode .btn-action { border-color: #334155; color: #94a3b8; background: transparent; }
    body.dark-mode .btn-edit { color: #34d399; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); }
    body.dark-mode .btn-edit:hover { background: #059669; color: #fff; border-color: #059669; }
    body.dark-mode .btn-delete { color: #f87171; background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
    body.dark-mode .btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

    /* Modal Footer */
    body.dark-mode .modal-footer { background: #111827; border-top: 1px solid #1e293b; }
    body.dark-mode .modal-footer-info { color: #94a3b8; }

    /* ══════════════════════════════════════════
       MODAL — MOBILE RESPONSIVE
       ══════════════════════════════════════════ */
    @media (max-width: 768px) {
        .modal-sheet {
            width: 95% !important;
            height: 85vh !important;
            border-radius: 24px !important;
            flex-direction: column !important;
            max-height: none !important;
            overflow-y: auto !important;
            background: #fff !important;
        }

        /* Left panel becomes a compact top strip */
        .modal-panel {
            width: 100% !important;
            flex-shrink: 0 !important;
            padding: 16px 20px !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 12px !important;
            border-right: none !important;
            border-bottom: 2px solid #e0e7ff;
            max-height: none !important;
            overflow: visible !important;
        }

        /* Hide decorative circles on mobile */
        .modal-panel::before,
        .modal-panel::after {
            display: none !important;
        }

        /* Compact icon */
        .panel-icon-box {
            width: 40px !important;
            height: 40px !important;
            border-radius: 12px !important;
            margin-bottom: 0 !important;
        }
        .panel-icon-box svg {
            width: 20px !important;
            height: 20px !important;
        }

        /* Title inline */
        .panel-title {
            font-size: 1rem !important;
            margin-bottom: 0 !important;
        }

        .panel-subtitle {
            display: none !important;
        }

        .panel-divider {
            display: none !important;
        }

        /* Stat card: compact inline */
        .panel-stat-card {
            padding: 10px 16px !important;
            margin-bottom: 0 !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .ps-count {
            font-size: 1.1rem !important;
            margin-bottom: 0 !important;
        }
        .ps-label {
            font-size: 0.65rem !important;
        }

        /* Filters: row layout */
        .panel-filters-group {
            display: flex !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .filter-item {
            flex: 1 !important;
            margin-bottom: 0 !important;
        }
        .fi-label {
            font-size: 0.6rem !important;
            margin-bottom: 4px !important;
        }
        .fi-select {
            padding: 8px 12px !important;
            font-size: 0.75rem !important;
        }
        .fi-select-wrap {
            border-radius: 10px !important;
        }

        /* Actions: row layout */
        .panel-actions {
            margin-top: 0 !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
            width: 100% !important;
        }
        .panel-actions .btn-panel {
            flex: 1 !important;
            min-width: 0 !important;
            padding: 10px 12px !important;
            font-size: 0.72rem !important;
            border-radius: 10px !important;
        }
        .panel-actions .btn-panel svg {
            width: 14px !important;
            height: 14px !important;
        }
        .panel-actions .export-actions {
            flex-direction: row !important;
            width: 100% !important;
        }

        /* Main content: allow content to scroll within sheet */
        .modal-main {
            flex: none !important;
            overflow: visible !important;
            background: transparent !important;
        }

        /* Header: sticky at top of scroll */
        .modal-main-header {
            padding: 12px 16px !important;
            flex-direction: column !important;
            gap: 8px !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 100 !important;
            background: #fff !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }
        body.dark-mode .modal-main-header {
            background: #0f172a !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
        }
        .mm-title {
            font-size: 0.85rem !important;
        }
        .mm-search-bar {
            max-width: 100% !important;
            width: 100% !important;
        }
        .mm-search-input {
            padding: 9px 14px 9px 36px !important;
            font-size: 0.78rem !important;
            border-radius: 10px !important;
        }

        /* Body and Table */
        .modal-main-body {
            flex: none !important;
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .record-table {
            min-width: 1100px !important;
            table-layout: fixed !important;
        }
        .record-table th,
        .record-table td {
            padding: 10px 12px !important;
            font-size: 0.72rem !important;
            white-space: normal !important;
            word-break: break-word !important;
        }

        /* Column widths for mobile wrap */
        .record-table th:nth-child(1), .record-table td:nth-child(1) { width: 45px !important; }
        .record-table th:nth-child(2), .record-table td:nth-child(2) { width: 35px !important; }
        .record-table th:nth-child(3), .record-table td:nth-child(3) { width: 140px !important; }

        /* Remove static sticky positioning for table headers to avoid sheet scroll conflict */
        .record-table th,
        .forwarded-header {
            position: relative !important;
            top: auto !important;
            z-index: auto !important;
        }

        /* Footer */
        .modal-main-footer {
            padding: 10px 16px !important;
        }
        .modal-footer {
            padding: 10px 16px !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        /* Form responsiveness */
        .form-actions {
            flex-direction: column-reverse;
            gap: 10px;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }

        /* Toast on mobile */
        .toast {
            left: 16px !important;
            right: 16px !important;
            bottom: 16px !important;
        }
    }

    /* Dark mode mobile overrides */
    @media (max-width: 768px) {
        body.dark-mode .modal-panel {
            border-bottom: 1px solid #1e293b !important;
        }
    }

</style>

<div class="toast" id="toast"></div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const selectedRecords = new Set();

    // Read URL params (from Leave Records page Add button)
    const urlParams = new URLSearchParams(window.location.search);
    const presetForwarded = urlParams.get('forwarded');
    const presetBatch = urlParams.get('batch');
    const presetSource = urlParams.get('source');
    const presetEmployeeName = urlParams.get('employeeName');
    const presetSchoolName = urlParams.get('schoolName');
    const presetPositionName = urlParams.get('positionName');
    const presetTypeName = urlParams.get('typeName');
    const presetRemarkName = urlParams.get('remarkName');
    const presetInchargeName = urlParams.get('inchargeName');

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `toast toast-${type} show`;
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function resetForm() {
        document.getElementById('leaveForm').reset();
        document.getElementById('recordId').value = '';
        if (nameCombo) nameCombo.clear();
        if (forwardedCombo) forwardedCombo.clear();
        if (posCombo) posCombo.clear();
        if (schoolCombo) schoolCombo.clear();
        if (leaveCombo) leaveCombo.clear();
        if (remarksCombo) remarksCombo.clear();
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
                const modalTotalEl = document.getElementById('modalTotalRegistered');
                if (modalTotalEl) modalTotalEl.textContent = data.count;
            })
            .catch(() => {});
    }

    // ── Enter to Next Navigation ──
    const entryFields = [
        'forwardedInput',
        'nameInput',
        'positionInput',
        'schoolInput',
        'leaveInput',
        'remarksInput',
        'inclusiveDates',
        'dateOfAction',
        'deductionRemarks',
        'submitBtn'
    ];

    function focusNextField(currentId) {
        const idx = entryFields.indexOf(currentId);
        if (idx > -1 && idx < entryFields.length - 1) {
            const nextEl = document.getElementById(entryFields[idx + 1]);
            if (nextEl) nextEl.focus();
        }
    }

    // Add enter listener to non-combobox fields
    ['inclusiveDates', 'dateOfAction', 'deductionRemarks'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    focusNextField(this.id);
                }
            });
        }
    });

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
        
        // Sync all comboboxes to ensure typed values are captured
        if (nameCombo) nameCombo.sync();
        if (forwardedCombo) forwardedCombo.sync();
        if (posCombo) posCombo.sync();
        if (schoolCombo) schoolCombo.sync();
        if (leaveCombo) leaveCombo.sync();
        if (remarksCombo) remarksCombo.sync();

        const record = {
            name: document.getElementById('employeeName').value,
            forwarded: document.getElementById('forwarded').value,
            position: document.getElementById('position').value,
            school: document.getElementById('school').value,
            type_of_leave: document.getElementById('typeOfLeave').value,
            inclusive_dates: document.getElementById('inclusiveDates').value,
            remarks: document.getElementById('remarks').value,
            date_of_action: document.getElementById('dateOfAction').value,
            deduction_remarks: document.getElementById('deductionRemarks').value,
        };

        if (!record.remarks) {
            showToast('Please provide a remark.', 'error');
            btn.disabled = false;
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Save Record
            `;
            return;
        }

        // If coming from Leave Records page, include batch/source info
        if (presetSource) {
            record.source = presetSource;
            if (presetBatch) record.target_batch = presetBatch;
        }

        const recordId = document.getElementById('recordId').value;
        const method = recordId ? 'PUT' : 'POST';
        const url = recordId ? `/leave-records/${recordId}` : '/leave-records';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(record),
        })
        .then(async res => {
            const data = await res.json();
            if (res.status === 422) {
                const errors = data.errors || {};
                const firstError = Object.values(errors)[0];
                showToast(firstError ? firstError[0] : 'Validation failed', 'error');
                btn.disabled = false;
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Save Record
                `;
                return;
            }
             if (data.success) {
                showToast(data.message);
                updateRecordCount();
                loadDropdownData();
                
                // CRITICAL: Capture the name BEFORE resetForm() clears it
                const finalName = document.getElementById('employeeName').value || presetEmployeeName;
                
                // Also capture school name in case it changed
                if (schoolCombo) schoolCombo.sync();
                const finalSchoolName = document.getElementById('school').value || presetSchoolName;

                // Also capture position name in case it changed
                if (posCombo) posCombo.sync();
                const finalPositionName = document.getElementById('position').value || presetPositionName;

                // Also capture leave type in case it changed
                if (leaveCombo) leaveCombo.sync();
                const finalTypeName = document.getElementById('typeOfLeave').value || presetTypeName;

                // Also capture remark in case it changed
                if (remarksCombo) remarksCombo.sync();
                const finalRemarkName = document.getElementById('remarks').value || presetRemarkName;
                
                resetForm();
                
                // Redirect logic
                if (presetSource === 'leave-records') {
                    setTimeout(() => {
                        window.location.href = '/leave-records';
                    }, 1000);
                } else if (presetSource === 'employee') {
                    setTimeout(() => {
                        const baseUrl = "{{ auth()->user()->role === 'admin' ? '/admin/employee' : '/user/employee' }}";
                        window.location.href = baseUrl + "?openModal=" + encodeURIComponent(finalName || '');
                    }, 1000);
                } else if (presetSource === 'school') {
                    setTimeout(() => {
                        const baseUrl = "{{ auth()->user()->role === 'admin' ? '/admin/school' : '/user/school' }}";
                        window.location.href = baseUrl + "?openModal=" + encodeURIComponent(finalSchoolName || '');
                    }, 1000);
                } else if (presetSource === 'position') {
                    setTimeout(() => {
                        const baseUrl = "{{ auth()->user()->role === 'admin' ? '/admin/position' : '/user/position' }}";
                        window.location.href = baseUrl + "?openModal=" + encodeURIComponent(finalPositionName || '');
                    }, 1000);
                } else if (presetSource === 'types-of-leave') {
                    setTimeout(() => {
                        const baseUrl = "{{ auth()->user()->role === 'admin' ? '/admin/types-of-leave' : '/user/types-of-leave' }}";
                        window.location.href = baseUrl + "?openModal=" + encodeURIComponent(finalTypeName || '');
                    }, 1000);
                } else if (presetSource === 'remarks') {
                    setTimeout(() => {
                        const baseUrl = "{{ auth()->user()->role === 'admin' ? '/admin/remarks' : '/user/remarks' }}";
                        window.location.href = baseUrl + "?openModal=" + encodeURIComponent(finalRemarkName || '');
                    }, 1000);
                } else if (presetSource === 'incharge') {
                    setTimeout(() => {
                        window.location.href = "/admin/incharge?openModal=" + encodeURIComponent(presetInchargeName || '');
                    }, 1000);
                }
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
        const isMulti = opts.multi || false;
        const strict = opts.strict || false;
        const tagsContainer = isMulti ? document.getElementById(opts.tagsId) : null;
        let selectedValues = [];
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

        function updateTags() {
            if (!tagsContainer) return;
            if (selectedValues.length === 0) {
                tagsContainer.innerHTML = '';
                return;
            }
            tagsContainer.innerHTML = selectedValues.map((val, idx) => `
                <div class="combobox-tag">
                    <span>${val}</span>
                    <span class="tag-remove" data-index="${idx}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            `).join('');

            tagsContainer.querySelectorAll('.tag-remove').forEach(btn => {
                btn.onclick = function(e) {
                    e.stopPropagation();
                    const idx = parseInt(this.getAttribute('data-index'));
                    selectedValues.splice(idx, 1);
                    updateTags();
                    hidden.value = selectedValues.join(', ');
                    if (opts.onSelect) opts.onSelect(selectedValues);
                };
            });
        }

        function applyValue(v) {
            if (isMulti) {
                if (!selectedValues.includes(v)) {
                    selectedValues.push(v);
                    updateTags();
                }
                input.value = '';
                hidden.value = selectedValues.join(', ');
                if (opts.onSelect) opts.onSelect(selectedValues);
            } else {
                input.value = v;
                hidden.value = v;
                if (opts.onSelect) opts.onSelect(v);
            }
        }

        let highlightedIndex = -1;

        function highlightOption(index) {
            const options = dropdown.querySelectorAll('.combobox-option');
            if (options.length === 0) return;
            
            options.forEach((opt, i) => {
                if (i === index) {
                    opt.classList.add('highlighted');
                    opt.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                } else {
                    opt.classList.remove('highlighted');
                }
            });
            highlightedIndex = index;
        }

        function render(filter = '') {
            const q = filter.toLowerCase();
            let html = '';
            let hasResults = false;
            highlightedIndex = -1; // Reset on new search

            if (grouped && Object.keys(groupedItems).length > 0) {
                Object.entries(groupedItems).forEach(([group, list]) => {
                    const filtered = list.filter(s => s.toLowerCase().includes(q));
                    if (filtered.length > 0) {
                        hasResults = true;
                        html += `<div class="combobox-group-label">${group}</div>`;
                        filtered.forEach(s => {
                            const isSelected = isMulti && selectedValues.includes(s);
                            html += `<div class="combobox-option ${isSelected ? 'selected' : ''}" data-value="${s}">${s}</div>`;
                        });
                    }
                });
            } else {
                const filtered = allItems.filter(s => s.toLowerCase().includes(q));
                if (filtered.length > 0) {
                    hasResults = true;
                    filtered.forEach(s => {
                        const isSelected = isMulti && selectedValues.includes(s);
                        html += `<div class="combobox-option ${isSelected ? 'selected' : ''}" data-value="${s}">${s}</div>`;
                    });
                }
            }

            if (!hasResults) {
                html = '<div class="combobox-no-results">No results found</div>';
            }

            dropdown.innerHTML = html;

            dropdown.querySelectorAll('.combobox-option').forEach((opt, idx) => {
                opt.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    applyValue(this.getAttribute('data-value'));
                    close();
                });
                // Update highlighted on hover for feedback
                opt.addEventListener('mouseenter', () => {
                    highlightOption(idx);
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
            highlightedIndex = -1;
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
            if (!isMulti) hidden.value = this.value;
            if (opts.onInput) opts.onInput(this.value);
            updateGhost();
            open();
        });

        // Accept ghost suggestion or navigate dropdown
        input.addEventListener('keydown', function(e) {
            if ((e.key === 'Tab' || e.key === 'ArrowRight') && ghost && ghost.innerHTML) {
                const suggestionEl = ghost.querySelector('.ghost-suggestion');
                if (suggestionEl && suggestionEl.textContent) {
                    e.preventDefault();
                    const fullText = input.value + suggestionEl.textContent;
                    applyValue(fullText);
                    ghost.innerHTML = '';
                    close();
                    focusNextField(input.id);
                }
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!dropdown.classList.contains('show')) open();
                const options = dropdown.querySelectorAll('.combobox-option');
                let next = highlightedIndex + 1;
                if (next >= options.length) next = 0;
                highlightOption(next);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const options = dropdown.querySelectorAll('.combobox-option');
                let prev = highlightedIndex - 1;
                if (prev < 0) prev = options.length - 1;
                highlightOption(prev);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                const options = dropdown.querySelectorAll('.combobox-option');
                
                // If something is highlighted with arrows, use that!
                if (highlightedIndex > -1 && options[highlightedIndex]) {
                    applyValue(options[highlightedIndex].getAttribute('data-value'));
                } else {
                    const val = input.value.trim();
                    if (val !== '') {
                        const match = allItems.find(s => s.toLowerCase() === val.toLowerCase());
                        if (strict && !match) {
                            const ghostSuggestion = ghost && ghost.querySelector('.ghost-suggestion');
                            if (ghostSuggestion) {
                                applyValue(val + ghostSuggestion.textContent);
                            } else {
                                input.value = '';
                            }
                        } else {
                            applyValue(match || val);
                        }
                        
                        if (isMulti) {
                            if (ghost) ghost.innerHTML = '';
                            return; 
                        }
                    }
                }
                close();
                focusNextField(input.id);
            }
        });

        input.addEventListener('blur', function() {
            if (ghost) ghost.innerHTML = '';
            
            if (strict && input.value.trim() !== '') {
                const val = input.value.trim();
                const match = allItems.find(s => s.toLowerCase() === val.toLowerCase());
                if (!match) {
                    input.value = ''; // Clear invalid partial input
                } else {
                    input.value = match; // Snap to correct case
                }
            }
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
                allItems = Array.isArray(newItems) ? [...newItems] : [];
            },
            updateGroupedItems: function(newGroups) {
                groupedItems = newGroups && typeof newGroups === 'object' ? newGroups : {};
                flattenItems();
            },
            clear: function() {
                selectedValues = [];
                if (isMulti) updateTags();
                input.value = '';
                hidden.value = '';
            },
            setValue: function(val) {
                if (isMulti) {
                    selectedValues = val ? val.split(', ').filter(v => v) : [];
                    updateTags();
                    hidden.value = selectedValues.join(', ');
                } else {
                    input.value = val || '';
                    hidden.value = val || '';
                }
            },
            // Ensure any typed but un-entered value is captured
            sync: function() {
                if (input.value.trim() !== '') {
                    const val = input.value.trim();
                    if (isMulti) {
                        if (!selectedValues.includes(val)) {
                            selectedValues.push(val);
                            updateTags();
                            hidden.value = selectedValues.join(', ');
                        }
                        input.value = '';
                    } else {
                        hidden.value = val;
                    }
                }
            }
        };
    }

    // ── Initialize comboboxes ──
    let nameCombo, forwardedCombo, posCombo, schoolCombo, leaveCombo, remarksCombo;
    let employeeDataMap = {};
    let allEmployeeNames = [];

    const leaveTypes = ['FL', 'SL', 'SPL', 'VL', 'SP', 'CTO', 'LC', 'SP/SPL', 'CL', 'PL', 'CTO/LC', 'SL/SPL', 'FL/SL', 'FL/SPL'];
    const remarksList = ['With Pay', 'Without Pay', 'With Pay & Without Pay'];

    function autoFillEmployee(name) {
        if (!name) return;
        const info = employeeDataMap[name];
        if (info) {
            if (info.forwarded && forwardedCombo) forwardedCombo.setValue(info.forwarded);
            if (info.position && posCombo) posCombo.setValue(info.position);
            if (info.school && schoolCombo) schoolCombo.setValue(info.school);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        nameCombo = initCombobox('nameInput', 'employeeName', 'nameDropdown', [], {
            onSelect: function(val) { autoFillEmployee(val); },
            onInput: function(val) { autoFillEmployee(val); }
        });
        forwardedCombo = initCombobox('forwardedInput', 'forwarded', 'forwardedDropdown', [], {
            onSelect: function(val) { filterNamesByForwarded(val); },
            onInput: function(val) { filterNamesByForwarded(val); }
        });
        posCombo = initCombobox('positionInput', 'position', 'posDropdown', []);
        schoolCombo = initCombobox('schoolInput', 'school', 'schoolDropdown', {}, { grouped: true });
        leaveCombo = initCombobox('leaveInput', 'typeOfLeave', 'leaveDropdown', leaveTypes, { 
            multi: true, 
            strict: false,
            tagsId: 'leaveTags' 
        });
        remarksCombo = initCombobox('remarksInput', 'remarks', 'remarksDropdown', remarksList);

        // Load from database
        updateRecordCount();
        loadDropdownData().then(() => {
            // Check for edit parameter
            const urlParams = new URLSearchParams(window.location.search);
            const editId = urlParams.get('edit');
            if (editId) {
                fetch(`/api/leave-records/${editId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) editRecord(data);
                    })
                    .catch(() => {});
            }
            
            // Pre-fill forwarded if coming from Leave Records Add button
            if (presetForwarded && forwardedCombo) {
                forwardedCombo.setValue(presetForwarded);
                filterNamesByForwarded(presetForwarded);
            }
        });
        setTodayDate();
    });

    function filterNamesByForwarded(forwarded) {
        if (!nameCombo) return;
        if (!forwarded) {
            nameCombo.updateItems(allEmployeeNames);
            return;
        }
        const filtered = allEmployeeNames.filter(name => {
            const info = employeeDataMap[name];
            return info && info.forwarded === forwarded;
        });
        nameCombo.updateItems(filtered);
    }

    function loadDropdownData() {
        return fetch('/leave-records/dropdown-data')
            .then(res => res.json())
            .then(data => {
                allEmployeeNames = data.names || [];
                if (nameCombo) nameCombo.updateItems(allEmployeeNames);
                if (forwardedCombo) forwardedCombo.updateItems(data.forwardeds || []);
                if (posCombo) posCombo.updateItems(data.positions || []);
                if (schoolCombo) schoolCombo.updateGroupedItems(data.schools || {});
                
                employeeDataMap = data.employee_map || {};

                // Merge hardcoded leaveTypes with dynamic ones from DB
                if (leaveCombo) {
                    const dbTypes = data.leave_types || [];
                    const combinedTypes = [...new Set([...leaveTypes, ...dbTypes])];
                    leaveCombo.updateItems(combinedTypes);
                }
                
                // Strictly use the hardcoded list for Remarks
                if (remarksCombo) remarksCombo.updateItems(remarksList);
            })
            .catch(() => {});
    }
</script>

<!-- Records Modal -->
<div class="modal-backdrop" id="recordsModal">
    <div class="modal-sheet">
        <!-- Left Panel -->
        <div class="modal-panel">
            <div class="panel-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:24px; height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <h2 class="panel-title">Records Registry</h2>
            <p class="panel-subtitle">Leave Management</p>
            
            <div class="panel-stat-card">
                <span class="ps-count" id="modalTotalRegistered">0</span>
                <span class="ps-label">Total Registered</span>
            </div>

            <div class="panel-divider"></div>

            <div class="panel-filters-group">
                <div class="filter-item">
                    <label class="fi-label">Forwarded</label>
                    <div class="fi-select-wrap">
                        <select id="filterForwarded" class="fi-select" onchange="filterModalRecords()">
                            <option value="all">All Forwarded</option>
                        </select>
                    </div>
                </div>
                <div class="filter-item">
                    <label class="fi-label">Pay Status</label>
                    <div class="fi-select-wrap">
                        <select id="filterPay" class="fi-select" onchange="filterModalRecords()">
                            <option value="all">All Status</option>
                            <option value="with pay">With Pay</option>
                            <option value="without pay">Without Pay</option>
                            <option value="with pay & without pay">With Pay & Without Pay</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="panel-actions">
                <button class="btn-panel btn-panel-done" onclick="doneAction()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Done</span>
                </button>

                <button id="excelModeBtn" class="btn-panel btn-panel-secondary" onclick="togglePrintMode()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Export Data</span>
                </button>
                <div class="export-actions" style="display: none; flex-direction: column; gap: 8px; width: 100%;">
                    <button class="btn-panel btn-panel-primary" onclick="executeExport()">Download .xls</button>
                    <button class="btn-panel btn-panel-secondary" onclick="togglePrintMode()">Cancel</button>
                </div>
                
                <button class="btn-panel btn-panel-danger" onclick="closeRecordsModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px; height:16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close Registry
                </button>
            </div>
        </div>

        <!-- Right Main Panel -->
        <div class="modal-main">
            <div class="modal-main-header">
                <h3 class="mm-title">Leave Records Table</h3>
                <div class="mm-search-bar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" id="modalSearch" class="mm-search-input" placeholder="Search by name, position, school...">
                </div>
            </div>

            <div class="modal-main-body">
                <table class="record-table">
                    <thead>
                        <tr>
                            <th class="selection-col"></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>School</th>
                            <th>Leave Type</th>
                            <th>Inclusive Dates</th>
                            <th>Remarks</th>
                            <th>Action Date</th>
                            <th>Deduction Remark</th>
                            <th>Incharge</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="recordsTableBody">
                        <tr><td colspan="12" class="empty-registry-message">Loading registry records...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-main-footer" id="modalSelectionFooter">
                <span class="selection-badge" id="selectedCountValue">0</span>
                <span>items selected for export</span>
            </div>
        </div>
    </div>
</div>

<script>
    const recordsModal = document.getElementById('recordsModal');
    const recordsCounter = document.querySelector('.records-counter');

    recordsCounter.addEventListener('click', openRecordsModal);

    function openRecordsModal() {
        recordsModal.classList.add('open');
        document.getElementById('modalSearch').value = '';
        if (document.getElementById('filterPay')) document.getElementById('filterPay').value = 'all';
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

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && recordsModal.classList.contains('open')) {
            closeRecordsModal();
        }
    });


    function filterModalRecords() {
        const q = document.getElementById('modalSearch').value.toLowerCase();
        const payStatus = document.getElementById('filterPay') ? document.getElementById('filterPay').value : 'all';
        const forwardedFilter = document.getElementById('filterForwarded') ? document.getElementById('filterForwarded').value : 'all';
        const rows = document.querySelectorAll('#recordsTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (row.classList.contains('forwarded-header-row')) return;
            if (row.id === 'noResultsRow') return;
            
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(q);
            const matchesForwarded = (forwardedFilter === 'all' || row.getAttribute('data-forwarded') === forwardedFilter);
            
            let matchesPay = true;
            const rowRemarks = (row.getAttribute('data-remarks') || '').toLowerCase();
            if (payStatus === 'with pay') {
                matchesPay = (rowRemarks.includes('with pay') && !rowRemarks.includes('without pay')) || (rowRemarks.includes('approved') && !rowRemarks.includes('disapproved'));
            } else if (payStatus === 'without pay') {
                matchesPay = (rowRemarks.includes('without pay') && !rowRemarks.includes('with pay')) || rowRemarks.includes('disapproved');
            } else if (payStatus === 'with pay & without pay') {
                matchesPay = rowRemarks.includes('with pay') && rowRemarks.includes('without pay');
            }
            
            const isVisible = matchesSearch && matchesPay && matchesForwarded;
            row.style.display = isVisible ? '' : 'none';
            if (isVisible) visibleCount++;
        });

        // Handle case where all rows are filtered out
        const tbody = document.getElementById('recordsTableBody');
        const existingNoResults = document.getElementById('noResultsRow');
        
        if (visibleCount === 0 && rows.length > 0 && rows[0].cells.length >= 2) {
            const noResultsMsg = (q || payStatus !== 'all') ? `No records matching current filters` : `No records found`;
            if (!existingNoResults) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = `<td colspan="12" class="empty-registry-message">${noResultsMsg}</td>`;
                tbody.appendChild(noResultsRow);
            } else {
                existingNoResults.innerHTML = `<td colspan="12" class="empty-registry-message">${noResultsMsg}</td>`;
                existingNoResults.style.display = '';
            }
        } else if (existingNoResults) {
            existingNoResults.style.display = 'none';
        }

        // Logic to hide/show forwarded headers based on visible records and selected filter
        let currentHeader = null;
        let hasVisibleRecordsInGroup = false;

        rows.forEach(row => {
            if (row.classList.contains('forwarded-header-row')) {
                // Before starting next group, hide previous header if needed
                if (currentHeader && !hasVisibleRecordsInGroup) {
                    currentHeader.style.display = 'none';
                }
                
                currentHeader = row;
                hasVisibleRecordsInGroup = false;
                
                const headerForwarded = row.getAttribute('data-forwarded');
                const matchesForwardedFilter = (forwardedFilter === 'all' || headerForwarded === forwardedFilter);
                
                row.style.display = matchesForwardedFilter ? '' : 'none';
            } else if (row.id !== 'noResultsRow' && row.style.display !== 'none') {
                hasVisibleRecordsInGroup = true;
            }
        });

        if (currentHeader && !hasVisibleRecordsInGroup) {
            currentHeader.style.display = 'none';
        }
    }

    let currentModalRecords = [];
    document.getElementById('modalSearch').addEventListener('input', filterModalRecords);

    function fetchRecordsList() {
        const url = '/leave-records?view=registry';

        fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                // Sort by forwarded first
                data.sort((a, b) => (a.forwarded || '').localeCompare(b.forwarded || ''));
                
                currentModalRecords = data;
                const modalTotalEl = document.getElementById('modalTotalRegistered');
                if (modalTotalEl) modalTotalEl.textContent = data.length;
                const tbody = document.getElementById('recordsTableBody');
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="12" class="empty-registry-message">No records found.</td></tr>';
                    return;
                }

                const formatDate = (dateStr) => {
                    if (!dateStr) return '-';
                    try {
                        const date = new Date(dateStr);
                        if (isNaN(date.getTime())) return dateStr;
                        const mm = String(date.getMonth() + 1).padStart(2, '0');
                        const dd = String(date.getDate()).padStart(2, '0');
                        const yyyy = date.getFullYear();
                        return `${mm}-${dd}-${yyyy}`;
                    } catch (e) {
                        return dateStr;
                    }
                };

                // Populate Forwarded Filter
                const forwardedSelect = document.getElementById('filterForwarded');
                const forwardeds = [...new Set(data.map(r => r.forwarded || 'No Forwarded'))].sort();
                const currentFilter = forwardedSelect.value;
                forwardedSelect.innerHTML = '<option value="all">All Forwarded</option>';
                forwardeds.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d;
                    opt.textContent = d;
                    forwardedSelect.appendChild(opt);
                });
                forwardedSelect.value = forwardeds.includes(currentFilter) ? currentFilter : 'all';

                let html = '';
                let lastDept = null;

                data.forEach((r, index) => {
                    const forwarded = r.forwarded || '';
                if (forwarded && forwarded !== lastDept) {
                    html += `
                        <tr class="forwarded-header-row" data-forwarded="${forwarded}">
                            <td colspan="12" class="forwarded-header">
                                <div class="forwarded-header-content">
                                    <div class="custom-checkbox forwarded-select-all" data-forwarded="${forwarded}" onclick="toggleForwardedSelection('${forwarded.replace(/'/g, "\\'")}', this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>
                                    </div>
                                    <div class="forwarded-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:16px; height:16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                        </svg>
                                        <span>${forwarded}</span>
                                    </div>
                                    <div class="header-date-badge" style="display: none;">
                                        ${r.created_at ? formatDate(r.created_at) : '-'}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                        lastDept = forwarded;
                    }

                    let remarkClass = 'badge-gray';
                    const rem = (r.remarks || '').toLowerCase();
                    if (rem.includes('with pay') && rem.includes('without pay')) remarkClass = 'badge-violet';
                    else if (rem.includes('approved') || rem.includes('with pay')) remarkClass = 'badge-green';
                    else if (rem.includes('disapproved') || rem.includes('without pay') || rem.includes('cancelled')) remarkClass = 'badge-red';
                    else if (rem.includes('pending') || rem.includes('review')) remarkClass = 'badge-yellow';
                    
                    const remarkBadge = r.remarks ? `<span class="badge ${remarkClass}">${r.remarks}</span>` : '<span style="color:#cbd5e1">-</span>';

                    html += `
                        <tr data-forwarded="${forwarded}" data-id="${r.id}" data-remarks="${(r.remarks || '').toLowerCase()}" class="record-row">
                            <td class="selection-col">
                                <div class="custom-checkbox record-select" onclick="toggleRecordSelection(${r.id}, this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z"/></svg>
                                </div>
                            </td>
                            <td class="cell-idx" style="font-weight: 600; font-family:monospace;">${index + 1}</td>
                            <td class="cell-name" style="font-weight: 700;">${r.name}</td>
                            <td class="cell-position" style="font-weight: 600;">${r.position || '-'}</td>
                            <td class="cell-school">${r.school || '-'}</td>
                            <td><span class="badge-leave">${r.type_of_leave}</span></td>
                            <td class="cell-dates" style="font-family:monospace; letter-spacing: -0.01em;">${r.inclusive_dates || '-'}</td>
                            <td>${remarkBadge}</td>
                            <td class="cell-action-date" style="font-family:monospace; font-weight:700;">${formatDate(r.date_of_action)}</td>
                            <td class="cell-deduction">${r.deduction_remarks || '-'}</td>
                            <td class="cell-incharge" style="font-style: italic; font-weight: 500;">${r.first_name || r.incharge || '-'}</td>
                            <td>
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: nowrap;">
                                    <button onclick="editModalRecord(${r.id})" class="btn-action btn-edit" title="Edit">
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
                });

                tbody.innerHTML = html;

                // Apply filters to new data
                filterModalRecords();
            })
            .catch(() => {
                document.getElementById('recordsTableBody').innerHTML = '<tr><td colspan="12" style="text-align:center; padding: 30px; color: #ef4444;">Error loading records.</td></tr>';
            });
    }

    function editModalRecord(id) {
        const record = currentModalRecords.find(r => r.id == id);
        if (record) {
            editRecord(record);
        }
    }

    function editRecord(r) {
        // Close modal first
        closeRecordsModal();
        
        // Populate form fields
        document.getElementById('recordId').value = r.id;
        
        // For comboboxes, use setValue
        if (nameCombo) nameCombo.setValue(r.name);
        if (forwardedCombo) forwardedCombo.setValue(r.forwarded ? r.forwarded.split(' - ')[0].trim() : '');
        if (posCombo) posCombo.setValue(r.position);
        if (schoolCombo) schoolCombo.setValue(r.school);
        if (leaveCombo) leaveCombo.setValue(r.type_of_leave);
        if (remarksCombo) remarksCombo.setValue(r.remarks);

        // Standard inputs
        if (document.getElementById('inclusiveDates')) {
            document.getElementById('inclusiveDates').value = r.inclusive_dates || '';
        }
        if (document.getElementById('dateOfAction')) {
            document.getElementById('dateOfAction').value = r.date_of_action ? r.date_of_action.substring(0, 10) : '';
        }
        if (document.getElementById('deductionRemarks')) {
            document.getElementById('deductionRemarks').value = r.deduction_remarks || '';
        }

        // Change submit button text
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
            </svg>
            Update Record
        `;
        
        // Scroll to form
        window.scrollTo({ top: 0, behavior: 'smooth' });
        showToast('Form populated with record details. You can now edit and save.', 'info');
    }

    function deleteRecord(id) {
        if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) return;

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
                showToast(data.message);
                updateRecordCount();
                fetchRecordsList(); // Refresh the list in modal
            } else {
                showToast('Error deleting record', 'error');
            }
        })
        .catch(() => {
            showToast('Error deleting record. Please try again.', 'error');
        });
    }

    // --- Printing Mode Logic ---
    let isPrintingMode = false;

    function togglePrintMode() {
        isPrintingMode = !isPrintingMode;
        const sheet = document.querySelector('.modal-sheet');
        const exportActions = document.querySelector('.export-actions');
        const excelModeBtn = document.getElementById('excelModeBtn');
        const selectionFooter = document.getElementById('modalSelectionFooter');
        
        if (isPrintingMode) {
            if (sheet) sheet.classList.add('printing-mode');
            if (exportActions) exportActions.style.display = 'flex';
            if (excelModeBtn) excelModeBtn.style.display = 'none';
            if (selectionFooter) selectionFooter.classList.add('active');
            
            // AUTOMATIC SELECTION: Select all visible rows by default
            const visibleRows = document.querySelectorAll('.record-row:not([style*="display: none"])');
            visibleRows.forEach(row => {
                const checkbox = row.querySelector('.record-select');
                if (checkbox && !checkbox.classList.contains('checked')) {
                    toggleRecordSelection(row.getAttribute('data-id'), checkbox);
                }
            });
        } else {
            if (sheet) sheet.classList.remove('printing-mode');
            if (exportActions) exportActions.style.display = 'none';
            if (excelModeBtn) excelModeBtn.style.display = 'flex';
            if (selectionFooter) selectionFooter.classList.remove('active');
            
            // Clear selections when exiting print mode
            if (typeof selectedRecords !== 'undefined') {
                selectedRecords.clear();
            }
            document.querySelectorAll('.record-select.checked').forEach(cb => cb.classList.remove('checked'));
            document.querySelectorAll('.forwarded-select-all.checked').forEach(cb => cb.classList.remove('checked'));
            document.querySelectorAll('.record-row.selected-row').forEach(row => row.classList.remove('selected-row'));
            updateSelectedCount();
        }
    }

    function updateSelectedCount() {
        const count = selectedRecords.size;
        const countEl = document.getElementById('selectedCountValue');
        if (countEl) countEl.textContent = count;
        
        // Update header checkboxes based on grouped children
        document.querySelectorAll('.forwarded-select-all').forEach(headerCb => {
            const forwarded = headerCb.getAttribute('data-forwarded');
            const rowsInGroup = document.querySelectorAll(`.record-row[data-forwarded="${forwarded}"]:not([style*="display: none"])`);
            const checkedInGroup = Array.from(rowsInGroup).filter(row => {
                const cb = row.querySelector('.record-select');
                return cb && cb.classList.contains('checked');
            });
            
            if (rowsInGroup.length > 0 && checkedInGroup.length === rowsInGroup.length) {
                headerCb.classList.add('checked');
            } else {
                headerCb.classList.remove('checked');
            }
        });
    }

    function toggleRecordSelection(id, element) {
        if (!isPrintingMode) return;
        
        const row = element.closest('tr');
        if (element.classList.contains('checked')) {
            element.classList.remove('checked');
            row.classList.remove('selected-row');
            selectedRecords.delete(id.toString());
        } else {
            element.classList.add('checked');
            row.classList.add('selected-row');
            selectedRecords.add(id.toString());
        }
        updateSelectedCount();
    }

    function toggleForwardedSelection(forwarded, el) {
        if (!isPrintingMode) return;
        
        el.classList.toggle('checked');
        const newState = el.classList.contains('checked');
        
        const rowsInGroup = document.querySelectorAll(`.record-row[data-forwarded="${forwarded}"]:not([style*="display: none"])`);
        rowsInGroup.forEach(row => {
            const checkbox = row.querySelector('.record-select');
            if (checkbox) {
                if (newState) {
                    row.classList.add('selected-row');
                    checkbox.classList.add('checked');
                    selectedRecords.add(row.getAttribute('data-id'));
                } else {
                    row.classList.remove('selected-row');
                    checkbox.classList.remove('checked');
                    selectedRecords.delete(row.getAttribute('data-id'));
                }
            }
        });
        updateSelectedCount();
    }

    function executeExport() {
        const selectedRows = document.querySelectorAll('.record-row.selected-row');
        if (selectedRows.length === 0) {
            alert('Please select at least one record to export.');
            return;
        }

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
                    table { border-collapse: collapse; width: 100%; }
                    th { background-color: #f1f5f9; color: #1e293b; font-weight: bold; border: 1px solid #cbd5e1; padding: 10px; }
                    td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
                    .forwarded-header { background-color: #e2e8f0; font-weight: bold; text-align: center; }
                    .remark-with-pay { color: #16a34a; font-weight: bold; }
                    .remark-without-pay { color: #dc2626; font-weight: bold; }
                    .remark-both { color: #7c3aed; font-weight: bold; }
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

        let isFirstGroup = true;
        let counter = 1;

        // Color mapping for consistent forwarded headers (matches Leave Records page)
        const forwardedColorMap = {};
        const pastelColors = ['#e0f2fe', '#fef2f2', '#f0fdf4', '#f5f3ff', '#fff7ed', '#ecfeff', '#fdf2f8', '#ffedd5'];
        let nextColorIdx = 0;

        function getHeaderColor(name) {
            const clean = (name || '').trim().toLowerCase();
            if (!forwardedColorMap[clean]) {
                forwardedColorMap[clean] = pastelColors[nextColorIdx % pastelColors.length];
                nextColorIdx++;
            }
            return forwardedColorMap[clean];
        }

        // Iterate through rows in the DOM to preserve grouping and sorting
        const rows = document.querySelectorAll('#recordsTableBody tr');
        rows.forEach(row => {
            if (row.classList.contains('forwarded-header-row')) {
                const forwardedName = row.getAttribute('data-forwarded');
                // Check if any selected row exists under this specific forwarded header
                let hasSelected = false;
                let next = row.nextElementSibling;
                while (next && !next.classList.contains('forwarded-header-row') && !next.classList.contains('batch-header-row')) {
                    if (next.classList.contains('selected-row')) {
                        hasSelected = true;
                        break;
                    }
                    next = next.nextElementSibling;
                }
                if (hasSelected) {
                    const dateEl = row.querySelector('.header-date-badge');
                    const groupDate = dateEl ? dateEl.textContent.trim() : '';
                    const bgColor = getHeaderColor(forwardedName);
                    // Format: Forwarded Name - mm-dd-yyyy
                    const headerText = groupDate ? `${forwardedName} - ${groupDate}` : forwardedName;
                    html += `<tr><td colspan="10" class="forwarded-header" style="background-color: ${bgColor};">${headerText}</td></tr>`;
                }

            } else if (row.classList.contains('selected-row')) {
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

                // Note: Index 0 is selection-col, index 1 is #, index 2 is Name...
                html += `
                    <tr>
                        <td>${counter++}</td>
                        <td>${cells[2].textContent}</td>
                        <td>${cells[3].textContent}</td>
                        <td>${cells[4].textContent}</td>
                        <td>${cells[5].textContent}</td>
                        <td>${cells[6].textContent}</td>
                        <td><span class="${remarkStyleClass}">${remarksText}</span></td>
                        <td>${cells[8].textContent}</td>
                        <td>${cells[9].textContent}</td>
                        <td>${cells[10].textContent}</td>
                    </tr>
                `;
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
        a.download = `Leave_Records_Registry_${timestamp}.xls`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        // Extract IDs of exported records BEFORE clearing selection mode
        const exportedRows = document.querySelectorAll('#recordsTableBody tr.record-row.selected-row');
        const exportedIds = Array.from(exportedRows).map(row => row.getAttribute('data-id')).filter(id => id);

        showToast('Excel file generated successfully.');
        togglePrintMode(); // Exit excel mode (this clears selected-row classes)
        
        if (exportedIds.length > 0) {
            processRecordsInRegistry(exportedIds, 'Exported records marked as processed.');
        }
    }

    function processRecordsInRegistry(ids, successMessage = 'Registry cleared successfully.') {
        const tbody = document.getElementById('recordsTableBody');
        
        // Add a clearing animation
        tbody.style.transition = 'opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        tbody.style.opacity = '0.5';
        tbody.style.transform = 'translateY(10px)';

        // Call API to mark as processed
        fetch('/leave-records/bulk-process', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                setTimeout(() => {
                    // Update: Re-fetching the list is safer than just clearing HTML manually, 
                    // but for smooth UI we clear/hide the rows first
                    if (ids.length >= tbody.querySelectorAll('.record-row').length) {
                        tbody.innerHTML = '<tr><td colspan="12" class="empty-registry-message">All records processed and removed from registry.</td></tr>';
                    } else {
                        // Just re-fetch if partial export was done
                        fetchRecordsList();
                    }
                    
                    tbody.style.opacity = '1';
                    tbody.style.transform = 'translateY(0)';
                    
                    showToast(successMessage);
                    updateRecordCount(); // Refresh the counter on the form
                    
                    if (ids.length >= tbody.querySelectorAll('.record-row').length) {
                        setTimeout(closeRecordsModal, 800);
                    }
                }, 400);
            } else {
                tbody.style.opacity = '1';
                tbody.style.transform = 'translateY(0)';
                showToast('Error processing records', 'error');
            }
        })
        .catch(() => {
            tbody.style.opacity = '1';
            tbody.style.transform = 'translateY(0)';
            showToast('Connection error', 'error');
        });
    }

    function completeRegistryAction() {
        const tbody = document.getElementById('recordsTableBody');
        const rows = tbody.querySelectorAll('.record-row');
        
        if (rows.length === 0) {
            closeRecordsModal();
            return;
        }

        // Get all visible record IDs in the registry
        const ids = Array.from(rows).map(row => row.getAttribute('data-id')).filter(id => id);

        if (ids.length === 0) {
            closeRecordsModal();
            return;
        }

        processRecordsInRegistry(ids, 'Registry cleared successfully.');
    }

    function doneAction() {
        const tbody = document.getElementById('recordsTableBody');
        const rows = tbody.querySelectorAll('.record-row');
        
        if (rows.length > 0) {
            const ids = Array.from(rows).map(row => row.getAttribute('data-id')).filter(id => id);
            if (ids.length > 0) {
                // Process them first
                processRecordsInRegistry(ids, 'Finalizing registry...');
                // Wait a bit for processing to complete then redirect
                setTimeout(() => {
                    window.location.href = '/user/leave-records';
                }, 1200);
                return;
            }
        }
        
        // If no records, just go to history
        window.location.href = '/user/leave-records';
    }
</script>
</body>
</html>

