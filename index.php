<?php
// =========================================================
//  index.php (Raíz del proyecto)
//  Dashboard principal del sistema de inventario.
// =========================================================

require 'conexion.php'; // Conectamos a la base de datos

// Hacemos consultas rápidas para mostrar estadísticas
$total_productos = $conexion->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()['total'];
$total_categorias = $conexion->query("SELECT COUNT(*) AS total FROM categorias")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Inventario</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <main class="contenedor">
        <div class="encabezado-dashboard">
            <h1>Panel de Control</h1>
            <p>Bienvenido al Sistema de Control de Inventario. Gestiona tu almacén de forma rápida y segura.</p>
        </div>

        <div class="grid-estadisticas">
            <div class="tarjeta">
                <h3>📦 Productos Registrados</h3>
                <p class="numero">
                    <?= $total_productos ?>
                </p>
                <a href="views/listar_inventario.php" class="btn-accion">Ver listado completo ➡</a>
            </div>

            <div class="tarjeta">
                <h3>🏷️ Categorías Activas</h3>
                <p class="numero">
                    <?= $total_categorias ?>
                </p>
                <a href="views/formulario_producto.php" class="btn-accion btn-secundario">Registrar nuevo ➡</a>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>


</html>