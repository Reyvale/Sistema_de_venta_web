<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Venta</title>
    <link rel="stylesheet" href="../css/ventas.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        input, select { padding: 8px; margin: 5px 0; width: 100%; }
        .carrito, .totales { margin-top: 20px; }
        .ui-autocomplete-loading { background: white url("../img/loading.gif") right center no-repeat; }
    </style>
</head>
<body>
<div class="container">
    <h2>Nueva Venta</h2>

    <input type="text" id="buscarProducto" placeholder="🔍 Buscar producto por nombre...">
    <input type="hidden" id="productoId">
    <input type="number" id="cantidad" placeholder="Cantidad del producto" min="1">
    <button onclick="agregarProducto()">Agregar</button>

    <div class="carrito">
        <table border="1" width="100%" id="tablaCarrito">
            <thead>
                <tr>
                    <th>Producto</th><th>Cant</th><th>Precio</th><th>Subtotal</th><th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="totales">
        <p><strong>Total:</strong> <span id="totalVenta">$0.00</span></p>
        <label>💵 Efectivo recibido:</label>
        <input type="number" id="efectivo" placeholder="Cantidad con la que paga" oninput="calcularCambio()">
        <label>💰 Cambio:</label>
        <input type="text" id="cambio" readonly>
        <button onclick="finalizarVenta()">Finalizar Venta</button>
    </div>
<br>
    <div style="margin-top: 10px;">
        <a href="../panel.php" style="background-color:green;color:white;padding:10px;border-radius:5px;text-decoration:none;">🔙 Regresar</a>
    </div>
</div>

<!-- JS y jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
let carrito = [];
let productoSeleccionado = {};

$(function() {
    $("#buscarProducto").autocomplete({
        source: "../ventas/buscar_productos.php",
        minLength: 2,
        select: function(event, ui) {
            productoSeleccionado = ui.item;
            $("#productoId").val(ui.item.id);
        }
    });
});

function agregarProducto() {
    const id = $("#productoId").val();
    const nombre = $("#buscarProducto").val();
    const cantidad = parseInt($("#cantidad").val());
    const precio = parseFloat(productoSeleccionado.precio);
    const stock = parseInt(productoSeleccionado.stock);

    if (!id || cantidad < 1) return alert("⚠️ Seleccione un producto válido y cantidad.");
    if (cantidad > stock) return alert("❌ Stock insuficiente.");

    carrito.push({ id, nombre, cantidad, precio });
    actualizarCarrito();
    $("#buscarProducto, #productoId, #cantidad").val('');
}

function actualizarCarrito() {
    const tbody = $("#tablaCarrito tbody");
    tbody.html('');
    let total = 0;

    carrito.forEach((item, i) => {
        const subtotal = item.cantidad * item.precio;
        total += subtotal;
        tbody.append(`
            <tr>
                <td>${item.nombre}</td>
                <td>${item.cantidad}</td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>$${subtotal.toFixed(2)}</td>
                <td><button onclick="quitarProducto(${i})">❌</button></td>
            </tr>
        `);
    });

    $("#totalVenta").text(`$${total.toFixed(2)}`);
    calcularCambio();
}

function quitarProducto(index) {
    carrito.splice(index, 1);
    actualizarCarrito();
}

function calcularCambio() {
    const efectivo = parseFloat($("#efectivo").val());
    const total = parseFloat($("#totalVenta").text().replace('$', ''));
    const cambio = efectivo - total;
    $("#cambio").val(isNaN(cambio) ? '' : cambio >= 0 ? `$${cambio.toFixed(2)}` : '❌ Insuficiente');
}

function finalizarVenta() {
    const efectivo = parseFloat($("#efectivo").val());
    const total = parseFloat($("#totalVenta").text().replace('$', ''));

    if (efectivo < total) return alert("❌ Efectivo insuficiente");

    fetch('guardar_venta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ carrito, efectivo })
    })
    .then(r => r.json())
    .then(data => {
    if (data.success && data.id) {
        window.location.href = `ticket.php?id=${data.id}`; // ← ID dinámico
    } else {
        alert("Error al guardar venta");
    }
});

}
</script>
</body>
</html>
