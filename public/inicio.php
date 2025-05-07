<?php
session_start(); // Iniciar sesión al comienzo

// Para propósitos de prueba, si no está definida la sesión puedes poner algo así:
// $_SESSION['nombre_usuario'] = 'Carlos';

// Verificar si hay sesión activa
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Inicio</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,#662952,rgb(17, 11, 105));
            color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main#main {
            padding: 40px;
            text-align: center;
            flex: 1;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 30px;
        }
        .reloj {
            font-size: 24px;
            margin-top: 20px;
            color: #cfd8dc;
        }
        p {
            font-size: 20px;
            margin-top: 50px;
            color: #eceff1;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main id="main">
        <h1>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>!</h1>
        <h2>Nos alegra tenerte de vuelta</h2>
        <div class="reloj" id="horaActual"></div>

    </main>

    <script src="js/script.js"></script>
    <script>
        // Reloj dinámico
        function actualizarHora() {
            const ahora = new Date();
            const hora = ahora.toLocaleTimeString();
            document.getElementById('horaActual').textContent = "Hora actual: " + hora;
        }
        setInterval(actualizarHora, 1000);
        actualizarHora();
    </script>
</body>
</html>
