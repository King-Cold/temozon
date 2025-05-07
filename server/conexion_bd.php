<?php
$servidor = "localhost";  // Servidor de MySQL (por defecto "localhost" en XAMPP)
$usuario = "root";        // Usuario de MySQL (por defecto "root" en XAMPP)
$clave = "";              // Contraseña (por defecto vacío en XAMPP)
$base_datos = "distribuidora_veterinaria_temozon"; // Reemplázalo con el nombre real de tu base de datos

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);
$conexion->set_charset("utf8");
?>
