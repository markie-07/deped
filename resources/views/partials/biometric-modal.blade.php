<!-- ═══════════════════════════════════════════════
     BIOMETRIC MODAL — Light Glassmorphism Design
     ═══════════════════════════════════════════════ -->
<div class="bio-modal-overlay" id="bioModalOverlay">
    <div class="bio-modal">
        <!-- Decorative blobs -->
        <div class="bio-blob bio-blob-1"></div>
        <div class="bio-blob bio-blob-2"></div>
        <div class="bio-blob bio-blob-3"></div>

        <!-- Close -->
        <button class="bio-close" id="bioModalClose" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>

        <!-- Title Area -->
        <div class="bio-hero">
            <div class="bio-icon-bubble">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
                </svg>
            </div>
            <h2 id="bioModalTitle">Face Recognition</h2>
            <p id="bioModalSubtitle">Position your face inside the frame to get started</p>
        </div>

        <!-- Camera -->
        <div class="bio-camera-wrap">
            <div class="bio-camera">
                <video id="bioVideo" autoplay muted playsinline></video>
                <canvas id="bioCanvas"></canvas>

                <!-- Scan Frame -->
                <div class="bio-scan-frame" id="bioScanFrame">
                    <div class="corner tl"></div>
                    <div class="corner tr"></div>
                    <div class="corner bl"></div>
                    <div class="corner br"></div>
                    <div class="scan-line"></div>
                </div>

                <!-- Status Pill -->
                <div class="bio-cam-status" id="bioCamStatus">
                    <span class="status-dot"></span>
                    <span id="bioCamStatusText">Starting camera...</span>
                </div>
            </div>
        </div>

        <!-- Progress Ring -->
        <div class="bio-progress-row">
            <div class="bio-step pipe-step" id="stepDetect"><span class="step-num">1</span><span class="step-text pipe-label">Detect</span></div>
            <div class="bio-step-line"></div>
            <div class="bio-step pipe-step" id="stepAlign"><span class="step-num">2</span><span class="step-text pipe-label">Align</span></div>
            <div class="bio-step-line"></div>
            <div class="bio-step pipe-step" id="stepExtract"><span class="step-num">3</span><span class="step-text pipe-label">Extract</span></div>
            <div class="bio-step-line"></div>
            <div class="bio-step pipe-step" id="stepMatch"><span class="step-num">4</span><span class="step-text pipe-label">Match</span></div>
        </div>

        <!-- Scan Button -->
        <button type="button" class="bio-scan-btn" id="btnScanFace">
            <div class="bio-scan-btn-glow"></div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
            </svg>
            <span id="btnScanText">Scan My Face</span>
        </button>

        <!-- Alert -->
        <div class="bio-alert" id="bioAlert">
            <span id="bioAlertText"></span>
        </div>

        <!-- Account Selection -->
        <div class="bio-select-area" id="bioSelectArea">
            <div class="select-header">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                Multiple Matches Found
            </div>
            <p class="select-sub">Select your account to continue:</p>
            <div class="select-list" id="candidateList"></div>
        </div>

        <!-- Footer Hint -->
        <div class="bio-footer-hint">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
            Your face data is processed locally and never stored as an image
        </div>

        <!-- Hidden elements for JS compatibility -->
        <div style="display:none">
            <span id="hudScore"></span>
            <span id="hudProgress"></span>
            <span id="valDetection">0.000</span>
            <div id="barDetection" style="width:0%"></div>
            <span id="valDistance">N/A</span>
            <span id="distMarker"></span>
            <span id="distMatchStatus"></span>
            <span id="valVectors">0</span>
            <span id="statSamples">0 / 5</span>
            <span id="statL2">0.0000</span>
            <span id="statMin">0.0000</span>
            <canvas id="embeddingCanvas" width="300" height="40"></canvas>
        </div>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════════════
   BIOMETRIC MODAL — LIGHT GLASSMORPHISM
   ═══════════════════════════════════════════════════ */

/* ─── Overlay ─── */
.bio-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(99, 102, 241, 0.15);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    display: none; align-items: center; justify-content: center;
    z-index: 9999; opacity: 0;
    transition: opacity 0.4s ease;
    padding: 20px;
}
.bio-modal-overlay.active { display: flex; opacity: 1; }

