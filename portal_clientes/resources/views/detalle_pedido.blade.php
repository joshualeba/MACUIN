@extends('app')

@push('styles')
<style>
    .detail-container {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }
    
    .detail-main {
        flex: 2;
        min-width: 300px;
    }
    
    .detail-sidebar {
        flex: 1;
        min-width: 300px;
    }
    
    .detail-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .detail-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .info-row span:last-child {
        color: var(--text-main);
        font-weight: 600;
        text-align: right;
    }

    .product-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px dashed var(--border);
    }

    .product-row:last-child {
        border-bottom: none;
    }

    .product-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        background: var(--bg-light);
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="gsap-container">
    <a href="{{ url('/historial') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary); font-weight: 600; text-decoration: none; margin-bottom: 1.5rem;" class="gsap-item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Volver a mis pedidos
    </a>

    <div class="page-title gsap-item" style="text-transform: uppercase;">Pedido #ORD-{{ $id }}</div>
    <p class="gsap-item" style="color: var(--text-muted); margin-bottom: 2rem;">Detalles confirmados de tu compra y facturación.</p>

    <div class="detail-container">
        <!-- Detalles del pedido -->
        <div class="detail-main gsap-item">
            <div class="detail-card">
                <h3 class="detail-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    Artículos en el pedido
                </h3>
                
                @if($id == '8294')
                <div class="product-row">
                    <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803615/13_q15jp9.jpg" class="product-img">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--text-main);">Bujía láser de Iridio</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">Cantidad: 4</div>
                    </div>
                    <div style="font-weight: 800; color: var(--text-main);">$1000.00</div>
                </div>
                <div class="product-row">
                    <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803599/27_hmbamh.jpg" class="product-img">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--text-main);">Válvula PCV</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">Cantidad: 1</div>
                    </div>
                    <div style="font-weight: 800; color: var(--text-main);">$180.00</div>
                </div>
                <div class="product-row">
                    <img src="https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/4_rejzkf.jpg" class="product-img">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--text-main);">Filtro de aceite sintético</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">Cantidad: 2</div>
                    </div>
                    <div style="font-weight: 800; color: var(--text-main);">$500.00</div>
                </div>
                @else
                <div class="product-row">
                    <div style="width: 60px; height: 60px; border-radius: 8px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--text-main);">Set de Faros LED Adicionales</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">Cantidad: 1</div>
                    </div>
                    <div style="font-weight: 800; color: var(--text-main);">$1200.00</div>
                </div>
                @endif
            </div>

            <div class="detail-card">
                <h3 class="detail-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Información de entrega
                </h3>
                <div class="info-row">
                    <span>Receptor:</span>
                    <span>Armando Maldonado Morales</span>
                </div>
                <div class="info-row">
                    <span>Dirección:</span>
                    <span>Blvd. Bernardo Quintana 111, Álamos 2da Sección</span>
                </div>
                <div class="info-row">
                    <span>Ciudad:</span>
                    <span>Santiago de Querétaro, Querétaro</span>
                </div>
                <div class="info-row">
                    <span>Código Postal:</span>
                    <span>76160</span>
                </div>
            </div>
        </div>

        <!-- Sidebar / Resumen -->
        <div class="detail-sidebar gsap-item">
            <div style="background: var(--primary); color: white; border-radius: 16px; padding: 2rem; position: sticky; top: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 800; text-transform: uppercase; margin-bottom: 2rem;">Resumen financiero</h3>

                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #CBD5E1; font-weight: 500;">
                    <span>Estado de pago</span>
                    <span style="color: #10B981;">Aprobado</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #CBD5E1; font-weight: 500;">
                    <span>Estado del pedido</span>
                    <span>{{ $id == '8294' ? 'En bodega' : 'Entregado' }}</span>
                </div>

                <hr style="border-color: rgba(255,255,255,0.2); margin-bottom: 1.5rem;">

                <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 2rem;">
                    <span style="color: #94A3B8; font-size: 0.8rem; text-transform: uppercase;">Importe total</span>
                    <span style="font-size: 2.5rem; font-weight: 800; margin: 0;">${{ $id == '8294' ? '1,948.80' : '1,200.00' }}</span>
                </div>

                <button onclick="descargarComprobante('{{ $id }}', '{{ $id == '8294' ? '1,948.80' : '1,200.00' }}', '{{ $id == '8294' ? 'Hoy' : '15 Ene 2026' }}')" class="btn btn-primary" style="display: flex; align-items: center; justify-content: center; width: 100%; border: none; cursor: pointer; text-align: center; background: white; color: var(--primary); font-weight: 800; text-transform: uppercase; padding: 1rem; border-radius: 8px; transition: transform 0.2s; gap: 0.5rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Descargar comprobante
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function descargarComprobante(orderId, total, date) {
        // Obtenemos jsPDF del contexto de la ventana
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Colores y estilos corporativos
        doc.setFillColor(30, 41, 59); // Fondo cabecera (azul oscuro / slate)
        doc.rect(0, 0, 210, 40, 'F');
        
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(22);
        doc.setFont("helvetica", "bold");
        doc.text("MACUIN", 15, 25);
        
        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        doc.text("COMPROBANTE DE COMPRA", 130, 25);
        
        // Datos del pedido
        doc.setTextColor(30, 41, 59);
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.text("Detalles del Pedido", 15, 60);
        
        doc.setFontSize(11);
        doc.setFont("helvetica", "normal");
        doc.text("Número de Orden: #ORD-" + orderId, 15, 75);
        doc.text("Fecha de Compra: " + date, 15, 85);
        doc.text("Cliente: Armando Maldonado Morales", 15, 95);
        doc.text("Dirección: Blvd. Bernardo Quintana 111, Querétaro", 15, 105);
        
        // Línea divisora
        doc.setDrawColor(226, 232, 240);
        doc.setLineWidth(0.5);
        doc.line(15, 115, 195, 115);
        
        // Tabla de detalles
        doc.setFont("helvetica", "bold");
        doc.text("Concepto", 15, 130);
        doc.text("Monto", 160, 130);
        
        doc.setFont("helvetica", "normal");
        doc.text("Total Pagado (Refacciones automotrices)", 15, 145);
        doc.text("$" + total + " MXN", 160, 145);
        
        // Línea divisora
        doc.line(15, 155, 195, 155);
        
        // Total
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(16, 185, 129); // Verde success
        doc.text("TOTAL DEL PEDIDO", 15, 175);
        doc.text("$" + total + " MXN", 160, 175);
        
        // Footer
        doc.setFontSize(9);
        doc.setTextColor(100, 116, 139);
        doc.setFont("helvetica", "normal");
        doc.text("Gracias por comprar en Macuin. Este documento es un comprobante no fiscal.", 45, 270);
        
        // Descargar PDF
        doc.save("Comprobante_Macuin_ORD-" + orderId + ".pdf");
        
        // Mostrar modal de confirmación en la web
        window.showModal("Descarga exitosa", "El comprobante del pedido #ORD-" + orderId + " se ha descargado correctamente en formato PDF.", "success");
    }

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
    });
</script>
@endsection
