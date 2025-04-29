<?php
session_start(); // Iniciar la sesión al comienzo
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
    <div class="left">
        <div class="menu-contenedor">
            <div class="menu" id="menu">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="brand">
            <img src="/Icons/logo-Photoroom-removebg-preview.png " alt="icon-udemy" class="logo">
            <samp class="name">DISTRIBUIDORA TEMOZÓN</samp>
        </div>
    </div>
    <div class="right">
        <a href="#" class="icons-header">
            <img src="/Icons/warning-svgrepo-com.svg" alt="notificacion">
        </a>
        <a href="#"class="icons-header">
            <img src="/Icons/logout-2-svgrepo-com.svg" alt="salida">
        </a>

            <img src="/Icons/user-svgrepo-com.svg" alt="img-user" class="user">

    </div>
</header>
<div class="sidebar" id="sidebar">
    <nav>
        <ul>
            <li>
                <a href="#" class="selected">
                    <img src="/Icons/home-svgrepo-com.svg" alt="Home"
                    <span>PAGINA PRINCIPAL</span>
                </a>
            </li>
            <li>
                <a href="#" >
                    <img src="/Icons/product-guide-svgrepo-com.svg" alt="Home"
                    <span>INVENTARIO</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/Icons/lorry-svgrepo-com.svg" alt="Home"
                    <span>ENVIOS</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/Icons/list-check-svgrepo-com.svg" alt="Home"
                    <span>PEDIDOS</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/Icons/building-user-svgrepo-com.svg" alt="Home"
                    <span>PROVEEDORES</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/Icons/users-group-svgrepo-com.svg" alt="Home"
                    <span>USUARIOS</span>
                </a>
            </li>
        </ul>
    </nav>

</div>
<main id="main">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam eum esse maiores vitae eligendi voluptatibus veniam facere tenetur exercitationem enim dolores quasi quaerat amet error, temporibus nostrum fugiat. Accusamus, nostrum.</p>
</main>
<script src="script.js">
</script>
</body>
</html>
