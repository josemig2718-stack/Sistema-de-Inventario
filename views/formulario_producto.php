<?php
// views/formulario_producto.php
require '../conexion.php'; // Subimos un nivel porque conexion.php está en la raíz
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto - Inventario</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <main class="contenedor">
        <div class="encabezado-dashboard">
            <h1>➕ Registrar Nuevo Producto</h1>
            <p>Ingresa los datos de la nueva mercancía para el almacén.</p>
        </div>

        <div class="formulario-caja">
            <form action="../procesos/guardar_producto.php" method="POST">

                <div class="grupo-input">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Teclado Logitech" required>
                </div>

                <div class="grupo-input doble">
                    <div>
                        <label for="stock">Stock Inicial</label>
                        <input type="number" id="stock" name="stock" min="0" placeholder="Ej: 10" required>
                    </div>
                    <div>
                        <label for="precio">Precio (USD)</label>
                        <input type="number" step="0.01" id="precio" name="precio" min="0" placeholder="Ej: 25.50">
                    </div>
                </div>

                <div class="grupo-input">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">-- Selecciona una categoría --</option>
                        <?php
                        // Hacemos una consulta rápida para llenar el select
                        $query_cat = $conexion->query("SELECT ID_Categoria, Nombre FROM categorias");
                        while ($cat = $query_cat->fetch_assoc()) {
                            echo '<option value="' . $cat['ID_Categoria'] . '">' . $cat['Nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn-accion" style="width: 100%; margin-top: 10px; font-size: 16px;">
                    💾 Guardar Producto
                </button>
            </form>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>