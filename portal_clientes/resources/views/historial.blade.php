@extends('app')

@push('styles')
<style>
    /* Dark mode text/icon fixes para ordenes */
    body.dark-mode .order-id {
        color: white !important;
    }
    body.dark-mode .order-icon {
        stroke: white !important;
    }
</style>
@endpush

@section('content')
<div class="gsap-container">
    <div class="page-title gsap-item" style="text-transform: uppercase;">Tus pedidos</div>
    <p class="gsap-item" style="color: var(--text-muted); margin-bottom: 2rem;">Gestiona tus compras e historial de facturación.</p>

    <!-- Lista de pedidos -->
    <div class="card gsap-item" style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 1.5rem; align-items: center;">
            <div style="width: 60px; height: 60px; background: var(--bg-light); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg class="order-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
            <div>
                <div class="order-id" style="font-weight: 800; font-size: 1.1rem; color: var(--primary);">#ORD-8294</div>
                <div style="color: var(--text-muted); font-size: 0.8rem; display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <span>Fecha: Hoy</span>
                    <span>Artículos: 7</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 3rem; align-items: center; flex-wrap: wrap;">
            <div>
                <div style="color: #3B82F6; font-weight: 700; font-size: 0.8rem; background: rgba(59, 130, 246, 0.1); padding: 0.4rem 0.8rem; border-radius: 999px; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    PROCESANDO EN BODEGA
                </div>
            </div>
            <div style="text-align: right;">
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">Total pagado</div>
                <div style="font-weight: 800; font-size: 1.25rem; color: var(--text-main);">$1,948.80</div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button class="btn" style="background: transparent; border: 1px solid var(--border); color: var(--text-main);" onclick="descargarComprobante('8294', '1,948.80', 'Hoy')">Descargar comprobante</button>
            <a href="{{ url('/pedido/8294') }}" class="btn" style="background: var(--text-main); color: var(--bg-light); text-decoration: none; display: flex; align-items: center;">Ver detalle &rarr;</a>
        </div>
    </div>

    <div class="card gsap-item" style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 1.5rem; align-items: center;">
            <div style="width: 60px; height: 60px; background: var(--bg-light); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg class="order-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
            <div>
                <div class="order-id" style="font-weight: 800; font-size: 1.1rem; color: var(--primary);">#ORD-7164</div>
                <div style="color: var(--text-muted); font-size: 0.8rem; display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <span>Fecha: 15 Ene 2026</span>
                    <span>Artículos: 3</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 3rem; align-items: center; flex-wrap: wrap;">
            <div>
                <div style="color: #10B981; font-weight: 700; font-size: 0.8rem; background: rgba(16, 185, 129, 0.1); padding: 0.4rem 0.8rem; border-radius: 999px; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    ENTREGADO
                </div>
            </div>
            <div style="text-align: right;">
                <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">Total pagado</div>
                <div style="font-weight: 800; font-size: 1.25rem; color: var(--text-main);">$1,200.00</div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button class="btn" style="background: transparent; border: 1px solid var(--border); color: var(--text-main);" onclick="descargarComprobante('7164', '1,200.00', '15 Ene 2026')">Descargar comprobante</button>
            <a href="{{ url('/pedido/7164') }}" class="btn" style="background: var(--text-main); color: var(--bg-light); text-decoration: none; display: flex; align-items: center;">Ver detalle &rarr;</a>
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