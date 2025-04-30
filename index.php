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
    <style>
        .ver-password {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="icons/logo.png" alt="Fondo" class="fondo">
        </div>
        <div class="login-right">
            <div class="login-box">
                <img src="icons/icono.png" alt="Usuario" class="avatar">
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
                        <input type="email" id="email" placeholder="Ingrese su correo" name="email">
                    </div>
                    <div class="input-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" id="usuario" placeholder="Ingrese su usuario" name="usuario">
                    </div>
                    <div class="input-group password-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" placeholder="Ingrese su contraseña" name="contraseña">
                        <span class="ver-password">👁</span>
                    </div>
                    <a href="#" class="olvide">Olvidé mi contraseña</a>
                    <button type="submit" name="btningresar">INICIAR SESIÓN</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const eyeIcon = document.querySelector('.ver-password');
        const passwordInput = document.getElementById('password');

        eyeIcon.addEventListener('click', () => {
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>
