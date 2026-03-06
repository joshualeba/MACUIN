@extends('app')

@push('styles')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
        }
    </style>
@endpush

@php
    $noSidebar = true;
@endphp

@section('content')
<div class="split-screen">
    <div class="split-left">
        <video autoplay muted loop>
            <source src="https://res.cloudinary.com/dpvm2gro2/video/upload/v1772563396/PinDown.io__cozysaver_1772562520_sb2l12.mp4" type="video/mp4">
        </video>
    </div>
    <div class="split-right" style="overflow-y: auto;">
        <div class="auth-card" style="box-shadow: none; padding: 2rem 0; width: 100%; max-width: 450px;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772562917/1_kj2lq7.png" alt="Logo" style="width: 80px;">
            </div>

            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; text-align: left;">Crear cuenta</h2>
            <p style="font-size: 0.875rem; color: #64748B; text-align: left; margin-bottom: 2rem;">Únete a la mejor plataforma de autopartes.</p>

            <form id="registro-form" action="{{ url('/login') }}" method="GET">
                <div class="input-group">
                    <label>Nombre completo</label>
                    <input type="text" id="reg-nombre" class="input-control" placeholder="Ej. Armando Maldonado" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$" title="Solo se permiten letras, espacios, acentos y ñ" required oninput="this.value = this.value.replace(/[0-9]/g, '')">
                </div>

                <div class="input-group">
                    <label>Correo electrónico</label>
                    <input type="email" class="input-control" placeholder="Ej. bepe@gmail.com" required>
                </div>

                <div class="input-group">
                    <label>Contraseña</label>
                    <div class="password-wrapper">
                        <input type="password" class="input-control password-input" id="reg-password" placeholder="••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('reg-password', this)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <!-- Requisitos de la contraseña en vivo -->
                <div class="password-requirements">
                    <div id="req-length" class="req-item"><span class="icon"><svg style="vertical-align: sub;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></span> Mínimo 8 y máximo 25 caracteres</div>
                    <div id="req-uppercase" class="req-item"><span class="icon"><svg style="vertical-align: sub;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></span> Al menos una mayúscula</div>
                    <div id="req-special" class="req-item"><span class="icon"><svg style="vertical-align: sub;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></span> Al menos un carácter especial (!@#$%^&*...)</div>
                </div>

                <div class="input-group" style="margin-top: 1.5rem;">
                    <label>Confirmar contraseña</label>
                    <div class="password-wrapper">
                        <input type="password" class="input-control password-input" id="reg-confirm" placeholder="••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('reg-confirm', this)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="btn btn-primary btn-block" style="margin-top: 1rem; border-radius: 999px;">Registrarse</button>
            </form>

            <p style="margin-top: 2rem; font-size: 0.875rem; color: #64748B;">
                ¿Ya tienes cuenta? <a href="{{ url('/login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>

<script>
    const iconValid = `<svg style="vertical-align: sub;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`;
    const iconInvalid = `<svg style="vertical-align: sub;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`;

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
        const eyeClosed = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;

        if (input.type === "password") {
            input.type = "text";
            btn.innerHTML = eyeClosed;
        } else {
            input.type = "password";
            btn.innerHTML = eyeOpen;
        }
    }

    const passwordField = document.getElementById('reg-password');
    const reqLength = document.getElementById('req-length');
    const reqUppercase = document.getElementById('req-uppercase');
    const reqSpecial = document.getElementById('req-special');

    passwordField.addEventListener('input', function() {
        const val = this.value;

        // Longitud
        if (val.length >= 8 && val.length <= 25) {
            reqLength.classList.add('valid');
            reqLength.querySelector('.icon').innerHTML = iconValid;
        } else {
            reqLength.classList.remove('valid');
            reqLength.querySelector('.icon').innerHTML = iconInvalid;
        }

        // Mayúscula
        if (/[A-Z]/.test(val)) {
            reqUppercase.classList.add('valid');
            reqUppercase.querySelector('.icon').innerHTML = iconValid;
        } else {
            reqUppercase.classList.remove('valid');
            reqUppercase.querySelector('.icon').innerHTML = iconInvalid;
        }

        // Caracter especial
        if (/[!@#$%^&*(),.?":{}|<>]/.test(val)) {
            reqSpecial.classList.add('valid');
            reqSpecial.querySelector('.icon').innerHTML = iconValid;
        } else {
            reqSpecial.classList.remove('valid');
            reqSpecial.querySelector('.icon').innerHTML = iconInvalid;
        }
    });

    const form = document.getElementById('registro-form');
    const confirmField = document.getElementById('reg-confirm');
    const nameField = document.getElementById('reg-nombre');

    form.addEventListener('submit', function(e) {
        // Validar que el nombre no tenga números (por si se los saltan de alguna manera)
        if (/[0-9]/.test(nameField.value)) {
            e.preventDefault();
            window.showModal("Formato Inválido", "El nombre no puede contener números. Por favor, escríbelo correctamente.");
            return;
        }

        // Validar que ambas contraseñas coincidan
        if (passwordField.value !== confirmField.value) {
            e.preventDefault();
            window.showModal("Verificación de Contraseña", "Las contraseñas no coinciden. Por favor, verifícalas y asegúrate de que sean iguales.");
            return;
        }
    });
</script>
@endsection
