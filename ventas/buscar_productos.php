<?php
include '../includes/conexion.php';

$term = $_GET['term'] ?? '';
$resultado = [];

if ($term !== '') {
    $stmt = $conexion->prepare("SELECT id, nombre, precio, stock FROM productos WHERE nombre LIKE ?");
    $like = "%$term%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $resultado[] = [
            'id' => $row['id'],
            'label' => $row['nombre'] . " (Stock: {$row['stock']})",
            'value' => $row['nombre'],
            'precio' => $row['precio'],
            'stock' => $row['stock']
        ];
    }
}

echo json_encode($resultado);
?>
