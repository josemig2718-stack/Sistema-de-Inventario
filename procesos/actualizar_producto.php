<?php
// procesos/actualizar_producto.php
require '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acceso no válido.");
}

// Recibir datos
$id = (int) ($_POST["id_producto"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$stock = (int) ($_POST["stock"] ?? 0);
$precio = (float) ($_POST["precio"] ?? 0.0);
$categoria = (int) ($_POST["categoria"] ?? 0);

if ($id === 0 || empty($nombre) || $categoria === 0) {
    die("❌ Faltan datos obligatorios.");
}

// Preparar el UPDATE
$sql = "UPDATE productos SET Nombre = ?, Stock = ?, Precio = ?, ID_Categoria = ? WHERE ID_Producto = ?";
$stmt = $conexion->prepare($sql);

// s = string, i = int, d = double (decimal), i = int, i = int (para el ID)
$stmt->bind_param("sidii", $nombre, $stock, $precio, $categoria, $id);

if ($stmt->execute()) {
    // Redirigir de vuelta al inventario si todo sale bien
    header("Location: ../views/listar_inventario.php");
    exit();
} else {
    echo "<h2>❌ Error al actualizar</h2>";
    echo "<p>" . $stmt->error . "</p>";
    echo '<a href="../views/listar_inventario.php">Volver</a>';
}

$stmt->close();
$conexion->close();
?>