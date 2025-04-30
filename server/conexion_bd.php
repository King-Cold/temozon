<?php
$servidor = "localhost";  // Servidor de MySQL (por defecto "localhost" en XAMPP)
$usuario = "root";        // Usuario de MySQL (por defecto "root" en XAMPP)
$clave = "1234";              // Contraseña (por defecto vacío en XAMPP)
$base_datos = "temozon"; // Reemplázalo con el nombre real de tu base de datos

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);
$conexion->set_charset("utf8");
?>
