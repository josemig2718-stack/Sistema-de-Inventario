<?php
// =========================================================
//  conexion.php
//  Archivo reutilizable: abre la conexión con MySQL.
//  Se importa desde otros archivos con:  require "conexion.php";
// =========================================================

// 1) Credenciales por defecto de XAMPP
$host = "localhost";   // Servidor local
$usuario = "root";        // Usuario administrador de XAMPP
$clave = "";            // Por defecto en XAMPP root NO tiene contraseña
$basedato = "inventario";     // Debe coincidir con el nombre creado en MySQL

// 2) Crear la conexión usando mysqli (orientado a objetos)
$conexion = new mysqli($host, $usuario, $clave, $basedato);

// 3) Verificar si hubo algún error al conectar
if ($conexion->connect_error) {
    // die() detiene la ejecución y muestra el mensaje en pantalla
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// 4) Asegurar UTF-8 para que las tildes y la ñ se guarden correctamente
$conexion->set_charset("utf8mb4");
?>