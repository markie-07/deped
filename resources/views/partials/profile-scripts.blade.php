@php $user = Auth::user(); @endphp
<div class="toast-container" id="toastContainer"></div>

<!-- Photo Viewer Lightbox -->
<div id="photoLightbox" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.85); backdrop-filter:blur(8px); align-items:center; justify-content:center; cursor:pointer;" onclick="closeLightbox()">
    <img id="lightboxImg" src="" style="max-width:90vw; max-height:85vh; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.4); object-fit:contain;">
    <button type="button" onclick="closeLightbox()" style="position:absolute; top:24px; right:24px; width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2); color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; backdrop-filter:blur(8px); transition:all 0.2s;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
    </button>
</div>

<script>
    // ═══ STATE MANAGEMENT ═══
    let initialFormData = {};
    function captureInitialData() {
        const form = document.getElementById('profileForm');
        const fd = new FormData(form);
        initialFormData = {};
        for (let [key, value] of fd.entries()) {
            // Only track identity fields, not passwords or tokens
            if (!['current_password', 'password', 'password_confirmation', '_token'].includes(key) && !(value instanceof File)) {
                initialFormData[key] = value;
            }
        }
    }
    function cancelPasswordChange() {
        // Hide new password section and strength meter
        document.getElementById('newPasswordSection').style.display = 'none';
        
        const pStrength = document.getElementById('passwordStrength');
        const sLabel = document.getElementById('strengthLabel');
        if (pStrength) pStrength.style.display = 'none';
        if (sLabel) sLabel.style.display = 'none';
        
        // Reset and show current password input
        const cpwInput = document.getElementById('inputCurrentPassword');
        cpwInput.value = '';
        cpwInput.readOnly = false;
        cpwInput.style.opacity = '1';
        
        // Reset and clear new password inputs
        document.getElementById('inputPassword').value = '';
        document.getElementById('inputPasswordConfirm').value = '';
        
        // Manage buttons
        const vBtn = document.getElementById('verifyBtn');
        const sBtn = document.getElementById('saveBtn');
        const cBtn = document.getElementById('cancelSecurityBtn');

        vBtn.style.display = 'flex';
        vBtn.disabled = false;
        vBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg> Verify Identity';
        
        if (sBtn) sBtn.style.display = 'none';
        if (cBtn) cBtn.style.display = 'none';
        
        clearErrors();
    }

    document.addEventListener('DOMContentLoaded', captureInitialData);

    // ═══ TAB SWITCHING ═══
    function switchTab(tabId, btn) {
        // Remove active class from all buttons and panes
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        
        // Add active class to current selection
        btn.classList.add('active');
        document.getElementById(tabId + 'Tab').classList.add('active');
        
        // Handle Action Buttons visibility
        const sBtn = document.getElementById('saveBtn'), vBtn = document.getElementById('verifyBtn');
        const cBtn = document.getElementById('cancelSecurityBtn');
        const isVerified = document.getElementById('newPasswordSection').style.display === 'block';
        
        if (tabId === 'security') {
            if (isVerified) {
                sBtn.style.display = 'flex';
                vBtn.style.display = 'none';
                cBtn.style.display = 'flex';
            } else {
                sBtn.style.display = 'none';
                vBtn.style.display = 'flex';
                cBtn.style.display = 'none';
            }
        } else {
            sBtn.style.display = 'flex';
            vBtn.style.display = 'none';
            cBtn.style.display = 'none';
        }
        
        // Scroll to alignment if needed
        window.scrollTo({ top: document.querySelector('.main-col').offsetTop - 100, behavior: 'smooth' });
    }

    // ═══ DROPDOWN TOGGLE FUNCTIONS ═══
    function closeAllDropdowns() {
        document.querySelectorAll('.photo-dropdown').forEach(d => d.classList.remove('open'));
    }

    function toggleCoverDropdown(e) {
        // Don't toggle if clicking on dropdown items or file input
        if (e.target.closest('.photo-dropdown') || e.target.closest('input[type="file"]')) return;
        e.stopPropagation();
        const dd = document.getElementById('coverDropdown');
        const isOpen = dd.classList.contains('open');
        closeAllDropdowns();
        if (!isOpen) dd.classList.add('open');
    }

    function toggleAvatarDropdown(e) {
        if (e.target.closest('.photo-dropdown') || e.target.closest('input[type="file"]')) return;
        e.stopPropagation();
        const dd = document.getElementById('avatarDropdown');
        const isOpen = dd.classList.contains('open');
        closeAllDropdowns();
        if (!isOpen) dd.classList.add('open');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.profile-cover') && !e.target.closest('.avatar-wrap')) {
            closeAllDropdowns();
        }
    });

    // ═══ VIEW PHOTO LIGHTBOX ═══
    function viewPhoto(type) {
        closeAllDropdowns();
        const lb = document.getElementById('photoLightbox');
        const img = document.getElementById('lightboxImg');
        if (type === 'cover') {
            const coverWrap = document.getElementById('coverPhotoWrap');
            const bgImage = coverWrap.style.backgroundImage;
            const url = bgImage.replace(/^url\(['"]?/, '').replace(/['"]?\)$/, '');
            img.src = url;
        } else {
            const avatarImg = document.getElementById('avatarPreview');
            if (avatarImg && avatarImg.src && avatarImg.style.display !== 'none') {
                img.src = avatarImg.src;
            } else {
                showToast('No Photo', 'No profile photo has been set yet.', 'error');
                return;
            }
        }
        lb.style.display = 'flex';
    }

    function closeLightbox() {
        document.getElementById('photoLightbox').style.display = 'none';
    }

    // Close lightbox on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
            closeAllDropdowns();
        }
    });
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const eye = btn.querySelector('.eye-icon'), eyeOff = btn.querySelector('.eye-off-icon');
        if (input.type === 'password') { input.type = 'text'; eye.style.display = 'none'; eyeOff.style.display = 'block'; btn.title = 'Hide password'; }
        else { input.type = 'password'; eye.style.display = 'block'; eyeOff.style.display = 'none'; btn.title = 'Show password'; }
    }

    document.getElementById('inputPassword').addEventListener('input', function() {
        const val = this.value, c = document.getElementById('passwordStrength'), l = document.getElementById('strengthLabel');
        const bars = [document.getElementById('str1'),document.getElementById('str2'),document.getElementById('str3'),document.getElementById('str4')];
        if (!val) { c.style.display = 'none'; l.style.display = 'none'; return; }
        c.style.display = 'flex'; l.style.display = 'block';
        let s = 0; if (val.length >= 8) s++; if (/[A-Z]/.test(val)) s++; if (/[0-9]/.test(val)) s++; if (/[^A-Za-z0-9]/.test(val)) s++;
        const lv = ['','weak','fair','good','strong'], lb = ['','Weak','Fair','Good','Strong'], cl = ['','#ef4444','#f59e0b','#22c55e','#10b981'];
        bars.forEach((b,i) => { b.className = 'pw-bar'; if (i < s) b.classList.add(lv[s]); });
        l.textContent = lb[s] || ''; l.style.color = cl[s] || '#64748b';
    });

    function showToast(title, msg, type = 'success') {
        const c = document.getElementById('toastContainer'), t = document.createElement('div');
        t.className = `toast ${type}`;
        let icon = '';
        if (type === 'success') {
            icon = '<svg class="toast-icon" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        } else if (type === 'error') {
            icon = '<svg class="toast-icon" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        } else {
            icon = '<svg class="toast-icon" fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        }
        t.innerHTML = `${icon}<div><div class="toast-title">${title}</div><div class="toast-msg">${msg}</div></div>`;
        c.appendChild(t); setTimeout(() => t.classList.add('show'), 10);
        setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 4000);
    }

    async function verifyCurrentPassword() {
        const input = document.getElementById('inputCurrentPassword'), btn = document.getElementById('verifyBtn');
        if (!input || !btn) return;
        
        const val = input.value;
        if (!val) { showToast('Error', 'Please enter your current password.', 'error'); return; }
        
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span style="width:18px;height:18px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;display:inline-block;animation:spin 0.8s linear infinite;"></span>';
        
        try {
            const res = await fetch('{{ url("/api/profile/verify-password") }}', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ password: val })
            });
            const data = await res.json();
            if (data.success) {
                showToast('Success', 'Password verified. You can now set a new password.');
                
                // Show new password fields
                const newPassSec = document.getElementById('newPasswordSection');
                if (newPassSec) newPassSec.style.display = 'block';
                
                input.readOnly = true;
                input.style.opacity = '0.7';
                
                // Switch buttons
                btn.style.display = 'none';
                const sBtn = document.getElementById('saveBtn');
                const cBtn = document.getElementById('cancelSecurityBtn');
                if (sBtn) sBtn.style.display = 'flex';
                if (cBtn) cBtn.style.display = 'flex';
            } else {
                showToast('Verification Failed', data.message || 'Incorrect password.', 'error');
                btn.innerHTML = orig;
                btn.disabled = false;
                showFieldError('current_password', 'Incorrect password.');
            }
        } catch(err) {
            console.error(err);
            showToast('Error', 'Failed to communicate with server.', 'error');
            btn.innerHTML = orig;
            btn.disabled = false;
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size > 2*1024*1024) { showToast('Error','Image must be under 2MB.','error'); input.value=''; return; }
            const r = new FileReader();
            r.onload = function(e) {
                const p = document.getElementById('avatarPreview'), ph = document.getElementById('avatarPlaceholder');
                if (p) { p.src = e.target.result; p.style.display = 'block'; }
                if (ph) ph.style.display = 'none';
            }; r.readAsDataURL(input.files[0]);
            // Auto-upload profile image immediately
            uploadPhoto('profile_image', input.files[0]);
        }
    }

    function previewCover(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size > 4*1024*1024) { showToast('Error','Cover image must be under 4MB.','error'); input.value=''; return; }
            const r = new FileReader();
            r.onload = function(e) {
                const wrap = document.getElementById('coverPhotoWrap');
                if (wrap) wrap.style.backgroundImage = `url('${e.target.result}')`;
            }; r.readAsDataURL(input.files[0]);
            // Auto-upload cover image immediately
            uploadPhoto('cover_image', input.files[0]);
        }
    }

    async function uploadPhoto(fieldName, file) {
        const fd = new FormData();
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fd.append(fieldName, file);
        // Also send required fields from the form so validation passes
        fd.append('username', document.getElementById('inputUsername').value);
        fd.append('first_name', document.getElementById('inputFirstName').value);
        fd.append('last_name', document.getElementById('inputLastName').value);
        fd.append('email', document.getElementById('inputEmail').value);
        fd.append('position', document.getElementById('inputPosition').value || '');
        fd.append('middle_name', document.getElementById('inputMiddleName').value || '');
        fd.append('suffix', document.getElementById('inputSuffix').value || '');

        try {
            const res = await fetch('{{ url("/api/profile/update") }}', {
                method: 'POST',
                body: fd,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                showToast('Success', fieldName === 'cover_image' ? 'Cover photo updated!' : 'Profile photo updated!');
                // Update cover image URL from server
                if (data.user.cover_image) {
                    const coverWrap = document.getElementById('coverPhotoWrap');
                    if (coverWrap) {
                        coverWrap.style.backgroundImage = `url('{{ url('/storage') }}/${data.user.cover_image}')`;
                        coverWrap.style.backgroundPosition = `${data.user.cover_offset_x}% ${data.user.cover_offset_y}%`;
                        coverWrap.style.backgroundSize = `${data.user.cover_zoom * 100}%`;
                    }
                }
                // Update sidebar/navbar profile images
                if (data.user.profile_image) {
                    const imgUrl = '{{ url('/storage') }}/' + data.user.profile_image;
                    const pImg = document.getElementById('avatarPreview');
                    if (pImg) pImg.style.transform = `translate(${data.user.profile_offset_x}px, ${data.user.profile_offset_y}px) scale(${data.user.profile_zoom})`;
                    
                    document.querySelectorAll('.sidebar .profile-avatar').forEach(el => {
                        if (el.tagName === 'IMG') el.src = imgUrl;
                    });
                    document.querySelectorAll('.navbar-user-avatar').forEach(el => {
                        if (el.tagName === 'IMG') el.src = imgUrl;
                    });
                }
            } else {
                showToast('Error', data.message || 'Failed to upload photo.', 'error');
            }
        } catch(err) {
            console.error(err);
            showToast('Error', 'Failed to communicate with server.', 'error');
        }
    }

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => { el.classList.remove('visible'); el.textContent = ''; });
        document.querySelectorAll('.f-input-wrap.error').forEach(el => el.classList.remove('error'));
    }
    function showFieldError(field, msg) {
        const e = document.getElementById('err-'+field), i = document.querySelector(`[name="${field}"]`);
        if (e) { e.textContent = msg; e.classList.add('visible'); }
        if (i) i.closest('.f-input-wrap').classList.add('error');
    }

    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        const isSecurityTab = document.getElementById('securityTab').classList.contains('active');
        const isVerified = document.getElementById('newPasswordSection').style.display === 'block';
        if (isSecurityTab && !isVerified) {
            verifyCurrentPassword();
            return;
        }

        const usernameInput = document.getElementById('inputUsername');
        const wasDisabled = usernameInput.disabled;
        if (wasDisabled) usernameInput.disabled = false;
        const currentFd = new FormData(this);
        if (wasDisabled) usernameInput.disabled = true;

        // Check if anything actually changed
        let isDirty = false;
        for (let [key, value] of currentFd.entries()) {
            if (['password', 'profile_image', 'cover_image'].includes(key) && value && (typeof value === 'string' ? value.length > 0 : value.size > 0)) {
                isDirty = true; break; 
            }
            if (initialFormData.hasOwnProperty(key) && initialFormData[key] !== value) {
                isDirty = true; break;
            }
        }

        if (!isDirty) {
            showToast('Note', 'No changes detected to save.', 'info');
            return;
        }

        clearErrors();
        const pw = document.getElementById('inputPassword').value, pwc = document.getElementById('inputPasswordConfirm').value;
        const cpw = document.getElementById('inputCurrentPassword').value;
        let err = false;
        if (pw && !cpw) { showFieldError('current_password','Current password is required to change password.'); err = true; }
        if (pw && pw.length < 8) { showFieldError('password','Password must be at least 8 characters.'); err = true; }
        if (pw && pw !== pwc) { showFieldError('password_confirmation','Passwords do not match.'); err = true; }
        if (!document.getElementById('inputUsername').value.trim()) { showFieldError('username','Username is required.'); err = true; }
        if (!document.getElementById('inputFirstName').value.trim()) { showFieldError('first_name','First name is required.'); err = true; }
        if (!document.getElementById('inputLastName').value.trim()) { showFieldError('last_name','Last name is required.'); err = true; }
        if (!document.getElementById('inputEmail').value.trim()) { showFieldError('email','Email is required.'); err = true; }
        if (err) return;
        const btn = document.getElementById('saveBtn'), orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span style="width:18px;height:18px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;display:inline-block;animation:spin 0.8s linear infinite;margin-right:8px;"></span> Saving...';
        try {
            const res = await fetch('{{ url("/api/profile/update") }}', { method:'POST', body: currentFd, headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' } });
            const data = await res.json();
            if (data.success) {
                showToast('Success','Profile updated successfully!');
                const fn = data.user.first_name||'', ln = data.user.last_name||'';
                document.getElementById('heroNameDisplay').textContent = (fn+' '+ln).trim() || data.user.username;
                const sn = document.querySelector('.sidebar .profile-name'), sr = document.querySelector('.sidebar .profile-role');
                const nn = document.querySelector('.navbar-user-name'), nr = document.querySelector('.navbar-user-role');
                if (sn) sn.textContent = data.user.username || data.user.name;
                if (sr) sr.textContent = data.user.position || 'User';
                if (nn) nn.textContent = data.user.username || data.user.name;
                if (nr) nr.textContent = data.user.position || 'User';
                if (!data.user.profile_image) {
                    const init = (data.user.username||data.user.name||'U').charAt(0).toUpperCase();
                    const sa = document.querySelector('.sidebar .profile-avatar:not(img)'), na = document.querySelector('.navbar-user-avatar:not(img)');
                    if (sa && !sa.tagName.match(/img/i)) sa.textContent = init;
                    if (na && !na.tagName.match(/img/i)) na.textContent = init;
                }
                // Update cover image if returned
                if (data.user.cover_image) {
                    const coverWrap = document.getElementById('coverPhotoWrap');
                    if (coverWrap) coverWrap.style.backgroundImage = `url('{{ url('/storage') }}/${data.user.cover_image}')`;
                }
                // Update initial state for next dirty check
                captureInitialData();
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => showFieldError(key, data.errors[key][0]));
                } else {
                    showToast('Update Failed', data.message || 'Error occurred.', 'error');
                }
            }
        } catch (err) {
            console.error(err);
            showToast('Error', 'Network error. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = orig;
        }
    });

    document.querySelectorAll('#profileForm input').forEach(input => {
        input.addEventListener('input', function() {
            const w = this.closest('.f-input-wrap'), e = document.getElementById('err-'+this.name);
            if (w) w.classList.remove('error');
            if (e) { e.classList.remove('visible'); e.textContent = ''; }
        });
    });
    // ═══ REPOSITION LOGIC ═══
    let repoState = {
        type: '', x: 0, y: 0, zoom: 1,
        isDragging: false, startX: 0, startY: 0,
        imgW: 0, imgH: 0, vpW: 0, vpH: 0
    };

    function openRepositionModal(type) {
        closeAllDropdowns();
        repoState.type = type;
        const modal = document.getElementById('repositionModal');
        const img = document.getElementById('repoImage');
        const overlay = document.getElementById('repoOverlay');
        const zoomInput = document.getElementById('repoZoom');

        let src = '';
        if (type === 'cover') {
            const bg = document.getElementById('coverPhotoWrap').style.backgroundImage;
            src = bg.replace(/^url\(['"]?/, '').replace(/['"]?\)$/, '');
            overlay.style.borderRadius = '20px'; // Rounded rect for cover
            // Get current values if already set, otherwise from PHP
            let valX = parseFloat('{{ $user->cover_offset_x }}');
            let valY = parseFloat('{{ $user->cover_offset_y }}');
            let valZ = parseFloat('{{ $user->cover_zoom }}');
            repoState.x = isNaN(valX) ? 50 : valX;
            repoState.y = isNaN(valY) ? 50 : valY;
            repoState.zoom = isNaN(valZ) ? 1 : valZ;
        } else {
            const pImg = document.getElementById('avatarPreview');
            src = pImg ? pImg.src : '';
            overlay.style.borderRadius = '50%'; // Circle for avatar
            let valX = parseFloat('{{ $user->profile_offset_x }}');
            let valY = parseFloat('{{ $user->profile_offset_y }}');
            let valZ = parseFloat('{{ $user->profile_zoom }}');
            repoState.x = isNaN(valX) ? 0 : valX;
            repoState.y = isNaN(valY) ? 0 : valY;
            repoState.zoom = isNaN(valZ) ? 1 : valZ;
        }

        if (!src || src.includes('images.unsplash.com')) { 
            showToast('Note', 'Please change the photo first before repositioning.', 'error'); 
            return; 
        }

        img.src = src;
        zoomInput.value = repoState.zoom;
        modal.style.display = 'flex';

        img.onload = function() {
            repoState.imgW = img.naturalWidth;
            repoState.imgH = img.naturalHeight;
            const vp = document.getElementById('repoViewport');
            repoState.vpW = vp.offsetWidth;
            repoState.vpH = vp.offsetHeight;
            updateRepoTransform();
        };
    }

    function closeRepositionModal() {
        document.getElementById('repositionModal').style.display = 'none';
        repoState.isDragging = false;
    }

    function updateRepoTransform() {
        const img = document.getElementById('repoImage');
        if (!img) return;
        if (repoState.type === 'cover') {
            img.style.left = '50%';
            img.style.top = '50%';
            img.style.transform = `translate(-${repoState.x}%, -${repoState.y}%) scale(${repoState.zoom})`;
        } else {
            img.style.left = '50%';
            img.style.top = '50%';
            img.style.transform = `translate(calc(-50% + ${repoState.x}px), calc(-50% + ${repoState.y}px)) scale(${repoState.zoom})`;
        }
    }

    const repoViewport = document.getElementById('repoViewport');
    
    function handleDragStart(e) {
        repoState.isDragging = true;
        const clientX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
        const clientY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;
        repoState.startX = clientX;
        repoState.startY = clientY;
        repoViewport.style.cursor = 'grabbing';
    }

    function handleDragMove(e) {
        if (!repoState.isDragging) return;
        const clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
        const clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
        
        const dx = clientX - repoState.startX;
        const dy = clientY - repoState.startY;

        if (repoState.type === 'cover') {
            // Adjust sensitivity based on zoom
            const sensitivity = 0.5; 
            repoState.x -= (dx / repoState.vpW) * 100 * sensitivity;
            repoState.y -= (dy / repoState.vpH) * 100 * sensitivity;
            repoState.x = Math.max(0, Math.min(100, repoState.x));
            repoState.y = Math.max(0, Math.min(100, repoState.y));
        } else {
            repoState.x += dx;
            repoState.y += dy;
        }

        repoState.startX = clientX;
        repoState.startY = clientY;
        updateRepoTransform();
    }

    function handleDragEnd() {
        repoState.isDragging = false;
        repoViewport.style.cursor = 'move';
    }

    repoViewport.addEventListener('mousedown', handleDragStart);
    window.addEventListener('mousemove', handleDragMove);
    window.addEventListener('mouseup', handleDragEnd);

    repoViewport.addEventListener('touchstart', handleDragStart, { passive: true });
    window.addEventListener('touchmove', handleDragMove, { passive: false });
    window.addEventListener('touchend', handleDragEnd);

    document.getElementById('repoZoom').addEventListener('input', function() {
        repoState.zoom = parseFloat(this.value);
        updateRepoTransform();
    });

    async function saveReposition() {
        const btn = document.getElementById('saveRepoBtn');
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span style="width:18px;height:18px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;display:inline-block;animation:spin 0.8s linear infinite;"></span> Saving...';

        const fd = new FormData();
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        fd.append('username', document.getElementById('inputUsername').value);
        fd.append('first_name', document.getElementById('inputFirstName').value);
        fd.append('last_name', document.getElementById('inputLastName').value);
        fd.append('email', document.getElementById('inputEmail').value);
        fd.append('position', document.getElementById('inputPosition').value || '');
        fd.append('middle_name', document.getElementById('inputMiddleName').value || '');
        fd.append('suffix', document.getElementById('inputSuffix').value || '');

        if (repoState.type === 'cover') {
            fd.append('cover_offset_x', repoState.x);
            fd.append('cover_offset_y', repoState.y);
            fd.append('cover_zoom', repoState.zoom);
        } else {
            fd.append('profile_offset_x', repoState.x);
            fd.append('profile_offset_y', repoState.y);
            fd.append('profile_zoom', repoState.zoom);
        }

        try {
            const res = await fetch('{{ url("/api/profile/update") }}', {
                method: 'POST',
                body: fd,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                showToast('Success', 'Profile photo positioning saved!');
                // Wait a bit then refresh to show updated values in PHP
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showToast('Error', data.message || 'Failed to save position.', 'error');
                btn.disabled = false;
                btn.innerHTML = orig;
            }
        } catch(err) {
            console.error(err);
            showToast('Error', 'Server communication failed.', 'error');
            btn.disabled = false;
            btn.innerHTML = orig;
        }
    }
</script>
