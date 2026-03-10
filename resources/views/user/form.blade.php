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
    /* ══════════════════════════════════════════
       MODAL — PROFESSIONAL MINIMAL DESIGN
       ══════════════════════════════════════════ */

    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
        backdrop-filter: blur(4px);
    }
    .modal-overlay.open {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-container {
        background: #fff;
        width: 96%;
        max-width: 1500px;
        border-radius: 16px;
        padding: 0;
        transform: translateY(20px);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        max-height: 92vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }
    .modal-overlay.open .modal-container {
        transform: translateY(0);
    }

    /* ── Modal Header ── */
    .modal-header {
        display: flex;
        flex-direction: column;
        padding: 0;
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 20;
        gap: 0;
    }
    .modal-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 20px 28px;
        border-bottom: 1px solid #e5e7eb;
    }
    .modal-title-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .modal-icon-box {
        width: 38px;
        height: 38px;
        background: #6366f1;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .modal-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .modal-close {
        background: transparent;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        color: #94a3b8;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
    }
    .modal-close:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #ef4444;
        transform: rotate(90deg);
    }

    /* ── Filter Bar ── */
    .modal-header-bottom {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 28px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        width: 100%;
        flex-wrap: wrap;
    }
    .modal-header-bottom .filter-divider {
        width: 1px;
        height: 22px;
        background: #d1d5db;
    }
    .modal-header-bottom .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .modal-header-bottom .filter-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }
    .modal-filter-input {
        padding: 7px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.82rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        background: #fff;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .modal-filter-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }
    .modal-filter-select {
        padding: 7px 32px 7px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.82rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        background: #fff;
        outline: none;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m19.5 8.25-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 14px;
        transition: border-color 0.2s ease;
    }
    .modal-filter-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.08);
    }
    .modal-search-box {
        position: relative;
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 200px;
        max-width: 280px;
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

    /* ── Modal Body ── */
    .modal-body {
        overflow-y: auto;
        overflow-x: hidden;
        flex: 1;
        padding: 0;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .modal-body::-webkit-scrollbar {
        display: none;
    }

    /* ── Table ── */
    .record-table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .record-table th {
        text-align: left;
        padding: 12px 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #6b7280;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 40;
        height: 44px;
        box-sizing: border-box;
        white-space: nowrap;
    }
    .record-table td {
        padding: 14px 20px;
        font-size: 0.84rem;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
        transition: all 0.2s ease;
    }
    .record-table tbody tr.record-row {
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    .record-table tbody tr.record-row:hover {
        border-left: 3px solid #6366f1;
    }
    .record-table tbody tr.record-row:hover td {
        background: #f5f3ff;
    }
    .record-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── Forwarded Header ── */
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
        top: 44px;
        z-index: 30;
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
        font-size: 0.7rem;
        padding: 3px 10px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-block;
        transition: all 0.2s ease;
    }
    .badge-green { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .badge-red { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-yellow { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-violet { background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe; }
    .badge-gray { background: #f9fafb; color: #4b5563; border: 1px solid #e5e7eb; }

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
    body.dark-mode .modal-overlay { background: rgba(0, 0, 0, 0.7); }
    body.dark-mode .modal-container { background: #0f172a; border: 1px solid #1e293b; box-shadow: 0 25px 70px rgba(0, 0, 0, 0.8); }

    /* Modal Header */
    body.dark-mode .modal-header { background: #0f172a; }
    body.dark-mode .modal-header-top { border-bottom-color: #1e293b; }
    body.dark-mode .modal-title { color: #fff; }
    body.dark-mode .modal-close { background: #111827; border-color: #334155; color: #94a3b8; }
    body.dark-mode .modal-close:hover { background: rgba(239, 68, 68, 0.1); border-color: #f87171; color: #f87171; }

    /* Modal Filter Bar */
    body.dark-mode .modal-header-bottom { background: #111827; border-bottom-color: #1e293b; }
    body.dark-mode .modal-header-bottom .filter-label { color: #94a3b8; }
    body.dark-mode .modal-header-bottom .filter-divider { background: #334155; }
    body.dark-mode .modal-filter-input { background: #0f172a; border-color: #334155; color: #f1f5f9; }
    body.dark-mode .modal-filter-input::placeholder { color: #64748b; }
    body.dark-mode .modal-filter-input:focus { border-color: #6366f1; }
    body.dark-mode .modal-filter-select { background: #0f172a; border-color: #334155; color: #f1f5f9; }
    body.dark-mode .modal-filter-select option { background: #0f172a; color: #f1f5f9; }
    body.dark-mode .modal-filter-select:focus { border-color: #6366f1; }

    /* Modal Search */
    body.dark-mode .modal-search-input { background: #0f172a; border: 1px solid #334155; color: #fff; }
    body.dark-mode .modal-search-input::placeholder { color: #64748b; }
    body.dark-mode .modal-search-input:focus { border-color: #818cf8; }
    body.dark-mode .modal-search-box .search-icon { color: #64748b; }

    /* Table */
    body.dark-mode .record-table th { background: #111827; color: #94a3b8; border-bottom: 1px solid #1e293b; }
    body.dark-mode .record-table td { color: #cbd5e1; border-bottom: 1px solid #1e293b; background: #0f172a; }
    body.dark-mode .record-table tbody tr.record-row { background: #0f172a; }
    body.dark-mode .record-table tbody tr.record-row:hover { border-left-color: #818cf8; }
    body.dark-mode .record-table tbody tr.record-row:hover td { background: #111827; }

    /* Forwarded Headers — Colored */
    body.dark-mode .forwarded-header { background: rgba(99, 102, 241, 0.08) !important; color: #818cf8; border-color: rgba(99, 102, 241, 0.15) !important; }
    body.dark-mode .batch-header-row { background: #0f172a !important; }
    body.dark-mode .batch-header-row:hover { background: #0f172a !important; }
    body.dark-mode .forwarded-badge { background: rgba(99, 102, 241, 0.12); color: #818cf8; border-color: rgba(99, 102, 241, 0.25); }
    body.dark-mode .forwarded-header-row:hover .forwarded-badge { background: rgba(99, 102, 241, 0.2); border-color: rgba(99, 102, 241, 0.4); color: #a5b4fc; }
    body.dark-mode .forwarded-badge svg { color: #818cf8; }
    body.dark-mode .forwarded-header-row:hover .forwarded-badge svg { color: #a5b4fc; }

    /* Badges */
    body.dark-mode .badge-leave { background: rgba(99, 102, 241, 0.1); color: #818cf8; border-color: rgba(99, 102, 241, 0.2); }
    body.dark-mode .record-table tbody tr.record-row:hover .badge-leave { background: rgba(99, 102, 241, 0.15); }
    body.dark-mode .badge-green { background: rgba(16, 185, 129, 0.1); color: #34d399; border-color: rgba(16, 185, 129, 0.2); }
    body.dark-mode .badge-red { background: rgba(239, 68, 68, 0.1); color: #f87171; border-color: rgba(239, 68, 68, 0.2); }
    body.dark-mode .badge-yellow { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border-color: rgba(245, 158, 11, 0.2); }
    body.dark-mode .badge-violet { background: rgba(139, 92, 246, 0.1); color: #a78bfa; border-color: rgba(139, 92, 246, 0.2); }
    body.dark-mode .badge-gray { background: rgba(30, 41, 59, 0.5); color: #94a3b8; border-color: #334155; }

    /* Table Action Buttons */
    body.dark-mode .btn-action { border-color: #334155; color: #94a3b8; background: transparent; }
    body.dark-mode .btn-edit { color: #34d399; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); }
    body.dark-mode .btn-edit:hover { background: #059669; color: #fff; border-color: #059669; }
    body.dark-mode .btn-delete { color: #f87171; background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
    body.dark-mode .btn-delete:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

    /* Modal Footer */
    body.dark-mode .modal-footer { background: #111827; border-top: 1px solid #1e293b; }
    body.dark-mode .modal-footer-info { color: #94a3b8; }

    /* Print/Excel Buttons */
    body.dark-mode .btn-print.btn-gray { background: #1e293b; color: #cbd5e1; border: 1px solid #334155; }
    body.dark-mode .btn-print.btn-gray:hover { background: #334155; border-color: #475569; }

    /* Checkbox */
    body.dark-mode .custom-checkbox { background: #111827; border-color: #475569; }
    body.dark-mode .custom-checkbox.checked { background: #6366f1; border-color: #6366f1; }

    /* Content Body */
    body.dark-mode .content-body { background: transparent; }

</style>

<div class="toast" id="toast"></div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Read URL params (from Leave Records page Add button)
    const urlParams = new URLSearchParams(window.location.search);
    const presetForwarded = urlParams.get('forwarded');
    const presetBatch = urlParams.get('batch');
    const presetSource = urlParams.get('source');

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
                resetForm();
                
                // If coming from Leave Records, redirect back after a brief delay
                if (presetSource === 'leave-records') {
                    setTimeout(() => {
                        window.location.href = '/leave-records';
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

            dropdown.querySelectorAll('.combobox-option').forEach(opt => {
                opt.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    const val = this.getAttribute('data-value');
                    
                    if (isMulti) {
                        if (!selectedValues.includes(val)) {
                            selectedValues.push(val);
                            updateTags();
                        }
                        input.value = '';
                        hidden.value = selectedValues.join(', ');
                        if (opts.onSelect) opts.onSelect(selectedValues);
                    } else {
                        input.value = val;
                        hidden.value = val;
                        if (opts.onSelect) opts.onSelect(val);
                    }
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
            // Auto Title Case
            const pos = this.selectionStart;
            this.value = this.value.replace(/\b\w/g, c => c.toUpperCase());
            this.setSelectionRange(pos, pos);
            if (!isMulti) hidden.value = this.value;
            if (opts.onInput) opts.onInput(this.value);
            updateGhost();
            open();
        });

        // Accept ghost suggestion
        input.addEventListener('keydown', function(e) {
            if ((e.key === 'Tab' || e.key === 'ArrowRight') && ghost && ghost.innerHTML) {
                const suggestionEl = ghost.querySelector('.ghost-suggestion');
                if (suggestionEl && suggestionEl.textContent) {
                    e.preventDefault();
                    const fullText = input.value + suggestionEl.textContent;
                    if (isMulti) {
                        if (!selectedValues.includes(fullText)) {
                            selectedValues.push(fullText);
                            updateTags();
                        }
                        input.value = '';
                        hidden.value = selectedValues.join(', ');
                    } else {
                        input.value = fullText;
                        hidden.value = fullText;
                    }
                    if (opts.onInput) opts.onInput(fullText);
                    ghost.innerHTML = '';
                    close();
                }
            } else if (e.key === 'Enter' && input.value.trim() !== '') {
                e.preventDefault();
                const val = input.value.trim();
                const match = allItems.find(s => s.toLowerCase() === val.toLowerCase());
                
                if (strict && !match) {
                    // In strict mode, if no exact match, try to use ghost suggestion
                    const ghostSuggestion = ghost && ghost.querySelector('.ghost-suggestion');
                    if (ghostSuggestion) {
                        const fullText = val + ghostSuggestion.textContent;
                        applyValue(fullText);
                    } else {
                        input.value = ''; // Clear if invalid
                    }
                    return;
                }

                const finalVal = match || val;

                function applyValue(v) {
                    if (isMulti) {
                        if (!selectedValues.includes(v)) {
                            selectedValues.push(v);
                            updateTags();
                        }
                        input.value = '';
                        hidden.value = selectedValues.join(', ');
                    } else {
                        input.value = v;
                        hidden.value = v;
                    }
                }

                applyValue(finalVal);
                close();
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
<div class="modal-overlay" id="recordsModal">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-header-top">
                <div class="modal-title-wrapper">
                    <div class="modal-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px; height:20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h2 class="modal-title">Leave Records Registry</h2>
                </div>
                <button class="modal-close" onclick="closeRecordsModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-header-bottom">
                <div class="modal-search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="search-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" id="modalSearch" class="modal-search-input" placeholder="Search records...">
                </div>
                <div class="filter-divider"></div>
                <div class="filter-group">
                    <span class="filter-label">Forwarded</span>
                    <select id="filterForwarded" class="modal-filter-select" onchange="filterModalRecords()">
                        <option value="all">All</option>
                    </select>
                </div>
                <div class="filter-divider"></div>
                <div class="filter-group">
                    <span class="filter-label">Status</span>
                    <select id="filterPay" class="modal-filter-select" onchange="filterModalRecords()">
                        <option value="all">All</option>
                        <option value="with pay">With Pay</option>
                        <option value="without pay">Without Pay</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <table class="record-table">
                <thead>
                    <tr>
                        <th class="selection-col"></th>
                        <th style="width: 4%">#</th>
                        <th style="width: 14%">Name</th>
                        <th style="width: 10%">Position</th>
                        <th style="width: 12%">School</th>
                        <th style="width: 8%">Leave Type</th>
                        <th style="width: 11%">Inclusive Dates</th>
                        <th style="width: 9%">Remarks</th>
                        <th style="width: 10%">Date of Action</th>
                        <th style="width: 10%">Deduction</th>
                        <th style="width: 8%">Incharge</th>
                        <th style="width: 8%; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="recordsTableBody">
                    <tr><td colspan="12" style="text-align:center; padding: 40px; color: #9ca3af; font-size: 0.85rem;">Loading records...</td></tr>
                </tbody>
            </table>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
            <div class="modal-footer-info">
                <span id="selectedCount">0</span> records selected
            </div>
            <div style="flex: 1;"></div>
            <div style="display: flex; gap: 10px;">
                <button id="excelModeBtn" class="btn-print" onclick="togglePrintMode()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px; height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>Export</span>
                </button>
                <div class="export-actions">
                    <button class="btn-print btn-gray" onclick="togglePrintMode()">Cancel</button>
                    <button class="btn-print active" onclick="executeExport()">Download .xls</button>
                </div>
                <!-- Done Button -->
                <button id="doneBtn" class="btn-print" onclick="completeRegistryAction()" style="background: #10b981; border-color: #10b981; color: white;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px; height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    <span>Done</span>
                </button>
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
                matchesPay = rowRemarks.includes('with pay') || (rowRemarks.includes('approved') && !rowRemarks.includes('disapproved'));
            } else if (payStatus === 'without pay') {
                matchesPay = rowRemarks.includes('without pay') || rowRemarks.includes('disapproved');
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
                noResultsRow.innerHTML = `<td colspan="12" style="text-align:center; padding: 60px; color: #94a3b8; font-size: 0.9rem;">${noResultsMsg}</td>`;
                tbody.appendChild(noResultsRow);
            } else {
                existingNoResults.innerHTML = `<td colspan="12" style="text-align:center; padding: 60px; color: #94a3b8; font-size: 0.9rem;">${noResultsMsg}</td>`;
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
                const tbody = document.getElementById('recordsTableBody');
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="12" style="text-align:center; padding: 30px; color: #94a3b8;">No records found.</td></tr>';
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
                    const forwarded = r.forwarded || 'No Forwarded';
                if (forwarded !== lastDept) {
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
                            <td style="color:#94a3b8; font-weight: 600; font-family:monospace; font-size:0.8rem;">${index + 1}</td>
                            <td style="font-weight: 700; color:#0f172a;">${r.name}</td>
                            <td style="font-weight: 600; font-size: 0.82rem; color: #475569;">${r.position || '-'}</td>
                            <td style="color:#64748b; font-size: 0.85rem;">${r.school || '-'}</td>
                            <td><span class="badge-leave">${r.type_of_leave}</span></td>
                            <td style="font-family:monospace; font-size:0.78rem; color:#475569; letter-spacing: -0.01em;">${r.inclusive_dates || '-'}</td>
                            <td>${remarkBadge}</td>
                            <td style="font-family:monospace; font-size:0.8rem; color:#0f172a; font-weight:700;">${formatDate(r.date_of_action)}</td>
                            <td style="color:#64748b; font-size: 0.82rem;">${r.deduction_remarks || '-'}</td>
                            <td style="color:#475569; font-size: 0.85rem; font-style: italic; font-weight: 500;">${r.incharge || '-'}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
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
        const container = document.querySelector('.modal-container');
        
        if (isPrintingMode) {
            container.classList.add('printing-mode');
            
            // AUTOMATIC SELECTION: Select all visible rows by default
            const visibleRows = document.querySelectorAll('.record-row:not([style*="display: none"])');
            visibleRows.forEach(row => {
                row.classList.add('print-selected');
                const cb = row.querySelector('.record-select');
                if (cb) cb.classList.add('checked');
            });
            
            // Update all forwarded "select all" checkboxes to checked
            document.querySelectorAll('.forwarded-select-all').forEach(cb => {
                cb.classList.add('checked');
            });
            
            updateSelectedCount();
        } else {
            container.classList.remove('printing-mode');
            
            // Clear selections
            document.querySelectorAll('.custom-checkbox.checked').forEach(cb => cb.classList.remove('checked'));
            document.querySelectorAll('.record-row.print-selected').forEach(row => row.classList.remove('print-selected'));
            updateSelectedCount();
        }
    }

    function toggleRecordSelection(id, el) {
        el.classList.toggle('checked');
        const row = el.closest('tr');
        row.classList.toggle('print-selected');
        
        // Update forwarded "select all" state
        const forwarded = row.getAttribute('data-forwarded');
        const forwardedHeader = document.querySelector(`.forwarded-header-row[data-forwarded="${forwarded}"]`);
        if (forwardedHeader) {
            const allInForwarded = document.querySelectorAll(`.record-row[data-forwarded="${forwarded}"]`);
            const allChecked = document.querySelectorAll(`.record-row[data-forwarded="${forwarded}"].print-selected`);
            const forwardedCheck = forwardedHeader.querySelector('.forwarded-select-all');
            
            if (allChecked.length === allInForwarded.length && allInForwarded.length > 0) {
                forwardedCheck.classList.add('checked');
            } else {
                forwardedCheck.classList.remove('checked');
            }
        }
        
        updateSelectedCount();
    }

    function toggleForwardedSelection(forwarded, el) {
        const isChecked = el.classList.contains('checked');
        const newState = !isChecked;
        
        el.classList.toggle('checked', newState);
        
        const rows = document.querySelectorAll(`.record-row[data-forwarded="${forwarded}"]`);
        rows.forEach(row => {
            const checkbox = row.querySelector('.record-select');
            if (checkbox) {
                if (newState) {
                    row.classList.add('print-selected');
                    checkbox.classList.add('checked');
                } else {
                    row.classList.remove('print-selected');
                    checkbox.classList.remove('checked');
                }
            }
        });
        
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const count = document.querySelectorAll('.record-row.print-selected').length;
        document.getElementById('selectedCount').textContent = count;
    }

    function executeExport() {
        const selectedRows = document.querySelectorAll('.record-row.print-selected');
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

        let lastDept = null;
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
                    if (next.classList.contains('print-selected')) {
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

            } else if (row.classList.contains('print-selected')) {
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
        
        showToast('Excel file generated successfully.');
        togglePrintMode(); // Exit excel mode
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

        // Add a clearing animation
        tbody.style.transition = 'opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        tbody.style.opacity = '0';
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
                    tbody.innerHTML = '<tr><td colspan="12" style="text-align:center; padding: 60px; color: #94a3b8; font-size: 0.9rem; background: #f8fafc;">All records processed and removed from registry.</td></tr>';
                    tbody.style.opacity = '1';
                    tbody.style.transform = 'translateY(0)';
                    
                    showToast('Registry cleared successfully.');
                    updateRecordCount(); // Refresh the counter on the form
                    
                    setTimeout(closeRecordsModal, 800);
                }, 400);
            } else {
                tbody.style.opacity = '1';
                tbody.style.transform = 'translateY(0)';
                showToast('Error clearing registry', 'error');
            }
        })
        .catch(() => {
            tbody.style.opacity = '1';
            tbody.style.transform = 'translateY(0)';
            showToast('Connection error', 'error');
        });
    }
</script>
</body>
</html>