/* ─── Modal ─── */
.bio-modal {
    position: relative;
    background: linear-gradient(160deg, #ffffff 0%, #f8f7ff 40%, #f0eeff 100%);
    width: 100%; max-width: 520px;
    max-height: 94vh;
    border-radius: 32px;
    padding: 36px 32px 28px;
    overflow-y: auto; overflow-x: hidden;
    box-shadow:
        0 25px 60px -15px rgba(99, 102, 241, 0.2),
        0 0 0 1px rgba(99, 102, 241, 0.08),
        0 0 100px -30px rgba(139, 92, 246, 0.15);
    transform: scale(0.88) translateY(40px);
    transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    scrollbar-width: none;
}
.bio-modal::-webkit-scrollbar { display: none; }
.bio-modal-overlay.active .bio-modal {
    transform: scale(1) translateY(0);
}

/* ─── Decorative Blobs ─── */
.bio-blob {
    position: absolute; border-radius: 50%; pointer-events: none;
    filter: blur(60px); opacity: 0.5; z-index: 0;
}
.bio-blob-1 {
    width: 200px; height: 200px; top: -60px; right: -40px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.25), transparent 70%);
    animation: blobFloat 8s ease-in-out infinite;
}
.bio-blob-2 {
    width: 160px; height: 160px; bottom: -30px; left: -30px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.2), transparent 70%);
    animation: blobFloat 10s ease-in-out infinite reverse;
}
.bio-blob-3 {
    width: 120px; height: 120px; top: 40%; left: 50%;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.12), transparent 70%);
    animation: blobFloat 12s ease-in-out infinite 2s;
}
@keyframes blobFloat {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(15px, -20px) scale(1.1); }
    66% { transform: translate(-10px, 10px) scale(0.95); }
}

