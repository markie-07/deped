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
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #FAFBFF;
            color: #1a1a2e;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ─── Layout ─── */
        .login-page {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            min-height: 100vh;
        }

        @media (max-width: 960px) {
            .login-page { grid-template-columns: 1fr; }
            .visual-panel { display: none; }
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
            padding: 3rem;
            max-width: 440px;
            animation: fadeIn 1s ease-out;
        }

        .v-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 120px; height: 120px;
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
            font-size: 2.6rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.04em;
            margin-bottom: 1rem;
        }

        .v-subtitle {
            font-size: 1.05rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
            margin-bottom: 2.5rem;
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
            gap: 1.25rem;
            margin-top: 2.5rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.25rem;
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
            width: 40px;
            height: 40px;
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
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.25rem;
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
            padding: 2.5rem;
            position: relative;
            background: #FAFBFF;
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
            margin-bottom: 2.5rem;
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
            margin-bottom: 1.35rem;
        }

        .field-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.55rem;
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

        .input-box input {
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
        }

        .input-box input::placeholder { color: #b0b9c8; }

        .input-box input:hover {
            border-color: #c5ccda;
        }

        .input-box input:focus {
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
        }

        .page-footer p {
            font-size: 0.72rem;
            color: #c0c7d6;
        }

        /* ─── Right Panel Interactive Canvas ─── */
        #rightCanvas {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══════════════════════════════════════════
           OTP INLINE VIEW (replaces login form in right panel)
           ═══════════════════════════════════════════ */
        .form-wrapper {
            position: relative;
            overflow: hidden;
        }

        .login-view,
        .otp-view,
        .forgot-view {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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

                    <div class="separator anim-5"><span>Secured by DepEd</span></div>

                    <div class="bottom-text anim-6">
                        <p>Don't have an account? <a href="#">Contact your admin</a></p>
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
                        <div class="otp-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <h2>Verify Your Identity</h2>
                        <p class="otp-desc">
                            Hello, <strong id="otpUserName"></strong>! Enter the 6-digit code to continue to your dashboard.
                        </p>
                    </div>



                    <div class="otp-inputs" id="otpInputs">
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
                            <div class="password-strength">
                                <div class="password-strength-bar" id="strengthBar"></div>
                            </div>
                            <div class="strength-text" id="strengthText"></div>
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
        const loginForm = document.getElementById('loginForm');
        const loginView = document.getElementById('loginView');
        const otpView = document.getElementById('otpView');
        const loginAlert = document.getElementById('loginAlert');
        const alertText = document.getElementById('alertText');
        const alertIcon = document.getElementById('alertIcon');
        const submitBtn = document.getElementById('submitBtn');
        
        // OTP Elements
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
        // Back buttons (both top left and bottom text logic if needed)
        const otpBackBtn = document.getElementById('otpBackBtn');
        
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

        const resetView = document.getElementById('resetView');

        function switchView(view) {
            // Hide all views first
            loginView.classList.add('hidden');
            otpView.classList.remove('active');
            forgotView.classList.remove('active');
            resetView.classList.remove('active');

            setTimeout(() => {
                if (view === 'otp') {
                    otpView.classList.add('active');
                    otpDigits[0].focus();
                } else if (view === 'forgot') {
                    forgotView.classList.add('active');
                    document.getElementById('forgotEmail').focus();
                } else if (view === 'reset') {
                    resetView.classList.add('active');
                    document.getElementById('newPassword').focus();
                } else {
                    loginView.classList.remove('hidden');
                }
            }, 100);
        }

        // ─── Login Form Submit ───
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlert(loginAlert);

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.querySelector('span').textContent = 'Sending OTP...';
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
                        // Update OTP view data
                        otpUserName.textContent = data.user_name || 'User';
                        if(data.otp_code) {
                             // OTP code handled via backend
                        }

                        // Switch views
                        switchView('otp');
                        startCountdown();

                        if (!data.email_sent) {
                            showAlert(otpAlert, otpAlertText, otpAlertIcon, 'Email delivery failed. Use the code above.', 'success');
                        } else {
                             showAlert(otpAlert, otpAlertText, otpAlertIcon, 'OTP sent to your email!', 'success');
                        }
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
             switchView('login');
             clearInterval(countdownInterval);
             otpDigits.forEach(d => { d.value = ''; d.classList.remove('filled', 'error'); });
             hideAlert(otpAlert);
             hideAlert(loginAlert);
        });

        // ═══════════════════════════════════════════
        //  FORGOT PASSWORD FLOW
        // ═══════════════════════════════════════════
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const forgotView = document.getElementById('forgotView');
        const forgotForm = document.getElementById('forgotForm');
        const forgotSubmitBtn = document.getElementById('forgotSubmitBtn');
        const forgotBtnText = document.getElementById('forgotBtnText');
        const forgotSpinner = document.getElementById('forgotSpinner');
        const forgotAlert = document.getElementById('forgotAlert');
        const forgotAlertText = document.getElementById('forgotAlertText');
        const forgotAlertIcon = document.getElementById('forgotAlertIcon');
        const forgotBackBtn = document.getElementById('forgotBackBtn');
        const forgotBackLink = document.getElementById('forgotBackLink');

        // "Forgot?" link click
        forgotPasswordLink.addEventListener('click', (e) => {
            e.preventDefault();
            switchView('forgot');
        });

        // Back buttons
        forgotBackBtn.addEventListener('click', () => {
            switchView('login');
            hideAlert(forgotAlert);
        });

        forgotBackLink.addEventListener('click', () => {
            switchView('login');
            hideAlert(forgotAlert);
        });

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
        const strengthBar = document.getElementById('strengthBar');
        const strengthTextEl = document.getElementById('strengthText');

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

        // Password strength checker
        newPasswordInput.addEventListener('input', () => {
            const val = newPasswordInput.value;
            let score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const percent = (score / 5) * 100;
            strengthBar.style.width = percent + '%';

            if (score <= 1) {
                strengthBar.style.background = '#ef4444';
                strengthTextEl.textContent = 'Weak';
                strengthTextEl.style.color = '#ef4444';
            } else if (score <= 2) {
                strengthBar.style.background = '#f59e0b';
                strengthTextEl.textContent = 'Fair';
                strengthTextEl.style.color = '#f59e0b';
            } else if (score <= 3) {
                strengthBar.style.background = '#3b82f6';
                strengthTextEl.textContent = 'Good';
                strengthTextEl.style.color = '#3b82f6';
            } else {
                strengthBar.style.background = '#10b981';
                strengthTextEl.textContent = 'Strong';
                strengthTextEl.style.color = '#10b981';
            }

            if (!val) {
                strengthBar.style.width = '0';
                strengthTextEl.textContent = '';
            }
        });

        // Toggle password visibility for reset fields
        function setupResetToggle(btnId, inputId, iconId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            btn.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.innerHTML = isPassword
                    ? '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />'
                    : '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
            });
        }

        setupResetToggle('toggleNewPass', 'newPassword', 'eyeNewPass');
        setupResetToggle('toggleConfirmPass', 'confirmPassword', 'eyeConfirmPass');

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
        const formPanel = document.getElementById('formPanel');
        const ripples = [];
        const bubbles = [];
        let rMouse = { x: -1000, y: -1000 };
        let bubbleTimer = 0;

        function resizeRightCanvas() {
            rCanvas.width = formPanel.offsetWidth;
            rCanvas.height = formPanel.offsetHeight;
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
</body>
</html>
