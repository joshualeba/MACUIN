@extends('app')

@push('styles')
<style>
    .profile-container {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    
    .profile-sidebar {
        width: 100%;
        max-width: 320px;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
    }
    
    .profile-main {
        flex: 1;
        min-width: 300px;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    
    .profile-section {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
    }
    
    .profile-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--primary);
        color: #FFFFFF;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg-light);
        color: var(--text-main);
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Password wrapper */
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-wrapper .form-control {
        padding-right: 3rem;
    }
    .eye-btn-cl {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        z-index: 5;
        padding: 4px;
        transition: color 0.2s;
    }
    .eye-btn-cl:hover { color: var(--primary); }

    /* Validador contraseña */
    .pass-req-list {
        margin-top: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    .pass-req-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        transition: color 0.2s;
    }
    .pass-req-item.valid { color: #10B981; }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .profile-sidebar {
            max-width: 100%;
        }
    }
    
    .btn-save {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
    }
    
    .btn-save:hover {
        background: #2563EB;
        transform: translateY(-1px);
    }

    .btn-edit {
        background: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-edit:hover {
        background: rgba(59, 130, 246, 0.1);
    }
    
    .form-control:disabled {
        background: rgba(241, 245, 249, 0.5);
        color: var(--text-muted);
        cursor: not-allowed;
        border-color: rgba(226, 232, 240, 0.5);
    }

    body.dark-mode .form-control:disabled {
        background: rgba(30, 41, 59, 0.5);
        border-color: rgba(51, 65, 85, 0.5);
    }

    body.dark-mode .profile-avatar-large {
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    }
    body.dark-mode .btn-save {
        background: #FFFFFF;
        color: #000000;
    }
    body.dark-mode .btn-save:hover {
        background: #E2E8F0;
    }
    .phone-flex { display: flex; gap: 0.5rem; }
    .lada-select { width: 135px; flex-shrink: 0; text-align: center; padding: 0.75rem 0.5rem; cursor: pointer; }
    .btn-cancel { background: transparent; color: var(--text-muted); border: 1px solid var(--border); padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; }
    .btn-cancel:hover { background: rgba(0,0,0,0.05); }
    .sidebar-meta-item { text-align: left; margin-bottom: 0.75rem; }
    .sidebar-meta-label { display: block; font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 0.15rem; }
    .sidebar-meta-value { font-weight: 700; color: var(--text-main); font-size: 0.9rem; }
</style>
@endpush

@section('content')
<div class="gsap-container">
    <div class="page-title gsap-item">Mi perfil</div>
    <p class="gsap-item" style="color: var(--text-muted); margin-bottom: 2rem;">
        Gestiona tu información personal y preferencias de la cuenta.
    </p>

    <div class="profile-container">
        <!-- Barra lateral del perfil -->
        <aside class="profile-sidebar gsap-card">
            <div class="profile-avatar-large" id="sidebar-avatar">--</div>
            <h2 id="sidebar-name" style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Cargando...</h2>
            <p id="sidebar-email" style="color: var(--text-muted); margin-bottom: 2rem;">...</p>
            
            <div style="border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <div class="sidebar-meta-item">
                    <span class="sidebar-meta-label">Teléfono</span>
                    <strong class="sidebar-meta-value" id="sidebar-phone">N/A</strong>
                </div>
            </div>
        </aside>

        <!-- Formulario principal -->
        <div class="profile-main">
            <!-- Sección de información personal -->
            <section class="profile-section gsap-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.75rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin: 0;">
                        Información personal
                    </h3>
                    <button type="button" class="btn-edit" id="btn-toggle-edit" onclick="toggleEditProfile()">Editar perfil</button>
                </div>
                
                <form id="profile-form" onsubmit="saveProfile(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control profile-input" id="perfil-nombre" value="" required disabled oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="perfil-email" value="" required disabled style="cursor: not-allowed; opacity: 0.65;">
                            <small style="color: var(--text-muted); font-size: 0.78rem; margin-top: 0.3rem; display: block;">El correo electrónico no puede modificarse.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Teléfono de contacto (10 números)</label>
                            <div class="phone-flex">
                                <select id="p-lada" class="form-control lada-select profile-input" disabled>
                                    <option value="+52">MX +52</option>
                                    <option value="+1">US +1</option>
                                    <option value="+34">ES +34</option>
                                    <option value="+54">AR +54</option>
                                    <option value="+57">CO +57</option>
                                </select>
                                <input type="text" class="form-control profile-input" id="p-phone" value="" placeholder="10 dígitos" maxlength="10" disabled oninput="this.value = this.value.replace(/\D/g, '').substring(0, 10)">
                            </div>
                        </div>
                    </div>
                    
                    <div id="btn-save-container" style="margin-top: 1rem; display: none; gap: 1rem; justify-content: flex-end;">
                        <button type="button" class="btn-cancel" onclick="toggleEditProfile()">Cancelar</button>
                        <button type="submit" class="btn-save" id="btn-save-info">Guardar cambios</button>
                    </div>
                </form>
            </section>

            <!-- Sección de cambio de contraseña -->
            <section class="profile-section gsap-card">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.75rem;">
                    Seguridad
                </h3>
                
                <form id="security-form" onsubmit="changePassword(event)">
                    <div class="form-group">
                        <label class="form-label">Contraseña actual</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" id="cl-current-pass" placeholder="••••••••" required>
                            <button type="button" class="eye-btn-cl" onclick="togglePassVis('cl-current-pass', this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nueva contraseña</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="cl-new-pass" placeholder="Mínimo 8 caracteres" required oninput="validateCliPass(this.value)">
                                <button type="button" class="eye-btn-cl" onclick="togglePassVis('cl-new-pass', this)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmar nueva contraseña</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="cl-confirm-pass" placeholder="Repite tu nueva contraseña" required>
                                <button type="button" class="eye-btn-cl" onclick="togglePassVis('cl-confirm-pass', this)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pass-req-list">
                        <div class="pass-req-item" id="cli-req-length">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mínimo 8-25 caracteres
                        </div>
                        <div class="pass-req-item" id="cli-req-upper">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mínimo una letra mayúscula
                        </div>
                        <div class="pass-req-item" id="cli-req-special">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mínimo un carácter especial (@, #, $, %)
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem; text-align: right;">
                        <button type="submit" class="btn-save" id="btn-change-pass">Actualizar contraseña</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<script>
    let initialValues = {};
    let currentUserId = null;

    function togglePassVis(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
        const eyeClosed = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;
        if (input.type === 'password') { input.type = 'text'; btn.innerHTML = eyeClosed; }
        else { input.type = 'password'; btn.innerHTML = eyeOpen; }
    }

    function validateCliPass(pass) {
        const hasLength = pass.length >= 8 && pass.length <= 25;
        const hasUpper = /[A-Z]/.test(pass);
        const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pass);
        document.getElementById('cli-req-length').classList.toggle('valid', hasLength);
        document.getElementById('cli-req-upper').classList.toggle('valid', hasUpper);
        document.getElementById('cli-req-special').classList.toggle('valid', hasSpecial);
        return hasLength && hasUpper && hasSpecial;
    }

    async function loadClientProfile() {
        const userData = localStorage.getItem('macuin_user');
        if (!userData) return;

        const cached = JSON.parse(userData);
        currentUserId = cached.id;

        // Mostrar datos de caché inmediatamente
        updateCliUI(cached);

        try {
            // Obtener datos frescos de la API
            const res = await fetch(`http://localhost:8008/autenticacion/usuarios`);
            if(!res.ok) throw new Error("API Error");
            const allUsers = await res.json();
            const user = allUsers.find(u => u.id === currentUserId);
            
            if(user) {
                // Actualizar localStorage con datos frescos solo si existen
                const updatedUser = { ...cached, ...user };
                localStorage.setItem('macuin_user', JSON.stringify(updatedUser));
                updateCliUI(user);
            }
        } catch(e) {
            console.warn('Usando datos de caché (API no disponible)', e);
        }
    }

    function updateCliUI(user) {
        // Sidebar
        document.getElementById('sidebar-name').innerText = user.nombre || 'Usuario';
        document.getElementById('sidebar-email').innerText = user.email || '';
        document.getElementById('sidebar-phone').innerText = user.telefono || 'N/A';

        // Iniciales
        if (user.nombre) {
            const parts = user.nombre.split(' ').filter(p => p.trim() !== '');
            let initials = parts.length >= 2
                ? (parts[0][0] + parts[1][0]).toUpperCase()
                : parts[0]?.substring(0, 2).toUpperCase() || 'IN';
            document.getElementById('sidebar-avatar').innerText = initials;
        }

        // Inputs
        document.getElementById('perfil-nombre').value = user.nombre || '';
        document.getElementById('perfil-email').value = user.email || '';

        // Teléfono
        const rawPhone = user.telefono || '';
        if (rawPhone && rawPhone !== 'N/A') {
            const ladaOptions = ['+52', '+1', '+34', '+54', '+57'];
            let matched = '';
            for (const l of ladaOptions) {
                if (rawPhone.startsWith(l)) { matched = l; break; }
            }
            if (matched) {
                document.getElementById('p-lada').value = matched;
                document.getElementById('p-phone').value = rawPhone.replace(matched, '');
            } else {
                document.getElementById('p-phone').value = rawPhone;
            }
        }
    }

    function toggleEditProfile() {
        const inputs = document.querySelectorAll('.profile-input');
        const saveContainer = document.getElementById('btn-save-container');
        const editBtn = document.getElementById('btn-toggle-edit');
        const isEditing = !inputs[0].disabled;

        if (isEditing) {
            // Cancelar: restaurar valores
            document.getElementById('perfil-nombre').value = initialValues.nombre || '';
            document.getElementById('p-lada').value = initialValues.lada || '+52';
            document.getElementById('p-phone').value = initialValues.phone || '';
            inputs.forEach(i => i.disabled = true);
            saveContainer.style.display = 'none';
            editBtn.style.display = 'inline-block';
            initialValues = {};
        } else {
            // Guardar estado inicial antes de editar
            initialValues = {
                nombre: document.getElementById('perfil-nombre').value,
                lada: document.getElementById('p-lada').value,
                phone: document.getElementById('p-phone').value
            };
            inputs.forEach(i => i.disabled = false);
            saveContainer.style.display = 'flex';
            editBtn.style.display = 'none';
            inputs[0].focus();
        }
    }

    async function saveProfile(e) {
        e.preventDefault();

        const nombre = document.getElementById('perfil-nombre').value.trim();
        const phone = document.getElementById('p-phone').value.trim();
        const lada = document.getElementById('p-lada').value;

        if (!nombre || nombre.length < 3) {
            window.showModal('Nombre inválido', 'El nombre debe tener al menos 3 caracteres.', 'error');
            return;
        }

        if (phone && phone.length !== 10) {
            window.showModal('Teléfono inválido', 'El número de teléfono debe tener exactamente 10 dígitos.', 'error');
            return;
        }

        const telefonoFull = phone ? `${lada}${phone}` : 'N/A';
        const btn = document.getElementById('btn-save-info');
        btn.innerText = 'Guardando...';
        btn.disabled = true;

        try {
            const res = await fetch(`http://localhost:8008/autenticacion/usuarios/${currentUserId}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, telefono: telefonoFull })
            });

            if (!res.ok) {
                const err = await res.json();
                window.showModal('Error al guardar', err.detail || 'Inténtalo de nuevo.', 'error');
                return;
            }

            // Actualizar localStorage
            const userData = localStorage.getItem('macuin_user');
            if (userData) {
                const u = JSON.parse(userData);
                u.nombre = nombre;
                u.telefono = telefonoFull;
                localStorage.setItem('macuin_user', JSON.stringify(u));
            }

            document.getElementById('sidebar-name').innerText = nombre;
            document.getElementById('sidebar-phone').innerText = telefonoFull;
            initialValues = {};

            const inputs = document.querySelectorAll('.profile-input');
            inputs.forEach(i => i.disabled = true);
            document.getElementById('btn-save-container').style.display = 'none';
            document.getElementById('btn-toggle-edit').style.display = 'inline-block';

            window.showModal('¡Perfil actualizado!', 'Tu información personal ha sido guardada correctamente.', 'success');
        } catch(err) {
            window.showModal('Error de conexión', 'No se pudo conectar con el servidor.', 'error');
        } finally {
            btn.innerText = 'Guardar cambios';
            btn.disabled = false;
        }
    }

    async function changePassword(e) {
        e.preventDefault();

        const currentPass = document.getElementById('cl-current-pass').value;
        const newPass = document.getElementById('cl-new-pass').value;
        const confirmPass = document.getElementById('cl-confirm-pass').value;

        if (!currentPass) {
            window.showModal('Campo requerido', 'Por favor ingresa tu contraseña actual.', 'error');
            return;
        }

        if (!validateCliPass(newPass)) {
            window.showModal('Seguridad insuficiente', 'La nueva contraseña no cumple con los requisitos de seguridad.', 'error');
            return;
        }

        if (newPass !== confirmPass) {
            window.showModal('Error de coincidencia', 'Las contraseñas no coinciden. Por favor verifícalas.', 'error');
            return;
        }

        const userData = localStorage.getItem('macuin_user');
        const user = userData ? JSON.parse(userData) : null;
        if (!user?.email) {
            window.showModal('Error de sesión', 'No se encontró la sesión activa.', 'error');
            return;
        }

        const btn = document.getElementById('btn-change-pass');
        btn.innerText = 'Verificando...';
        btn.disabled = true;

        try {
            // Paso 1: verificar contraseña actual
            const loginRes = await fetch('http://localhost:8008/autenticacion/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: user.email, password: currentPass })
            });

            if (!loginRes.ok) {
                window.showModal('Contraseña incorrecta', 'La contraseña actual que ingresaste no es correcta.', 'error');
                return;
            }

            // Paso 2: actualizar contraseña
            const patchRes = await fetch(`http://localhost:8008/autenticacion/usuarios/${currentUserId}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ password: newPass })
            });

            if (!patchRes.ok) {
                const err = await patchRes.json();
                window.showModal('Error al actualizar', err.detail || 'No se pudo actualizar la contraseña.', 'error');
                return;
            }

            e.target.reset();
            validateCliPass('');
            window.showModal('¡Contraseña actualizada!', 'Tu nueva contraseña ha sido guardada de forma segura.', 'success');
        } catch(err) {
            window.showModal('Error de conexión', 'No se pudo conectar con el servidor.', 'error');
        } finally {
            btn.innerText = 'Actualizar contraseña';
            btn.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadClientProfile();
        if (typeof gsap !== 'undefined') {
            gsap.from('.page-title', { opacity: 0, y: -20, duration: 0.5, ease: 'power2.out' });
            gsap.from('.gsap-item', { opacity: 0, y: 20, stagger: 0.1, duration: 0.5, ease: 'power2.out', delay: 0.1 });
            gsap.from('.gsap-card', { opacity: 0, y: 30, stagger: 0.15, duration: 0.6, ease: 'power2.out', delay: 0.3 });
        }
    });
</script>
@endsection
