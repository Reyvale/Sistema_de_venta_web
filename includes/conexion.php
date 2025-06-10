
<?php
$conexion = mysqli_connect("localhost", "root", "", "punto_venta");

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
?>

