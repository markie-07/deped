@php $user = Auth::user(); @endphp
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>My Profile - DepEd Manager</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f2f5; color: #1e293b; }

    .profile-page { max-width: 1100px; margin: 0 auto; padding-bottom: 60px; }

    /* ═══ COVER PHOTO ═══ */
    .profile-cover {
        position: relative; border-radius: 24px; overflow: hidden; margin-bottom: -60px;
        height: 240px;
        background-size: cover; background-position: center; background-repeat: no-repeat;
        background-color: #4338ca;
        box-shadow: 0 8px 32px rgba(99,102,241,0.18);
    }
    .cover-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(67,56,202,0.55) 0%, rgba(99,102,241,0.4) 40%, rgba(139,92,246,0.35) 70%, rgba(167,139,250,0.3) 100%);
    }
    .cover-gradient-bottom {
        position: absolute; bottom: 0; left: 0; right: 0; height: 80px;
        background: linear-gradient(to top, rgba(15,23,42,0.3), transparent);
    }
    .cover-shimmer {
        position: absolute; inset: 0;
        background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,0.06) 50%, transparent 70%);
        background-size: 250% 100%;
        animation: shimmer 6s ease-in-out infinite;
    }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    /* ═══ PHOTO DROPDOWN MENUS ═══ */
    .profile-cover { cursor: pointer; }
    .photo-dropdown {
        position: absolute; z-index: 10; min-width: 200px;
        background: rgba(255,255,255,0.95); backdrop-filter: blur(16px);
        border-radius: 14px; border: 1px solid rgba(0,0,0,0.08);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        padding: 6px; opacity: 0; visibility: hidden;
        transform: translateY(8px) scale(0.96);
        transition: all 0.2s cubic-bezier(0.16,1,0.3,1);
    }
    .photo-dropdown.open {
        opacity: 1; visibility: visible;
        transform: translateY(0) scale(1);
    }
    .photo-dropdown-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; border-radius: 10px;
        font-size: 0.82rem; font-weight: 600; color: #334155;
        cursor: pointer; transition: all 0.15s; border: none;
        background: transparent; width: 100%; text-align: left;
        font-family: inherit;
    }
    .photo-dropdown-item:hover { background: #f1f5f9; color: #6366f1; }
    .photo-dropdown-item svg { width: 16px; height: 16px; flex-shrink: 0; color: #94a3b8; }
    .photo-dropdown-item:hover svg { color: #6366f1; }
    .photo-dropdown-divider { height: 1px; background: #f1f5f9; margin: 4px 6px; }

    /* Cover dropdown position */
    .cover-dropdown { bottom: 16px; right: 16px; }

    /* Avatar dropdown position */
    .avatar-dropdown { top: 100%; left: 0; margin-top: 6px; }
    .avatar-wrap { position: relative; z-index: 5; }

    /* ═══ PROFILE HEADER CARD ═══ */
    .profile-header-card {
        position: relative; z-index: 2; background: #fff; border-radius: 20px;
        margin: 0 24px; padding: 0 32px 28px; border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .phc-top { display: flex; align-items: flex-end; gap: 24px; margin-top: -48px; margin-bottom: 20px; }

    .avatar-wrap {
        position: relative; cursor: pointer; flex-shrink: 0;
        transition: transform 0.3s; filter: drop-shadow(0 8px 16px rgba(99,102,241,0.3));
    }
    .avatar-wrap:hover { transform: scale(1.04); }
    .avatar-ring {
        width: 110px; height: 110px; border-radius: 50%; padding: 4px;
        background: linear-gradient(135deg, #6366f1, #a78bfa, #6366f1);
        background-size: 200% 200%; animation: ringShift 4s ease infinite;
    }
    @keyframes ringShift { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
    .avatar-inner {
        width: 100%; height: 100%; border-radius: 50%; overflow: hidden;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        border: 3px solid #fff;
    }
    .avatar-inner img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-initial { font-size: 2.2rem; font-weight: 900; color: #fff; }
    .avatar-cam {
        position: absolute; bottom: 4px; right: 4px; width: 32px; height: 32px;
        background: #fff; border-radius: 50%; display: flex; align-items: center;
        justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        border: 2px solid #f0f2f5; opacity: 0; transform: scale(0.7);
        transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
    }
    .avatar-cam svg { width: 14px; height: 14px; color: #6366f1; }
    .avatar-wrap:hover .avatar-cam { opacity: 1; transform: scale(1); }

    .phc-info { flex: 1; padding-bottom: 4px; }
    .phc-name { font-size: 1.6rem; font-weight: 900; color: #0f172a; letter-spacing: -0.03em; line-height: 1.2; }
    .phc-meta { font-size: 0.85rem; color: #64748b; font-weight: 500; margin-top: 4px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .phc-meta-dot { width: 4px; height: 4px; background: #cbd5e1; border-radius: 50%; }

    .phc-badges { display: flex; gap: 8px; flex-shrink: 0; align-self: center; padding-top: 48px; }
    .badge-role {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px;
        border-radius: 24px; font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.04em;
    }
    .badge-role.admin { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; box-shadow: 0 2px 8px rgba(251,191,36,0.2); }
    .badge-role.user { background: #f1f5f9; color: #64748b; }
    .badge-role svg { width: 14px; height: 14px; }
    .badge-active { display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; border-radius: 24px; background: #ecfdf5; color: #059669; font-size: 0.72rem; font-weight: 700; }
    .badge-active .pulse { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 0 rgba(34,197,94,0.4); animation: pulse 2s infinite; }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(34,197,94,0.4); } 70% { box-shadow: 0 0 0 8px rgba(34,197,94,0); } 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); } }

    /* Stats row in header */
    .phc-stats { display: flex; gap: 0; border-top: 1px solid #f1f5f9; padding-top: 20px; }
    .phc-stat { flex: 1; text-align: center; position: relative; }
    .phc-stat:not(:last-child)::after { content: ''; position: absolute; right: 0; top: 15%; height: 70%; width: 1px; background: #f1f5f9; }
    .phc-stat-num { display: block; font-size: 1.3rem; font-weight: 900; color: #0f172a; letter-spacing: -0.02em; }
    .phc-stat-label { font-size: 0.68rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px; }

    /* ═══ CONTENT GRID ═══ */
    .profile-grid { display: grid; grid-template-columns: 1fr 320px; gap: 24px; margin-top: 28px; }

    /* ═══ CARDS ═══ */
    .pro-card {
        background: #fff; border-radius: 20px; padding: 28px; border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-bottom: 20px;
        transition: box-shadow 0.3s;
    }
    .pro-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .pro-card-head { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid #f1f5f9; }
    .pro-card-ico { width: 44px; height: 44px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .pro-card-ico svg { width: 22px; height: 22px; }
    .ico-indigo { background: linear-gradient(135deg, #eef2ff, #e0e7ff); color: #6366f1; }
    .ico-emerald { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669; }
    .ico-amber { background: linear-gradient(135deg, #fffbeb, #fef3c7); color: #d97706; }
    .pro-card-ttl { font-size: 1.05rem; font-weight: 800; color: #0f172a; letter-spacing: -0.01em; }
    .pro-card-sub { font-size: 0.74rem; color: #94a3b8; font-weight: 500; margin-top: 2px; }

    /* ═══ FORM ═══ */
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
    .form-group { display: flex; flex-direction: column; gap: 7px; }
    .form-group.full { grid-column: span 2; }
    .f-label { font-size: 0.72rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.06em; }
    .f-input-wrap { position: relative; }
    .f-input-wrap input {
        width: 100%; padding: 12px 16px; border-radius: 14px;
        border: 1.5px solid #e2e8f0; background: #fafbfc; font-family: inherit;
        font-size: 0.88rem; font-weight: 500; color: #1e293b;
        outline: none; transition: all 0.25s ease;
    }
    .f-input-wrap input:focus { border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,0.08); background: #fff; }
    .f-input-wrap input[type="password"] { padding-right: 44px; }
    .f-input-wrap input::placeholder { color: #c0c7d6; }

    .pw-toggle { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; padding: 3px; display: flex; transition: color 0.2s; z-index: 2; }
    .pw-toggle:hover { color: #6366f1; }
    .pw-toggle svg { width: 18px; height: 18px; }

    .pw-strength { display: flex; gap: 5px; margin-top: 8px; }
    .pw-bar { flex: 1; height: 4px; background: #e2e8f0; border-radius: 3px; transition: background 0.3s; }
    .pw-bar.weak { background: #ef4444; } .pw-bar.fair { background: #f59e0b; }
    .pw-bar.good { background: #22c55e; } .pw-bar.strong { background: #10b981; }
    .pw-label-text { font-size: 0.7rem; font-weight: 600; margin-top: 4px; }

    .security-note {
        display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-radius: 14px;
        border-left: 4px solid #6366f1; margin-bottom: 22px;
        font-size: 0.8rem; color: #64748b; line-height: 1.5;
    }
    .security-note svg { width: 18px; height: 18px; color: #6366f1; flex-shrink: 0; margin-top: 1px; }

    .field-error { font-size: 0.7rem; color: #ef4444; font-weight: 500; margin-top: 3px; display: none; }
    .field-error.visible { display: block; animation: shakeErr 0.3s ease; }
    .f-input-wrap.error input { border-color: #ef4444; box-shadow: 0 0 0 4px rgba(239,68,68,0.08); }
    @keyframes shakeErr { 0%,100%{transform:translateX(0)} 25%{transform:translateX(-4px)} 75%{transform:translateX(4px)} }

    /* ═══ ACTION ═══ */
    .form-actions { display: flex; justify-content: flex-end; margin-top: 8px; }
    .btn-save {
        padding: 13px 32px; border-radius: 16px; border: none;
        background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff;
        font-family: inherit; font-size: 0.88rem; font-weight: 700;
        cursor: pointer; display: flex; align-items: center; gap: 10px;
        box-shadow: 0 4px 16px rgba(99,102,241,0.3); transition: all 0.25s ease;
        position: relative; overflow: hidden;
    }
    .btn-save::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent, rgba(255,255,255,0.1)); opacity: 0; transition: opacity 0.3s; }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(99,102,241,0.4); }
    .btn-save:hover::before { opacity: 1; }
    .btn-save:active { transform: translateY(0); }
    .btn-save:disabled { background: #cbd5e1; box-shadow: none; cursor: not-allowed; transform: none; }
    .btn-save svg { width: 18px; height: 18px; }

    .btn-cancel-profile {
        padding: 13px 24px; border-radius: 16px; border: 1.5px solid #e2e8f0;
        background: #fff; color: #64748b;
        font-family: inherit; font-size: 0.88rem; font-weight: 700;
        cursor: pointer; display: flex; align-items: center; gap: 8px;
        transition: all 0.25s ease; margin-right: 12px;
    }
    .btn-cancel-profile:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }
    .btn-cancel-profile svg { width: 18px; height: 18px; }

    /* ═══ TABS ═══ */
    .profile-tabs { margin-bottom: 24px; }
    .tab-nav {
        display: flex; gap: 8px; border-bottom: 1.5px solid #e2e8f0;
        margin-bottom: 24px; padding: 0 4px;
    }
    .tab-btn {
        padding: 12px 24px; border: none; background: none;
        font-family: inherit; font-size: 0.88rem; font-weight: 700;
        color: #64748b; cursor: pointer; position: relative;
        transition: all 0.2s;
    }
    .tab-btn:hover { color: #6366f1; }
    .tab-btn.active { color: #6366f1; }
    .tab-btn.active::after {
        content: ''; position: absolute; bottom: -1.5px; left: 0; right: 0;
        height: 3px; background: #6366f1; border-radius: 3px 3px 0 0;
    }
    .tab-btn svg { width: 18px; height: 18px; margin-right: 8px; vertical-align: middle; display: inline-block; margin-top: -2px; }
    
    .tab-pane { display: none; animation: tabFade 0.3s ease-out; }
    .tab-pane.active { display: block; }
    @keyframes tabFade { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

    /* ═══ SIDEBAR ITEMS ═══ */
    .info-row { display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: #f8fafc; border-radius: 14px; border: 1px solid #f1f5f9; margin-bottom: 10px; transition: all 0.2s; }
    .info-row:hover { background: #f1f5f9; border-color: #e2e8f0; }
    .info-row:last-child { margin-bottom: 0; }
    .ir-ico { width: 36px; height: 36px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ir-ico svg { width: 16px; height: 16px; }
    .ir-green { background: #ecfdf5; color: #10b981; } .ir-amber { background: #fffbeb; color: #f59e0b; }
    .ir-blue { background: #eff6ff; color: #3b82f6; } .ir-purple { background: #f5f3ff; color: #8b5cf6; }
    .ir-text { flex: 1; min-width: 0; }
    .ir-label { font-size: 0.68rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
    .ir-value { font-size: 0.82rem; color: #0f172a; font-weight: 700; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* ═══ TOAST ═══ */
    .toast-container { position: fixed; top: 24px; right: 24px; z-index: 1000; display: flex; flex-direction: column; gap: 10px; }
    .toast { padding: 14px 20px; border-radius: 16px; background: #fff; box-shadow: 0 10px 40px rgba(0,0,0,0.12); display: flex; align-items: center; gap: 12px; min-width: 300px; border-left: 4px solid #6366f1; transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.68,-0.55,0.265,1.55); }
    .toast.show { transform: translateX(0); }
    .toast.success { border-left-color: #10b981; } .toast.error { border-left-color: #ef4444; }
    .toast-icon { width: 22px; height: 22px; flex-shrink: 0; }
    .toast-title { font-weight: 700; font-size: 0.85rem; margin-bottom: 2px; }
    .toast-msg { font-size: 0.76rem; color: #64748b; }

    @keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }

    @media (max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full { grid-column: span 1; }
        .phc-top { flex-direction: column; align-items: center; text-align: center; }
        .phc-badges { padding-top: 0; }
        .phc-info { text-align: center; }
        .phc-meta { justify-content: center; }
        .profile-header-card { margin: 0 12px; padding: 0 20px 24px; }
    }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
    .light-box {
        position: fixed; inset: 0; background: rgba(0,0,0,0.8);
        backdrop-filter: blur(10px); display: flex; align-items: center;
        justify-content: center; z-index: 10000;
    }
</style>
