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
                    <input type="email" class="input-control" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="input-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label style="margin: 0;">Contraseña</label>
                    </div>
                    <div class="password-wrapper">
                        <input type="password" class="input-control password-input" id="login-password" placeholder="••••••••" required>
                        <button type="button" class="eye-btn" onclick="togglePassword('login-password', this)">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
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

    const loginForm = document.getElementById('login-form');
    const passwordInput = document.getElementById('login-password');

    // Soporte para tecla Enter
    loginForm.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            submitBtn.click();
        }
    });

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.querySelector('input[type="email"]').value.trim();
        const password = passwordInput.value;

        if (!email || !password) {
            window.showModal('Campos requeridos', 'Por favor, completa todos los campos para iniciar sesión.', 'error');
            return;
        }

        // Validación estricta de correo (e.g. dominios completos .com, .mx, etc.)
        const emailRegex = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) {
            window.showModal('Correo inválido', 'Por favor, ingresa un formato de correo electrónico válido (ejemplo: correo@gmail.com).', 'error');
            return;
        }

        // Enviar a la API Central
        fetch('http://localhost:8008/autenticacion/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        })
        .then(async response => {
            const result = await response.json();
            if (response.ok) {
                // Guardar los datos del usuario en localStorage para usarlos en el dashboard
                localStorage.setItem('macuin_user', JSON.stringify(result.user));
                window.location.href = "{{ url('/catalogo') }}";
            } else {
                let errorTitle = 'Acceso denegado';
                if (result.detail && result.detail.includes('registrado')) errorTitle = 'Correo no registrado';
                if (result.detail && result.detail.includes('Contraseña')) errorTitle = 'Contraseña incorrecta';
                
                window.showModal(errorTitle, result.detail || "Verifica tus credenciales.", "error");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showModal("Error de conexión", "No se pudo contactar con el servidor central.", "error");
        })
        .finally(() => {
            if (window.completeLoader) window.completeLoader();
        });
    });
</script>
@endsection
