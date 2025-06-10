<?php
include '../includes/conexion.php';

$id = $_POST['id'];
$cantidad = intval($_POST['cantidad']);
$tipo = $_POST['tipo'];

if ($tipo === 'entrada') {
    $sql = "UPDATE productos SET stock = stock + $cantidad WHERE id = $id";
} else {
    $sql = "UPDATE productos SET stock = stock - $cantidad WHERE id = $id AND stock >= $cantidad";
}

if (mysqli_query($conexion, $sql)) {
    header("Location: inventario.php");
} else {
    echo "Error al actualizar stock";
}
?>
