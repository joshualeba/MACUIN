@extends('app')

@push('styles')
<style>
    .cart-container {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }
    .cart-items {
        flex: 2;
        min-width: 300px;
    }
    .cart-summary {
        flex: 1;
        min-width: 300px;
    }
    
    .cart-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .cart-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .item-info {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex: 1;
        min-width: 250px;
    }

    .item-img {
        width: 80px;
        height: 80px;
        background: #F1F5F9;
        border-radius: 8px;
        object-fit: cover;
    }

    .qty-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--bg-light);
        padding: 0.3rem;
        border-radius: 999px;
        border: 1px solid var(--border);
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: var(--card-bg);
        color: var(--text-main);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .qty-btn:hover {
        background: var(--primary);
        color: white;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        border: none;
        background: transparent;
        color: var(--text-main);
        font-weight: 600;
        font-size: 0.95rem;
        outline: none;
    }

    .item-price {
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--text-main);
        text-align: right;
        min-width: 100px;
    }

    .remove-btn {
        background: transparent;
        border: none;
        color: #EF4444;
        cursor: pointer;
        padding: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
<div class="gsap-container">
    <div class="page-title gsap-item">Carrito de compras</div>
    <p class="gsap-item" style="color: var(--text-muted); margin-bottom: 2rem;">Revisa tus artículos antes de proceder al pago.</p>

    <div class="cart-container">
        <!-- Lista de artículos -->
        <div class="cart-items gsap-item">
            <div class="card" style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--text-main);" id="cart-counter-title">Tus artículos (3)</h3>
                
                <div id="cart-list">
                    <!-- Producto 1 -->
                    <div class="cart-item" data-id="13" data-price="250">
                        <div class="item-info">
                            <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803615/13_q15jp9.jpg" alt="Bujía láser de Iridio" class="item-img">
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main);">Bujía láser de Iridio</h4>
                                <div style="color: var(--text-muted); font-size: 0.8rem;">Eléctrico</div>
                                <button class="remove-btn" onclick="removeItem(this)">Quitar</button>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <input type="number" class="qty-input" value="4" readonly>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                            <div class="item-price">$<span class="price-val">1000.00</span></div>
                        </div>
                    </div>

                    <!-- Producto 2 -->
                    <div class="cart-item" data-id="27" data-price="180">
                        <div class="item-info">
                            <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803599/27_hmbamh.jpg" alt="Válvula PCV" class="item-img">
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main);">Válvula PCV</h4>
                                <div style="color: var(--text-muted); font-size: 0.8rem;">Motor</div>
                                <button class="remove-btn" onclick="removeItem(this)">Quitar</button>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <input type="number" class="qty-input" value="1" readonly>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                            <div class="item-price">$<span class="price-val">180.00</span></div>
                        </div>
                    </div>

                    <!-- Producto 3 -->
                    <div class="cart-item" data-id="4" data-price="250">
                        <div class="item-info">
                            <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/4_rejzkf.jpg" alt="Filtro de aceite sintético" class="item-img">
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700; color: var(--text-main);">Filtro de aceite sintético</h4>
                                <div style="color: var(--text-muted); font-size: 0.8rem;">Motor</div>
                                <button class="remove-btn" onclick="removeItem(this)">Quitar</button>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                            <div class="qty-controls">
                                <button class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                <input type="number" class="qty-input" value="2" readonly>
                                <button class="qty-btn" onclick="updateQty(this, 1)">+</button>
                            </div>
                            <div class="item-price">$<span class="price-val">500.00</span></div>
                        </div>
                    </div>
                </div>
                
                <div id="empty-cart-msg" style="display: none; text-align: center; padding: 3rem 1rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;">🛒</div>
                    <h3 style="color: var(--text-main); font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Tu carrito está vacío</h3>
                    <p style="color: var(--text-muted); margin-bottom: 2rem;">¿No sabes qué comprar? ¡Miles de piezas te esperan!</p>
                    <a href="{{ url('/catalogo') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem; background: var(--primary); color: white; padding: 0.8rem 2.5rem; border-radius: 999px; text-decoration: none; font-weight: 600; font-size: 1rem; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59, 130, 246, 0.4)';" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.3)';">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Ir al catálogo
                    </a>
                </div>
            </div>
        </div>

        <!-- Panel de totales -->
        <div class="cart-summary gsap-item">
            <div style="background: var(--primary); color: white; border-radius: 16px; padding: 2rem; position: sticky; top: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 800; text-transform: uppercase; margin-bottom: 2rem;">Resumen de compra</h3>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #CBD5E1; font-weight: 500;">
                    <span>Subtotal</span>
                    <span>$<span id="summary-subtotal">1680.00</span></span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #CBD5E1; font-weight: 500;">
                    <span>IVA (16%)</span>
                    <span>$<span id="summary-iva">268.80</span></span>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; color: #10B981; font-weight: 600; text-transform: uppercase;">
                    <span>Envío</span>
                    <span>Gratis</span>
                </div>

                <hr style="border-color: rgba(255,255,255,0.2); margin-bottom: 1.5rem;">

                <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 2rem;">
                    <span style="color: #94A3B8; font-size: 0.8rem; text-transform: uppercase;">Importe total</span>
                    <span style="font-size: 2.5rem; font-weight: 800; margin: 0;">$<span id="summary-total">1948.80</span></span>
                </div>

                <a href="{{ url('/pago') }}" id="btn-checkout" class="btn btn-primary text-decoration-none" style="display: block; text-align: center; background: white; color: var(--primary); font-weight: 800; text-transform: uppercase; padding: 1rem; border-radius: 8px; transition: transform 0.2s;">Proceder al pago &rarr;</a>
            </div>
        </div>
    </div>
