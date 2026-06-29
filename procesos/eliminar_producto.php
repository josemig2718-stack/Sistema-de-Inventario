<?php
// procesos/eliminar_producto.php
require '../conexion.php';

// Recibimos el ID por la URL (método GET)
$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    // Preparamos la consulta para borrar
    $sql = "DELETE FROM productos WHERE ID_Producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigimos de vuelta al inventario
        header("Location: ../views/listar_inventario.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "ID no válido.";
}

$conexion->close();
?>