@php $user = Auth::user(); $isAdmin = $user?->role === 'admin'; @endphp
<div class="profile-page">
    <form id="profileForm" enctype="multipart/form-data">
        @csrf

        <!-- ═══ COVER PHOTO ═══ -->
        <div class="profile-cover" id="coverPhotoWrap" onclick="toggleCoverDropdown(event)" style="background-image: url('{{ $user && $user->cover_image ? url('/storage/' . $user->cover_image) : 'https://images.unsplash.com/photo-1557683316-973673baf926?w=1400&h=400&fit=crop&crop=center' }}'); background-position: {{ $user->cover_offset_x }}% {{ $user->cover_offset_y }}%; background-size: {{ $user->cover_zoom * 100 }}%;">
            <div class="cover-overlay"></div>
            <div class="cover-gradient-bottom"></div>
            <div class="cover-shimmer"></div>
            <!-- Cover Photo Dropdown -->
            <div class="photo-dropdown cover-dropdown" id="coverDropdown">
                <button type="button" class="photo-dropdown-item" onclick="viewPhoto('cover')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    View Cover Photo
                </button>
                <div class="photo-dropdown-divider"></div>
                <button type="button" class="photo-dropdown-item" onclick="openRepositionModal('cover')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                    Reposition Cover
                </button>
                <div class="photo-dropdown-divider"></div>
                <button type="button" class="photo-dropdown-item" onclick="document.getElementById('cover_image').click()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/></svg>
                    Change Cover Photo
                </button>
            </div>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" style="display:none;" onchange="previewCover(this)">
        </div>

        <!-- ═══ PROFILE HEADER ═══ -->
        <div class="profile-header-card">
            <div class="phc-top">
                <div class="avatar-wrap" onclick="toggleAvatarDropdown(event)">
                    <div class="avatar-ring">
                        <div class="avatar-inner">
                            @if($user && $user->profile_image)
                                <img src="{{ url('/storage/' . $user->profile_image) }}" id="avatarPreview" style="transform: translate({{ $user->profile_offset_x }}px, {{ $user->profile_offset_y }}px) scale({{ $user->profile_zoom }});">
                            @elseif($user)
                                <span class="avatar-initial" id="avatarPlaceholder">{{ strtoupper(substr($user->username ?? $user->name ?? 'U', 0, 1)) }}</span>
                                <img src="" id="avatarPreview" style="display:none; width:100%; height:100%; object-fit:cover; transform: translate({{ $user->profile_offset_x }}px, {{ $user->profile_offset_y }}px) scale({{ $user->profile_zoom }});">
                            @else
                                <span class="avatar-initial">G</span>
                            @endif
                        </div>
                    </div>
                    <div class="avatar-cam">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/></svg>
                    </div>
                    <!-- Avatar Photo Dropdown -->
                    <div class="photo-dropdown avatar-dropdown" id="avatarDropdown">
                        <button type="button" class="photo-dropdown-item" onclick="viewPhoto('avatar')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            View Profile Photo
                        </button>
                        <div class="photo-dropdown-divider"></div>
                        <button type="button" class="photo-dropdown-item" onclick="openRepositionModal('avatar')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                            Reposition Photo
                        </button>
                        <div class="photo-dropdown-divider"></div>
                        <button type="button" class="photo-dropdown-item" onclick="document.getElementById('profile_image').click()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/></svg>
                            Change Profile Photo
                        </button>
                    </div>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display:none;" onchange="previewImage(this)">
                </div>
                <div class="phc-info">
                    <h1 class="phc-name" id="heroNameDisplay">
                        @if($user && ($user->first_name || $user->last_name))
                            {{ $user->first_name }} {{ $user->last_name }}
                        @else
                            {{ $user?->username ?? 'Guest' }}
                        @endif
                    </h1>
                    <p class="phc-meta">
                        <span>{{ $user?->position ?? 'User' }}</span>
                        <span class="phc-meta-dot"></span>
                        <span>{{ $user?->email }}</span>
                    </p>
                </div>
                <div class="phc-badges">
                    <div class="badge-active"><div class="pulse"></div> Active</div>
                    <div class="badge-role {{ $isAdmin ? 'admin' : 'user' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            @if($isAdmin)
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            @endif
                        </svg>
                        {{ $isAdmin ? 'Administrator' : 'Standard User' }}
                    </div>
                </div>
            </div>
            <div class="phc-stats">
                <div class="phc-stat"><span class="phc-stat-num">{{ $user && $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span><span class="phc-stat-label">Member Since</span></div>
                <div class="phc-stat"><span class="phc-stat-num">{{ $user?->username ?? '—' }}</span><span class="phc-stat-label">Username</span></div>
                <div class="phc-stat"><span class="phc-stat-num">{{ $user?->position ?? '—' }}</span><span class="phc-stat-label">Position</span></div>
            </div>
        </div>

        <!-- ═══ CONTENT GRID ═══ -->
        <div class="profile-grid">
            <div class="main-col">
                <!-- Tab Navigation -->
                <div class="tab-nav">
                    <button type="button" class="tab-btn active" onclick="switchTab('personal', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                        Personal Details
                    </button>
                    <button type="button" class="tab-btn" onclick="switchTab('security', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 1.5h13.5c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H5.25a1.125 1.125 0 0 1-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125Z"/></svg>
                        Security
                    </button>
                </div>

                <!-- Personal Information Tab -->
                <div id="personalTab" class="tab-pane active">
                    <div class="pro-card">
                        <div class="pro-card-head">
                            <div class="pro-card-ico ico-indigo"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg></div>
                            <div><div class="pro-card-ttl">Personal Information</div><div class="pro-card-sub">Update your personal details and identity</div></div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group"><label class="f-label">Username</label><div class="f-input-wrap"><input type="text" name="username" id="inputUsername" value="{{ $user?->username }}" placeholder="Enter username" readonly disabled style="background-color: #f1f5f9; cursor: not-allowed; opacity: 0.7;"></div><div class="field-error" id="err-username"></div></div>
                            <div class="form-group"><label class="f-label">Position</label><div class="f-input-wrap"><input type="text" name="position" id="inputPosition" value="{{ $user?->position }}" placeholder="Enter position"></div></div>
                            <div class="form-group"><label class="f-label">First Name</label><div class="f-input-wrap"><input type="text" name="first_name" id="inputFirstName" value="{{ $user?->first_name }}" placeholder="Enter first name" required></div><div class="field-error" id="err-first_name"></div></div>
                            <div class="form-group"><label class="f-label">Last Name</label><div class="f-input-wrap"><input type="text" name="last_name" id="inputLastName" value="{{ $user?->last_name }}" placeholder="Enter last name" required></div><div class="field-error" id="err-last_name"></div></div>
                            <div class="form-group"><label class="f-label">Middle Name</label><div class="f-input-wrap"><input type="text" name="middle_name" id="inputMiddleName" value="{{ $user?->middle_name }}" placeholder="Optional"></div></div>
                            <div class="form-group"><label class="f-label">Suffix</label><div class="f-input-wrap"><input type="text" name="suffix" id="inputSuffix" value="{{ $user?->suffix }}" placeholder="e.g. Jr, III"></div></div>
                            <div class="form-group full"><label class="f-label">Email Address</label><div class="f-input-wrap"><input type="email" name="email" id="inputEmail" value="{{ $user?->email }}" placeholder="Enter email address" required></div><div class="field-error" id="err-email"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings Tab -->
                <div id="securityTab" class="tab-pane">
                    <div class="pro-card">
                        <div class="pro-card-head">
                            <div class="pro-card-ico ico-emerald"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-2.25 1.5h13.5c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H5.25a1.125 1.125 0 0 1-1.125-1.125v-6.75c0-.621.504-1.125 1.125-1.125Z"/></svg></div>
                            <div><div class="pro-card-ttl">Security Settings</div><div class="pro-card-sub">Manage your password and account security</div></div>
                        </div>
                        <div class="security-note">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                            <span>Leave the password fields empty if you don't want to change your current password.</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group full" id="currentPasswordGroup">
                                <label class="f-label">Current Password</label>
                                <div class="f-input-wrap">
                                    <input type="password" name="current_password" id="inputCurrentPassword" placeholder="Enter your current password to change password" autocomplete="current-password" style="padding-right: 40px;">
                                    <div class="f-input-btns" style="position: absolute; right: 0; top: 0; bottom: 0; display: flex; align-items: center; gap: 8px; padding-right: 12px; z-index: 5;">
                                        <button type="button" class="pw-toggle" onclick="togglePassword('inputCurrentPassword', this)" tabindex="-1" title="Show password" style="position: static; transform: none; color: #94a3b8; transition: color 0.2s; background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="eye-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="eye-off-icon" style="display:none; width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="field-error" id="err-current_password"></div>
                            </div>
                            <div id="newPasswordSection" style="display: none; grid-column: 1 / -1; width: 100%;">
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; width: 100%;">
                                    <div class="form-group">
                                        <label class="f-label">New Password</label>
                                        <div class="f-input-wrap">
                                            <input type="password" name="password" id="inputPassword" placeholder="Minimum 8 characters" autocomplete="new-password">
                                            <button type="button" class="pw-toggle" onclick="togglePassword('inputPassword', this)" tabindex="-1" title="Show password">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="eye-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="eye-off-icon" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                            </button>
                                        </div>
                                        <div class="pw-strength" id="passwordStrength" style="display:none;"><div class="pw-bar" id="str1"></div><div class="pw-bar" id="str2"></div><div class="pw-bar" id="str3"></div><div class="pw-bar" id="str4"></div></div>
                                        <div class="pw-label-text" id="strengthLabel" style="display:none;"></div>
                                        <div class="field-error" id="err-password"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="f-label">Confirm Password</label>
                                        <div class="f-input-wrap">
                                            <input type="password" name="password_confirmation" id="inputPasswordConfirm" placeholder="Repeat new password" autocomplete="new-password">
                                            <button type="button" class="pw-toggle" onclick="togglePassword('inputPasswordConfirm', this)" tabindex="-1" title="Show password">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="eye-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="eye-off-icon" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                            </button>
                                        </div>
                                        <div class="field-error" id="err-password_confirmation"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel-profile" id="cancelSecurityBtn" style="display: none;" onclick="cancelPasswordChange()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        Cancel
                    </button>

                    <button type="button" class="btn-save" id="verifyBtn" style="display: none;" onclick="verifyCurrentPassword()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                        Verify Identity
                    </button>
                    <button type="submit" class="btn-save" id="saveBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        Save Changes
                    </button>
                </div>
            </div>

            <!-- ═══ SIDEBAR ═══ -->
            <div class="side-col">
                <div class="pro-card">
                    <div class="pro-card-head">
                        <div class="pro-card-ico ico-amber"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg></div>
                        <div><div class="pro-card-ttl">Account Details</div></div>
                    </div>
                    <div class="info-row">
                        <div class="ir-ico ir-green"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg></div>
                        <div class="ir-text"><div class="ir-label">Username</div><div class="ir-value">{{ $user?->username ?? '—' }}</div></div>
                    </div>
                    <div class="info-row">
                        <div class="ir-ico ir-purple"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/></svg></div>
                        <div class="ir-text"><div class="ir-label">Position</div><div class="ir-value">{{ $user?->position ?? '—' }}</div></div>
                    </div>
                    <div class="info-row">
                        <div class="ir-ico ir-blue"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg></div>
                        <div class="ir-text"><div class="ir-label">Email</div><div class="ir-value">{{ $user?->email ?? '—' }}</div></div>
                    </div>
                    <div class="info-row">
                        <div class="ir-ico ir-amber"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg></div>
                        <div class="ir-text"><div class="ir-label">Joined</div><div class="ir-value">{{ $user && $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}</div></div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- ═══ REPOSITION MODAL ═══ -->
    <div id="repositionModal" class="light-box" style="display:none; z-index: 9999; animation: fadeIn 0.3s ease-out;">
        <div class="lb-inner" style="max-width: 600px; width: 90%; background: #1a1a2e; border-radius: 32px; padding: 40px; border: 1px solid rgba(255,255,255,0.1); position: relative; display: flex; flex-direction: column; align-items: center; gap: 24px; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.8);">
            <button type="button" class="lb-close" onclick="closeRepositionModal()" style="top: 24px; right: 24px; background: rgba(255,255,255,0.05); width: 44px; height: 44px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.1); color: #fff; font-size: 28px; line-height: 40px; text-align: center; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
            
            <div style="text-align: center;">
                <h2 style="color: #fff; margin: 0; font-size: 24px; font-weight: 700; margin-bottom: 8px;">Edit Photo</h2>
                <p style="color: #8892a4; margin: 0; font-size: 15px;">Drag to reposition and use the slider to zoom</p>
            </div>
            
            <div id="repoViewport" style="width: 100%; height: 320px; position: relative; overflow: hidden; background: #000; border-radius: 20px; cursor: move; user-select: none;">
                <img id="repoImage" src="" style="position: absolute; pointer-events: none; max-width: none; will-change: transform;">
                <div id="repoOverlay" style="position: absolute; inset: 0; pointer-events: none; box-shadow: 0 0 0 9999px rgba(0,0,0,0.7); outline: 2px solid rgba(255,255,255,0.3); outline-offset: -2px;"></div>
            </div>

            <div style="width: 100%; display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="rgba(255,255,255,0.5)" style="width:20px; height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6"/></svg>
                    <input type="range" id="repoZoom" min="1" max="3" step="0.01" value="1" style="flex: 1; accent-color: #6366f1; height: 6px; border-radius: 3px; cursor: pointer; background: rgba(255,255,255,0.1);">
                </div>
                
                <div style="display: flex; gap: 16px; width: 100%; padding-top: 8px;">
                    <button type="button" onclick="closeRepositionModal()" style="flex: 1; height: 52px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); background: transparent; color: #fff; font-weight: 600; cursor: pointer; transition: all 0.3s;">Cancel</button>
                    <button type="button" id="saveRepoBtn" onclick="saveReposition()" style="flex: 1.5; height: 52px; border-radius: 16px; border: none; background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; font-weight: 600; cursor: pointer; box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <span>Apply Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
