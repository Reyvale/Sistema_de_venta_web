<?php
session_start();
include '../includes/conexion.php';

// Leer datos JSON del frontend
$data = json_decode(file_get_contents("php://input"), true);

// Validar datos
if (
    !$data ||
    !isset($data['carrito']) ||
    !isset($data['efectivo']) ||
    !isset($_SESSION['usuario_id'])
) {
    echo json_encode(['success' => false, 'message' => '⚠️ Datos incompletos']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$carrito = $data['carrito'];
$efectivo = floatval($data['efectivo']);
$total = 0;

// Calcular total
foreach ($carrito as $item) {
    $subtotal = $item['cantidad'] * $item['precio'];
    $total += $subtotal;
}

// Insertar venta
$query = "INSERT INTO ventas (usuario_id, fecha, total, pago) VALUES (?, NOW(), ?, ?)";
$stmt = $conexion->prepare($query);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => '❌ Error en prepare: ' . $conexion->error]);
    exit;
}

$stmt->bind_param('idd', $usuario_id, $total, $efectivo);

if ($stmt->execute()) {
    $venta_id = $stmt->insert_id;

    // Insertar detalles
    $detalle_query = "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
    $stmt_detalle = $conexion->prepare($detalle_query);

    if (!$stmt_detalle) {
        echo json_encode(['success' => false, 'message' => '❌ Error en prepare detalle: ' . $conexion->error]);
        exit;
    }

    foreach ($carrito as $item) {
        $producto_id = $item['id'];
        $cantidad = $item['cantidad'];
        $precio = $item['precio'];

        $stmt_detalle->bind_param('iiid', $venta_id, $producto_id, $cantidad, $precio);
        $stmt_detalle->execute();

        // Actualizar stock
        $conexion->query("UPDATE productos SET stock = stock - $cantidad WHERE id = $producto_id");
    }

    echo json_encode(['success' => true, 'id' => $venta_id]);
} else {
    echo json_encode(['success' => false, 'message' => '❌ Error al guardar venta: ' . $stmt->error]);
}
?>
