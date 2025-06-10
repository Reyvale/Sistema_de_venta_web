<!-- reportes.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📊 Reportes del Sistema</title>
    <link rel="stylesheet" href="css/reportes.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(255, 255, 255);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color:rgb(0, 0, 0);
            margin-bottom: 30px;
        }

        .menu-reportes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .reporte-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 0 10px rgb(45, 204, 23);
            transition: transform 0.3s ease;
        }

        .reporte-card:hover {
            transform: scale(1.03);
        }

        .reporte-card h3 {
            margin-bottom: 10px;
            color:rgb(0, 0, 0);
        }

        .reporte-card button {
            padding: 10px 20px;
            border: none;
            background:rgb(40, 44, 48);
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .reporte-card button:hover {
            background:rgb(35, 192, 69);
        }
    </style>
</head>
<body>

    <h2>📋 Panel de Reportes</h2>

    <div class="menu-reportes">
        <div class="reporte-card">
            <h3>📦 Reporte de Productos</h3>
            <button onclick="location.href='../reporte/reporte_productos.php'">Ver Reporte</button>
        </div>

        <div class="reporte-card">
            <h3>🧾 Ventas Diarias</h3>
            <button onclick="location.href='../reporte/reporte_ventas_diarias.php'">Ver Reporte</button>
        </div>

        <div class="reporte-card">
            <h3>📅 Ventas Mensuales</h3>
            <button onclick="location.href='../reporte/reporte_ventas_mensuales.php'">Ver Reporte</button>
        </div>

        <div class="reporte-card">
            <h3>👤 Usuarios del Sistema</h3>
            <button onclick="location.href='../reporte/reporte_usuarios.php'">Ver Reporte</button>
        </div>

        <div class="reporte-card">
            <h3> Regresar</h3>
            <button onclick="location.href='../panel.php'"> Regresar inicio </button>
        </div>
    </div>

</body>
</html>
