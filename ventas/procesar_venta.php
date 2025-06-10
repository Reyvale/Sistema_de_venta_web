<?php
include '../includes/conexion.php';

$carrito = json_decode($_POST['carrito'], true);
$total = $_POST['total'];
$pago = $_POST['pago'];
$cambio = $_POST['cambio'];

$fecha = date("Y-m-d H:i:s");

// Insertar venta principal
mysqli_query($conexion, "INSERT INTO ventas (usuario_id, fecha, total, pago, cambio) VALUES ('$fecha', $total, $pago, $cambio)");
$id_venta = mysqli_insert_id($conexion); // ID generado

// Insertar detalles
foreach ($carrito as $item) {
    $id_producto = $item['id'];
    $cantidad = $item['cantidad'];
    $precio = $item['precio'];
    $subtotal = $precio * $cantidad;

    mysqli_query($conexion, "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio, subtotal)
                             VALUES ($id_venta, $id_producto, $cantidad, $precio, $subtotal)");
}

// Redirigir al ticket
header("Location: ticket.php?id=$id_venta");
exit;
?>
