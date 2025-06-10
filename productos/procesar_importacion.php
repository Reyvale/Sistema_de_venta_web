<?php
include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo']['tmp_name'])) {
    $archivo = $_FILES['archivo']['tmp_name'];

    $handle = fopen($archivo, 'r');
    if ($handle === false) {
        die("No se pudo abrir el archivo.");
    }

    // Leer encabezado
    fgetcsv($handle, 1000, ",");

    $importados = 0;
    $errores = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $nombre = mysqli_real_escape_string($conexion, trim($data[0]));
        $descripcion = mysqli_real_escape_string($conexion, trim($data[1]));
        $precio = floatval($data[2]);
        $stock = intval($data[3]);

        if ($nombre != '' && $precio >= 0 && $stock >= 0) {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock) 
                    VALUES ('$nombre', '$descripcion', $precio, $stock)";
            if (mysqli_query($conexion, $sql)) {
                $importados++;
            } else {
                $errores++;
            }
        } else {
            $errores++;
        }
    }

    fclose($handle);
    echo "<h3>Importación completada.</h3>";
    echo "<p>Productos importados: $importados</p>";
    echo "<p>Filas con error: $errores</p>";
    echo '<a href="importar_productos.php">🔙 Volver</a>';
} else {
    echo "No se ha enviado ningún archivo.";
}
?>
    