<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - DepEd Manager</title>
    <meta name="description" content="Sign in to DepEd Manager">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ─── SCOPED RESET: Override Tailwind Preflight ─── */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            overflow-x: hidden !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
            background: #FAFBFF !important;
            color: #1a1a2e !important;
            min-height: 100vh;
            min-height: 100dvh;
            height: 100vh;
            height: 100dvh;
            overflow-y: hidden !important;
        }

        /* Force all login-page elements to use border-box */
        .login-page, .login-page * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .login-page p, .login-page h1, .login-page h2, .login-page h3 {
            margin-top: 0;
        }

        /* ─── Layout ─── */
        .login-page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
            height: 100dvh;
            width: 100vw;
            overflow: hidden;
            background: #FAFBFF;
        }



        /* ═══════════════════════════════════════════
           LEFT VISUAL PANEL
           ═══════════════════════════════════════════ */
        .visual-panel {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Layered abstract shapes */
        .visual-panel .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.12;
        }

        .shape-1 {
            width: 700px; height: 700px;
            border: 80px solid #fff;
            top: -200px; left: -200px;
            animation: shapeRotate 40s linear infinite;
        }

        .shape-2 {
            width: 500px; height: 500px;
            border: 60px solid #fff;
            bottom: -150px; right: -100px;
            animation: shapeRotate 35s linear infinite reverse;
        }

        .shape-3 {
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.08);
            top: 30%; left: 55%;
            animation: shapePulse 8s ease-in-out infinite;
        }

        .shape-4 {
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.1);
            bottom: 25%; left: 15%;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: shapeMorph 12s ease-in-out infinite;
        }

        @keyframes shapeRotate {
            to { transform: rotate(360deg); }
        }

        @keyframes shapePulse {
            0%, 100% { transform: scale(1); opacity: 0.08; }
            50% { transform: scale(1.15); opacity: 0.14; }
        }

        @keyframes shapeMorph {
            0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            25% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
            50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
            75% { border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%; }
        }

        /* Dot pattern overlay */
        .dot-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: radial-gradient(circle, #fff 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Interactive canvas */
        #particleCanvas {
            position: absolute;
            inset: 0;
            z-index: 5;
            cursor: crosshair;
        }

        .visual-content {
            pointer-events: none;
        }

        .click-hint {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 12;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            letter-spacing: 0.03em;
            animation: hintPulse 3s ease-in-out infinite;
            pointer-events: none;
        }

        .click-hint svg {
            width: 14px; height: 14px;
        }

        @keyframes hintPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Panel content */
        .visual-content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 1.5rem;
            max-width: 360px;
            animation: fadeIn 1s ease-out;
        }

        .v-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(16px);
            border: 3px solid rgba(255,255,255,0.4);
            border-radius: 50%;
            margin-bottom: 2rem;
            box-shadow: 0 8px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            padding: 8px;
        }

        .v-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .v-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.04em;
            margin-bottom: 1rem;
        }

        .v-subtitle {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        /* Stats row */
        .stats-row {
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .stat-label {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 2px;
        }

        .stat-divider {
            width: 1px;
            background: rgba(255,255,255,0.15);
            align-self: stretch;
        }

        /* Features Grid */
        .features-grid {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }

        .feature-icon {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            color: #fff;
        }

        .feature-icon svg {
            width: 22px;
            height: 22px;
        }

        .feature-text {
            flex: 1;
        }

        .feature-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.15rem;
            letter-spacing: -0.01em;
        }

        .feature-desc {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.4;
        }

        /* ═══════════════════════════════════════════
           RIGHT FORM PANEL
           ═══════════════════════════════════════════ */
        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            background: #FAFBFF;
            overflow-y: auto; /* Internal scroll for forms */
            overflow-x: hidden;
            height: 100%;
            width: 100%;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }

        .form-panel::-webkit-scrollbar {
            display: none; /* Chrome/Safari/Opera */
        }

        /* Scrollable and white background for Register View */
        .form-panel.panel-register {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: flex-start !important;
            background: #fff !important;
            padding: 3rem 2rem;
        }

        .form-panel.panel-register .form-wrapper {
            margin: 0 auto !important;
            max-width: 480px;
            width: 100%;
            padding-top: 1rem;
        }

        .form-panel.panel-register .page-footer {
            position: relative !important;
            bottom: auto !important;
            margin: 3rem 0 1rem 0 !important;
            width: 100%;
            z-index: 10;
        }

        /* Subtle background accent */
        .form-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.06) 0%, transparent 70%);
            top: -100px; right: -100px;
            border-radius: 50%;
            pointer-events: none;
        }

        .form-wrapper {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 5;
            margin: auto 0; /* Vertically center in flex when content is short */
        }

        /* Stagger animation */
        .anim-1 { animation: slideUp 0.6s ease-out 0.1s both; }
        .anim-2 { animation: slideUp 0.6s ease-out 0.2s both; }
        .anim-3 { animation: slideUp 0.6s ease-out 0.3s both; }
        .anim-4 { animation: slideUp 0.6s ease-out 0.4s both; }
        .anim-5 { animation: slideUp 0.6s ease-out 0.5s both; }
        .anim-6 { animation: slideUp 0.6s ease-out 0.6s both; }

        /* Greeting */
        .form-greeting {
            margin-bottom: 2.5rem !important;
        }

        .greeting-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.08));
            border: 1px solid rgba(102, 126, 234, 0.12);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #667eea;
            letter-spacing: 0.04em;
            margin-bottom: 1.25rem;
        }

        .greeting-badge .dot {
            width: 6px; height: 6px;
            background: #667eea;
            border-radius: 50%;
            animation: dotPulse 2s ease-in-out infinite;
        }

        @keyframes dotPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.3); }
        }

        .form-greeting h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f0f23;
            letter-spacing: -0.04em;
            margin-bottom: 0.5rem;
        }

        .form-greeting p {
            font-size: 0.95rem;
            color: #8892a4;
            line-height: 1.5;
        }

        /* ─── Inputs ─── */
        .field {
            margin-bottom: 1.35rem !important;
        }

        .field-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.55rem !important;
        }

        .field-label label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #4a5568;
        }

        .field-label a {
            font-size: 0.78rem;
            font-weight: 600;
            color: #667eea;
            text-decoration: none;
            transition: color 0.2s;
        }

        .field-label a:hover {
            color: #764ba2;
        }

        .input-box {
            position: relative;
        }

        .input-box input,
        .input-box select {
            width: 100%;
            padding: 13px 16px 13px 46px;
            background: #fff;
            border: 1.5px solid #e8ecf4;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.92rem;
            font-weight: 400;
            color: #1a1a2e;
            outline: none;
            transition: all 0.25s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            appearance: none; /* Hide default arrow */
        }

        .input-box select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23b0b9c8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
        }

        .input-box input::placeholder { color: #b0b9c8; }

        .input-box input:hover {
            border-color: #c5ccda;
        }

        .input-box input:focus,
        .input-box select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 2px 8px rgba(102, 126, 234, 0.08);
        }

        .input-box .icon {
            position: absolute;
            top: 50%; left: 15px;
            transform: translateY(-50%);
            width: 20px; height: 20px;
            color: #c0c7d6;
            pointer-events: none;
            transition: color 0.25s ease;
        }

        .input-box:focus-within .icon { color: #667eea; }

        .input-box .eye-toggle {
            position: absolute;
            top: 50%; right: 14px;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #b0b9c8;
            cursor: pointer;
            padding: 4px;
            display: flex;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .input-box .eye-toggle:hover { color: #667eea; background: rgba(102,126,234,0.06); }
        .input-box .eye-toggle svg { width: 18px; height: 18px; }

        /* ─── Submit Button ─── */
        .btn-login {
            width: 100%;
            padding: 14px 24px;
            margin-top: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.35s ease;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #7c8ff8 0%, #8a5fb5 100%);
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-login:hover::after { opacity: 1; }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-login span,
        .btn-login svg {
            position: relative;
            z-index: 1;
        }

        .btn-login svg {
            width: 18px; height: 18px;
            transition: transform 0.3s ease;
        }

        .btn-login:hover svg {
            transform: translateX(3px);
        }

        /* ─── Separator ─── */
        .separator {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 1.75rem 0;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #eaecf4;
        }

        .separator span {
            font-size: 0.72rem;
            color: #b0b9c8;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* ─── Bottom links ─── */
        .bottom-text {
            text-align: center;
        }

        .bottom-text p {
            font-size: 0.82rem;
            color: #8892a4;
        }

        .bottom-text a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .bottom-text a:hover { color: #764ba2; }

        /* ─── Footer ─── */
        .page-footer {
            position: absolute;
            bottom: 1.5rem;
            left: 0; right: 0;
            text-align: center;
            z-index: 10;
        }

        .page-footer p {
            font-size: 0.72rem;
            color: #c0c7d6;
        }

        /* ─── Right Panel Interactive Canvas ─── */
        #rightCanvas {
            position: fixed;
            top: 0;
            right: 0;
            width: 50%; /* Desktop default */
            height: 100vh;
            z-index: 1;
            pointer-events: none;
        }

        @media (max-width: 960px) {
            #rightCanvas {
                width: 100%;
            }
        }

        /* ═══════════════════════════════════════════
           OTP INLINE VIEW (replaces login form in right panel)
           ═══════════════════════════════════════════ */
        .form-wrapper {
            position: relative;
            z-index: 10;
            overflow: visible; /* Don't clip the register view */
        }

        .login-view,
        .otp-view,
        .forgot-view,
        .register-view {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Password Strength Meter */
        .strength-meter {
            height: 4px;
            width: 100%;
            background: #e2e8f0;
            border-radius: 2px;
            margin-top: 6px;
            overflow: hidden;
            display: none;
        }
        .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }
        .strength-text {
            font-size: 0.65rem;
            font-weight: 600;
            margin-top: 4px;
            display: block;
        }

        /* Register View - Compact & No Scroll */
        .register-view {
            opacity: 0;
            transform: translateX(40px);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
            width: 100%;
            padding: 0.5rem 0.5rem 1rem 0.5rem;
        }

        .register-view.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            pointer-events: auto;
            visibility: visible;
        }

        .reg-header { 
            text-align: center; 
            margin-bottom: 0.75rem;
            position: relative;
        }
        
        .reg-title { 
            font-size: 1.4rem; 
            font-weight: 800; 
            color: #0f0f23; 
            letter-spacing: -0.04em; 
            margin-bottom: 0.25rem;
            background: linear-gradient(135deg, #0f0f23 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .reg-desc { 
            font-size: 0.78rem; 
            color: #718096; 
            line-height: 1.3;
            max-width: 280px;
            margin: 0 auto;
        }

        /* Enhanced Profile Upload - More Compact */
        .reg-profile-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .reg-profile-upload {
            width: 120px; height: 120px;
            background: #fff;
            border: 2px dashed #cbd5e0;
            border-radius: 38px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; position: relative; overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .reg-profile-upload:hover { 
            border-color: #667eea; 
            background: rgba(102,126,234,0.02);
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 24px rgba(102, 126, 234, 0.12);
        }
        
        .reg-profile-upload::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(102,126,234,0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s;
        }
        
        .reg-profile-upload:hover::before { opacity: 1; }

        .reg-profile-upload img { 
            width:100%; height:100%; object-fit:cover; position:absolute; inset:0; 
            z-index: 2;
        }
        
        .reg-profile-upload svg { 
            width: 40px; height: 40px; color: #cbd5e0; 
            margin-bottom: 4px;
            transition: color 0.3s;
        }
        
        .reg-profile-upload:hover svg { color: #667eea; }
        
        .reg-profile-upload span { 
            font-size: 0.7rem; color: #a0aec0; font-weight: 700; 
            letter-spacing: 0.02em;
        }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        @media (max-width: 540px) {
            .form-grid { grid-template-columns: 1fr; }
        }
        .form-grid.span-2 { grid-template-columns: 1fr; }
        
        .register-view .field {
            margin-bottom: 0.6rem;
        }
        
        .register-view .input-box input {
            background: #fff;
            padding: 9px 14px 9px 42px; /* Slightly reduced for compactness */
            font-size: 0.82rem;
        }
        
        .register-view .field-label {
            margin-bottom: 0.35rem;
        }
        
        .register-view .field-label label {
            font-size: 0.75rem;
        }
        
        .reg-select-wrap {
            position: relative;
        }
        
        .reg-select-wrap select {
            width: 100%;
            padding: 13px 16px;
            background: #fff;
            border: 1.5px solid #e8ecf4;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.92rem;
            color: #1a1a2e;
            outline: none;
            appearance: none;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        
        .reg-select-wrap::after {
            content: '';
            position: absolute;
            right: 16px; top: 50%;
            transform: translateY(-50%);
            width: 10px; height: 10px;
            border-right: 2px solid #a0aec0;
            border-bottom: 2px solid #a0aec0;
            transform: translateY(-70%) rotate(45deg);
            pointer-events: none;
        }
        
        .reg-select-wrap select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        /* Forgot Password View */
        .forgot-view {
            opacity: 0;
            transform: translateX(40px);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
            width: 100%;
        }

        .forgot-view.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            pointer-events: auto;
            visibility: visible;
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .forgot-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, rgba(102,126,234,0.12), rgba(118,75,162,0.12));
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .forgot-icon svg {
            width: 32px; height: 32px;
            color: #667eea;
        }

        .forgot-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f0f23;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .forgot-header p {
            font-size: 0.88rem;
            color: #8892a4;
            line-height: 1.6;
        }

        .btn-reset-send {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(102,126,234,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .btn-reset-send::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #7c8ff8 0%, #8a5fb5 100%);
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        .btn-reset-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102,126,234,0.4);
        }

        .btn-reset-send:hover::after { opacity: 1; }

        .btn-reset-send:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-reset-send span {
            position: relative;
            z-index: 1;
        }

        .btn-reset-send .spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
            position: relative;
            z-index: 1;
        }

        .forgot-back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #8892a4;
            cursor: pointer;
            background: none;
            border: none;
            font-family: inherit;
            transition: color 0.2s;
            width: 100%;
        }

        .forgot-back-link:hover { color: #667eea; }
        .forgot-back-link svg { width: 16px; height: 16px; }

        /* Reset Password View */
        .reset-view {
            opacity: 0;
            transform: translateX(40px);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
            width: 100%;
        }

        .reset-view.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            pointer-events: auto;
            visibility: visible;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .reset-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, rgba(102,126,234,0.12), rgba(118,75,162,0.12));
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .reset-icon svg {
            width: 32px; height: 32px;
            color: #667eea;
        }

        .reset-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f0f23;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .reset-header p {
            font-size: 0.88rem;
            color: #8892a4;
            line-height: 1.6;
        }

        .reset-email-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.08));
            border: 1px solid rgba(102, 126, 234, 0.12);
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #667eea;
            margin-top: 0.75rem;
        }

        .reset-email-badge svg {
            width: 14px; height: 14px;
        }

        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: #e8ecf4;
            border-radius: 4px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease, background 0.3s ease;
            width: 0;
        }

        .strength-text {
            font-size: 0.72rem;
            margin-top: 0.35rem;
            font-weight: 500;
            color: #8892a4;
        }

        .login-view {
            opacity: 1;
            transform: translateX(0);
        }

        .login-view.hidden {
            opacity: 0;
            transform: translateX(-40px);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
        }

        .otp-view {
            opacity: 0;
            transform: translateX(40px);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
            width: 100%;
        }

        .otp-view.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            pointer-events: auto;
            visibility: visible;
        }

        .otp-back-btn {
            background: none;
            border: none;
            color: #8892a4;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .otp-back-btn:hover { color: #667eea; background: rgba(102,126,234,0.06); }
        .otp-back-btn svg { width: 18px; height: 18px; }

        .otp-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .otp-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, rgba(102,126,234,0.12), rgba(118,75,162,0.12));
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .otp-icon svg {
            width: 32px; height: 32px;
            color: #667eea;
        }

        .otp-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f0f23;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .otp-header .otp-desc {
            font-size: 0.88rem;
            color: #8892a4;
            line-height: 1.6;
        }

        .otp-header .otp-email {
            font-weight: 600;
            color: #667eea;
        }

        /* OTP Code Display */
        .otp-code-display {
            text-align: center;
            margin-bottom: 1.75rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(102,126,234,0.06), rgba(118,75,162,0.06));
            border: 1.5px dashed rgba(102,126,234,0.25);
            border-radius: 16px;
            position: relative;
        }

        .otp-code-display .code-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: #8892a4;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .otp-code-display .code-value {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 10px;
            color: #667eea;
            font-family: 'Inter', monospace;
        }

        .otp-code-display .code-note {
            font-size: 0.72rem;
            color: #b0b9c8;
            margin-top: 0.5rem;
        }

        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 400px) {
            .otp-inputs {
                gap: 6px;
            }
            .otp-inputs input {
                width: 38px;
                height: 48px;
                font-size: 1.2rem;
            }
        }

        .otp-inputs input {
            width: 48px; height: 56px;
            border: 2px solid #e8ecf4;
            border-radius: 12px;
            text-align: center;
            font-family: inherit;
            font-size: 1.4rem;
            font-weight: 700;
            color: #0f0f23;
            outline: none;
            transition: all 0.2s ease;
            background: #fff;
        }

        .otp-inputs input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102,126,234,0.12);
            background: #fff;
        }

        .otp-inputs input.filled {
            border-color: #667eea;
            background: rgba(102,126,234,0.04);
        }

        .otp-inputs input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239,68,68,0.1);
        }

        .btn-verify {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(102,126,234,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-verify::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #7c8ff8 0%, #8a5fb5 100%);
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(102,126,234,0.4);
        }

        .btn-verify:hover::after { opacity: 1; }

        .btn-verify:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-verify:disabled:hover::after { opacity: 0; }

        .btn-verify span,
        .btn-verify .spinner {
            position: relative;
            z-index: 1;
        }

        .btn-verify .spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .otp-footer {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.82rem;
            color: #8892a4;
        }

        .otp-footer .resend-btn {
            background: none;
            border: none;
            color: #667eea;
            font-weight: 600;
            font-family: inherit;
            font-size: inherit;
            cursor: pointer;
            transition: color 0.2s;
        }

        .otp-footer .resend-btn:hover { color: #764ba2; }
        .otp-footer .resend-btn:disabled { color: #b0b9c8; cursor: not-allowed; }

        .otp-timer {
            display: inline-block;
            font-weight: 600;
            color: #667eea;
        }

        /* ─── Alert Messages ─── */
        .login-alert {
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1rem;
            display: none;
            align-items: center;
            gap: 8px;
            animation: slideUp 0.3s ease-out;
        }

        .login-alert.show { display: flex; }

        .login-alert.error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: #dc2626;
        }

        .login-alert.success {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.15);
            color: #059669;
        }

        .login-alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ─── Animations ─── */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile Logo Styling */
        .mobile-logo {
            display: none;
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeIn 0.8s ease-out;
        }
        .mobile-logo img {
            height: 70px;
            width: auto;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.08));
        }
        .mobile-logo h2 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f0f23;
            margin-top: 0.75rem;
            letter-spacing: -0.02em;
        }

        /* ─── Responsive Queries (MUST BE AT THE BOTTOM) ─── */
        @media (max-width: 960px) {
            html, body {
                height: auto !important;
                min-height: 100% !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
            }
            .login-page { 
                grid-template-columns: 1fr !important;
                height: auto !important;
                min-height: 100dvh !important;
            }
            .visual-panel { 
                display: none !important; 
            }

            /* ── Default mobile form panel: no scroll, centered ── */
            .form-panel {
                height: auto !important;
                min-height: 100dvh !important;
                padding: 2rem 1.5rem !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                background: #fff !important;
                overflow: hidden !important;
                position: relative !important;
            }

            /* ── Register-mode mobile panel: scrollable (handled by base class now, just adjusting padding) ── */
            .form-panel.panel-register {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            .page-footer {
                padding: 1.5rem 0 !important;
                margin-top: auto !important;
                position: relative !important;
                bottom: auto !important;
            }
            .form-wrapper {
                width: 100% !important;
                max-width: 420px !important;
                margin: 0 auto !important;
                padding: 1rem 0 !important;
                position: relative !important;
                z-index: 5 !important;
            }
            .mobile-logo {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                margin-bottom: 1.75rem !important;
                text-align: center !important;
            }
            .mobile-logo img {
                height: 65px !important;
                width: auto !important;
            }
            .mobile-logo h2 {
                font-size: 1.1rem !important;
                margin-top: 0.5rem !important;
                font-weight: 800 !important;
                color: #0f0f23 !important;
            }
            .greeting-badge {
                display: none !important; 
            }
            .form-greeting {
                text-align: center !important;
                margin-bottom: 2rem !important;
            }
            .form-greeting h1 {
                font-size: 1.75rem !important;
                font-weight: 800 !important;
                line-height: 1.2 !important;
                margin-bottom: 0.5rem !important;
                color: #0f0f23 !important;
            }
            .form-greeting p {
                font-size: 0.9rem !important;
                line-height: 1.5 !important;
                color: #8892a4 !important;
                margin-bottom: 0 !important;
            }
            .field {
                margin-bottom: 1.35rem !important;
            }
            .field-label {
                margin-bottom: 0.5rem !important;
                display: flex !important;
            }
            .input-box input {
                padding: 13px 16px 13px 46px !important;
                font-size: 0.92rem !important;
            }
            .separator {
                margin: 1.5rem 0 !important;
            }
            .btn-login {
                padding: 14px !important;
                margin-top: 0.5rem !important;
            }
            .bottom-text {
                margin-top: 0 !important;
            }
        }

        @media (max-width: 540px) {
            .form-grid { 
                grid-template-columns: 1fr; 
            }
        }

        @media (max-width: 400px) {
            .otp-inputs {
                gap: 6px;
            }
            .otp-inputs input {
                width: 38px;
                height: 48px;
                font-size: 1.2rem;
            }
        }

        /* ═══ FACE LOGIN ═══ */
        .btn-face-login {
            width: 100%;
            padding: 13px 24px;
            margin-top: 0.5rem;
            background: rgba(124, 58, 237, 0.05);
            border: 1.5px solid rgba(124, 58, 237, 0.2);
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.88rem;
            font-weight: 600;
            color: #7c3aed;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        .btn-face-login:hover {
            border-color: #7c3aed;
            background: rgba(124, 58, 237, 0.1);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.15);
        }
        .btn-face-login svg { width: 20px; height: 20px; }

        /* ═══ VERIFICATION CHOOSER VIEW ═══ */
        .chooser-view {
            opacity: 0;
            transform: translateX(40px);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
            width: 100%;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .chooser-view.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
            pointer-events: auto;
            visibility: visible;
        }
        .chooser-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .chooser-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, rgba(102,126,234,0.12), rgba(118,75,162,0.12));
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }
        .chooser-icon svg {
            width: 32px; height: 32px;
            color: #667eea;
        }
        .chooser-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f0f23;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }
        .chooser-header p {
            font-size: 0.88rem;
            color: #8892a4;
            line-height: 1.6;
        }
        .chooser-header .chooser-name { font-weight: 600; color: #667eea; }
        .chooser-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 1.5rem;
        }
        .chooser-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 20px;
            background: #fff;
            border: 2px solid #e8ecf4;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            width: 100%;
            text-align: left;
        }
        .chooser-option:not(:disabled):hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.03);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.12);
        }
        .chooser-option:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #f8fafc;
            border-color: #e2e8f0;
            transform: none !important;
            box-shadow: none !important;
        }
        .chooser-option:disabled .chooser-option-arrow {
            opacity: 0.3;
        }
        .chooser-option:disabled:hover {
            border-color: #e2e8f0;
            background: #f8fafc;
        }
        .chooser-option:active:not(:disabled) {
            transform: translateY(0);
        }
        .chooser-option-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .chooser-option-icon svg {
            width: 24px; height: 24px;
        }
        .chooser-option-icon.otp-icon {
            background: linear-gradient(135deg, rgba(102,126,234,0.12), rgba(118,75,162,0.12));
            color: #667eea;
        }
        .chooser-option-icon.face-icon {
            background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(139,92,246,0.12));
            color: #7c3aed;
        }
        .chooser-option-text {
            flex: 1;
        }
        .chooser-option-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f0f23;
            margin-bottom: 2px;
        }
        .chooser-option-desc {
            font-size: 0.78rem;
            color: #8892a4;
            line-height: 1.4;
        }
        .chooser-option-arrow {
            width: 20px; height: 20px;
            color: #c0c7d6;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .chooser-option:hover .chooser-option-arrow {
            color: #667eea;
            transform: translateX(3px);
        }
    </style>
