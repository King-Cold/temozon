<?php


/*Si necesitas la tuya solo comenta la mia y descomenta la tuya para asi veas la tuya y no la mia, por que si no comentas la mia
veras la mia y no la tuya, haciendo que se muestre lo mio y no lo tuyo, mientras que tu querias que se vea lo tuyo y no lo mio */



$servidor = "localhost";  // Servidor de MySQL (por defecto "localhost" en XAMPP)
$usuario = "root";        // Usuario de MySQL (por defecto "root" en XAMPP)
$clave = "";              // Contraseña (por defecto vacío en XAMPP)
$base_datos = "dvgt"; // Reemplázalo con el nombre real de tu base de datos

/*
$servidor = "localhost";  // Servidor de MySQL (por defecto "localhost" en XAMPP)
$usuario = "root";        // Usuario de MySQL (por defecto "root" en XAMPP)
$clave = "1234";              // Contraseña (por defecto vacío en XAMPP)
$base_datos = "temozon"; // Reemplázalo con el nombre real de tu base de datos
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
