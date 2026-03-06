@extends('app')

@push('styles')
<style>
    .payment-container {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }
    
    .payment-form-area {
        flex: 2;
        min-width: 300px;
    }
    
    .payment-summary {
        flex: 1;
        min-width: 300px;
    }
    
    .checkout-section {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
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
    }
</style>
@endpush

@section('content')
<div class="gsap-container">
    <div class="page-title gsap-item">Sección de pago</div>
    <p class="gsap-item" style="color: var(--text-muted); margin-bottom: 2rem;">Ingresa tus datos de envío y facturación para finalizar la compra.</p>

    <div class="payment-container">
        <!-- Formulario -->
        <div class="payment-form-area gsap-item">
            <form id="checkout-form" novalidate onsubmit="processPayment(event)">
                <!-- Dirección de envío -->
                <div class="checkout-section">
                    <h3 class="section-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Dirección de entrega
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nombre completo del receptor</label>
                        <input type="text" class="form-control" id="receptor_nombre" placeholder="Ej. Armando Maldonado Morales" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Dirección (Calle y número)</label>
                        <input type="text" class="form-control" id="direccion" placeholder="Ej. Blvd. Bernardo Quintana 111">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Colonia / Fraccionamiento</label>
                            <input type="text" class="form-control" id="colonia" placeholder="Ej. Álamos 2da Sección">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="zip_code" placeholder="Ej. 76160" oninput="this.value = this.value.replace(/\D/g, '').substring(0, 5)">
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" placeholder="Ej. Santiago de Querétaro">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" placeholder="Ej. Querétaro">
                        </div>
                    </div>
                </div>

                <!-- Método de pago -->
                <div class="checkout-section">
                    <h3 class="section-title">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        Método de pago
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nombre en la tarjeta</label>
                        <input type="text" class="form-control" id="card_name" placeholder="COMO APARECE EN LA TARJETA" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '').toUpperCase()">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Número de tarjeta</label>
                        <input type="text" class="form-control" id="card_number" placeholder="0000 0000 0000 0000" maxlength="19">
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Fecha de vencimiento (Mes/Año)</label>
                            <input type="month" class="form-control" id="exp_date">
                        </div>
                        <div class="form-group">
                            <label class="form-label">CVC</label>
                            <input type="password" class="form-control" id="card_cvc" placeholder="Ej. 123" maxlength="3" oninput="this.value = this.value.replace(/\D/g, '').substring(0, 3)">
                        </div>
                    </div>
                </div>
                
                <button type="submit" id="submit-btn" style="display: none;"></button>
            </form>
        </div>

        <!-- Resumen estático para el demo -->
        <div class="payment-summary gsap-item">
            <div style="background: var(--primary); color: white; border-radius: 16px; padding: 2rem; position: sticky; top: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 800; text-transform: uppercase; margin-bottom: 2rem;">Total a pagar</h3>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #CBD5E1; font-weight: 500;">
                    <span>Subtotal</span>
                    <span>$1680.00</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #CBD5E1; font-weight: 500;">
                    <span>IVA (16%)</span>
                    <span>$268.80</span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; color: #10B981; font-weight: 600; text-transform: uppercase;">
                    <span>Envío</span>
                    <span>Gratis</span>
                </div>

                <hr style="border-color: rgba(255,255,255,0.2); margin-bottom: 1.5rem;">

                <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 2rem;">
                    <span style="color: #94A3B8; font-size: 0.8rem; text-transform: uppercase;">Importe total</span>
                    <span style="font-size: 2.5rem; font-weight: 800; margin: 0;">$1948.80</span>
                </div>

                <button onclick="document.getElementById('submit-btn').click()" class="btn btn-primary text-decoration-none" style="display: block; width: 100%; border: none; cursor: pointer; text-align: center; background: white; color: var(--primary); font-weight: 800; text-transform: uppercase; padding: 1rem; border-radius: 8px; transition: transform 0.2s;">Confirmar pedido &rarr;</button>
            </div>
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
        }
        
        // Formatear la tarjeta en bloques de 4 dígitos
        const cardInput = document.getElementById('card_number');
        if(cardInput) {
            cardInput.addEventListener('input', function(e) {
                let target = e.target;
                let val = target.value.replace(/\D/g, '').substring(0, 16);
                target.value = val !== '' ? val.match(/.{1,4}/g).join(' ') : '';
            });
        }
    });

    function processPayment(e) {
        e.preventDefault();
        
        const nombre = document.getElementById('receptor_nombre').value.trim();
        const direccion = document.getElementById('direccion').value.trim();
        const colonia = document.getElementById('colonia').value.trim();
        const zip = document.getElementById('zip_code').value.trim();
        const ciudad = document.getElementById('ciudad').value.trim();
        const estado = document.getElementById('estado').value.trim();
        
        const cardName = document.getElementById('card_name').value.trim();
        const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '');
        const expDate = document.getElementById('exp_date').value;
        const cardCvc = document.getElementById('card_cvc').value;

        // Validar que todos los campos estén llenos
        if (!nombre || !direccion || !colonia || !zip || !ciudad || !estado || !cardName || !cardNumber || !expDate || !cardCvc) {
            window.showModal(
                "Información incompleta", 
                "Por favor, asegúrate de llenar todos los campos de entrega y pago.", 
                "error"
            );
            return;
        }

        // Validación estricta de CP
        if (zip.length !== 5) {
            window.showModal(
                "Código postal inválido", 
                "El código postal debe estar compuesto por exactamente 5 números.", 
                "error"
            );
            return;
        }

        // Validación estricta de Tarjeta
        if (cardNumber.length !== 16) {
            window.showModal(
                "Tarjeta inválida", 
                "Verifica el número de tu tarjeta, debe contener exactamente 16 dígitos.", 
                "error"
            );
            return;
        }

        // Validación estricta de CVC
        if (cardCvc.length !== 3) {
            window.showModal(
                "CVC inválido", 
                "El código de seguridad (CVC) debe componerse de exactamente 3 dígitos.", 
                "error"
            );
            return;
        }
        
        // Si todo está correcto, simular pago satisfactorio
        window.showModal(
            "¡Pedido confirmado!", 
            "Hemos recibido tu pago exitosamente. En un momento te redirigiremos al historial de tus pedidos.", 
            "success"
        );
        
        setTimeout(() => {
            window.location.href = "{{ url('/historial') }}";
        }, 3500);
    }
</script>
@endsection
