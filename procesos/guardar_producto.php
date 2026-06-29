<?php
// procesos/guardar_producto.php
require '../conexion.php';

// Bloquear acceso por URL
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acceso no válido.");
}

// Limpiar y recibir los datos
$nombre = trim($_POST["nombre"] ?? "");
$stock = (int) ($_POST["stock"] ?? 0);
$precio = (float) ($_POST["precio"] ?? 0.0);
$categoria = (int) ($_POST["categoria"] ?? 0);

if (empty($nombre) || $categoria === 0) {
    die("❌ Faltan datos obligatorios.");
}

// Consulta preparada para mayor seguridad
$sql = "INSERT INTO productos (Nombre, Stock, Precio, ID_Categoria) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

// s = string, i = entero, d = decimal, i = entero
$stmt->bind_param("sidi", $nombre, $stock, $precio, $categoria);

if ($stmt->execute()) {
    // Si se guarda bien, lo mandamos de vuelta al inicio con un mensaje
    echo "<h2>✅ Producto guardado correctamente</h2>";
    echo '<a href="../views/formulario_producto.php">⬅ Registrar otro</a> | ';
    echo '<a href="../index.php">Ir al Dashboard ➡</a>';
} else {
    echo "<h2>❌ Error al guardar</h2>";
    echo "<p>" . $stmt->error . "</p>";
}

$stmt->close();
$conexion->close();
?>