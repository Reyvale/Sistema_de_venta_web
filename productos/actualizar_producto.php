<?php
include '../includes/conexion.php';
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];

$sql = "UPDATE productos SET 
            nombre = '$nombre',
            descripcion = '$descripcion',
            precio = '$precio',
            stock = '$stock'
        WHERE id = $id";

mysqli_query($conexion, $sql);
header("Location: productos.php");
exit();
