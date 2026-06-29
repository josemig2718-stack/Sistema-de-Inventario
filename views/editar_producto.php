<?php
// views/editar_producto.php
require '../conexion.php';

// Validar que recibimos un ID válido
$id = (int) ($_GET['id'] ?? 0);
if ($id === 0) {
    die("ID de producto no válido.");
}

// Consultar los datos del producto actual
$sql = "SELECT Nombre, Stock, Precio, ID_Categoria FROM productos WHERE ID_Producto = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("El producto no existe.");
}
$producto = $resultado->fetch_assoc();
$stmt->close();

// Consultar las categorías para el select
$query_cat = $conexion->query("SELECT ID_Categoria, Nombre FROM categorias");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Inventario</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <main class="contenedor">
        <div class="encabezado-dashboard">
            <h1>✏️ Editar Producto</h1>
            <p>Modifica los datos del producto seleccionado.</p>
        </div>

        <div class="formulario-caja" style="border-top-color: #f59e0b;">
            <form action="../procesos/actualizar_producto.php" method="POST">

                <input type="hidden" name="id_producto" value="<?= $id ?>">

                <div class="grupo-input">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['Nombre']) ?>"
                        required readonly style="background-color: #e2e8f0; cursor: not-allowed;">
                </div>

                <div class="grupo-input doble">
                    <div>
                        <label for="stock">Stock Actual</label>
                        <input type="number" id="stock" name="stock" min="0" value="<?= $producto['Stock'] ?>" required>
                    </div>
                    <div>
                        <label for="precio">Precio (USD)</label>
                        <input type="number" step="0.01" id="precio" name="precio" min="0"
                            value="<?= $producto['Precio'] ?>">
                    </div>
                </div>

                <div class="grupo-input">
                    <label for="categoria">Categoría</label>

                    <select id="categoria" disabled style="background-color: #e2e8f0; cursor: not-allowed;">
                        <?php while ($cat = $query_cat->fetch_assoc()): ?>
                            <option value="<?= $cat['ID_Categoria'] ?>" <?= ($producto['ID_Categoria'] == $cat['ID_Categoria']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['Nombre']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <input type="hidden" name="categoria" value="<?= $producto['ID_Categoria'] ?>">
                </div>

                <button type="submit" class="btn-accion"
                    style="width: 100%; margin-top: 10px; font-size: 16px; background-color: #f59e0b;">
                    🔄 Actualizar Producto
                </button>
                <a href="listar_inventario.php"
                    style="display: block; text-align: center; margin-top: 15px; color: #64748b; text-decoration: none;">Cancelar
                    y volver</a>
            </form>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>