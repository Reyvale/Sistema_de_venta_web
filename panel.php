<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
$rol = $_SESSION['rol'];
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>☰ Panel Principal</title>
    <link rel="stylesheet" href="css/panel1.css">
</head>
<body>
    <!-- Botón para alternar el menú -->
    <button id="menu-toggle">☰</button>

    <!-- Menú lateral -->
    <div class="sidebar" id="sidebar">
        <h2>R S C</h2>
        <ul>
            <li><a href="productos/productos.php">📦 Productos</a></li>
            <li><a href="ventas/nueva_venta.php">🛒 Ventas</a></li>
            <li><a href="inventario/inventario.php">📋 Inventario</a></li>
            
            <?php if ($rol === 'admin') : ?>
                <li><a href="reporte/reportes.php">📊 Reportes</a></li>
                <li><a href="usuario/usuarios.php">👤 Usuarios</a></li>
            <?php endif; ?>

            <li><a href="logout.php">🚪 Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">
        <header>
            <center><hr>
            <h1>Bienvenido, <?= htmlspecialchars($usuario) ?> (<?= strtoupper($rol) ?>)</h1>
            <p>Seleccione una opción del menú para comenzar.</p>
            <hr></center>
        </header>

        <section class="cards">
            <a href="productos/productos.php" class="card">📦 Productos</a>
            <a href="ventas/nueva_venta.php" class="card">💵 Ventas</a>
            <a href="inventario/inventario.php" class="card">📊 Inventario</a>

            <?php if ($rol === 'admin') : ?>
                <a href="reporte/reportes.php" class="card">📈 Reportes</a>
                <a href="usuario/usuarios.php" class="card">👥 Usuarios</a>
            <?php endif; ?>
        </section>
    </div>

    <!-- Script para alternar visibilidad del menú -->
    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    </script>
</body>
</html>
