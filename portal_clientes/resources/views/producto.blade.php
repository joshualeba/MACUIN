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

    $producto = null;
    foreach($productos as $p) {
        if($p['id'] == $id) {
            $producto = $p;
            break;
        }
    }
    if(!$producto) $producto = $productos[0];
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
                    {{ $producto['desc'] }}
                </p>
                <div style="width: 50px; height: 3px; background: var(--primary); margin-bottom: 1rem; border-radius: 999px;"></div>
                <p style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; text-align: justify;">
                    Diseñado y desarrollado bajo los más estrictos estándares de la industria, el artículo <strong>{{ $producto['nombre'] }}</strong> restaura la eficiencia y seguridad total de tu vehículo. Gracias a su maquinado de precisión y control de calidad superior (OEM), este componente clave ofrece un ensamble directo e impecable, garantizando una extraordinaria resistencia ante el desgaste por fricción y las altas temperaturas del motor. Adquiérelo ahora y vuelve al camino con total paz mental.
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
            const qty = document.getElementById('qty-input').value;
            window.showModal("Añadido al carrito", `Se han añadido ${qty} unidades al carrito exitosamente.`, "success", { text: "Ir al carrito", url: "{{ url('/carrito') }}" });
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
