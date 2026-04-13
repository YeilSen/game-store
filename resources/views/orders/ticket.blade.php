<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $orderData['id'] ?? 'N/A' }} - Rayonic Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(circle at 20% 30%, #0a0f1e, #020617);
            font-family: 'Poppins', 'Segoe UI', 'Orbitron', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .ticket-container {
            width: 100%;
            max-width: 860px;
            margin: 0 auto;
        }

        .ticket {
            background: rgba(6, 10, 28, 0.92);
            backdrop-filter: blur(2px);
            border: 2px solid #0ff;
            border-radius: 38px;
            padding: 2rem;
            box-shadow: 0 25px 40px -12px rgba(0, 255, 255, 0.45);
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .logo {
            font-size: 2.3rem;
            font-weight: 800;
            letter-spacing: 2px;
            background: linear-gradient(135deg, #0ff, #7df9ff, #2dd4bf);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-family: 'Orbitron', monospace;
        }

        .subtitle {
            font-size: 0.75rem;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            background: #0e142e;
            display: inline-block;
            padding: 0.25rem 1.3rem;
            border-radius: 40px;
            margin-top: 8px;
            color: #b0f0ff;
            border: 1px solid rgba(0, 255, 255, 0.5);
        }

        .info-panel {
            background: rgba(2, 6, 23, 0.7);
            border-radius: 28px;
            padding: 1rem 1.6rem;
            margin-bottom: 1.6rem;
            border: 1px solid rgba(34, 211, 238, 0.4);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 0.6rem 0;
            border-bottom: 1px dashed rgba(100, 116, 139, 0.5);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 700;
            color: #94a3b8;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .info-value {
            font-weight: 700;
            color: #f1f5f9;
            font-family: 'Courier New', monospace;
            font-size: 0.95rem;
        }

        .badge-pagado {
            background: linear-gradient(145deg, #0b2e1f, #05200f);
            border-left: 3px solid #2ecc71;
            padding: 0.25rem 1rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: bold;
            color: #8effb2;
        }

        .divider-neon {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 1rem 0;
        }

        .divider-neon hr {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, transparent, #0ff, #f0f, transparent);
            border: none;
        }

        .divider-icon {
            color: #0ff;
            font-size: 1rem;
            font-weight: bold;
        }

        .item-card {
            background: rgba(0, 20, 45, 0.7);
            border-radius: 24px;
            padding: 1rem 1.4rem;
            margin: 0.8rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(0, 255, 255, 0.3);
        }

        .item-name {
            font-weight: 800;
            font-size: 1.1rem;
            color: #dcf5ff;
        }

        .item-qty {
            font-size: 0.7rem;
            color: #b9c7e0;
            background: #0a122e;
            padding: 3px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        .item-price {
            font-weight: 800;
            color: #facc15;
            font-size: 1.3rem;
            font-family: monospace;
        }

        .total-section {
            margin: 1.4rem 0 0.8rem;
            background: linear-gradient(115deg, #020c1c, #041a2a);
            border-radius: 30px;
            padding: 1.2rem 1.6rem;
            border: 1px solid #0ff;
            box-shadow: 0 0 16px rgba(0, 255, 255, 0.4);
        }

        .total-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 0.5rem;
        }

        .total-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 600;
            color: #8dd0ff;
        }

        .total-amount {
            text-align: right;
            font-size: 2.4rem;
            font-weight: 800;
            font-family: 'Orbitron', monospace;
            color: #0ff;
            text-shadow: 0 0 10px cyan;
            margin-top: 5px;
        }

        .usd-note {
            text-align: right;
            font-size: 0.7rem;
            color: #7ab3ff;
            margin-top: 8px;
        }

        .promo-box {
            background: #010814;
            border-radius: 60px;
            padding: 0.35rem 1.3rem;
            text-align: center;
            display: inline-block;
            width: auto;
            margin: 0 auto;
        }

        .promo-text {
            font-size: 0.7rem;
            font-family: monospace;
            color: #b0d4ff;
        }

        .footer-verif {
            text-align: center;
            margin-top: 1.8rem;
            padding-top: 1rem;
            border-top: 1px dashed rgba(0, 255, 255, 0.4);
        }

        .blockchain-badge {
            display: inline-block;
            background: #0a142e;
            padding: 6px 20px;
            border-radius: 40px;
            margin-bottom: 14px;
            font-size: 0.7rem;
            font-weight: bold;
            color: #7befb0;
            border: 1px solid #2ecc71;
        }

        .btn-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #0ff, #0a0);
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            z-index: 1000;
        }

        /* ============================================ */
        /* ESTILOS PARA IMPRESIÓN PDF - FONDO BLANCO */
        /* ============================================ */
        @media print {
            @page {
                size: letter;
                margin: 0.5in;
            }
            
            * {
                background: white !important;
                background-color: white !important;
                color: black !important;
                box-shadow: none !important;
                text-shadow: none !important;
            }
            
            body {
                background: white !important;
                padding: 0;
                margin: 0;
            }
            
            .ticket-container {
                background: white !important;
            }
            
            .ticket {
                background: white !important;
                border: 1px solid #ccc !important;
                box-shadow: none !important;
                padding: 20px;
            }
            
            .btn-print {
                display: none !important;
            }
            
            .logo {
                background: none !important;
                color: #0a0a0a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .total-amount {
                color: #0a0a0a !important;
                text-shadow: none !important;
            }
            
            .divider-icon {
                color: #0a0a0a !important;
            }
            
            .item-price {
                color: #0a0a0a !important;
            }
            
            .info-label {
                color: #555 !important;
            }
            
            .divider-neon hr {
                background: #333 !important;
            }
            
            .info-panel, .item-card, .total-section {
                background: #f5f5f5 !important;
                border: 1px solid #ddd !important;
            }
            
            .badge-pagado {
                background: #d4edda !important;
                color: #155724 !important;
                border-left: 3px solid #28a745 !important;
                border: 1px solid #28a745 !important;
            }
            
            .promo-box {
                background: #e9ecef !important;
                border: 1px solid #ccc !important;
            }
            
            .promo-text {
                color: #333 !important;
            }
            
            .blockchain-badge {
                background: #e9ecef !important;
                color: #155724 !important;
                border: 1px solid #28a745 !important;
            }
            
            .footer-verif {
                border-top: 1px dashed #ccc !important;
            }
            
            .subtitle {
                background: #e9ecef !important;
                color: #333 !important;
                border: 1px solid #ccc !important;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="ticket-container">
    <div class="ticket" id="ticket-content">
        <!-- El contenido se generará aquí -->
    </div>
</div>

<button class="btn-print" onclick="window.print();">🖨️ Guardar como PDF / Imprimir</button>

<script>
    // Datos recibidos directamente de Laravel
    const orderData = @json($orderData);
    
    console.log('Datos recibidos:', orderData);

    function generarTicket() {
        if (!orderData || !orderData.items) {
            document.getElementById('ticket-content').innerHTML = `
                <div style="text-align: center; color: red; padding: 50px;">
                    <h2>Error al cargar el ticket</h2>
                    <p>No se recibieron datos de la orden.</p>
                </div>
            `;
            return;
        }

        // GENERAR HTML DE LOS ITEMS (PRODUCTOS COMPRADOS)
        let itemsHTML = '';
        if (orderData.items.length > 0) {
            itemsHTML = `
                <div class="divider-neon">
                    <hr><span class="divider-icon">[ ITEMS ]</span><hr>
                </div>
            `;
            orderData.items.forEach(item => {
                const precioTotal = (item.precio_unitario * item.cantidad).toFixed(2);
                itemsHTML += `
                    <div class="item-card">
                        <div>
                            <div class="item-name">🎮 ${escapeHtml(item.nombre)}</div>
                            <div class="item-qty">CANTIDAD: ${item.cantidad} UNIDAD${item.cantidad !== 1 ? 'ES' : ''}</div>
                        </div>
                        <div class="item-price">$${precioTotal} ${item.moneda}</div>
                    </div>
                `;
            });
        } else {
            itemsHTML += `
                <div class="divider-neon">
                    <hr><span class="divider-icon">[ ITEMS ]</span><hr>
                </div>
                <div style="text-align: center; padding: 20px; color: #888;">
                    No hay items en esta orden
                </div>
            `;
        }

        const usdEquivalente = (orderData.total / 18.15).toFixed(2);
        const descuentoTexto = orderData.descuento_aplicado 
            ? `CÓDIGO: ${orderData.codigo_promo} • Descuento aplicado` 
            : `CÓDIGO: ${orderData.codigo_promo} • 0% descuento aplicado`;

        const html = `
            <div class="header">
                <div class="logo">RAYONIC STORE</div>
                <div class="subtitle">FACTURA DIGITAL GAMER EDITION</div>
            </div>
            
            <div class="info-panel">
                <div class="info-row">
                    <span class="info-label">ORDER ID</span>
                    <span class="info-value">${escapeHtml(orderData.id)}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">FECHA TRANSMISION</span>
                    <span class="info-value">${escapeHtml(orderData.fecha)}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">ESTADO</span>
                    <span class="info-value"><span class="badge-pagado">${escapeHtml(orderData.estado)}</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">METODO</span>
                    <span class="info-value">${escapeHtml(orderData.metodo)}</span>
                </div>
            </div>
            
            ${itemsHTML}
            
            <div class="divider-neon">
                <hr><span class="divider-icon">TOTAL</span><hr>
            </div>
            
            <div class="total-section">
                <div class="total-header">
                    <span class="total-label">MONTO FINAL (IVA INCLUIDO)</span>
                    <span class="total-label">USD/MXN</span>
                </div>
                <div class="total-amount">
                    $${orderData.total.toFixed(2)}
                </div>
                <div class="usd-note">
                    ≈ ${usdEquivalente} USD 
                </div>
            </div>
            
            <div style="text-align: center; margin: 16px 0;">
                <div class="promo-box">
                    <span class="promo-text">${descuentoTexto}</span>
                </div>
            </div>
            
            <div class="footer-verif">
                <div class="blockchain-badge">
                    ✔ COMPRA VERIFICADA POR BLOCKCHAIN GAMER
                </div>
                <div style="margin: 8px 0 6px;">
                    <strong>⚡ Gracias por jugar con nosotros ⚡</strong><br>
                    <small>SÍGUENOS: @rayonic_store | Discord: gg/rayonic</small>
                </div>
                <div style="margin-top: 10px; font-size: 0.6rem; opacity: 0.8;">
                    Rayonic Store © 2026 • Todos los derechos reservados
                </div>
            </div>
        `;
        
        document.getElementById('ticket-content').innerHTML = html;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // Ejecutar cuando cargue la página
    document.addEventListener('DOMContentLoaded', generarTicket);
</script>
</body>
</html>