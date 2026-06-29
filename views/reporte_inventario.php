<?php
// views/reporte_inventario.php
require '../conexion.php';

// --- 1) CAPTURAR LOS MISMOS FILTROS ---
$f_nombre = trim($_GET["nombre"] ?? "");
$f_categoria = trim($_GET["categoria"] ?? "");


// --- 2) ARMAR LA CONSULTA SQL ---
$sql = "SELECT p.ID_Producto, p.Nombre, p.Stock, p.Precio, c.Nombre AS Categoria
        FROM productos p 
        LEFT JOIN categorias c ON p.ID_Categoria = c.ID_Categoria 
        WHERE 1=1";
$params = [];
$tipos = "";

if ($f_nombre !== "") {
    $sql .= " AND p.Nombre LIKE ?";
    $params[] = "%$f_nombre%";
    $tipos .= "s";
}

if ($f_categoria !== "") {
    $sql .= " AND p.ID_Categoria = ?";
    $params[] = (int) $f_categoria;
    $tipos .= "i";
}

$sql .= " ORDER BY p.ID_Producto ASC";

$stmt = $conexion->prepare($sql);
if ($params) {
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();

// Texto dinámico para saber qué estamos filtrando
$texto_filtro = "Todos los productos";
if ($f_nombre !== "" || $f_categoria !== "") {
    $texto_filtro = $f_categoria;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        /* Estilos específicos para el reporte y la impresión */
        body {
            font-family: Arial, sans-serif;
            background: #e5e7eb;
            margin: 0;
            padding: 0;
        }

        .toolbar {
            background: #1e293b;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 15px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .toolbar button,
        .toolbar a {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            font-size: 14px;
        }

        .toolbar a {
            background: transparent;
            border: 1px solid white;
        }

        .toolbar button:hover {
            background: #059669;
        }

        .hoja {
            background: white;
            max-width: 800px;
            margin: 20px auto;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            min-height: 1000px;
        }

        .membrete {
            border-bottom: 2px solid #0284c7;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .membrete h1 {
            color: #0f172a;
            margin: 0;
            font-size: 24px;
        }

        .membrete p {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #cbd5e1;
            text-align: left;
        }

        th {
            background: #0284c7;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .pie-pagina {
            border-top: 1px solid #cbd5e1;
            margin-top: 40px;
            padding-top: 10px;
            font-size: 12px;
            color: #64748b;
            text-align: space-between;
            display: flex;
            justify-content: space-between;
        }

        /* Magia para cuando le des a Imprimir/PDF */
        @media print {
            body {
                background: white;
            }

            .toolbar {
                display: none;
                /* Ocultamos los botones al imprimir */
            }

            .hoja {
                box-shadow: none;
                margin: 0;
                padding: 0;
                width: 100%;
                min-height: auto;
            }
        }
    </style>
</head>

<body>

    <div class="toolbar">
        <button onclick="window.print()">🖨️ Guardar como PDF / Imprimir</button>
        <a href="listar_inventario.php">⬅ Volver al Inventario</a>
    </div>

    <div class="hoja">
        <div class="membrete">
            <h1>📦 Almacén Central - Reporte de Inventario</h1>
            <p>Fecha de emisión:
                <?= date("d/m/Y H:i") ?> | Filtro aplicado:
                <?= $texto_filtro ?>
            </p>
        </div>

        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Precio Unitario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= $fila["ID_Producto"] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($fila["Nombre"]) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($fila["Categoria"] ?? 'N/A') ?>
                            </td>

                            <td style="font-weight: bold;">
                                <?= $fila["Stock"] ?>
                            </td>
                            <td>$
                                <?= number_format($fila["Precio"], 2) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; margin-top: 50px;">No hay productos para mostrar con los filtros actuales.</p>
        <?php endif; ?>

        <div class="pie-pagina">
            <span>Sistema Web de Control de Inventario</span>
            <span>Estudiantes de Informática - UPTP</span>
        </div>
    </div>

</body>

</html>
<?php
$stmt->close();
$conexion->close();
?>