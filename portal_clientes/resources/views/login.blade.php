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
    <div class="split-right">
        <div class="auth-card" style="box-shadow: none; padding: 0;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772562917/1_kj2lq7.png" alt="Logo" style="width: 100px;">
            </div>

            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 0.5rem; text-align: left;">¡Bienvenido/a de vuelta!</h2>
            <p style="font-size: 0.875rem; color: #64748B; text-align: left; margin-bottom: 2rem;">Inicia sesión para gestionar tus pedidos.</p>

            <form id="login-form" action="{{ url('/catalogo') }}" method="GET">
                <div class="input-group">
                    <label>Correo electrónico</label>
                    <input type="email" class="input-control" placeholder="bepe@gmail.com" required>
                </div>

                <div class="input-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label style="margin: 0;">Contraseña</label>
                        <a href="#" style="font-size: 0.75rem; color: var(--accent); text-decoration: none; font-weight: 600;">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="password-wrapper">
                        <input type="password" class="input-control password-input" id="login-password" placeholder="••••••••" required oninput="validatePassword(this.value)">
                        <button type="button" class="eye-btn" onclick="togglePassword('login-password', this)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>

                    <!-- Password Hooks -->
                    <div class="password-validator" style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <div class="req-item" id="req-length" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: #94A3B8; font-weight: 600;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mínimo 8-25 caracteres
                        </div>
                        <div class="req-item" id="req-upper" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: #94A3B8; font-weight: 600;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mínimo una letra mayúscula
                        </div>
                        <div class="req-item" id="req-special" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: #94A3B8; font-weight: 600;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Mínimo un carácter especial (@, #, $, etc.)
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark btn-block" style="margin-top: 1rem; border-radius: 999px;">Iniciar sesión &rarr;</button>
            </form>

            <p style="margin-top: 2rem; font-size: 0.875rem; color: #64748B;">
                ¿No tienes cuenta? <a href="{{ url('/registro') }}" style="color: var(--accent); font-weight: 600; text-decoration: none;">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>

<script>
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

    function validatePassword(pass) {
        const hasLength = pass.length >= 8 && pass.length <= 25;
        const hasUpper = /[A-Z]/.test(pass);
        const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pass);

        const applyStyle = (id, valid) => {
            const el = document.getElementById(id);
            el.style.color = valid ? '#10B981' : '#94A3B8';
            el.querySelector('svg').style.stroke = valid ? '#10B981' : 'currentColor';
        };

        applyStyle('req-length', hasLength);
        applyStyle('req-upper', hasUpper);
        applyStyle('req-special', hasSpecial);

        return hasLength && hasUpper && hasSpecial;
    }

    document.getElementById('login-form').addEventListener('submit', function(e) {
        const pass = document.getElementById('login-password').value;
        if (!validatePassword(pass)) {
            e.preventDefault();
            // Detener el loader que se activa globalmente en app.blade.php
            if (window.completeLoader) window.completeLoader();
            
            window.showModal('Seguridad insuficiente', 'Tu contraseña debe cumplir con todos los requisitos de seguridad (mayúsculas, símbolos y longitud).', 'error');
        }
    });
</script>
@endsection
