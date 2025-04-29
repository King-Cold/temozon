<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location:login.php"); // Redirige si no es admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 15px;
            font-size: 24px;
        }
        .container {
            margin-top: 20px;
        }
        .menu {
            margin: 20px;
        }
        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="header">
        Panel de Administrador
    </div>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["nombre"]); ?> 👋</h2>
        
        <div class="menu">
            <a href="gestionar_usuarios.php">Gestionar Usuarios</a>
            <a href="gestionar_productos.php">Gestionar Productos</a>
            <a href="reportes.php">Ver Reportes</a>
        </div>

        <a href="logout.php" class="logout">Salir</a>
    </div>
</body>
</html>
