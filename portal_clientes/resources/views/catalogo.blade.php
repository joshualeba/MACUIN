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
    $productos = [
        ['id' => 1, 'nombre' => 'Amortiguador de gas premium', 'precio' => '1,450', 'stock' => 15, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/1_mum70h.jpg', 'desc' => 'Vuelve tu auto estable ante los baches y elimina el balanceo por completo.', 'features' => ['Garantía' => '2 años', 'Vida útil' => '50,000 km', 'Material' => 'Acero templado']],
        ['id' => 2, 'nombre' => 'Batería automotriz 12V LTH', 'precio' => '2,300', 'stock' => 45, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803604/2_gv1kb4.jpg', 'desc' => 'Arranque seguro bajo cualquier clima con celdas de alta duración.', 'features' => ['Voltaje' => '12V', 'Amperaje' => '650 CCA', 'Garantía' => '4 años']],
        ['id' => 3, 'nombre' => 'Llanta deportiva de alto rendimiento', 'precio' => '1,850', 'stock' => 3, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/3_jhe3ti.jpg', 'desc' => 'Maximiza el agarre y la tracción en cualquier condición de pista o lluvia.', 'features' => ['Medida' => '225/45R17', 'Índice de vel.' => 'W (270 km/h)', 'Tracción' => 'AA']],
        ['id' => 4, 'nombre' => 'Filtro de aceite sintético', 'precio' => '250', 'stock' => 12, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/4_rejzkf.jpg', 'desc' => 'Atrapa hasta el 99% de las partículas contaminantes del motor.', 'features' => ['Eficiencia' => '99.9%', 'Intervalo' => '15,000 km', 'Válvula' => 'Anti-retorno']],
        ['id' => 5, 'nombre' => 'Juego de balatas cerámicas', 'precio' => '750', 'stock' => 25, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/5_xqmuur.jpg', 'desc' => 'Frenado silencioso, libre de asbesto y ultra seguro.', 'features' => ['Material' => 'Cerámica', 'Polvo' => 'Ultra bajo', 'Sensor' => 'Incluido']],
        ['id' => 6, 'nombre' => 'Faros LED de largo alcance', 'precio' => '1,200', 'stock' => 8, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803611/6_wcpptk.jpg', 'desc' => 'Iluminación nítida con más de 10,000 lúmenes de potencia para carretera.', 'features' => ['Lúmenes' => '10,000', 'Temp. color' => '6000K', 'Consumo' => '35W']],
        ['id' => 7, 'nombre' => 'Radiador de aluminio reforzado', 'precio' => '2,100', 'stock' => 5, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803582/7_nrnjsu.jpg', 'desc' => 'Sistema de enfriamiento superior para prevenir sobrecalentamientos.', 'features' => ['Material' => 'Aluminio', 'Filas' => '2 hileras', 'Garantía' => '1 año']],
        ['id' => 8, 'nombre' => 'Bomba de agua de alto flujo', 'precio' => '850', 'stock' => 18, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803601/8_djl9tm.jpg', 'desc' => 'Mantiene un flujo constante y óptimo del refrigerante.', 'features' => ['Material' => 'Acero', 'Impulsor' => 'Metálico', 'Sellado' => 'Premium']],
        ['id' => 9, 'nombre' => 'Kit de distribución completo', 'precio' => '3,400', 'stock' => 2, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803605/9_o22arl.jpg', 'desc' => 'Sincronización perfecta del motor, incluye banda, tensor y polea.', 'features' => ['Garantía' => '60,000 km', 'Incluye' => 'Tensores', 'Material' => 'Kevlar']],
        ['id' => 10, 'nombre' => 'Sensor de oxígeno Denso', 'precio' => '950', 'stock' => 10, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/10_xqowdm.jpg', 'desc' => 'Optimiza el consumo de combustible midiendo la mezcla de gases.', 'features' => ['Cables' => '4 pines', 'Tipo' => 'Calentado', 'Garantía' => '1 año']],
        ['id' => 11, 'nombre' => 'Inyector de combustible 4 puertos', 'precio' => '1,100', 'stock' => 15, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/11_n3roer.jpg', 'desc' => 'Pulverización exacta para aprovechar cada gota de gasolina.', 'features' => ['Puertos' => '4 orificios', 'Caudal' => '250cc/min', 'Resistencia' => 'Alta']],
        ['id' => 12, 'nombre' => 'Bobina de encendido', 'precio' => '600', 'stock' => 30, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803587/12_dbimni.jpg', 'desc' => 'Proporciona la chispa con voltaje ideal para la ignición.', 'features' => ['Voltaje' => '40,000V', 'Conector' => '3 Pines', 'Garantía' => '1 año']],
        ['id' => 13, 'nombre' => 'Bujía láser de Iridio', 'precio' => '250', 'stock' => 100, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803615/13_q15jp9.jpg', 'desc' => 'Encendido instantáneo y ahorro de combustible con punta fina.', 'features' => ['Punta' => 'Iridio 0.6mm', 'Vida útil' => '100,000 km', 'Grado térmico' => '6']],
        ['id' => 14, 'nombre' => 'Alternador 12V', 'precio' => '2,800', 'stock' => 4, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803612/14_cx1b8o.jpg', 'desc' => 'Generador de energía probado para abastecer todos los accesorios eléctricos.', 'features' => ['Amperaje' => '110A', 'Voltaje' => '12V', 'Polea' => '6 canales']],
        ['id' => 15, 'nombre' => 'Marcha de arranque', 'precio' => '1,900', 'stock' => 7, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803600/15_ojqtbz.jpg', 'desc' => 'Engrane preciso y potente para iniciar tu motor suavemente.', 'features' => ['Dientes' => '9', 'Garantía' => '2 años', 'Construcción' => 'Reforzada']],
        ['id' => 16, 'nombre' => 'Compresor A/C', 'precio' => '3,600', 'stock' => 3, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803605/16_jfkbtw.jpg', 'desc' => 'Refrigera tu cabina al instante incluso en días extremadamente soleados.', 'features' => ['Gas' => 'R134a', 'Clutch' => 'Incluido', 'Aceite' => 'PAG 46']],
        ['id' => 17, 'nombre' => 'Condensador A/C', 'precio' => '1,400', 'stock' => 8, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803610/17_lele1h.jpg', 'desc' => 'Disipa el calor del refrigerante de manera altamente eficiente.', 'features' => ['Material' => 'Aluminio', 'Acabado' => 'Plata', 'Garantía' => '1 año']],
        ['id' => 18, 'nombre' => 'Filtro de aire alto flujo', 'precio' => '550', 'stock' => 20, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803587/18_iohp0d.jpg', 'desc' => 'Cónico y lavable, otorga caballos de fuerza y sonido deportivo.', 'features' => ['Lavable' => 'Sí', 'Incremento HP' => '+5 HP', 'Material' => 'Algodón']],
        ['id' => 19, 'nombre' => 'Filtro de cabina carbón', 'precio' => '350', 'stock' => 35, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803587/19_arzsz1.jpg', 'desc' => 'Respira aire purificado bloqueando humo y olores.', 'features' => ['Capas' => '3 capas', 'Carbón activado' => 'Sí', 'Bloqueo' => '99% PM2.5']],
        ['id' => 20, 'nombre' => 'Embrague completo', 'precio' => '2,900', 'stock' => 5, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803588/20_zgaqnp.jpg', 'desc' => 'Cambios de velocidad precisos y suaves como nuevo.', 'features' => ['Incluye' => 'Plato y Disco', 'Diámetro' => '220mm', 'Uso' => 'Urbano']],
        ['id' => 21, 'nombre' => 'Bomba gasolina eléctrica', 'precio' => '1,250', 'stock' => 12, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803582/21_g4odld.jpg', 'desc' => 'Entrega constante y silenciosa de presión al riel.', 'features' => ['Presión' => '45 PSI', 'Caudal' => '130 L/h', 'Filtro' => 'Incluido']],
        ['id' => 22, 'nombre' => 'Rótula de suspensión', 'precio' => '480', 'stock' => 22, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803562/22_riq9wk.jpg', 'desc' => 'Soporta movimientos bruscos manteniendo firme la dirección.', 'features' => ['Engrasable' => 'Sí', 'Material' => 'Acero', 'Posición' => 'Inferior']],
        ['id' => 23, 'nombre' => 'Terminal de dirección', 'precio' => '320', 'stock' => 16, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803609/23_gzgzka.jpg', 'desc' => 'Protege la alineación de tu auto frente a baches.', 'features' => ['Lado' => 'Derecho/Izq.', 'Sello' => 'Neopreno', 'Engrasable' => 'Sí']],
        ['id' => 24, 'nombre' => 'Tornillo estabilizador', 'precio' => '250', 'stock' => 28, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803609/24_rak6t6.jpg', 'desc' => 'Conecta la barra estabilizadora evitando ruidos.', 'features' => ['Largo' => '260mm', 'Bujes' => 'Poliuretano', 'Tratamiento' => 'Anticorrosivo']],
        ['id' => 25, 'nombre' => 'Caliper de freno', 'precio' => '1,600', 'stock' => 4, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803613/25_cjcn0h.jpg', 'desc' => 'Muerde fuertemente el disco otorgando frenadas de pánico.', 'features' => ['Pistones' => '1', 'Purgador' => 'Incluido', 'Garantía' => '1 año']],
        ['id' => 26, 'nombre' => 'Rotor de disco de freno', 'precio' => '950', 'stock' => 11, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803589/26_xj1orj.jpg', 'desc' => 'Ventilado para evitar alabeo en pendientes.', 'features' => ['Ventilado' => 'Sí', 'Barrenación' => '4x100', 'Material' => 'Hierro']],
        ['id' => 27, 'nombre' => 'Válvula PCV', 'precio' => '180', 'stock' => 42, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803599/27_hmbamh.jpg', 'desc' => 'Libera la presión de gases nocivos cuidando los sellos.', 'features' => ['Material' => 'Plástico', 'Mantenimiento' => 'Toda afinación', 'Original' => 'Sí']],
        ['id' => 28, 'nombre' => 'Empaque de cabeza', 'precio' => '850', 'stock' => 7, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803600/28_cul7ox.jpg', 'desc' => 'Sella a la perfección soportando altas presiones termales.', 'features' => ['Material' => 'Multilámina', 'Espesor' => '1.2mm', 'Resistencia' => 'Alta Tensión']],
        ['id' => 29, 'nombre' => 'Sensor MAF', 'precio' => '1,150', 'stock' => 6, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803604/29_tv6npk.jpg', 'desc' => 'Mide con precisión la masa de aire que respira el motor.', 'features' => ['Conector' => '5 pines', 'Elemento' => 'Hilo caliente', 'Garantía' => '1 año']],
        ['id' => 30, 'nombre' => 'Módulo ABS', 'precio' => '4,500', 'stock' => 1, 'imagen' => 'https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803582/30_gvgpfh.jpg', 'desc' => 'El cerebro para frenar sin bloquear ruedas.', 'features' => ['Canales' => '4', 'Plug & play' => 'Sí', 'Garantía' => '2 años']]
    ];

    $productosActivos = count(array_filter($productos, fn($p) => $p['stock'] > 0));
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
        @foreach($productos as $producto)
        @php
            $cat = 'motor';
            $nameLower = mb_strtolower($producto['nombre'], 'UTF-8');
            if (str_contains($nameLower, 'freno') || str_contains($nameLower, 'balata') || str_contains($nameLower, 'caliper') || str_contains($nameLower, 'abs')) $cat = 'frenos';
            elseif (str_contains($nameLower, 'batería') || str_contains($nameLower, 'led') || str_contains($nameLower, 'bobina') || str_contains($nameLower, 'bujía') || str_contains($nameLower, 'alternador') || str_contains($nameLower, 'sensor') || str_contains($nameLower, 'marcha')) $cat = 'electrico';
            elseif (str_contains($nameLower, 'amortiguador') || str_contains($nameLower, 'rótula') || str_contains($nameLower, 'terminal') || str_contains($nameLower, 'tornillo') || str_contains($nameLower, 'suspensión') || str_contains($nameLower, 'llanta')) $cat = 'suspension';
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
            <div class="product-price" style="font-size: 1.25rem; margin-bottom: 0.5rem;">${{ $producto['precio'] }} <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: normal;">MXN</span></div>
            
            <div class="product-actions">
                <a href="{{ url('/producto/' . $producto['id']) }}" class="btn-outline">Ver más</a>
                @if($producto['stock'] > 0)
                    <button class="btn-primary-action" onclick="agregarAlCarrito({{ $producto['id'] }})">Agregar al carrito</button>
                @else
                    <button class="btn-primary-action" style="background: #94A3B8; cursor: not-allowed;" disabled>Agotado</button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function agregarAlCarrito(id) {
        window.showModal("Añadido al carrito", "El producto ha sido añadido correctamente a tu carrito de compras.", "success", { text: "Ir al carrito", url: "{{ url('/carrito') }}" });
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