/* ─── Close ─── */
.bio-close {
    position: absolute; top: 16px; right: 16px; z-index: 10;
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(0, 0, 0, 0.06);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    cursor: pointer; color: #64748b;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.bio-close svg { width: 16px; height: 16px; }
.bio-close:hover {
    background: #fee2e2; color: #ef4444; border-color: #fecaca;
    transform: rotate(90deg) scale(1.1);
}

/* ─── Hero ─── */
.bio-hero {
    position: relative; z-index: 1;
    text-align: center; margin-bottom: 24px;
}
.bio-icon-bubble {
    width: 64px; height: 64px; border-radius: 22px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
    box-shadow:
        0 8px 24px rgba(99, 102, 241, 0.3),
        0 0 0 6px rgba(99, 102, 241, 0.08);
    animation: iconBreathe 4s ease-in-out infinite;
}
@keyframes iconBreathe {
    0%, 100% { box-shadow: 0 8px 24px rgba(99,102,241,0.3), 0 0 0 6px rgba(99,102,241,0.08); }
    50% { box-shadow: 0 12px 32px rgba(99,102,241,0.4), 0 0 0 10px rgba(99,102,241,0.06); }
}
.bio-icon-bubble svg { width: 28px; height: 28px; color: #fff; }

.bio-hero h2 {
    font-family: 'Inter', sans-serif;
    font-size: 1.5rem; font-weight: 900; color: #1e1b4b;
    margin: 0; letter-spacing: -0.03em;
}
.bio-hero p {
    font-size: 0.82rem; color: #6366f1; font-weight: 500;
    margin: 6px 0 0 0; opacity: 0.8;
}

/* ─── Camera ─── */
.bio-camera-wrap {
    position: relative; z-index: 1;
    padding: 6px; border-radius: 24px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6, #6366f1);
    background-size: 200% 200%;
    animation: borderGlow 4s ease infinite;
    margin-bottom: 20px;
    box-shadow: 0 8px 30px rgba(99, 102, 241, 0.2);
}
@keyframes borderGlow {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.bio-camera {
    position: relative; width: 100%;
    aspect-ratio: 4/3;
    background: #0f172a; border-radius: 20px; overflow: hidden;
}
.bio-camera video { width: 100%; height: 100%; object-fit: cover; transform: scaleX(-1); }
.bio-camera canvas {
    position: absolute; inset: 0; width: 100%; height: 100%;
    transform: scaleX(-1); pointer-events: none;
}

/* Scan Frame */
.bio-scan-frame {
    position: absolute; inset: 0; display: flex; align-items: center;
    justify-content: center; pointer-events: none;
}
.corner {
    position: absolute; width: 48px; height: 48px;
    border-color: rgba(255, 255, 255, 0.4); border-style: solid; border-width: 0;
    transition: all 0.5s ease;
}
.corner.tl { top: 14%; left: 18%; border-top-width: 3px; border-left-width: 3px; border-radius: 18px 0 0 0; }
.corner.tr { top: 14%; right: 18%; border-top-width: 3px; border-right-width: 3px; border-radius: 0 18px 0 0; }
.corner.bl { bottom: 14%; left: 18%; border-bottom-width: 3px; border-left-width: 3px; border-radius: 0 0 0 18px; }
.corner.br { bottom: 14%; right: 18%; border-bottom-width: 3px; border-right-width: 3px; border-radius: 0 0 18px 0; }

.scanning .corner {
    border-color: #818cf8;
    filter: drop-shadow(0 0 14px rgba(129,140,248,0.6));
    animation: cornerGlow 1.5s infinite;
}
.success .corner {
    border-color: #34d399; border-width: 4px;
    filter: drop-shadow(0 0 16px rgba(52,211,153,0.6));
}
.failed .corner {
    border-color: #ef4444; border-width: 4px;
    filter: drop-shadow(0 0 16px rgba(239,68,68,0.6));
    animation: failedShake 0.5s ease;
}
@keyframes failedShake {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-4px); }
    40% { transform: translateX(4px); }
    60% { transform: translateX(-3px); }
    80% { transform: translateX(3px); }
}
@keyframes cornerGlow { 0%,100%{transform:scale(1)} 50%{transform:scale(1.08)} }

.scan-line {
    position: absolute; top: -5%; left: 8%; width: 84%; height: 3px;
    background: linear-gradient(to right, transparent, rgba(129,140,248,0.9), transparent);
    box-shadow: 0 0 24px rgba(129,140,248,0.5), 0 0 60px rgba(129,140,248,0.2);
    z-index: 5; opacity: 0; pointer-events: none; border-radius: 4px;
}
.scanning .scan-line { opacity: 1; animation: scanMove 2.5s infinite ease-in-out; }
@keyframes scanMove { 0%{top:14%} 50%{top:86%} 100%{top:14%} }

/* Camera Status Pill */
.bio-cam-status {
    position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 8px 18px; border-radius: 100px; display: flex;
    align-items: center; gap: 8px;
    color: #fff; font-size: 0.78rem; font-weight: 600; white-space: nowrap; z-index: 10;
}
.status-dot {
    width: 8px; height: 8px; border-radius: 50%; background: #94a3b8;
    transition: all 0.3s;
}
.active .status-dot {
    background: #34d399;
    box-shadow: 0 0 10px rgba(52, 211, 153, 0.6);
    animation: dotPulse 2s infinite;
}
@keyframes dotPulse { 0%{opacity:.4;transform:scale(.8)} 50%{opacity:1;transform:scale(1.2)} 100%{opacity:.4;transform:scale(.8)} }

/* ─── Progress Steps ─── */
.bio-progress-row {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: center;
    gap: 0; margin-bottom: 20px;
    padding: 12px 16px;
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    border-radius: 16px; border: 1px solid rgba(99, 102, 241, 0.08);
}

.bio-step {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 10px; border-radius: 10px;
    transition: all 0.3s ease;
}
.step-num {
    width: 22px; height: 22px; border-radius: 50%;
    background: #e2e8f0; color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.6rem; font-weight: 800;
    transition: all 0.3s ease;
}
.step-text {
    font-size: 0.68rem; font-weight: 700; color: #94a3b8;
    letter-spacing: 0.02em; transition: all 0.3s ease;
}
.bio-step-line {
    width: 20px; height: 2px; background: #e2e8f0;
    margin: 0 2px; border-radius: 1px;
    transition: all 0.3s ease;
}

/* Active & Done states */
.bio-step.active .step-num {
    background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #fff;
    box-shadow: 0 2px 10px rgba(99,102,241,0.3);
    animation: stepPulse 1.2s infinite;
}
.bio-step.active .step-text { color: #6366f1; }

.bio-step.done .step-num {
    background: linear-gradient(135deg, #10b981, #34d399); color: #fff;
    box-shadow: 0 2px 10px rgba(16,185,129,0.3);
}
.bio-step.done .step-text { color: #10b981; }

@keyframes stepPulse {
    0%,100% { box-shadow: 0 2px 10px rgba(99,102,241,0.3); }
    50% { box-shadow: 0 2px 20px rgba(99,102,241,0.5); }
}

/* ─── Scan Button ─── */
.bio-scan-btn {
    position: relative; z-index: 1;
    width: 100%; padding: 16px 24px; border: none;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #6366f1 100%);
    background-size: 200% 200%; animation: btnShimmer 3s ease infinite;
    color: #fff; border-radius: 18px;
    font-family: 'Inter', sans-serif; font-size: 0.95rem; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;
    margin-bottom: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 6px 24px rgba(99, 102, 241, 0.3);
    overflow: hidden;
}
@keyframes btnShimmer {
    0%,100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
.bio-scan-btn-glow {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, transparent, rgba(255,255,255,0.15), transparent);
    opacity: 0; transition: opacity 0.3s;
}
.bio-scan-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 36px rgba(99,102,241,0.4); }
.bio-scan-btn:hover .bio-scan-btn-glow { opacity: 1; }
.bio-scan-btn:active { transform: translateY(-1px); }
.bio-scan-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; animation: none; }
.bio-scan-btn svg { width: 22px; height: 22px; }

/* ─── Alert ─── */
.bio-alert {
    position: relative; z-index: 1;
    padding: 14px 20px; border-radius: 16px; text-align: center;
    font-size: 0.82rem; font-weight: 600;
    display: none; margin-bottom: 12px;
}
.bio-alert.show { display: block; animation: alertPop 0.4s cubic-bezier(0.34,1.56,0.64,1); }
.bio-alert.error {
    background: linear-gradient(135deg, #fff5f5, #fee2e2);
    color: #dc2626; border: 1px solid #fecaca;
}
.bio-alert.success {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    color: #059669; border: 1px solid #a7f3d0;
}
@keyframes alertPop { from{opacity:0;transform:scale(0.92)} to{opacity:1;transform:scale(1)} }

/* ─── Account Selection ─── */
.bio-select-area {
    display: none; flex-direction: column; gap: 12px;
    position: relative; z-index: 1; margin-bottom: 12px;
    padding: 20px; border-radius: 20px;
    background: linear-gradient(135deg, #ffffff, #f8f7ff);
    border: 1.5px solid rgba(99, 102, 241, 0.15);
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.08);
    animation: alertPop 0.4s ease;
}
.bio-select-area.active { display: flex; }
.select-header {
    font-size: 0.95rem; font-weight: 800; color: #1e1b4b;
    display: flex; align-items: center; gap: 8px;
}
.select-header svg { width: 20px; height: 20px; color: #6366f1; }
.select-sub { font-size: 0.75rem; color: #64748b; margin-bottom: 4px; }
.select-list { display: flex; flex-direction: column; gap: 8px; max-height: 200px; overflow-y: auto; }

.candidate-item {
    display: flex; align-items: center; gap: 12px; padding: 14px 16px;
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 16px; cursor: pointer; transition: all 0.25s ease;
}
.candidate-item:hover {
    background: #f5f3ff; border-color: #c7d2fe;
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.1);
}
.cand-avatar {
    width: 40px; height: 40px; border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #fff; font-size: 0.85rem; object-fit: cover;
}
img.cand-avatar { border-radius: 12px; }
.cand-info { flex: 1; }
.cand-name { font-size: 0.88rem; font-weight: 700; color: #1e1b4b; }
.cand-role {
    font-size: 0.6rem; font-weight: 800; text-transform: uppercase;
    padding: 3px 10px; border-radius: 8px;
}
.cand-role.admin { background: #fef3c7; color: #92400e; }
.cand-role.user { background: #ecfdf5; color: #065f46; }

/* ─── Footer Hint ─── */
.bio-footer-hint {
    position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-size: 0.68rem; color: #94a3b8; font-weight: 500;
    padding-top: 6px;
}
.bio-footer-hint svg { width: 14px; height: 14px; color: #10b981; flex-shrink: 0; }

/* ─── Pipe-step compat (alias for bio-step) ─── */
/* The JS uses .pipe-step class references, so we alias */

/* ═══ RESPONSIVE ═══ */
@media (max-width: 560px) {
    .bio-modal { 
        padding: 28px 20px 22px; 
        border-radius: 24px; 
        max-width: 100%; 
    }
    .bio-hero h2 { font-size: 1.25rem; }
    .bio-icon-bubble { width: 52px; height: 52px; border-radius: 18px; }
    .bio-icon-bubble svg { width: 24px; height: 24px; }
    .step-text { display: none; }
    .bio-step-line { width: 24px; }
    .bio-progress-row { padding: 10px 20px; }
}

/* ═══ DARK MODE SUPPORT ═══ */
body.dark-mode .bio-modal {
    background: linear-gradient(160deg, #1e1b4b 0%, #0f172a 40%, #1e1b4b 100%);
    box-shadow:
        0 25px 60px -15px rgba(0, 0, 0, 0.5),
        0 0 0 1px rgba(99, 102, 241, 0.15),
        0 0 100px -30px rgba(139, 92, 246, 0.2);
}
body.dark-mode .bio-close {
    background: rgba(30, 27, 75, 0.8); border-color: rgba(99, 102, 241, 0.15);
    color: #94a3b8;
}
body.dark-mode .bio-close:hover { background: rgba(239, 68, 68, 0.15); color: #f87171; border-color: rgba(239,68,68,0.2); }
body.dark-mode .bio-hero h2 { color: #f1f5f9; }
body.dark-mode .bio-hero p { color: #818cf8; }
body.dark-mode .bio-progress-row {
    background: rgba(30, 27, 75, 0.5);
    border-color: rgba(99, 102, 241, 0.1);
}
body.dark-mode .step-num { background: #334155; color: #64748b; }
body.dark-mode .step-text { color: #64748b; }
body.dark-mode .bio-step-line { background: #334155; }
body.dark-mode .bio-step.active .step-text { color: #818cf8; }
body.dark-mode .bio-step.done .step-text { color: #34d399; }
body.dark-mode .bio-alert.error {
    background: rgba(239, 68, 68, 0.1); color: #f87171; border-color: rgba(239,68,68,0.2);
}
body.dark-mode .bio-alert.success {
    background: rgba(16, 185, 129, 0.1); color: #34d399; border-color: rgba(16,185,129,0.2);
}
body.dark-mode .bio-select-area {
    background: linear-gradient(135deg, #1e1b4b, #0f172a);
    border-color: rgba(99, 102, 241, 0.2);
}
body.dark-mode .select-header { color: #f1f5f9; }
body.dark-mode .select-sub { color: #94a3b8; }
body.dark-mode .candidate-item {
    background: rgba(30, 27, 75, 0.5); border-color: rgba(99, 102, 241, 0.1);
}
body.dark-mode .candidate-item:hover {
    background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.3);
}
body.dark-mode .cand-name { color: #f1f5f9; }
body.dark-mode .cand-role.admin { background: rgba(239,68,68,0.15); color: #f87171; }
body.dark-mode .cand-role.user { background: rgba(16,185,129,0.15); color: #34d399; }
body.dark-mode .bio-footer-hint { color: #64748b; }
body.dark-mode .bio-blob-1 { background: radial-gradient(circle, rgba(99,102,241,0.15), transparent 70%); }
body.dark-mode .bio-blob-2 { background: radial-gradient(circle, rgba(139,92,246,0.12), transparent 70%); }
body.dark-mode .bio-blob-3 { background: radial-gradient(circle, rgba(59,130,246,0.08), transparent 70%); }
</style>
