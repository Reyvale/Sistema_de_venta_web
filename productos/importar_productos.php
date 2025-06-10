<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Importar Productos</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        padding: 40px;
    }
    h2 {
        text-align: center;
    }
    form {
        text-align: center;
        margin-top: 30px;
    }
    input[type="file"] {
        padding: 10px;
        margin: 15px 0;
        font-size: 18px; /* ← Aumenta el tamaño del texto */
    }
        button {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #27ae60;
        }
        .btn-agregar {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-agregar:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <h2>Importar Productos desde archivo CSV</h2>
    <form action="procesar_importacion.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="archivo" accept=".csv" required>
        <br>
        <button type="submit">📥 Importar</button>
        <a href="../productos/productos.php" class="btn-agregar">🚪 Regresar</a>
    </form>
</body>
</html>
