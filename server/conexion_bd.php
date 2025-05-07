<?php
$servidor = "localhost";  // Servidor de MySQL (por defecto "localhost" en XAMPP)
$usuario = "root";        // Usuario de MySQL (por defecto "root" en XAMPP)
$clave = "";              // Contraseña (por defecto vacío en XAMPP)
$base_datos = "distribuidora_veterinaria_temozon"; // Reemplázalo con el nombre real de tu base de datos

/*
$servidor = "sql211.infinityfree.com"; 
$usuario = "if0_38412147";        
$clave = "hbht1YUBmA";             
$base_datos = "if0_38412147_temozon"; 
*/ 

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);
$conexion->set_charset("utf8");
?>
