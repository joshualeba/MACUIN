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

    <!-- Lista de pedidos dinámicos -->
    <div id="orders-list">
        <!-- Renderizados dinámicamente -->
        <p id="loading-msg" style="color: var(--text-muted);">Cargando tu historial de pedidos...</p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function formatMoney(amount) {
        return parseFloat(amount).toFixed(2);
    }
    
    function formatDate(dateStr) {
        // Aseguramos de que JS lo interprete como UTC
        const utcDateStr = dateStr.endsWith('Z') ? dateStr : dateStr + 'Z';
        const d = new Date(utcDateStr);
        return d.toLocaleDateString('es-MX', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    async function fetchOrders() {
        let nombreCliente = "Cliente Externo";
        try {
            const userData = JSON.parse(localStorage.getItem('macuin_user'));
            if (userData && userData.nombre) {
                nombreCliente = userData.nombre;
            }
        } catch (e) {}

        try {
            const response = await fetch(`http://127.0.0.1:8008/productos/pedidos/${encodeURIComponent(nombreCliente)}`);
            if (!response.ok) throw new Error("Network response was not ok");
            const orders = await response.json();
            renderOrders(orders);
        } catch (error) {
            console.error("Error fetching orders:", error);
            document.getElementById('orders-list').innerHTML = `<p style="color: #EF4444;">Error al cargar el historial.</p>`;
        }
    }

    function renderOrders(orders) {
        const container = document.getElementById('orders-list');
        container.innerHTML = '';
        
        if (orders.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 3rem 1rem;">
                    <div style="font-size: 4rem; opacity: 0.5;">📦</div>
                    <h3 style="color: var(--text-main); font-size: 1.5rem; font-weight: 700;">Aún no tienes pedidos</h3>
                    <p style="color: var(--text-muted); margin-bottom: 2rem;">Tus compras recientes aparecerán aquí.</p>
                    <a href="{{ url('/catalogo') }}" class="btn" style="background: var(--primary); color: white; text-decoration: none; padding: 0.8rem 2.5rem; border-radius: 999px;">Ir al catálogo</a>
                </div>
            `;
            return;
        }

        orders.forEach(order => {
            const dateStr = formatDate(order.fecha);
            const itemsCount = order.items.reduce((sum, item) => sum + item.qty, 0);
            
            // Pasamos el json str al botón para el PDF
            const orderJson = JSON.stringify(order).replace(/'/g, "&apos;").replace(/"/g, "&quot;");

            let statusFront = order.estado.toUpperCase();
            if(statusFront === "EN PROCESO") statusFront = "PROCESANDO";
            let statusColor = "#3B82F6"; // Azul
            let statusBg = "rgba(59, 130, 246, 0.1)";
            let statusIcon = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>`;
            
            if (statusFront.includes("ENVIADO") || statusFront.includes("CAMINO")) {
                statusFront = "EN CAMINO";
                statusColor = "#8B5CF6"; // Morado
                statusBg = "rgba(139, 92, 246, 0.1)";
                statusIcon = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 3h15v13H1z"></path><path d="M16 8h4l3 3v5h-7V8z"></path><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>`;
            } else if (statusFront.includes("ENTREGADO") || statusFront.includes("COMPLETADO")) {
                statusFront = "ENTREGADO";
                statusColor = "#10B981"; // Verde
                statusBg = "rgba(16, 185, 129, 0.1)";
                statusIcon = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`;
            } else {
                statusFront = "EN BODEGA";
            }

            const html = `
            <div class="card gsap-item" style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; gap: 1.5rem; align-items: center;">
                    <div style="width: 60px; height: 60px; background: var(--bg-light); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg class="order-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div class="order-id" style="font-weight: 800; font-size: 1.1rem; color: var(--primary);">#${order.no_orden}</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            <span>Fecha: ${dateStr}</span>
                            <span>Artículos: ${itemsCount}</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 3rem; align-items: center; flex-wrap: wrap;">
                    <div>
                        <div style="color: ${statusColor}; font-weight: 700; font-size: 0.8rem; background: ${statusBg}; padding: 0.4rem 0.8rem; border-radius: 999px; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            ${statusIcon}
                            ${statusFront}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">Total pagado</div>
                        <div style="font-weight: 800; font-size: 1.25rem; color: var(--text-main);">$${formatMoney(order.total)}</div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button class="btn" style="background: transparent; border: 1px solid var(--border); color: var(--text-main);" onclick="descargarComprobante('${orderJson}')">Descargar comprobante</button>
                    <!-- <a href="#" class="btn" style="background: var(--text-main); color: var(--bg-light); text-decoration: none; display: flex; align-items: center;">Ver detalle &rarr;</a> -->
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        if (typeof gsap !== 'undefined') {
            gsap.from(".gsap-item", {
                opacity: 0,
                y: 20,
                stagger: 0.1,
                duration: 0.5,
                ease: "power2.out",
                delay: 0.1
            });
        }
    }

    function descargarComprobante(orderJsonStr) {
        const order = JSON.parse(orderJsonStr);
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Colores corporativos
        doc.setFillColor(30, 41, 59);
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
        doc.text("Número de Orden: #" + order.no_orden, 15, 75);
        doc.text("Fecha de Compra: " + formatDate(order.fecha), 15, 85);
        doc.text("Cliente: " + order.cliente, 15, 95);
        
        // Línea divisora
        doc.setDrawColor(226, 232, 240);
        doc.setLineWidth(0.5);
        doc.line(15, 105, 195, 105);
        
        // Tabla de detalles
        doc.setFont("helvetica", "bold");
        doc.text("Concepto", 15, 120);
        doc.text("Cant.", 120, 120);
        doc.text("Precio U.", 145, 120);
        doc.text("Subtotal", 175, 120);
        
        // Items
        doc.setFont("helvetica", "normal");
        let yPos = 135;
        
        order.items.forEach(item => {
            let productName = item.product_nombre;
            if (productName.length > 40) productName = productName.substring(0, 37) + "...";
            
            doc.text(productName, 15, yPos);
            doc.text(item.qty.toString(), 120, yPos);
            doc.text("$" + formatMoney(item.price), 145, yPos);
            doc.text("$" + formatMoney(item.qty * item.price), 175, yPos);
            yPos += 10;
        });

        // Línea divisora
        doc.line(15, yPos + 10, 195, yPos + 10);
        
        // Total
        const totalNoIva = order.total / 1.16;
        const iva = order.total - totalNoIva;
        
        yPos += 25;
        doc.text("Subtotal (sin IVA):", 130, yPos);
        doc.text("$" + formatMoney(totalNoIva), 175, yPos);
        yPos += 10;
        doc.text("IVA (16%):", 130, yPos);
        doc.text("$" + formatMoney(iva), 175, yPos);

        yPos += 10;
        doc.setFontSize(14);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(16, 185, 129); // Verde success
        doc.text("TOTAL DEL PEDIDO", 120, yPos);
        doc.text("$" + formatMoney(order.total), 175, yPos);
        
        // Footer
        doc.setFontSize(9);
        doc.setTextColor(100, 116, 139);
        doc.setFont("helvetica", "normal");
        doc.text("Gracias por comprar en Macuin. Este documento es un comprobante no fiscal.", 45, 280);
        
        // Descargar PDF
        doc.save("Comprobante_Macuin_" + order.no_orden + ".pdf");
        window.showModal("Descarga exitosa", "El comprobante del pedido #" + order.no_orden + " se ha descargado correctamente.", "success");
    }

    document.addEventListener("DOMContentLoaded", () => {
        fetchOrders();
        
        if (typeof gsap !== 'undefined') {
            gsap.from(".page-title", { opacity: 0, y: -20, duration: 0.5, ease: "power2.out" });
        }
    });
</script>
@endsection