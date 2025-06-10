<?php
include '../includes/conexion.php';

// Validación de ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de venta no proporcionado.');
}

$id = intval($_GET['id']);

// Obtener datos de la venta
$venta_sql = "SELECT v.*, u.nombre_completo AS nombre_usuario 
              FROM ventas v 
              JOIN usuarios u ON v.usuario_id = u.id 
              WHERE v.id = $id";

$venta_resultado = mysqli_query($conexion, $venta_sql);

// Validación de resultado
if (!$venta_resultado) {
    die("Error en la consulta de venta: " . mysqli_error($conexion));
}

$venta = mysqli_fetch_assoc($venta_resultado);

// Verificación de existencia
if (!$venta) {
    die("Venta no encontrada.");
}

// Obtener detalles
$detalle_sql = "SELECT dv.*, p.nombre 
                FROM detalle_ventas dv 
                JOIN productos p ON dv.producto_id = p.id 
                WHERE dv.venta_id = $id";

$detalles = mysqli_query($conexion, $detalle_sql);

// Validación de detalles
if (!$detalles) {
    die("Error en la consulta de detalles: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body { font-family: monospace; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 5px; border-bottom: 1px solid #ccc; font-size: 12px; }
    </style>
</head>
<body>
    <p><strong>Fecha y hora:</strong> <span id="fechaHoraJS"></span></p>
    <h3>Soporte Técnico R S C</h3>
    <h3>🧾 Ticket de Venta</h3>

    <p>ID Venta: <?= $venta['id'] ?></p>
    <p>Cliente: <?= $venta['nombre_usuario'] ?></p>
    <p>Total: $<?= number_format($venta['total'], 2) ?></p>
    <p>Pago: $<?= number_format($venta['pago'], 2) ?></p>
    <p>Cambio: $<?= number_format($venta['pago'] - $venta['total'], 2) ?></p>

    <table>
        <thead>
            <tr><th>Producto</th><th>Cant</th><th>Precio</th></tr>
        </thead>
        <tbody>
            <?php while ($d = mysqli_fetch_assoc($detalles)): ?>
                <tr>
                    <td><?= $d['nombre'] ?></td>
                    <td><?= $d['cantidad'] ?></td>
                    <td>$<?= number_format($d['precio'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br><br>
    <div class="boton-regresar">
        <a href="nueva_venta.php" class="btn-regresar">🔙 Regresar</a>
    </div>

    <style>
        @media print {
            @page { size: 5cm 16cm; margin: 0; }
            body { width: 5cm; height: 16cm; margin: 0; font-size: 11px; }
            .boton-regresar { display: none; }
        }

        .btn-regresar {
            background-color: #1E3A8A;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.6);
            transition: 0.3s ease;
        }

        .btn-regresar:hover {
            background-color: #FF6A00;
        }
    </style>

   <script>
    window.onload = () => {
        const fecha = new Date();

        // Ajuste manual de +1 hora (modifique si necesita otra corrección)
        fecha.setHours(fecha.getHours() + 1);

        const dia = String(fecha.getDate()).padStart(2, '0');
        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
        const año = fecha.getFullYear();

        const horas = String(fecha.getHours()).padStart(2, '0');
        const minutos = String(fecha.getMinutes()).padStart(2, '0');
        const segundos = String(fecha.getSeconds()).padStart(2, '0');

        const fechaFormateada = `${dia}/${mes}/${año} ${horas}:${minutos}:${segundos}`;
        document.getElementById('fechaHoraJS').textContent = fechaFormateada;

        window.print();
    };
</script>




</body>
</html>
