<?php
// includes/navbar.php
// Definimos la ruta base de tu proyecto en XAMPP para evitar enlaces rotos
$base_url = "http://localhost/mis_cosas_php/Sistema_inventario/";
?>
<nav class="navbar">
    <div class="nav-brand">
        📦 <span>Almacén Central</span>
    </div>
    <ul class="nav-links">
        <li><a href="<?= $base_url ?>index.php">🏠 Inicio</a></li>
        <li><a href=" <?= $base_url ?>views/formulario_producto.php">➕ Registrar</a></li>
        <li><a href="<?= $base_url ?>views/listar_inventario.php">📋 Inventario y Reportes</a></li>
    </ul>
</nav>