</div>

<script>
    function formatMoney(amount) {
        return amount.toFixed(2);
    }

    function calculateTotals() {
        const items = document.querySelectorAll('.cart-item');
        let subtotal = 0;
        let count = 0;

        items.forEach(item => {
            const price = parseFloat(item.getAttribute('data-price'));
            const qty = parseInt(item.querySelector('.qty-input').value);
            const itemTotal = price * qty;
            
            item.querySelector('.price-val').innerText = formatMoney(itemTotal);
            subtotal += itemTotal;
            count += qty;
        });

        const iva = subtotal * 0.16;
        const total = subtotal + iva;

        document.getElementById('summary-subtotal').innerText = formatMoney(subtotal);
        document.getElementById('summary-iva').innerText = formatMoney(iva);
        document.getElementById('summary-total').innerText = formatMoney(total);
        
        const titleItems = Array.from(items).length;
        document.getElementById('cart-counter-title').innerText = `Tus artículos (${titleItems})`;

        if (titleItems === 0) {
            document.getElementById('cart-list').style.display = 'none';
            document.getElementById('empty-cart-msg').style.display = 'block';
            const btnCheckout = document.getElementById('btn-checkout');
            btnCheckout.style.pointerEvents = 'none';
            btnCheckout.style.opacity = '0.5';
        }
    }

    function updateQty(btn, change) {
        const input = btn.parentElement.querySelector('.qty-input');
        let current = parseInt(input.value);
        let newVal = current + change;
        
        if (newVal >= 1 && newVal <= 99) {
            input.value = newVal;
            calculateTotals();
        }
    }

    function removeItem(btn) {
        const item = btn.closest('.cart-item');
        
        // Animación suave de salida
        gsap.to(item, {
            opacity: 0,
            x: -20,
            height: 0,
            paddingTop: 0,
            paddingBottom: 0,
            marginBottom: 0,
            border: 'none',
            duration: 0.3,
            onComplete: () => {
                item.remove();
                calculateTotals();
            }
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        calculateTotals();
        
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
    });
</script>
@endsection
