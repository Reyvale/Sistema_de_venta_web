<?php
include 'includes/conexion.php';

$usuarios = mysqli_query($conexion, "SELECT id, contrasena FROM usuarios");
while ($u = mysqli_fetch_assoc($usuarios)) {
    $id = $u['id'];
    $clavePlano = $u['contrasena'];
    $claveHash = password_hash($clavePlano, PASSWORD_DEFAULT);

    mysqli_query($conexion, "UPDATE usuarios SET contrasena = '$claveHash' WHERE id = $id");
}

echo "✅ Contraseñas actualizadas a formato encriptado.";
?>
