<?php
include '../includes/conexion.php';
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, stock)
        VALUES ('$nombre', '$descripcion', '$precio', '$stock')";
mysqli_query($conexion, $sql);

header("Location: productos.php");
exit();
