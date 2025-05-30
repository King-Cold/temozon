<?php
include("server/controlador.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="public/css/estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        .ver-password {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="Icons/logo.png" alt="Fondo" class="fondo">
        </div>
        <div class="login-right">
            <div class="login-box">
                <img src="Icons/gatito.png" alt="Usuario" class="avatar">
                <h2>BIENVENIDO</h2>

                <!-- Mostrar mensaje de error -->
                <?php if (!empty($mensaje)) : ?>
                    <p class="mensaje-error"><?php echo $mensaje; ?></p>
                    
                <?php endif; ?>
                <?php
                include("server/conexion_bd.php"); 
                ?>
                

<form action="" method="POST">

    <div class="input-group">
        <label for="email">Correo Electrónico</label>
        <img src="Icons/email.svg" alt="Icono Correo">
        <input type="email" id="email" placeholder="Ingrese su correo" name="email">
    </div>

    <div class="input-group">
        <label for="usuario">Usuario</label>
        <img src="Icons/user.svg" alt="Icono Usuario">
        <input type="text" id="usuario" placeholder="Ingrese su usuario" name="usuario">
    </div>

    <div class="input-group password-group">
        <label for="password">Contraseña</label>
        <img src="Icons/candado.svg" alt="Icono Contraseña">
        <input type="password" id="password" placeholder="Ingrese su contraseña" name="contraseña">
        <span class="ver-password" onclick="togglePassword()">
            <img id="eyeIcon" src="Icons/ojo.png" alt="Ver contraseña" width="20" height="20">
        </span>
    </div>

    <a href="#" class="olvide">Olvidé mi contraseña</a>
    <button type="submit" name="btningresar">INICIAR SESIÓN</button>

</form>
            </div>
        </div>
    </div>

    <script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.src = "Icons/ciego.png"; // Cambia a ícono de ojo cerrado
    } else {
        passwordInput.type = "password";
        eyeIcon.src = "Icons/ojo.png"; // Vuelve al ícono de ojo abierto
    }
}
</script>
</body>
</html>
