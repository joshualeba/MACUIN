@extends('app')

@push('styles')
<style>
    .qty-btn { border: none; background: transparent; padding: 0.8rem 1rem; cursor: pointer; color: var(--text-main); display: flex; align-items: center; justify-content: center; }
    .qty-btn:hover { background: rgba(0,0,0,0.05); }
    body.dark-mode .qty-btn:hover { background: rgba(255,255,255,0.05); }
    
    .product-showcase { background: #F1F5F9; border-radius: 12px; overflow: hidden; border: 1px solid var(--border); padding: 2rem; display: flex; justify-content: center; align-items: center; }
    body.dark-mode .product-showcase { background: #111111; border-color: #27272A; }
</style>
@endpush

@section('content')
@php
    $id = isset($id) ? (int)$id : 1;
    if (!isset($producto)) {
        $producto = [
            'id' => $id, 'nombre' => 'Producto no encontrado', 'precio' => '0', 'stock' => 0, 
            'imagen' => '', 'desc' => 'El producto solicitado no existe o no está disponible.', 
            'features' => []
        ];
    }
@endphp

<div class="gsap-container pb-10">
    <a href="{{ url('/catalogo') }}" class="gsap-item" style="color: var(--text-muted); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem; font-weight: 600;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Volver al catálogo
    </a>

    <div style="display: flex; gap: 4rem; flex-wrap: wrap; background: var(--card-bg); padding: 3rem; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.03);" class="card">
        <!-- Imagen -->
        <div class="gsap-item" style="flex: 1; min-width: 300px;">
            <div class="product-showcase" style="height: 100%; min-height: 400px;">
                <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}" style="width: 100%; max-width: 100%; object-fit: contain; transform: scale(1.15);">
            </div>
        </div>

        <!-- Detalles -->
        <div class="gsap-item" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; justify-content: center;">
            <div style="color: var(--accent); font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Repuestos Automotrices</div>
            <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--text-main); line-height: 1.2; margin-bottom: 1rem;">{{ $producto['nombre'] }}</h1>
            
            <div style="font-size: 2rem; font-weight: 700; color: var(--text-main); margin-bottom: 1.5rem; display: flex; align-items: flex-end; gap: 0.5rem;">
                ${{ $producto['precio'] }} <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal; margin-bottom: 0.4rem;">MXN</span>
            </div>

            <div style="margin-bottom: 2.5rem;">
                <p style="color: var(--text-main); font-size: 1.15rem; font-weight: 500; margin-bottom: 1rem; line-height: 1.6;">
                    {{ $producto['desc_breve'] ?? $producto['desc'] ?? '' }}
                </p>
                <div style="width: 50px; height: 3px; background: var(--primary); margin-bottom: 1rem; border-radius: 999px;"></div>
                <p style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; text-align: justify;">
                    {{ $producto['desc_completa'] ?? 'Diseñado y desarrollado bajo los más estrictos estándares de la industria, el artículo restaura la eficiencia y seguridad total de tu vehículo.' }}
                </p>
            </div>

            <!-- Tarjetitas de características (Features) -->
            @if(isset($producto['features']))
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2.5rem;">
                    @foreach($producto['features'] as $clave => $valor)
                        <div style="background: rgba(148, 163, 184, 0.05); border: 1px solid var(--border); border-radius: 8px; padding: 1rem; text-align: center;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; margin-bottom: 0.3rem;">{{ $clave }}</div>
                            <div style="font-size: 1rem; color: var(--text-main); font-weight: 600;">{{ $valor }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div style="display: flex; align-items: center; gap: 2rem; margin-bottom: 2.5rem;">
                <!-- Contador con flechitas -->
                <div style="display: flex; align-items: center; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; width: max-content;">
                    <button class="qty-btn" onclick="updateQty(-1)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <input type="number" id="qty-input" value="1" min="1" max="{{ $producto['stock'] }}" style="width: 60px; text-align: center; border: none; background: transparent; font-size: 1.2rem; font-weight: 600; color: var(--text-main); outline: none;" readonly>
                    <button class="qty-btn" onclick="updateQty(1)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                </div>
                
                <div style="font-size: 0.95rem; color: var(--text-muted);">
                    Disponibles: <span id="product-stock" style="font-weight: 700; color: {{ $producto['stock'] < 5 ? '#EF4444' : 'var(--text-main)' }};">{{ $producto['stock'] }}</span> unidades
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                @if($producto['stock'] > 0)
                    <button onclick="addToCartConfirm()" style="background: var(--text-main); color: var(--card-bg); border: none; padding: 1rem 2rem; border-radius: 999px; font-weight: 600; font-size: 1.1rem; flex: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.8rem; transition: transform 0.2s;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        Añadir al carrito
                    </button>
                @else
                    <button disabled style="background: #94A3B8; color: white; border: none; padding: 1rem 2rem; border-radius: 999px; font-weight: 600; font-size: 1.1rem; flex: 1; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 0.8rem;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                        Agotado
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const maxStock = {{ $producto['stock'] }};
    
    function updateQty(change) {
        const input = document.getElementById('qty-input');
        let val = parseInt(input.value) + change;
        
        if (val >= 1 && val <= maxStock) {
            input.value = val;
        } else if (val > maxStock && maxStock > 0) {
            window.showModal("Stock máximo", `Lo sentimos, sólo tenemos ${maxStock} unidades disponibles de este producto.`);
        }
    }

    function addToCartConfirm() {
        if(maxStock > 0) {
            const qty = parseInt(document.getElementById('qty-input').value);
            
            // Integración en tiempo real con el carrito
            window.addToCartGlobal({
                id: {{ $producto['id'] }},
                nombre: '{{ addslashes($producto['nombre']) }}',
                precio: {{ str_replace(',', '', $producto['precio']) }},
                cat: '{{ $producto['cat'] ?? "motor" }}',
                imagen: '{{ $producto['imagen'] }}',
                maxStock: maxStock
            }, qty);

            window.showModal(
                "Añadido al carrito", 
                `Se han añadido ${qty} unidades al carrito y están listas para su proceso.`, 
                "success", 
                { text: "Ir a pagar", url: "{{ url('/carrito') }}" }
            );
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        if (typeof gsap !== 'undefined') {
            gsap.from(".gsap-item", {
                y: 20,
                opacity: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: "power2.out",
                delay: 0.1
            });
        }
    });
</script>
@endsection