</head>
<body>
    <div class="login-page">
        <!-- ═══ Left Visual Panel ═══ -->
        <div class="visual-panel" id="visualPanel">
            <canvas id="particleCanvas"></canvas>
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="dot-pattern"></div>

            <div class="visual-content">
                <div class="v-logo">
                    <img src="{{ asset('images/SDO-Logo.png') }}" alt="DepEd Logo">
                </div>
                <h2 class="v-title">Schools Division Office</h2>
                <p class="v-subtitle">Your all-in-one division management platform — manage personnel, track records, and streamline school operations across the division.</p>

                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">Secure Access</div>
                            <div class="feature-desc">Protected with OTP verification</div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">Real-time Updates</div>
                            <div class="feature-desc">Live data synchronization</div>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <div class="feature-title">Centralized Data</div>
                            <div class="feature-desc">All records in one place</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="click-hint">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                </svg>
                Move & click to interact
            </div>
        </div>

        <!-- ═══ Right Form Panel ═══ -->
        <div class="form-panel" id="formPanel">
            <!-- Interactive Ripple Canvas -->
            <canvas id="rightCanvas"></canvas>
            <div class="form-wrapper">
                <!-- Mobile Logo (Visible on < 960px) -->
                <div class="mobile-logo">
                    <img src="{{ asset('images/SDO-Logo.png') }}" alt="DepEd Logo">
                    <h2>Schools Division Office</h2>
                </div>

                <!-- ═══ LOGIN VIEW ═══ -->
                <div class="login-view" id="loginView">
                    <!-- Greeting -->
                    <div class="form-greeting anim-1">
                        <div class="greeting-badge">
                            <span class="dot"></span>
                            DepEd Manager
                        </div>
                        <h1>Welcome back</h1>
                        <p>Sign in to continue to your dashboard</p>
                    </div>

                    <!-- Form -->
                    <form action="#" method="POST" id="loginForm">
                        @csrf

                        <div class="field anim-2">
                            <div class="field-label">
                                <label for="email">Email Address</label>
                            </div>
                            <div class="input-box">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                <input type="email" name="email" id="email" placeholder="you@deped.gov.ph" required autocomplete="email">
                            </div>
                        </div>

                        <div class="field anim-3">
                            <div class="field-label">
                                <label for="password">Password</label>
                            </div>
                            <div class="input-box">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <input type="password" name="password" id="password" placeholder="Enter your password" required autocomplete="current-password">
                                <button type="button" class="eye-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="eyeIcon">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div style="text-align: right; margin-top: 0.5rem;">
                                <a href="#" id="forgotPasswordLink" style="font-size: 0.82rem; color: #667eea; font-weight: 500; text-decoration: none; transition: color 0.2s;">Forgot Password?</a>
                            </div>
                        </div>

                        <div class="anim-4">
                            <button type="submit" class="btn-login" id="submitBtn">
                                <span>Sign In</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Alert Message -->
                    <div class="login-alert {{ session('error') ? 'show error' : '' }}" id="loginAlert">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="alertIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span id="alertText">{{ session('error') }}</span>
                    </div>

                    <div class="bottom-text anim-5" style="margin-top: 1.25rem;">
                        <p>Don't have an account? <a href="#" id="showRegisterLink">Contact your admin</a></p>
                    </div>
                </div>

                <!-- ═══ REGISTER VIEW ═══ -->
                <div class="register-view" id="registerView">
                    <button class="otp-back-btn" id="regBackBtn" title="Go back to login">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back to login
                    </button>

                    <div class="reg-header anim-1">
                        <h2 class="reg-title">Create Account</h2>
                        <p class="reg-desc">Request access to the Schools Division Office platform.</p>
                    </div>

                    <form id="registerForm" enctype="multipart/form-data" class="anim-2">
                        @csrf
                        <div class="reg-profile-container">
                            <div class="reg-profile-upload" onclick="document.getElementById('regProfileInput').click()">
                                <img id="regProfilePreview" src="" alt="" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" /></svg>
                                <span>Photo</span>
                                <input type="file" name="profile_image" id="regProfileInput" accept="image/*" style="display:none;" onchange="previewRegImage(this)">
                            </div>
                        </div>

                        <div class="form-grid span-2">

                            <div class="field">
                                <div class="field-label"><label>Email Address</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                    <input type="email" name="email" placeholder="you@deped.gov.ph" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="field">
                                <div class="field-label"><label>Last Name</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <input type="text" name="last_name" placeholder="Dela Cruz" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="field-label"><label>First Name</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <input type="text" name="first_name" placeholder="Juan" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="field">
                                <div class="field-label"><label>Middle Name</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <input type="text" name="middle_name" placeholder="Santos">
                                </div>
                            </div>
                            <div class="field">
                                <div class="field-label"><label>Suffix</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                    </svg>
                                    <input type="text" name="suffix" placeholder="Jr., III">
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="field">
                                <div class="field-label"><label>Position</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <input type="text" name="position" placeholder="e.g. Teacher I" required>
                                </div>
                            </div>

                            <div class="field">
                                <div class="field-label"><label>Assign</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                    <select name="assigned">
                                        <option value="national">National</option>
                                        <option value="city">City</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="field">
                                <div class="field-label"><label>Password</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    <input type="password" name="password" id="regPassword" placeholder="••••••••" required minlength="8">
                                    <button type="button" class="eye-toggle" id="toggleRegPassword" aria-label="Toggle password visibility">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="eyeRegIcon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="strength-meter" id="strengthMeter">
                                    <div class="strength-bar" id="strengthBar"></div>
                                </div>
                                <span class="strength-text" id="strengthText"></span>
                            </div>
                            <div class="field">
                                <div class="field-label"><label>Confirm Password</label></div>
                                <div class="input-box">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                    <input type="password" name="password_confirmation" id="regConfirmPassword" placeholder="••••••••" required minlength="8">
                                    <button type="button" class="eye-toggle" id="toggleRegConfirmPassword" aria-label="Toggle password visibility">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="eyeRegConfirmIcon">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="field-label">
                                <label>Face Recognition (Optional)</label>
                                <span id="faceCapturedStatus" style="font-size: 0.72rem; color: #10b981; font-weight: 600; display: none; align-items: center; gap: 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    Face Captured
                                </span>
                            </div>
                            <input type="hidden" name="face_descriptor" id="regFaceDescriptor">
                            <button type="button" class="btn-face-login" id="regFaceBtn" style="background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2); color: #10b981; margin-bottom: 0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>
                                <span id="regFaceBtnText">Setup Face Recognition</span>
                            </button>
                            <p style="font-size: 0.65rem; color: #8892a4; margin-top: -0.25rem;">Adding face data allows you to log in faster using your camera.</p>
                        </div>

                        <button type="submit" class="btn-login" id="regSubmitBtn">

                            <span>Submit Registration</span>
                        </button>
                    </form>

                    <div class="login-alert" id="regAlert" style="margin-top:1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span id="regAlertText"></span>
                    </div>
                </div>

                <!-- ═══ VERIFICATION CHOOSER VIEW ═══ -->
                <div class="chooser-view" id="chooserView">
                    <button class="otp-back-btn" id="chooserBackBtn" title="Go back to login">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back to login
                    </button>

                    <div class="chooser-header">
                        <div class="chooser-icon" style="display: flex; margin: 0 auto 1.25rem auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <h2>Verify Your Identity</h2>
                        <p>Hello, <span class="chooser-name" id="chooserUserName"></span>! Choose how you'd like to verify.</p>
                    </div>

                    <div class="chooser-options">
                        <!-- Email OTP Option -->
                        <button type="button" class="chooser-option" id="chooseOtpBtn">
                            <div class="chooser-option-icon otp-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div class="chooser-option-text">
                                <div class="chooser-option-title">Email OTP Code</div>
                                <div class="chooser-option-desc">We'll send a 6-digit code to your email</div>
                            </div>
                            <svg class="chooser-option-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>

                        <!-- Face Recognition Option -->
                        <button type="button" class="chooser-option" id="chooseFaceBtn">
                            <div class="chooser-option-icon face-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>
                            </div>
                            <div class="chooser-option-text">
                                <div class="chooser-option-title">Face Recognition</div>
                                <div class="chooser-option-desc">Use your camera to verify your identity</div>
                            </div>
                            <svg class="chooser-option-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Chooser Alert -->
                    <div class="login-alert" id="chooserAlert" style="margin-bottom: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="chooserAlertIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span id="chooserAlertText"></span>
                    </div>
                </div>

                <!-- ═══ OTP VIEW (replaces login form) ═══ -->
                <div class="otp-view" id="otpView">
                    <button class="otp-back-btn" id="otpBackBtn" title="Go back to login">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back to login
                    </button>

                    <div class="otp-header">
                        <div class="otp-icon" style="display: flex; margin: 0 auto 1.5rem auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 32px; height: 32px; color: #667eea;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <h2 style="margin-bottom: 0.5rem; font-size: 1.8rem; font-weight: 800; color: #0f0f23; letter-spacing: -0.03em;">Verify Your Identity</h2>
                        <p class="otp-desc" style="font-size: 0.9rem; color: #8892a4; margin-bottom: 2rem;">
                            Hello, <strong id="otpUserName" style="color: #667eea;"></strong>! Enter the 6-digit code to continue to your dashboard.
                        </p>
                    </div>

                    <div class="otp-inputs" id="otpInputs" style="display: flex; justify-content: center; gap: 12px; margin-bottom: 1.5rem;">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="0" autocomplete="one-time-code">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="1">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="2">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="3">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="4">
                        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" class="otp-digit" data-index="5">
                    </div>

                    <!-- OTP Alert -->
                    <div class="login-alert" id="otpAlert" style="margin-bottom: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="otpAlertIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span id="otpAlertText"></span>
                    </div>

                    <button class="btn-verify" id="verifyBtn" disabled>
                        <div class="spinner" id="verifySpinner"></div>
                        <span id="verifyBtnText">Verify Code</span>
                    </button>

                    <div class="otp-footer">
                        Didn't receive a code?
                        <button class="resend-btn" id="resendBtn" disabled>
                            Resend in <span class="otp-timer" id="otpTimer">60</span>s
                        </button>
                    </div>
                </div>

                <!-- ═══ FORGOT PASSWORD VIEW ═══ -->
                <div class="forgot-view" id="forgotView">
                    <button class="otp-back-btn" id="forgotBackBtn" title="Go back to login">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                        Back to login
                    </button>

                    <div class="forgot-header">
                        <div class="forgot-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <h2>Forgot Password?</h2>
                        <p>Enter your email address and we'll send you a link to reset your password.</p>
                    </div>

                    <form id="forgotForm">
                        @csrf
                        <div class="field">
                            <div class="field-label">
                                <label for="forgotEmail">Email Address</label>
                            </div>
                            <div class="input-box">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                <input type="email" name="email" id="forgotEmail" placeholder="you@deped.gov.ph" required autocomplete="email">
                            </div>
                        </div>

                        <button type="submit" class="btn-reset-send" id="forgotSubmitBtn">
                            <div class="spinner" id="forgotSpinner"></div>
                            <span id="forgotBtnText">Send Reset Link</span>
                        </button>
                    </form>

                    <!-- Alert -->
                    <div class="login-alert" id="forgotAlert" style="margin-top: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="forgotAlertIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span id="forgotAlertText"></span>
                    </div>

                    <button class="forgot-back-link" id="forgotBackLink">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        Return to Sign In
                    </button>
                </div>

                <!-- ═══ RESET PASSWORD VIEW ═══ -->
                <div class="reset-view" id="resetView">
                    <div class="reset-header">
                        <div class="reset-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h2>Set New Password</h2>
                        <p>Create a strong password for your account</p>
                        <div class="reset-email-badge" id="resetEmailBadge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <span id="resetEmailDisplay"></span>
                        </div>
                    </div>

                    <form id="resetForm">
                        @csrf
                        <input type="hidden" name="token" id="resetToken" value="{{ $resetToken ?? '' }}">
                        <input type="hidden" name="email" id="resetEmailInput" value="{{ $resetEmail ?? '' }}">

                        <div class="field">
                            <div class="field-label">
                                <label for="newPassword">New Password</label>
                            </div>
                            <div class="input-box">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                <input type="password" name="password" id="newPassword" placeholder="Minimum 8 characters" required minlength="8">
                                <button type="button" class="eye-toggle" id="toggleNewPass" aria-label="Toggle password visibility">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="eyeNewPass">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                                <div class="strength-meter" id="resetStrengthMeter">
                                    <div class="strength-bar" id="resetStrengthBar"></div>
                                </div>
                                <span class="strength-text" id="resetStrengthText"></span>
                            </div>

                        <div class="field">
                            <div class="field-label">
                                <label for="confirmPassword">Confirm Password</label>
                            </div>
                            <div class="input-box">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Re-enter your password" required minlength="8">
                                <button type="button" class="eye-toggle" id="toggleConfirmPass" aria-label="Toggle password visibility">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="eyeConfirmPass">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-reset-send" id="resetSubmitBtn">
                            <div class="spinner" id="resetSpinner"></div>
                            <span id="resetBtnText">Reset Password</span>
                        </button>
                    </form>

                    <!-- Alert -->
                    <div class="login-alert" id="resetAlert" style="margin-top: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="resetAlertIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span id="resetAlertText"></span>
                    </div>

                    <button class="forgot-back-link" id="resetBackLink">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        Back to Sign In
                    </button>
                </div>
            </div>

            <div class="page-footer">
                <p>© 2026 Department of Education. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // ─── DOM ELEMENTS ───
        const loginForm = document.getElementById('loginForm');
        const loginView = document.getElementById('loginView');
        const otpView = document.getElementById('otpView');
        const forgotView = document.getElementById('forgotView');
        const registerView = document.getElementById('registerView');
        const resetView = document.getElementById('resetView');
        const chooserView = document.getElementById('chooserView');
        const faceLoginView = document.getElementById('faceLoginView');
        const formPanel = document.getElementById('formPanel');
        
        const showRegisterLink = document.getElementById('showRegisterLink');
        const regBackBtn = document.getElementById('regBackBtn');
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const registerForm = document.getElementById('registerForm');
        
        const loginAlert = document.getElementById('loginAlert');
        const alertText = document.getElementById('alertText');
        const alertIcon = document.getElementById('alertIcon');
        const submitBtn = document.getElementById('submitBtn');

        // Chooser elements
        const chooserBackBtn = document.getElementById('chooserBackBtn');
        const chooserUserName = document.getElementById('chooserUserName');
        const chooseOtpBtn = document.getElementById('chooseOtpBtn');
        const chooseFaceBtn = document.getElementById('chooseFaceBtn');
        const chooserAlert = document.getElementById('chooserAlert');
        const chooserAlertText = document.getElementById('chooserAlertText');
        const chooserAlertIcon = document.getElementById('chooserAlertIcon');

        // Forgot and OTP elements
        const forgotForm = document.getElementById('forgotForm');
        const forgotSubmitBtn = document.getElementById('forgotSubmitBtn');
        const forgotBtnText = document.getElementById('forgotBtnText');
        const forgotSpinner = document.getElementById('forgotSpinner');
        const forgotAlert = document.getElementById('forgotAlert');
        const forgotAlertText = document.getElementById('forgotAlertText');
        const forgotAlertIcon = document.getElementById('forgotAlertIcon');
        const forgotBackBtn = document.getElementById('forgotBackBtn');
        const forgotBackLink = document.getElementById('forgotBackLink');

        const otpUserName = document.getElementById('otpUserName');
        const otpDigits = document.querySelectorAll('.otp-digit');
        const verifyBtn = document.getElementById('verifyBtn');
        const verifyBtnText = document.getElementById('verifyBtnText');
        const verifySpinner = document.getElementById('verifySpinner');
        const otpAlert = document.getElementById('otpAlert');
        const otpAlertText = document.getElementById('otpAlertText');
        const otpAlertIcon = document.getElementById('otpAlertIcon');
        const resendBtn = document.getElementById('resendBtn');
        const otpTimerEl = document.getElementById('otpTimer');
        const otpBackBtn = document.getElementById('otpBackBtn');

        const resetForm = document.getElementById('resetForm');
        const resetSubmitBtn = document.getElementById('resetSubmitBtn');
        const resetBtnText = document.getElementById('resetBtnText');
        const resetSpinner = document.getElementById('resetSpinner');
        const resetAlert = document.getElementById('resetAlert');
        const resetAlertText = document.getElementById('resetAlertText');
        const resetAlertIcon = document.getElementById('resetAlertIcon');
        const resetBackLink = document.getElementById('resetBackLink');
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        // View switches for Register
        showRegisterLink.addEventListener('click', (e) => {
            e.preventDefault();
            resetRegisterForm();
            formPanel.classList.add('panel-register');
            switchView('register');
        });

        regBackBtn.addEventListener('click', () => {
            formPanel.classList.remove('panel-register');
            switchView('login');
        });

        // View switches for Forgot Password (initial toggle)
        forgotPasswordLink.addEventListener('click', (e) => {
            e.preventDefault();
            formPanel.classList.remove('panel-register');
            switchView('forgot');
        });

        window.previewRegImage = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('regProfilePreview').src = e.target.result;
                    document.getElementById('regProfilePreview').style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        function resetRegisterForm() {
            registerForm.reset();
            document.getElementById('regProfilePreview').style.display = 'none';
            document.getElementById('regProfilePreview').src = '';
            document.getElementById('regAlert').style.display = 'none';
            // Also reset strength meter if it exists
            const meter = document.getElementById('strengthMeter');
            const text = document.getElementById('strengthText');
            if (meter) meter.style.display = 'none';
            if (text) text.textContent = '';
            
            // Reset Face recognition UI
            const faceDesc = document.getElementById('regFaceDescriptor');
            const faceStatus = document.getElementById('faceCapturedStatus');
            const faceBtnText = document.getElementById('regFaceBtnText');
            const faceBtn = document.getElementById('regFaceBtn');
            if (faceDesc) faceDesc.value = '';
            if (faceStatus) faceStatus.style.display = 'none';
            if (faceBtnText) faceBtnText.textContent = 'Setup Face Recognition';
            if (faceBtn) {
                faceBtn.style.background = 'rgba(16, 185, 129, 0.05)';
                faceBtn.style.borderColor = 'rgba(16, 185, 129, 0.2)';
            }
        }

        registerForm.addEventListener('submit', async e => {
            e.preventDefault();
            const btn = document.getElementById('regSubmitBtn');
            const alert = document.getElementById('regAlert');
            const alertText = document.getElementById('regAlertText');
            
            btn.disabled = true;
            btn.querySelector('span').textContent = 'Submitting...';
            
            try {
                const formData = new FormData(registerForm);
                formData.append('role', 'user');
                
                // Ensure face descriptor is included from hidden field
                const faceDescriptor = document.getElementById('regFaceDescriptor').value;
                if (faceDescriptor) {
                    formData.append('face_descriptor', faceDescriptor);
                }

                const res = await fetch('/api/register', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
                    body: formData
                });
                const data = await res.json();
                
                alert.style.display = 'flex';
                if (res.ok) {
                    alert.className = 'login-alert success';
                    alertText.textContent = data.message;
                    setTimeout(() => {
                        regBackBtn.click();
                        resetRegisterForm();
                    }, 3000);
                } else {
                    alert.className = 'login-alert error';
                    alertText.textContent = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Error during registration.');
                }
            } catch (err) {
                alert.style.display = 'flex';
                alert.className = 'login-alert error';
                alertText.textContent = 'Server error. Please try again later.';
            } finally {
                btn.disabled = false;
                btn.querySelector('span').textContent = 'Submit Registration';
            }
        });

        // ═══════════════════════════════════════════
        //  INTERACTIVE PARTICLE CONSTELLATION
        // ═══════════════════════════════════════════
        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d');
        const panel = document.getElementById('visualPanel');
        let particles = [];
        let mouse = { x: -1000, y: -1000, radius: 120 };
        const PARTICLE_COUNT = 80;
        const CONNECT_DIST = 140;
        const MOUSE_ATTRACT = 0.02;

        function resizeCanvas() {
            canvas.width = panel.offsetWidth;
            canvas.height = panel.offsetHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        class Particle {
            constructor(x, y, isExplosion = false) {
                this.x = x ?? Math.random() * canvas.width;
                this.y = y ?? Math.random() * canvas.height;
                this.baseRadius = Math.random() * 2.5 + 1;
                this.radius = this.baseRadius;
                const speed = isExplosion ? (Math.random() * 4 + 2) : (Math.random() * 0.6 + 0.15);
                const angle = Math.random() * Math.PI * 2;
                this.vx = Math.cos(angle) * speed;
                this.vy = Math.sin(angle) * speed;
                this.alpha = isExplosion ? 1 : (Math.random() * 0.5 + 0.3);
                this.isExplosion = isExplosion;
                this.life = isExplosion ? 1 : Infinity;
                this.hue = Math.random() * 40 + 220; // blue-purple range
            }

            update() {
                // Mouse attraction
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < mouse.radius && !this.isExplosion) {
                    this.vx += dx * MOUSE_ATTRACT * 0.3;
                    this.vy += dy * MOUSE_ATTRACT * 0.3;
                    this.radius = this.baseRadius * 1.8;
                } else {
                    this.radius += (this.baseRadius - this.radius) * 0.1;
                }

                // Dampen velocity
                if (!this.isExplosion) {
                    this.vx *= 0.98;
                    this.vy *= 0.98;
                }

                this.x += this.vx;
                this.y += this.vy;

                // Explosion particles fade
                if (this.isExplosion) {
                    this.life -= 0.015;
                    this.alpha = this.life;
                    this.vx *= 0.97;
                    this.vy *= 0.97;
                }

                // Wrap around edges
                if (!this.isExplosion) {
                    if (this.x < -20) this.x = canvas.width + 20;
                    if (this.x > canvas.width + 20) this.x = -20;
                    if (this.y < -20) this.y = canvas.height + 20;
                    if (this.y > canvas.height + 20) this.y = -20;
                }

                // Random gentle drift
                if (!this.isExplosion) {
                    this.vx += (Math.random() - 0.5) * 0.02;
                    this.vy += (Math.random() - 0.5) * 0.02;
                }
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = `hsla(${this.hue}, 80%, 80%, ${this.alpha})`;
                ctx.fill();

                // Glow effect
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius * 3, 0, Math.PI * 2);
                ctx.fillStyle = `hsla(${this.hue}, 80%, 80%, ${this.alpha * 0.08})`;
                ctx.fill();
            }
        }

        // Initialize particles
        for (let i = 0; i < PARTICLE_COUNT; i++) {
            particles.push(new Particle());
        }

        function drawConnections() {
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < CONNECT_DIST) {
                        const opacity = (1 - dist / CONNECT_DIST) * 0.25 * Math.min(particles[i].alpha, particles[j].alpha);
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(200, 210, 255, ${opacity})`;
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                }
            }

            // Draw lines from mouse to nearby particles
            if (mouse.x > 0 && mouse.y > 0) {
                particles.forEach(p => {
                    const dx = mouse.x - p.x;
                    const dy = mouse.y - p.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < mouse.radius * 1.5) {
                        const opacity = (1 - dist / (mouse.radius * 1.5)) * 0.4;
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(mouse.x, mouse.y);
                        ctx.strokeStyle = `rgba(180, 190, 255, ${opacity})`;
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                });

                // Mouse glow
                const gradient = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, mouse.radius * 0.6);
                gradient.addColorStop(0, 'rgba(180, 190, 255, 0.12)');
                gradient.addColorStop(1, 'rgba(180, 190, 255, 0)');
                ctx.beginPath();
                ctx.arc(mouse.x, mouse.y, mouse.radius * 0.6, 0, Math.PI * 2);
                ctx.fillStyle = gradient;
                ctx.fill();
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Remove dead explosion particles
            particles = particles.filter(p => !p.isExplosion || p.life > 0);

            drawConnections();

            particles.forEach(p => {
                p.update();
                p.draw();
            });

            requestAnimationFrame(animate);
        }

        animate();

        // ─── Mouse Events (relative to panel) ───
        panel.addEventListener('mousemove', (e) => {
            const rect = panel.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        });

        panel.addEventListener('mouseleave', () => {
            mouse.x = -1000;
            mouse.y = -1000;
        });

        // ─── Click Burst ───
        panel.addEventListener('click', (e) => {
            const rect = panel.getBoundingClientRect();
            const cx = e.clientX - rect.left;
            const cy = e.clientY - rect.top;

            // Spawn burst particles
            const burstCount = 20 + Math.floor(Math.random() * 15);
            for (let i = 0; i < burstCount; i++) {
                particles.push(new Particle(cx, cy, true));
            }

            // Push nearby particles away
            particles.forEach(p => {
                if (p.isExplosion) return;
                const dx = p.x - cx;
                const dy = p.y - cy;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 200 && dist > 0) {
                    const force = (1 - dist / 200) * 6;
                    p.vx += (dx / dist) * force;
                    p.vy += (dy / dist) * force;
                }
            });
        });

        // ═══════════════════════════════════════════
        //  OTP LOGIN FLOW
        // ═══════════════════════════════════════════
        // ═══════════════════════════════════════════
        //  OTP LOGIN FLOW (INLINE)
        // ═══════════════════════════════════════════
        
        // OTP Elements (already declared at top)
        let countdownInterval = null;

        function showAlert(el, textEl, iconEl, msg, type) {
            el.className = 'login-alert show ' + type;
            textEl.textContent = msg;
            if (type === 'error') {
                iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />';
            } else {
                iconEl.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
            }
        }

        function hideAlert(el) {
            el.className = 'login-alert';
        }

        function startCountdown() {
            let seconds = 60;
            otpTimerEl.textContent = seconds;
            resendBtn.disabled = true;
            resendBtn.innerHTML = 'Resend in <span class="otp-timer">' + seconds + '</span>s';

            clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                seconds--;
                resendBtn.innerHTML = 'Resend in <span class="otp-timer">' + seconds + '</span>s';
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    resendBtn.disabled = false;
                    resendBtn.textContent = 'Resend Code';
                }
            }, 1000);
        }



        function switchView(view) {
            // Hide/Deactivate all views first
            loginView.classList.add('hidden');
            otpView.classList.remove('active');
            forgotView.classList.remove('active');
            resetView.classList.remove('active');
            registerView.classList.remove('active');
            if (chooserView) chooserView.classList.remove('active');
            if (faceLoginView) faceLoginView.classList.remove('active');

            // Stop face login camera if switching away
            if (view !== 'faceLogin' && typeof stopFaceLoginCamera === 'function') {
                stopFaceLoginCamera();
            }

            setTimeout(() => {
                // Ensure all views are display:none except the target
                loginView.style.display = (view === 'login' || !view) ? 'block' : 'none';
                otpView.style.display = (view === 'otp') ? 'block' : 'none';
                forgotView.style.display = (view === 'forgot') ? 'block' : 'none';
                resetView.style.display = (view === 'reset') ? 'block' : 'none';
                registerView.style.display = (view === 'register') ? 'block' : 'none';
                if (chooserView) chooserView.style.display = (view === 'chooser') ? 'block' : 'none';
                if (faceLoginView) faceLoginView.style.display = (view === 'faceLogin') ? 'block' : 'none';

                // Activate the target view
                if (view === 'otp') {
                    otpView.classList.add('active');
                    otpDigits[0].focus();
                } else if (view === 'chooser') {
                    chooserView.classList.add('active');
                } else if (view === 'forgot') {
                    forgotView.classList.add('active');
                    const emailInput = document.getElementById('forgotEmail');
                    if(emailInput) emailInput.focus();
                } else if (view === 'reset') {
                    resetView.classList.add('active');
                    if(newPasswordInput) newPasswordInput.focus();
                } else if (view === 'register') {
                    registerView.classList.add('active');
                } else if (view === 'faceLogin') {
                    faceLoginView.classList.add('active');
                    startFaceLoginCamera();
                } else {
                    loginView.classList.remove('hidden');
                }
            }, 400); // Standardized delay for transitions
        }

        // ─── Login Form Submit ───
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlert(loginAlert);

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.querySelector('span').textContent = 'Verifying...';
            submitBtn.querySelector('svg').style.display = 'none';

            try {
                const csrfToken = document.querySelector('input[name=_token]').value;
                const res = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const contentType = res.headers.get('content-type');
                if (contentType && contentType.indexOf('application/json') !== -1) {
                    const data = await res.json();
                    if (data.success) {
                        // Store user data for chooser
                        const userName = data.user_name || 'User';
                        chooserUserName.textContent = userName;
                        otpUserName.textContent = userName;

                        // Disable Face Recognition if not registered OR locked
                        if (chooseFaceBtn) {
                            if (!data.has_face) {
                                chooseFaceBtn.disabled = true;
                                chooseFaceBtn.querySelector('.chooser-option-desc').textContent = 'Face not registered for this account';
                                chooseFaceBtn.querySelector('.chooser-option-title').textContent = 'Face Recognition';
                            } else if (data.face_locked) {
                                chooseFaceBtn.disabled = true;
                                // Calculate remaining time
                                let lockMsg = 'Locked — too many failed attempts';
                                if (data.face_locked_until) {
                                    const lockedUntil = new Date(data.face_locked_until);
                                    const now = new Date();
                                    const diffMs = lockedUntil - now;
                                    if (diffMs > 0) {
                                        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                                        const diffMins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                                        lockMsg = diffHours > 0 
                                            ? `Locked — try again in ${diffHours}h ${diffMins}m`
                                            : `Locked — try again in ${diffMins} minute(s)`;
                                    }
                                }
                                chooseFaceBtn.querySelector('.chooser-option-desc').textContent = lockMsg;
                                chooseFaceBtn.querySelector('.chooser-option-title').textContent = 'Face Recognition (Locked)';
                            } else {
                                chooseFaceBtn.disabled = false;
                                chooseFaceBtn.querySelector('.chooser-option-desc').textContent = 'Use your camera to verify your identity';
                                chooseFaceBtn.querySelector('.chooser-option-title').textContent = 'Face Recognition';
                            }
                        }

                        // Show verification chooser
                        switchView('chooser');
                    } else {
                        showAlert(loginAlert, alertText, alertIcon, data.message || 'Login failed', 'error');
                    }
                } else {
                    const text = await res.text();
                    console.error('Non-JSON response:', text);
                    showAlert(loginAlert, alertText, alertIcon, 'Server Error: ' + text.substring(0, 50) + '...', 'error');
                }
            } catch (err) {
                console.error(err);
                showAlert(loginAlert, alertText, alertIcon, 'Error: ' + err.message, 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.querySelector('span').textContent = 'Sign In';
                submitBtn.querySelector('svg').style.display = '';
            }
        });

        // ─── Chooser: Back Button ───
        chooserBackBtn.addEventListener('click', () => {
            switchView('login');
            hideAlert(chooserAlert);
        });

        // ─── Chooser: Email OTP Option ───
        chooseOtpBtn.addEventListener('click', async () => {
            // Disable buttons to prevent double-click
            chooseOtpBtn.disabled = true;
            chooseFaceBtn.disabled = true;
            const origTitle = chooseOtpBtn.querySelector('.chooser-option-title');
            origTitle.textContent = 'Sending OTP...';

            try {
                const csrfToken = document.querySelector('input[name=_token]').value;
                const res = await fetch('/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    switchView('otp');
                    startCountdown();
                    if (!data.email_sent) {
                        showAlert(otpAlert, otpAlertText, otpAlertIcon, 'Email delivery failed. Use the code above.', 'success');
                    } else {
                        showAlert(otpAlert, otpAlertText, otpAlertIcon, 'OTP sent to your email!', 'success');
                    }
                } else {
                    showAlert(chooserAlert, chooserAlertText, chooserAlertIcon, data.message || 'Failed to send OTP.', 'error');
                }
            } catch (err) {
                showAlert(chooserAlert, chooserAlertText, chooserAlertIcon, 'Network error. Please try again.', 'error');
            } finally {
                chooseOtpBtn.disabled = false;
                chooseFaceBtn.disabled = false;
                origTitle.textContent = 'Email OTP Code';
            }
        });

        // ─── Chooser: Face Recognition Option ───
        chooseFaceBtn.addEventListener('click', () => {
            openBioModal('login');
        });

        // ─── OTP Input Handling ───
        otpDigits.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val;

                if (val && index < otpDigits.length - 1) {
                    otpDigits[index + 1].focus();
                }

                e.target.classList.toggle('filled', !!val);
                e.target.classList.remove('error');
                hideAlert(otpAlert);

                // Enable verify when all 6 digits filled
                const allFilled = [...otpDigits].every(d => d.value.length === 1);
                verifyBtn.disabled = !allFilled;
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpDigits[index - 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                pasted.split('').forEach((char, i) => {
                    if (otpDigits[i]) {
                        otpDigits[i].value = char;
                        otpDigits[i].classList.add('filled');
                    }
                });
                const lastIndex = Math.min(pasted.length, 6) - 1;
                if (otpDigits[lastIndex]) otpDigits[lastIndex].focus();
                verifyBtn.disabled = pasted.length < 6;
            });
        });

        // ─── Verify OTP ───
        verifyBtn.addEventListener('click', async () => {
            const otp = [...otpDigits].map(d => d.value).join('');
            if (otp.length !== 6) return;

            hideAlert(otpAlert);
            verifyBtn.disabled = true;
            verifyBtnText.textContent = 'Verifying...';
            verifySpinner.style.display = 'block';

            try {
                const csrfToken = document.querySelector('input[name=_token]').value;
                const res = await fetch('/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ otp })
                });

                const data = await res.json();

                if (data.success) {
                    showAlert(otpAlert, otpAlertText, otpAlertIcon, data.message, 'success');
                    verifyBtnText.textContent = 'Verified! ✓';
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    showAlert(otpAlert, otpAlertText, otpAlertIcon, data.message, 'error');
                    otpDigits.forEach(d => d.classList.add('error'));
                    verifyBtn.disabled = false;
                    verifyBtnText.textContent = 'Verify Code';
                    verifySpinner.style.display = 'none';
                }
            } catch (err) {
                showAlert(otpAlert, otpAlertText, otpAlertIcon, 'Network error. Please try again.', 'error');
                verifyBtn.disabled = false;
                verifyBtnText.textContent = 'Verify Code';
                verifySpinner.style.display = 'none';
            }
        });

        // ─── Resend OTP ───
        resendBtn.addEventListener('click', async () => {
            hideAlert(otpAlert);
            resendBtn.disabled = true;
            resendBtn.textContent = 'Sending...';

            try {
                const csrfToken = document.querySelector('input[name=_token]').value;
                const res = await fetch('/resend-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (data.success) {
                    if(data.otp_code) {
                         otpCodeValue.textContent = data.otp_code;
                    }
                    
                    if (!data.email_sent) {
                        showAlert(otpAlert, otpAlertText, otpAlertIcon, 'Email failed. New code generated.', 'success');
                    } else {
                        showAlert(otpAlert, otpAlertText, otpAlertIcon, 'New OTP sent to your email!', 'success');
                    }

                    // Clear old inputs
                    otpDigits.forEach(d => { d.value = ''; d.classList.remove('filled', 'error'); });
                    verifyBtn.disabled = true;
                    otpDigits[0].focus();
                    startCountdown();
                } else {
                    showAlert(otpAlert, otpAlertText, otpAlertIcon, data.message, 'error');
                }
            } catch (err) {
                showAlert(otpAlert, otpAlertText, otpAlertIcon, 'Failed to resend. Try again.', 'error');
            }
        });

        // ─── Back Button ───
        otpBackBtn.addEventListener('click', () => {
             switchView('chooser');
             clearInterval(countdownInterval);
             otpDigits.forEach(d => { d.value = ''; d.classList.remove('filled', 'error'); });
             hideAlert(otpAlert);
             hideAlert(loginAlert);
        });

        // ═══════════════════════════════════════════
        //  FORGOT PASSWORD FLOW
        // ═══════════════════════════════════════════
        // Forgot Password Flow elements (already declared at top)

        // "Forgot?" link click - handled in the top listener
        // forgotPasswordLink.addEventListener('click', (e) => { ... });

        // Back buttons
        if (forgotBackBtn) {
            forgotBackBtn.addEventListener('click', () => {
                formPanel.classList.remove('panel-register');
                switchView('login');
                hideAlert(forgotAlert);
            });
        }

        if (forgotBackLink) {
            forgotBackLink.addEventListener('click', () => {
                formPanel.classList.remove('panel-register');
                switchView('login');
                hideAlert(forgotAlert);
            });
        }

        // Forgot Password form submit
        forgotForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlert(forgotAlert);

            const email = document.getElementById('forgotEmail').value;
            if (!email) {
                showAlert(forgotAlert, forgotAlertText, forgotAlertIcon, 'Please enter your email address.', 'error');
                return;
            }

            // Show loading
            forgotSubmitBtn.disabled = true;
            forgotBtnText.textContent = 'Sending...';
            forgotSpinner.style.display = 'block';

            try {
                const csrfToken = forgotForm.querySelector('input[name=_token]').value;
                const res = await fetch('/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await res.json();

                if (data.success) {
                    showAlert(forgotAlert, forgotAlertText, forgotAlertIcon, data.message, 'success');
                    forgotBtnText.textContent = 'Email Sent ✓';
                } else {
                    showAlert(forgotAlert, forgotAlertText, forgotAlertIcon, data.message || 'Failed to send reset link.', 'error');
                    forgotBtnText.textContent = 'Send Reset Link';
                    forgotSubmitBtn.disabled = false;
                }
            } catch (err) {
                showAlert(forgotAlert, forgotAlertText, forgotAlertIcon, 'Network error. Please try again.', 'error');
                forgotBtnText.textContent = 'Send Reset Link';
                forgotSubmitBtn.disabled = false;
            } finally {
                forgotSpinner.style.display = 'none';
            }
        });

        // ═══════════════════════════════════════════
        //  RESET PASSWORD FLOW
        // ═══════════════════════════════════════════
        // Reset Flow elements (already declared at top)
        // Show email badge
        const resetEmailVal = document.getElementById('resetEmailInput').value;
        if (resetEmailVal) {
            document.getElementById('resetEmailDisplay').textContent = resetEmailVal;
        }

        // Auto-show reset view if token is present
        const resetToken = document.getElementById('resetToken').value;
        if (resetToken) {
            switchView('reset');
        }

        // Back to login
        resetBackLink.addEventListener('click', () => {
            window.location.href = '/';
        });

        // Reset form submit
        resetForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            resetAlert.className = 'login-alert';

            const password = newPasswordInput.value;
            const confirm = confirmPasswordInput.value;

            if (password.length < 8) {
                showAlert(resetAlert, resetAlertText, resetAlertIcon, 'Password must be at least 8 characters.', 'error');
                return;
            }

            if (password !== confirm) {
                showAlert(resetAlert, resetAlertText, resetAlertIcon, 'Passwords do not match.', 'error');
                return;
            }

            // Loading state
            resetSubmitBtn.disabled = true;
            resetBtnText.textContent = 'Resetting...';
            resetSpinner.style.display = 'block';

            try {
                const csrfToken = resetForm.querySelector('input[name=_token]').value;
                const token = resetForm.querySelector('input[name=token]').value;
                const email = resetForm.querySelector('input[name=email]').value;

                const res = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, token, password, password_confirmation: confirm })
                });

                const data = await res.json();

                if (data.success) {
                    showAlert(resetAlert, resetAlertText, resetAlertIcon, data.message, 'success');
                    resetBtnText.textContent = 'Password Reset ✓';
                    setTimeout(() => {
                        window.location.href = data.redirect || '/';
                    }, 2000);
                } else {
                    showAlert(resetAlert, resetAlertText, resetAlertIcon, data.message || 'Failed to reset password.', 'error');
                    resetSubmitBtn.disabled = false;
                    resetBtnText.textContent = 'Reset Password';
                }
            } catch (err) {
                showAlert(resetAlert, resetAlertText, resetAlertIcon, 'Network error. Please try again.', 'error');
                resetSubmitBtn.disabled = false;
                resetBtnText.textContent = 'Reset Password';
            } finally {
                resetSpinner.style.display = 'none';
            }
        });

        // ═══════════════════════════════════════════
        //  RIGHT PANEL — INTERACTIVE RIPPLES & BUBBLES
        // ═══════════════════════════════════════════
        const rCanvas = document.getElementById('rightCanvas');
        const rCtx = rCanvas.getContext('2d');
        // formPanel already declared at the top of the script
        // const formPanel = document.getElementById('formPanel');
        const ripples = [];
        const bubbles = [];
        let rMouse = { x: -1000, y: -1000 };
        let bubbleTimer = 0;

        function resizeRightCanvas() {
            // Use window size for fixed canvas to prevent distortion when scrolling long forms
            const isDesktop = window.innerWidth > 960;
            rCanvas.width = isDesktop ? formPanel.offsetWidth : window.innerWidth;
            rCanvas.height = window.innerHeight;
            
            // Re-draw background to fill if necessary? No, animation does it.
        }
        resizeRightCanvas();
        window.addEventListener('resize', resizeRightCanvas);

        // ─── Color palette (soft indigo/violet/teal) ───
        const rippleColors = [
            { r: 99, g: 102, b: 241 },   // indigo
            { r: 139, g: 92, b: 246 },   // violet
            { r: 59, g: 130, b: 246 },   // blue
            { r: 6, g: 182, b: 212 },    // cyan
            { r: 124, g: 58, b: 237 },   // purple
        ];

        class Ripple {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.radius = 0;
                this.maxRadius = 80 + Math.random() * 60;
                this.speed = 1.5 + Math.random() * 1.5;
                this.alpha = 0.35;
                this.lineWidth = 2 + Math.random() * 2;
                const c = rippleColors[Math.floor(Math.random() * rippleColors.length)];
                this.color = c;
                this.alive = true;
            }

            update() {
                this.radius += this.speed;
                this.alpha = 0.35 * (1 - this.radius / this.maxRadius);
                if (this.radius >= this.maxRadius) this.alive = false;
            }

            draw() {
                rCtx.beginPath();
                rCtx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                rCtx.strokeStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha})`;
                rCtx.lineWidth = this.lineWidth;
                rCtx.stroke();

                // Inner glow
                if (this.radius < this.maxRadius * 0.4) {
                    const grd = rCtx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.radius);
                    grd.addColorStop(0, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha * 0.3})`);
                    grd.addColorStop(1, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, 0)`);
                    rCtx.beginPath();
                    rCtx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    rCtx.fillStyle = grd;
                    rCtx.fill();
                }
            }
        }

        class Bubble {
            constructor(x, y) {
                this.x = x + (Math.random() - 0.5) * 30;
                this.y = y + (Math.random() - 0.5) * 30;
                this.radius = Math.random() * 10 + 4;
                this.vx = (Math.random() - 0.5) * 0.8;
                this.vy = -(Math.random() * 1.0 + 0.3);
                this.alpha = 0.6 + Math.random() * 0.3;
                this.life = 1;
                this.decay = 0.002 + Math.random() * 0.003;
                const c = rippleColors[Math.floor(Math.random() * rippleColors.length)];
                this.color = c;
                this.wobbleSpeed = Math.random() * 0.04 + 0.015;
                this.wobbleAmp = Math.random() * 2 + 1;
                this.time = Math.random() * 100;
                this.alive = true;
            }

            update() {
                this.time += this.wobbleSpeed;
                this.x += this.vx + Math.sin(this.time) * this.wobbleAmp * 0.3;
                this.y += this.vy;
                this.life -= this.decay;
                this.alpha = Math.max(0, this.life * 0.7);
                if (this.life <= 0) this.alive = false;
            }

            draw() {
                // Outer glow
                const outerGlow = rCtx.createRadialGradient(this.x, this.y, this.radius * 0.5, this.x, this.y, this.radius * 2.5);
                outerGlow.addColorStop(0, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha * 0.15})`);
                outerGlow.addColorStop(1, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, 0)`);
                rCtx.beginPath();
                rCtx.arc(this.x, this.y, this.radius * 2.5, 0, Math.PI * 2);
                rCtx.fillStyle = outerGlow;
                rCtx.fill();

                // Bubble body
                const grd = rCtx.createRadialGradient(
                    this.x - this.radius * 0.3, this.y - this.radius * 0.3, this.radius * 0.1,
                    this.x, this.y, this.radius
                );
                grd.addColorStop(0, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha * 0.5})`);
                grd.addColorStop(0.6, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha * 0.25})`);
                grd.addColorStop(1, `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha * 0.05})`);

                rCtx.beginPath();
                rCtx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                rCtx.fillStyle = grd;
                rCtx.fill();

                // Bubble ring
                rCtx.beginPath();
                rCtx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                rCtx.strokeStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha * 0.6})`;
                rCtx.lineWidth = 1;
                rCtx.stroke();

                // Shiny highlight
                rCtx.beginPath();
                rCtx.arc(this.x - this.radius * 0.3, this.y - this.radius * 0.3, this.radius * 0.3, 0, Math.PI * 2);
                rCtx.fillStyle = `rgba(255, 255, 255, ${this.alpha * 0.5})`;
                rCtx.fill();
            }
        }

        // Spawn ambient bubbles in the background automatically
        function spawnAmbientBubble() {
            const x = Math.random() * rCanvas.width;
            const y = rCanvas.height + 10;
            const b = new Bubble(x, y);
            b.vy = -(Math.random() * 0.6 + 0.2);
            b.decay = 0.001 + Math.random() * 0.0015;
            b.radius = Math.random() * 8 + 4;
            b.alpha = 0.4 + Math.random() * 0.3;
            bubbles.push(b);
        }

        // Pre-fill screen with bubbles so it's not empty on load
        for (let i = 0; i < 50; i++) {
            const x = Math.random() * rCanvas.width;
            const y = Math.random() * rCanvas.height;
            const b = new Bubble(x, y);
            b.vy = -(Math.random() * 0.4 + 0.1);
            b.decay = 0.001 + Math.random() * 0.001;
            b.radius = Math.random() * 10 + 3;
            b.alpha = 0.3 + Math.random() * 0.35;
            b.life = 0.3 + Math.random() * 0.7; // random starting life so they don't all fade at once
            bubbles.push(b);
        }

        function animateRight() {
            rCtx.clearRect(0, 0, rCanvas.width, rCanvas.height);

            // Ambient bubbles — spawn frequently
            bubbleTimer++;
            if (bubbleTimer % 4 === 0) {
                spawnAmbientBubble();
            }

            // Update & draw ripples
            for (let i = ripples.length - 1; i >= 0; i--) {
                ripples[i].update();
                ripples[i].draw();
                if (!ripples[i].alive) ripples.splice(i, 1);
            }

            // Update & draw bubbles
            for (let i = bubbles.length - 1; i >= 0; i--) {
                bubbles[i].update();
                bubbles[i].draw();
                if (!bubbles[i].alive) bubbles.splice(i, 1);
            }

            requestAnimationFrame(animateRight);
        }
        animateRight();

        // ─── Mouse events for right panel ───
        formPanel.addEventListener('mousemove', (e) => {
            const rect = formPanel.getBoundingClientRect();
            rMouse.x = e.clientX - rect.left;
            rMouse.y = e.clientY - rect.top;

            // Spawn trail bubbles on mouse move
            if (Math.random() > 0.5) {
                bubbles.push(new Bubble(rMouse.x, rMouse.y));
            }
        });

        formPanel.addEventListener('mouseleave', () => {
            rMouse.x = -1000;
            rMouse.y = -1000;
        });

        // Click spawns ripples
        formPanel.addEventListener('click', (e) => {
            const rect = formPanel.getBoundingClientRect();
            const cx = e.clientX - rect.left;
            const cy = e.clientY - rect.top;

            // Spawn 3 staggered ripples
            for (let i = 0; i < 3; i++) {
                setTimeout(() => {
                    ripples.push(new Ripple(cx, cy));
                }, i * 120);
            }

            // Spawn burst of bubbles
            for (let i = 0; i < 12; i++) {
                const b = new Bubble(cx, cy);
                const angle = (Math.PI * 2 / 12) * i;
                b.vx = Math.cos(angle) * (Math.random() * 2 + 1);
                b.vy = Math.sin(angle) * (Math.random() * 2 + 1);
                bubbles.push(b);
            }
        });

        // ═══════════════════════════════════════════
        //  FORM INTERACTIONS
        // ═══════════════════════════════════════════

        // ─── Toggle Password Visibility ───
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.innerHTML = isPassword
                ? '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />'
                : '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
        });

        // ─── Registration Toggles ───
        function setupToggle(btnId, inputId, iconId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!btn || !input || !icon) return;
            btn.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.innerHTML = isPassword
                    ? '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />'
                    : '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
            });
        }
        setupToggle('toggleRegPassword', 'regPassword', 'eyeRegIcon');
        setupToggle('toggleRegConfirmPassword', 'regConfirmPassword', 'eyeRegConfirmIcon');
        setupToggle('toggleNewPass', 'newPassword', 'eyeNewPass');
        setupToggle('toggleConfirmPass', 'confirmPassword', 'eyeConfirmPass');

        // ─── Registration Password Strength ───
        const regPassInput = document.getElementById('regPassword');
        const meter = document.getElementById('strengthMeter');
        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');

        function evaluateStrength(val, meterEl, barEl, textEl) {
            if (!val) {
                meterEl.style.display = 'none';
                textEl.textContent = '';
                return;
            }
            meterEl.style.display = 'block';
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
            const labels = ['Weak', 'Fair', 'Good', 'Strong'];
            const width = (score / 4) * 100;

            barEl.style.width = width + '%';
            barEl.style.backgroundColor = colors[Math.max(0, score - 1)];
            textEl.textContent = labels[Math.max(0, score - 1)];
            textEl.style.color = colors[Math.max(0, score - 1)];
        }

        regPassInput.addEventListener('input', () => {
            evaluateStrength(regPassInput.value, meter, bar, text);
        });

        // ─── Reset Password Strength ───
        const newPassInput = document.getElementById('newPassword');
        const resetMeter = document.getElementById('resetStrengthMeter');
        const resetBar = document.getElementById('resetStrengthBar');
        const resetText = document.getElementById('resetStrengthText');

        if (newPassInput) {
            newPassInput.addEventListener('input', () => {
                evaluateStrength(newPassInput.value, resetMeter, resetBar, resetText);
            });
        }

        // ─── Subtle input interaction ───
        document.querySelectorAll('.input-box input').forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('.input-box').style.transform = 'scale(1.01)';
                input.closest('.input-box').style.transition = 'transform 0.2s ease';
            });
            input.addEventListener('blur', () => {
                input.closest('.input-box').style.transform = 'scale(1)';
            });
        });
    </script>

    @include('partials.biometric-modal')

    <!-- face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script>
        let bioStream = null;
        let bioModelsLoaded = false;
        let bioDetectionInterval = null;
        let bioAttempting = false;
        let bioCurrentDescriptor = null;
        let bioRecentDescriptors = [];
        let bioMode = 'login'; // 'login' or 'register'
        const REQUIRED_SAMPLES = 5;

        // Modal Elements
        const bioModalOverlay = document.getElementById('bioModalOverlay');
        const bioModalClose = document.getElementById('bioModalClose');
        const btnFaceLoginTrigger = document.getElementById('faceLoginBtn');
        const btnScanFace = document.getElementById('btnScanFace');

        // Math Panel Elements
        const valDetection = document.getElementById('valDetection');
        const barDetection = document.getElementById('barDetection');
        const valDistance = document.getElementById('valDistance');
        const distMarker = document.getElementById('distMarker');
        const distMatchStatus = document.getElementById('distMatchStatus');
        const valVectors = document.getElementById('valVectors');
        const statSamples = document.getElementById('statSamples');
        const statL2 = document.getElementById('statL2');
        const statMin = document.getElementById('statMin');
        const embeddingCanvas = document.getElementById('embeddingCanvas');
        const hudScore = document.getElementById('hudScore');
        const hudProgress = document.getElementById('hudProgress');
        const bioAlert = document.getElementById('bioAlert');
        const bioAlertText = document.getElementById('bioAlertText');
        const btnScanText = document.getElementById('btnScanText');

        // Progress Bar Helper
        function setBioProgress(percent, statusText, stateClass) {
            const fill = document.getElementById('bioProgressFill');
            const glow = document.getElementById('bioProgressGlow');
            const statusEl = document.getElementById('bioProgressStatus');
            const percentEl = document.getElementById('bioProgressPercent');
            
            fill.style.width = percent + '%';
            glow.style.width = percent + '%';
            fill.classList.remove('success', 'error');
            statusEl.classList.remove('active', 'success', 'error');
            percentEl.style.color = '#6366f1';
            
            if (stateClass) {
                fill.classList.add(stateClass);
                statusEl.classList.add(stateClass);
                if (stateClass === 'success') percentEl.style.color = '#10b981';
                if (stateClass === 'error') percentEl.style.color = '#ef4444';
            } else if (percent > 0) {
                statusEl.classList.add('active');
            }
            
            statusEl.textContent = statusText || 'Ready to scan';
            percentEl.textContent = Math.round(percent) + '%';
        }

        // Compatibility shim for old setPipeStatus calls
        function setPipeStatus(stepId, status) {
            // No-op: steps replaced by progress bar
        }

        const btnFaceRegTrigger = document.getElementById('regFaceBtn');
        if (btnFaceRegTrigger) {
            btnFaceRegTrigger.addEventListener('click', () => openBioModal('register'));
        }
        if (bioModalClose) {
            bioModalClose.addEventListener('click', closeBioModal);
        }
        if (btnScanFace) {
            btnScanFace.addEventListener('click', startScanningProcess);
        }

        async function openBioModal(mode = 'login') {
            bioMode = mode;
            bioModalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Reset progress bar
            setBioProgress(0, 'Initializing...');
            
            if (mode === 'register') {
                document.getElementById('bioModalTitle').textContent = 'Setup Face Recognition';
                document.getElementById('bioModalSubtitle').textContent = 'Create a unique biometric profile for your account';
                btnScanText.textContent = 'Capture Biometrics';
            } else {
                document.getElementById('bioModalTitle').textContent = 'Biometric Login';
                document.getElementById('bioModalSubtitle').textContent = 'Verify your identity to continue';
                btnScanText.textContent = 'Scan My Face';
            }
            await startBioCamera();
        }

        function closeBioModal() {
            bioModalOverlay.classList.remove('active');
            document.body.style.overflow = '';
            stopBioCamera();
            setBioProgress(0, 'Ready to scan');
        }

        async function loadBioModels() {
            if (bioModelsLoaded) return;
            const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.12/model/';
            await Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
            ]);
            bioModelsLoaded = true;
        }

        /**
         * Cross-browser / cross-context getUserMedia polyfill.
         * Works on HTTP (mobile hotspot), older Android browsers, and modern browsers.
         */
        function getMediaStream(constraints) {
            // Modern browsers with secure context
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                return navigator.mediaDevices.getUserMedia(constraints);
            }
            // Polyfill mediaDevices for HTTP contexts (non-secure origin)
            const legacyGetUserMedia =
                navigator.getUserMedia ||
                navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia ||
                navigator.msGetUserMedia;

            if (legacyGetUserMedia) {
                // Wrap callback-based API in a Promise
                return new Promise((resolve, reject) => {
                    legacyGetUserMedia.call(navigator, constraints, resolve, reject);
                });
            }

            // If still nothing available, give a helpful message
            return Promise.reject(new Error(
                'Camera access is not available. Please open this page over HTTPS or use localhost.'
            ));
        }

        async function startBioCamera() {
            const statusText = document.getElementById('bioCamStatusText');
            const video = document.getElementById('bioVideo');
            
            statusText.textContent = 'Loading models...';
            setBioProgress(10, 'Loading AI models...');
            document.getElementById('bioLoaderOverlay').classList.remove('hidden');
            btnScanFace.disabled = true;
            try {
                await loadBioModels();
                setBioProgress(30, 'Starting camera...');
                statusText.textContent = 'Starting camera...';
                
                bioStream = await getMediaStream({
                    video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: 'user' }
                });
                video.srcObject = bioStream;
                await video.play();
                
                statusText.textContent = 'System Ready';
                document.querySelector('.bio-cam-status').classList.add('active');
                setBioProgress(40, 'Camera ready — press scan');
                
                startDetectionLoop();
            } catch (err) {
                console.error(err);
                statusText.textContent = 'Camera Error';
                setBioProgress(0, 'Camera error', 'error');
                let msg = err.message || 'Unknown error';
                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    msg = 'Camera permission denied. Please allow camera access in your browser settings.';
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    msg = 'No camera found on this device.';
                } else if (!navigator.mediaDevices) {
                    msg = 'Camera access requires a secure connection (HTTPS). Please contact your administrator.';
                }
                showBioAlert(msg, 'error');
            }
        }

        function stopBioCamera() {
            if (bioDetectionInterval) {
                clearInterval(bioDetectionInterval);
                bioDetectionInterval = null;
            }
            if (bioStream) {
                bioStream.getTracks().forEach(t => t.stop());
                bioStream = null;
            }
            const video = document.getElementById('bioVideo');
            if (video) video.srcObject = null;
            document.querySelector('.bio-cam-status').classList.remove('active');
            bioAttempting = false;
            document.querySelectorAll('.pipe-step').forEach(s => s.classList.remove('active', 'done'));
        }

        function drawFaceHUD(ctx, detection) {
            if (!detection.landmarks) return;
            
            const points = detection.landmarks.positions;
            const score = detection.detection.score;
            const hubColor = '#ffffff'; // Pure white contour
            const meshColor = 'rgba(255, 255, 255, 0.5)'; // Durable white features
            const lineColor = 'rgba(255, 255, 255, 0.15)'; // Faint white mesh triangulation

            // 1. Draw Face-Fitted Contour (The "Oval")
            // This follows the jawline and estimates the top of the head
            ctx.beginPath();
            ctx.strokeStyle = hubColor;
            ctx.lineWidth = 2.5;
            ctx.setLineDash([8, 5]);

            // Jaw points (0-16)
            points.slice(0, 17).forEach((p, i) => {
                if (i === 0) ctx.moveTo(p.x, p.y);
                else ctx.lineTo(p.x, p.y);
            });

            // Forehead Arc Estimation
            const jawLeft = points[0];
            const jawRight = points[16];
            const chin = points[8];
            
            // Calculate eye-level to determine forehead height
            const eyeAvgY = (points[36].y + points[45].y) / 2;
            const headHeight = chin.y - eyeAvgY;
            const foreheadTopY = eyeAvgY - (headHeight * 0.75); // Standard facial proportions
            
            // Close the shape with a curve for the forehead
            ctx.bezierCurveTo(jawRight.x, foreheadTopY, jawLeft.x, foreheadTopY, jawLeft.x, jawLeft.y);
            ctx.stroke();
            ctx.setLineDash([]);

            // 2. Clearer Landmark Mesh (Yellow)
            ctx.lineWidth = 1;
            ctx.strokeStyle = meshColor;
            
            const features = [
                // Interior features
                [17,18,19,20,21], [22,23,24,25,26], // Brows
                [27,28,29,30], [31,32,33,34,35,31], // Nose
                [36,37,38,39,40,41,36], [42,43,44,45,46,47,42], // Eyes
                [48,49,50,51,52,53,54,55,56,57,58,59,48], // Mouth Outer
                [60,61,62,63,64,65,66,67,60], // Mouth Inner
            ];

            features.forEach(path => {
                ctx.beginPath();
                path.forEach((idx, i) => i === 0 ? ctx.moveTo(points[idx].x, points[idx].y) : ctx.lineTo(points[idx].x, points[idx].y));
                ctx.stroke();
            });

            // Triangulated connecting lines (Mesh)
            const triangulation = [
                [19, 27, 24], [21, 27, 22], // Brows to nose bridge
                [39, 27, 42], // Inner eyes to bridge
                [31, 48, 4, 2], [35, 54, 12, 14], // Nose base to mouth and jaw
                [19, 36], [24, 45], // Brows to outer eyes
                [33, 51, 62], [33, 66, 57], // Nose to lips
                [51, 33, 48], [51, 33, 54] // bridge-mouth connections
            ];

            ctx.lineWidth = 0.5;
            ctx.strokeStyle = lineColor;
            triangulation.forEach(path => {
                ctx.beginPath();
                path.forEach((idx, i) => i === 0 ? ctx.moveTo(points[idx].x, points[idx].y) : ctx.lineTo(points[idx].x, points[idx].y));
                ctx.stroke();
            });
        }

        function startDetectionLoop() {
            const video = document.getElementById('bioVideo');
            const canvas = document.getElementById('bioCanvas');
            
            bioDetectionInterval = setInterval(async () => {
                if (!video.videoWidth) return;
                
                const detection = await faceapi.detectSingleFace(video, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                
                const displaySize = { width: video.videoWidth, height: video.videoHeight };
                faceapi.matchDimensions(canvas, displaySize);
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                // Hide loader on first detection attempt (once analyzer starts returning)
                const loader = document.getElementById('bioLoaderOverlay');
                if (loader && !loader.classList.contains('hidden')) {
                    loader.classList.add('hidden');
                    btnScanFace.disabled = false;
                }
                
                if (detection) {
                    const resized = faceapi.resizeResults(detection, displaySize);
                    drawFaceHUD(ctx, resized);
                    
                    bioCurrentDescriptor = detection.descriptor;
                    
                    // Update Math Panel
                    updateMathPanel(detection);
                    drawEmbedding(detection.descriptor);
                } else {
                    bioCurrentDescriptor = null;
                    resetMathPanel();
                }
            }, 100);
        }

        function updateMathPanel(detection) {
            const score = detection.detection.score;
            valDetection.textContent = score.toFixed(4);
            barDetection.style.width = (score * 100) + '%';
            hudScore.textContent = `Score: ${Math.round(score * 100)}%`;
            
            // Score based coloring
            if (score > 0.82) {
                barDetection.style.background = '#10b981';
                document.getElementById('bioScanFrame').classList.add('scanning');
            } else {
                barDetection.style.background = '#7c3aed';
                document.getElementById('bioScanFrame').classList.remove('scanning');
            }

            // Statistical calculations
            const descriptor = detection.descriptor;
            const l2Norm = Math.sqrt(descriptor.reduce((sum, val) => sum + val * val, 0));
            statL2.textContent = l2Norm.toFixed(4);
        }

        function resetMathPanel() {
            valDetection.textContent = '0.0000';
            barDetection.style.width = '0%';
            hudScore.textContent = 'Score: --%';
            document.getElementById('bioScanFrame').classList.remove('scanning');
            const ctx = embeddingCanvas.getContext('2d');
            ctx.clearRect(0, 0, embeddingCanvas.width, embeddingCanvas.height);
        }

        function drawEmbedding(descriptor) {
            const ctx = embeddingCanvas.getContext('2d');
            const w = embeddingCanvas.width;
            const h = embeddingCanvas.height;
            ctx.clearRect(0, 0, w, h);
            
            const barWidth = w / 128;
            for (let i = 0; i < 128; i++) {
                // Normalize float value for visualization
                const val = (descriptor[i] + 0.1) * 5; // offset and scale
                const color = Math.floor(Math.max(0, Math.min(255, val * 255)));
                ctx.fillStyle = `rgb(${color}, ${124}, ${237})`;
                // Use more variation
                const r = Math.floor((descriptor[i] + 0.5) * 255);
                ctx.fillStyle = `rgb(${40}, ${r}, ${250})`;
                ctx.fillRect(i * barWidth, 0, barWidth, h);
            }
        }

        async function startScanningProcess() {
            if (!bioCurrentDescriptor) {
                showBioAlert('Please position your face clearly in the frame.', 'error');
                return;
            }
            
            if (bioAttempting) return;
            bioAttempting = true;
            btnScanFace.disabled = true;
            const originalText = btnScanText.textContent;
            btnScanText.textContent = 'Scanning...';
            setBioProgress(50, 'Collecting biometric samples...');
            bioRecentDescriptors = [];
            
            // Collect samples
            const statusText = document.getElementById('bioCamStatusText');
            statusText.textContent = 'Collecting biometric samples...';
            
            let samplesTaken = 0;
            const collectInterval = setInterval(async () => {
                if (bioCurrentDescriptor) {
                    bioRecentDescriptors.push(Array.from(bioCurrentDescriptor));
                    samplesTaken++;
                    hudProgress.textContent = `${samplesTaken} / ${REQUIRED_SAMPLES}`;
                    statSamples.textContent = `${samplesTaken} / ${REQUIRED_SAMPLES}`;
                    
                    // Update progress bar proportionally (50% to 80%)
                    const samplePercent = 50 + (samplesTaken / REQUIRED_SAMPLES) * 30;
                    setBioProgress(samplePercent, `Sample ${samplesTaken} of ${REQUIRED_SAMPLES}...`);
                    
                    if (samplesTaken >= REQUIRED_SAMPLES) {
                        clearInterval(collectInterval);
                        setBioProgress(85, 'Analyzing face data...');
                        await performAuthentication();
                    }
                }
            }, 300);
        }

        async function performAuthentication() {
            const statusText = document.getElementById('bioCamStatusText');
            statusText.textContent = 'Analyzing vectors...';
            setBioProgress(90, 'Matching face data...');
            
            // Average the descriptors
            const avgDescriptor = bioRecentDescriptors[0].map((_, i) => {
                return bioRecentDescriptors.reduce((sum, d) => sum + d[i], 0) / bioRecentDescriptors.length;
            });
            
            if (bioMode === 'register') {
                // Handle Registration Mode locally
                document.getElementById('regFaceDescriptor').value = JSON.stringify(avgDescriptor);
                document.getElementById('faceCapturedStatus').style.display = 'inline-flex';
                document.getElementById('regFaceBtnText').textContent = 'Face Data Captured ✓';
                document.getElementById('regFaceBtn').style.background = 'rgba(16, 185, 129, 0.15)';
                document.getElementById('regFaceBtn').style.borderColor = '#10b981';
                
                setBioProgress(100, 'Profile generated!', 'success');
                statusText.textContent = 'Biometric Profile Generated!';
                document.getElementById('bioScanFrame').classList.add('success');
                showBioAlert('Success! Face data captured for your new account.', 'success');
                
                setTimeout(() => {
                    closeBioModal();
                }, 1500);
                return;
            }

            // Capture snapshot for security auditing
            const video = document.getElementById('bioVideo');
            let snapshot = null;
            
            // Wait for video dimensions to be valid (if necessary)
            if (video.videoWidth > 0 && video.videoHeight > 0) {
                const snapCanvas = document.createElement('canvas');
                snapCanvas.width = video.videoWidth;
                snapCanvas.height = video.videoHeight;
                const snapCtx = snapCanvas.getContext('2d');
                snapCtx.drawImage(video, 0, 0, snapCanvas.width, snapCanvas.height);
                // Switch to PNG as requested for quality
                snapshot = snapCanvas.toDataURL('image/png');
                console.log('Biometric audit snapshot captured. Size: ' + Math.round(snapshot.length / 1024) + ' KB');
            } else {
                console.warn('Face capture failed: video dimensions are zero.');
            }

            const csrfToken = document.querySelector('input[name=_token]').value;
            
            try {
                const res = await fetch('/api/face/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        descriptor: JSON.stringify(avgDescriptor),
                        snapshot: snapshot
                    })
                });

                const data = await res.json();
                
                if (data.stats) {
                    updateFinalStats(data.stats);
                }



                if (data.success) {
                    setBioProgress(100, 'Identity confirmed!', 'success');
                    statusText.textContent = 'Identity Confirmed!';
                    document.getElementById('bioScanFrame').classList.add('success');
                    showBioAlert(`Success! Welcome back, ${data.user_name}.`, 'success');
                    
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    // Face not recognized - show clear error feedback
                    setBioProgress(100, 'Not recognized', 'error');
                    statusText.textContent = 'Not Recognized';
                    
                    // Visual failure state on scan frame
                    const scanFrame = document.getElementById('bioScanFrame');
                    scanFrame.classList.remove('scanning', 'success');
                    scanFrame.classList.add('failed');
                    
                    showBioAlert(data.message || 'Face not recognized. No matching account found.', 'error');

                    // If locked after 3 attempts, close modal and disable face option
                    if (data.locked) {
                        setTimeout(() => {
                            closeBioModal();
                            // Disable Face Recognition on the chooser screen
                            const faceBtn = document.getElementById('chooseFaceBtn');
                            if (faceBtn) {
                                let lockMsg = 'Locked for 24 hours. Use Email OTP.';
                                if (data.locked_until) {
                                    const lockedUntil = new Date(data.locked_until);
                                    const now = new Date();
                                    const diffMs = lockedUntil - now;
                                    if (diffMs > 0) {
                                        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                                        const diffMins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                                        lockMsg = diffHours > 0 
                                            ? `Locked — try again in ${diffHours}h ${diffMins}m`
                                            : `Locked — try again in ${diffMins} minute(s)`;
                                    }
                                }
                                faceBtn.disabled = true;
                                faceBtn.querySelector('.chooser-option-desc').textContent = lockMsg;
                                faceBtn.querySelector('.chooser-option-title').textContent = 'Face Recognition (Locked)';
                            }
                            // Show alert on the chooser view
                            const chooserAlert = document.getElementById('chooserAlert');
                            const chooserAlertText = document.getElementById('chooserAlertText');
                            const chooserAlertIcon = document.getElementById('chooserAlertIcon');
                            if (chooserAlert) {
                                showAlert(chooserAlert, chooserAlertText, chooserAlertIcon, 
                                    'Face recognition locked for 24 hours after 3 failed attempts. Please use Email OTP.', 'error');
                            }
                        }, 2500);
                    } else {
                        // Show attempts remaining
                        const attemptsLeft = data.attempts_left !== undefined ? data.attempts_left : '?';
                        btnScanFace.disabled = false;
                        btnScanText.textContent = `Try Again (${attemptsLeft} left)`;
                        bioAttempting = false;
                        hudProgress.textContent = '0 / 5';
                        
                        // Reset scan frame and progress after a delay
                        setTimeout(() => {
                            scanFrame.classList.remove('failed');
                            setBioProgress(40, `Camera ready — ${attemptsLeft} attempt(s) left`);
                        }, 4000);
                    }
                }

            } catch (err) {
                console.error(err);
                showBioAlert('Server communication error.', 'error');
                btnScanFace.disabled = false;
                bioAttempting = false;
            }
        }

        function updateFinalStats(stats) {
            valVectors.textContent = stats.registered_users;
            valDistance.textContent = stats.best_distance !== null ? stats.best_distance.toFixed(4) : 'N/A';
            
            if (stats.best_distance !== null) {
                // Euclidean distance usually ranges from 0 to 1.5
                const percent = Math.min(100, (stats.best_distance / 1.5) * 100);
                distMarker.style.left = percent + '%';
                statMin.textContent = stats.best_distance.toFixed(4);
                
                if (stats.best_distance < 0.6) {
                    distMatchStatus.textContent = `MATCH! Distance ${stats.best_distance.toFixed(3)} < 0.6`;
                    distMatchStatus.style.color = '#10b981';
                } else {
                    distMatchStatus.textContent = `MISMATCH: Distance ${stats.best_distance.toFixed(3)} > 0.6`;
                    distMatchStatus.style.color = '#ef4444';
                }
            }
        }



        function showBioAlert(msg, type) {
            bioAlert.className = 'bio-alert show ' + type;
            bioAlertText.textContent = msg;
            if (type === 'error') {
                setTimeout(() => bioAlert.classList.remove('show'), 8000);
            }
        }
    </script>
</body>
</html>
