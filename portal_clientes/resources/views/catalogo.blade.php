@extends('app')

@push('styles')
<style>
    .kpi-card { background: white; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.5rem; flex: 1; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .kpi-title { font-size: 0.875rem; color: #64748B; margin-bottom: 0.5rem; font-weight: 500; }
    .kpi-value { font-size: 1.75rem; color: #1E293B; font-weight: 800; }
    .kpi-icon { width: 46px; height: 46px; background: #F8FAFC; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #475569; border: 1px solid #F1F5F9; }
    
    .product-img-wrapper { height: 180px; width: 100%; border-radius: 8px; margin-bottom: 1rem; overflow: hidden; background: #F1F5F9; position: relative; }
    .product-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
    .card:hover .product-img { transform: scale(1.05); }
    .stock-badge { position: absolute; top: 10px; right: 10px; background: rgba(16, 185, 129, 0.9); color: white; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; backdrop-filter: blur(4px); }
    .stock-badge.low-stock { background: rgba(239, 68, 68, 0.9); }
    
    .product-actions { display: flex; gap: 0.5rem; margin-top: 1rem; }
    .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-muted); padding: 0.5rem 1rem; border-radius: 999px; font-weight: 600; font-size: 0.8rem; cursor: pointer; text-align: center; flex: 1; text-decoration: none; transition: all 0.2s; }
    .btn-outline:hover { background: rgba(148, 163, 184, 0.1); color: var(--text-main); border-color: var(--text-main); }
    .btn-primary-action { background: #1E293B; color: white; border: none; padding: 0.5rem 1rem; border-radius: 999px; font-weight: 600; font-size: 0.8rem; cursor: pointer; text-align: center; flex: 1.5; text-decoration: none; transition: all 0.2s; }
    .btn-primary-action:hover { background: #0F172A; }
    body.dark-mode .btn-primary-action { background: #FFFFFF; color: #000000; }
    body.dark-mode .btn-primary-action:hover { background: #E2E8F0; }

    .filter-btn { background: transparent; border: 1px solid var(--border); color: var(--text-muted); padding: 0.5rem 1.25rem; border-radius: 999px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; white-space: nowrap; }
    .filter-btn:hover { color: var(--text-main); border-color: var(--text-muted); }
    .filter-btn.active { background: var(--text-main); color: var(--bg-light); border-color: var(--text-main); }
</style>
@endpush

@section('content')
@php
    // $productos ya ha sido filtrado en web.php para mostrar solo los activos
    $productosActivos = is_array($productos) ? count($productos) : 0;
    $nuevosHoy = 12;
    $ofertas = 24;
@endphp

<div class="gsap-container">
    <div class="page-title gsap-item">Catálogo principal de productos</div>
    <p class="gsap-item" style="color: var(--text-muted); margin-bottom: 2rem;">Encuentra las mejores piezas para tu vehículo al instante.</p>

    <!-- Resumen de información útil -->
    <div class="gsap-item" style="display: flex; gap: 1.5rem; margin-bottom: 2.5rem; justify-content: center;">
        <div class="kpi-card" style="display: flex; align-items: center; justify-content: space-between; max-width: 400px; width: 100%;">
            <div>
                <div class="kpi-title">Productos disponibles</div>
                <div class="kpi-value">{{ number_format($productosActivos) }}</div>
            </div>
            <div class="kpi-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            </div>
        </div>
    </div>

    <!-- Barra de búsqueda y clasificación (Horizontal) -->
    <div class="gsap-item" style="display: flex; gap: 1rem; align-items: center; justify-content: space-between; margin-bottom: 2rem; background: var(--card-bg); padding: 1rem; border-radius: 12px; border: 1px solid var(--border); flex-wrap: wrap;">
        <!-- Barra de búsqueda a la izquierda -->
        <div style="flex: 1; min-width: 250px; position: relative; max-width: 400px;">
            <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="searchInput" placeholder="Buscar refacción automotriz..." style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.8rem; border-radius: 999px; border: 1px solid var(--border); background: var(--bg-light); color: var(--text-main); font-size: 0.95rem; outline: none; transition: border-color 0.2s; box-sizing: border-box;">
        </div>
        
        <!-- Filtros por categoría -->
        <div style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.2rem; align-items: center;" class="category-filters">
            <button class="filter-btn active" data-filter="all">Todos</button>
            <button class="filter-btn" data-filter="frenos">Frenos</button>
            <button class="filter-btn" data-filter="electrico">Eléctrico</button>
            <button class="filter-btn" data-filter="suspension">Suspensión</button>
            <button class="filter-btn" data-filter="motor">Motor</button>
        </div>
    </div>

    <!-- Grid de autopartes -->
    <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @if(is_array($productos) && count($productos) > 0)
            @foreach($productos as $producto)
            @if($producto['active'])
                @php
                    $cat = $producto['cat'] ?? 'motor';
                    $nameLower = mb_strtolower($producto['nombre'], 'UTF-8');
                @endphp
                <div class="card gsap-card product-item" data-category="{{ $cat }}" data-name="{{ $nameLower }}" style="display: flex; flex-direction: column;">
                    <div class="product-img-wrapper">
                        <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}" class="product-img">
                        @if($producto['stock'] == 0)
                            <span class="stock-badge low-stock">Agotado</span>
                        @elseif($producto['stock'] < 5)
                            <span class="stock-badge low-stock">¡Solo {{ $producto['stock'] }} disponibles!</span>
                        @else
                            <span class="stock-badge">Stock: {{ $producto['stock'] }}</span>
                        @endif
                    </div>
                    
                    <h3 class="product-title" style="font-size: 1.05rem; flex: 1; margin-bottom: 0.5rem; line-height: 1.3;">{{ $producto['nombre'] }}</h3>
                    <div class="product-price" style="font-size: 1.25rem; margin-bottom: 0.5rem;">${{ is_numeric($producto['precio']) ? number_format((float)$producto['precio']) : $producto['precio'] }} <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: normal;">MXN</span></div>
                    
                    <div class="product-actions">
                        <a href="{{ url('/producto/' . $producto['id']) }}" class="btn-outline">Ver más</a>
                        @if($producto['stock'] > 0)
                            <button class="btn-primary-action" onclick="agregarAlCarrito({{ $producto['id'] }}, '{{ addslashes($producto['nombre']) }}', {{ str_replace(',', '', $producto['precio']) }}, '{{ $producto['cat'] ?? 'motor' }}', '{{ $producto['imagen'] }}', {{ $producto['stock'] }})">Agregar al carrito</button>
                        @else
                            <button class="btn-primary-action" style="background: #94A3B8; cursor: not-allowed;" disabled>Agotado</button>
                        @endif
                    </div>
                </div>
            @endif
            @endforeach
        @else
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: var(--card-bg); border-radius: 12px; border: 1px solid var(--border);">
                <h3 style="color: var(--text-muted);">No hay productos disponibles por el momento o no se pudo contactar al servidor.</h3>
            </div>
        @endif
    </div>
</div>

<script>
    function agregarAlCarrito(id, nombre, precio, categoria, imagen, maxStock) {
        window.addToCartGlobal({
            id: id,
            nombre: nombre,
            precio: parseFloat(precio),
            cat: categoria,
            imagen: imagen,
            maxStock: maxStock
        }, 1);
        
        window.showModal(
            "Añadido al carrito", 
            "El producto ha sido añadido correctamente a tu carrito de compras en tiempo real.", 
            "success", 
            { text: "Ir al carrito", url: "{{ url('/carrito') }}" }
        );
    }

    document.addEventListener("DOMContentLoaded", () => {
        // Animaciones GSAP limpias
        if (typeof gsap !== 'undefined') {
            gsap.from(".topbar-gsap", { y: -15, opacity: 0, duration: 0.8, ease: "power2.out" });
            
            gsap.from(".gsap-item", {
                y: 15,
                opacity: 0,
                duration: 0.7,
                stagger: 0.1,
                ease: "power2.out",
                delay: 0.1
            });

            gsap.from(".gsap-card", {
                scale: 0.95,
                y: 10,
                opacity: 0,
                duration: 0.4,
                stagger: 0.05,
                ease: "power1.out",
                delay: 0.3
            });
        }

        // Lógica interactiva de barra de búsqueda y filtros sin recargar la página
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productItems = document.querySelectorAll('.product-item');
        const searchInput = document.getElementById('searchInput');

        function filterProducts() {
            const activeBtn = document.querySelector('.filter-btn.active');
            const filterValue = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
            const searchValue = searchInput.value.toLowerCase().trim();

            productItems.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                const itemName = item.getAttribute('data-name');
                
                const matchCategory = filterValue === 'all' || itemCat === filterValue;
                const matchSearch = itemName.includes(searchValue);

                if (matchCategory && matchSearch) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); 
                e.stopPropagation();

                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                filterProducts();
            });
        });

        // Event listener para la barra de búsqueda en tiempo real
        if(searchInput) {
            searchInput.addEventListener('input', filterProducts);
        }
    });
</script>
@endsection
