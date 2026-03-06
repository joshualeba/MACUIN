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
        transition: background 0.2s;
    }
    
    .btn-save:hover {
        background: #2563EB;
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
            <div class="profile-avatar-large">CP</div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Cliente Premium</h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">bepe@gmail.com</p>
            
            <div style="border-top: 1px solid var(--border); padding-top: 1.5rem; text-align: left;">
                <div style="margin-bottom: 1rem;">
                    <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-bottom: 0.2rem;">Miembro desde</span>
                    <strong style="color: var(--text-main);">Enero 2026</strong>
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
                
                <form id="profile-form" onsubmit="saveProfile(event, 'Perfil actualizado', 'Tu información personal ha sido modificada con éxito.')">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control profile-input" id="perfil-nombre" value="Cliente Premium" required disabled oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" value="bepe@gmail.com" required disabled style="cursor: not-allowed; opacity: 0.65;">
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
                                <input type="text" class="form-control profile-input" id="p-phone" value="5512345678" maxlength="10" disabled oninput="this.value = this.value.replace(/\D/g, '').substring(0, 10)">
                            </div>
                        </div>

                    </div>
                    
                    <div id="btn-save-container" style="margin-top: 1rem; text-align: right; display: none; gap: 1rem; justify-content: flex-end;">
                        <button type="button" class="btn-cancel" onclick="toggleEditProfile()">Cancelar</button>
                        <button type="submit" class="btn-save">Guardar cambios</button>
                    </div>
                </form>
            </section>

            <!-- Sección de cambio de contraseña -->
            <section class="profile-section gsap-card">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-main); margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 0.75rem;">
                    Seguridad
                </h3>
                
                <form id="security-form" onsubmit="saveProfile(event, 'Contraseña actualizada', 'Tu nueva contraseña ha sido guardada de forma segura.')">
                    <div class="form-group">
                        <label class="form-label">Contraseña actual</label>
                        <input type="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control" placeholder="Repite tu nueva contraseña" required>
                        </div>
                    </div>
                    
                    <div style="margin-top: 1rem; text-align: right;">
                        <button type="submit" class="btn-save">Actualizar contraseña</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof gsap !== 'undefined') {
            gsap.from(".page-title", { opacity: 0, y: -20, duration: 0.5, ease: "power2.out" });
            gsap.from(".gsap-item", {
                opacity: 0,
                y: 20,
                stagger: 0.1,
                duration: 0.5,
                ease: "power2.out",
                delay: 0.1
            });
            gsap.from(".gsap-card", {
                opacity: 0,
                y: 30,
                stagger: 0.15,
                duration: 0.6,
                ease: "power2.out",
                delay: 0.3
            });
        }
    });

    // State for cancellation
    let initialValues = {};

    function toggleEditProfile() {
        const inputs = document.querySelectorAll('.profile-input');
        const saveContainer = document.getElementById('btn-save-container');
        const editBtn = document.getElementById('btn-toggle-edit');
        
        let isEditing = !inputs[0].disabled;
        
        if (isEditing) {
            // Restore values if canceled
            if (initialValues.nombre !== undefined) {
                document.getElementById('perfil-nombre').value = initialValues.nombre;
                document.getElementById('p-lada').value = initialValues.lada;
                document.getElementById('p-phone').value = initialValues.phone;
            }

            // Cancelar edición
            inputs.forEach(input => input.disabled = true);
            saveContainer.style.display = 'none';
            editBtn.style.display = 'inline-block';
            initialValues = {};
        } else {
            // Save initial values before edit
            initialValues = {
                nombre: document.getElementById('perfil-nombre').value,
                lada: document.getElementById('p-lada').value,
                phone: document.getElementById('p-phone').value
            };

            // Habilitar edición
            inputs.forEach(input => input.disabled = false);
            saveContainer.style.display = 'flex';
            editBtn.style.display = 'none';
            inputs[0].focus();
        }
    }

    function saveProfile(e, successTitle, successMessage) {
        e.preventDefault();

        if (e.target.id === 'profile-form') {
            const nombre = document.getElementById('perfil-nombre').value.trim();
            const telefono = document.querySelector('input[type="tel"].profile-input').value.trim();

            if (!nombre) {
                window.showModal('Campo requerido', 'El nombre completo no puede estar vacío.', 'error');
                return;
            }

            if (!telefono || telefono.length !== 10) {
                window.showModal('Teléfono inválido', 'Ingresa un número de teléfono válido de 10 dígitos.', 'error');
                return;
            }

            // Clear values so cancel doesn't revert AFTER save
            initialValues = {};

            window.showModal(successTitle, successMessage, 'success');
            
            // Lock inputs manually since toggleEditProfile now reverts
            const inputs = document.querySelectorAll('.profile-input');
            inputs.forEach(input => input.disabled = true);
            document.getElementById('btn-save-container').style.display = 'none';
            document.getElementById('btn-toggle-edit').style.display = 'inline-block';
        } else {
            window.showModal(successTitle, successMessage, 'success');
        }
    }
</script>
@endsection
