<?php
include("conexion_bd.php"); 
session_start();
$mensaje = ""; // Variable para almacenar el mensaje
if (isset($_POST["btningresar"])) { // Verifica si se presionó el botón
    if (empty($_POST["usuario"]) || empty($_POST["contraseña"]) || empty($_POST["email"])) {
        $mensaje = " LOS CAMPOS ESTÁN VACÍOS"; // Mensaje de error
    } else {
        $usuario=$_POST["usuario"];
        $clave=$_POST["contraseña"];
        $correo=$_POST["email"];

        $sql=$conexion->query ("select * from usuario where Nombre_Usuario = '$usuario' AND Contraseña = '$clave' AND Email= '$correo'");
        if ($datos=$sql->fetch_object()) {
           $_SESSION["ID_Usuario"] = $datos->ID_Usuarios;
$_SESSION["nombre"] = $datos->Nombre_Usuario;
$_SESSION["rol"] = $datos->Rol;
            header("location:public/inicio.php");


        } else {
            $mensaje = "⚠️ USUARIO O CONTRASEÑA INCORRECTOS";
        }
    }
}
?>