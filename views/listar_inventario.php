<?php
// views/listar_inventario.php
require '../conexion.php';

// --- 1) CAPTURAR LOS FILTROS DE BÚSQUEDA ---
$f_nombre = trim($_GET["nombre"] ?? "");
$f_categoria = trim($_GET["categoria"] ?? "");


// --- 2) ARMAR LA CONSULTA SQL DINÁMICA CON JOIN ---
$sql = "SELECT p.ID_Producto, p.Nombre, p.Stock, p.Precio, c.Nombre AS Categoria
        FROM productos p 
        LEFT JOIN categorias c ON p.ID_Categoria = c.ID_Categoria 
        WHERE 1=1"; // El 1=1 es un truco para concatenar los AND fácilmente

$params = [];
$tipos = "";

// Si el usuario escribió algo en el buscador de nombre...
if ($f_nombre !== "") {
    $sql .= " AND p.Nombre LIKE ?";
    $params[] = "%$f_nombre%";
    $tipos .= "s";
}

// Si el usuario seleccionó una categoría...
if ($f_categoria !== "") {
    $sql .= " AND p.ID_Categoria = ?";
    $params[] = (int) $f_categoria;
    $tipos .= "i";
}


$sql .= " ORDER BY p.ID_Producto ASC";

// --- 3) EJECUTAR LA CONSULTA SEGURA ---
$stmt = $conexion->prepare($sql);
if ($params) {
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();

// Consultamos las categorías para llenar el select del filtro
$query_cat = $conexion->query("SELECT ID_Categoria, Nombre FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Almacén Central</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>

    <?php include '../includes/navbar.php'; ?>

    <main class="contenedor" style="max-width: 1200px;">
        <div class="encabezado-dashboard">
            <h1>📋 Inventario Actual</h1>
            <p>Consulta, filtra y genera reportes de la mercancía disponible.</p>
        </div>

        <form method="GET" action="listar_inventario.php" class="caja-filtros">
            <fieldset>
                <legend>Filtros de Búsqueda y Reportes</legend>
                <div class="grid-filtros">
                    <div class="grupo-input">
                        <label>Buscar por Nombre</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($f_nombre) ?>"
                            placeholder="Ej: Monitor...">
                    </div>
                    <div class="grupo-input">
                        <label>Filtrar por Categoría</label>
                        <select name="categoria">
                            <option value="">-- Todas las categorías --</option>
                            <?php while ($cat = $query_cat->fetch_assoc()): ?>
                                <option value="<?= $cat['ID_Categoria'] ?>" <?= ($f_categoria == $cat['ID_Categoria']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['Nombre']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="botones-filtros">
                        <button type="submit" class="btn-accion">🔍 Buscar</button>
                        <a href="listar_inventario.php" class="btn-accion"
                            style="background-color: #64748b;">Limpiar</a>
                        <button type="submit" formaction="reporte_inventario.php" formtarget="_blank"
                            class="btn-accion btn-secundario">
                            📄 Generar Reporte PDF
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>

        <div class="tabla-contenedor">
            <?php if ($resultado->num_rows > 0): ?>
                <table class="tabla-inventario">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio (USD)</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila["ID_Producto"] ?></td>
                                <td><strong><?= htmlspecialchars($fila["Nombre"]) ?></strong></td>
                                <td>
                                    <?php
                                    $nombre_cat = $fila["Categoria"] ?? 'Sin categoría';
                                    $clase_color = 'badge-default'; // Color por defecto si no es ninguna de las 3
                            
                                    switch ($nombre_cat) {
                                        case 'Hardware':
                                            $clase_color = 'badge-hardware';
                                            break;
                                        case 'Periféricos':
                                            $clase_color = 'badge-perifericos';
                                            break;
                                        case 'Redes':
                                            $clase_color = 'badge-redes';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?= $clase_color ?>">
                                        <?= htmlspecialchars($nombre_cat) ?>
                                    </span>
                                </td>
                                <td style="font-weight: bold; color: <?= $fila['Stock'] < 10 ? '#ef4444' : '#10b981' ?>;">
                                    <?= $fila["Stock"] ?>
                                </td>
                                <td>$<?= number_format($fila["Precio"], 2) ?></td>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <a href="editar_producto.php?id=<?= $fila['ID_Producto'] ?>" class="btn-editar">✏️
                                            Editar</a>
                                        <a href="../procesos/eliminar_producto.php?id=<?= $fila['ID_Producto'] ?>"
                                            class="btn-eliminar"
                                            onclick="return confirm('¿Seguro que deseas eliminar este producto?');">🗑️
                                            Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <p style="text-align: right; margin-top: 10px; color: #64748b;">Total de resultados:
                    <?= $resultado->num_rows ?>
                </p>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
                    <h2>No se encontraron productos 📦</h2>
                    <p>Intenta con otros filtros o registra nueva mercancía.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>
<?php
$stmt->close();
$conexion->close();
?>