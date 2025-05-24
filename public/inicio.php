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
@import url('https://fonts.googleapis.com/css2?family=Cal+Sans&family=Comfortaa:wght@300..700&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

body {
    margin: 0;
    padding: 20px;
    background-color: #f0f0f0;
}

.dashboard {
    display: grid;
    grid-template-areas: 
    "productos compras ventas ingresos"
    "ventas-mensuales ventas-mensuales acciones acciones"
    "productos-vendidos productos-vendidos acciones acciones";
    grid-gap: 20px;
    grid-template-columns: repeat(4, 1fr);
    margin-top: 4rem;
    margin-left: 4rem;
    transition:margin 0.5s ease;

}
.dashboard.menu-toggle{
    margin-left: 13rem;
}

.box {
    display: flex;
    align-items: center;
    background: white;
    padding: 10px;
    border-radius: 10px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    position: relative;
    overflow: hidden;
    
}
.box .icono {
    width: 90px;
    height: 90px;
    opacity: 0.5;
    margin-right: 5px;
}
.box::after {
    content: attr(data-text);
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 18px;
    font-family: "Cal Sans", sans-serif;
    letter-spacing: 4px;
    opacity: 0.8;
}
.box .dato {
    flex: 1;
    text-align: right;
    font-size: 35px;
    font-family: "Cal Sans", sans-serif;
    margin-top: 10px;
    margin-right: 10px;
    letter-spacing: 4px;
}




.productos {
    grid-area: productos;
    background:    #D46DAD;

}

.ventas {
    grid-area: ventas;
    background: #3498db;
}

.ingresos {
    grid-area: ingresos;
    background: #2ecc71
}

.compras {
    grid-area: compras;
    background: #F3BA53;
}

.ventas-mensuales {
    grid-area: ventas-mensuales;
    background: white;
    color: black;
    
}

.productos-vendidos {
    grid-area: productos-vendidos;
    background: white;
    color: black;
    display: flex;
    flex-direction: column;
    align-items: flex;
    padding: 20px;
}

.productos-vendidos h3 {
    margin: 0 0 10px 0;
    font-family: "Cal Sans", sans-serif;
    color: #333;
    letter-spacing: 2px;
}

.acciones {
    grid-area: acciones;
    background: white;
    color: #333;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    
    display: flex;
    flex-direction: column;
}

.acciones h3 {
    margin-top: 0;
    font-family: "Cal Sans", sans-serif;
    font-size: 20px;
    margin-bottom: 15px;
    letter-spacing: 2px;
}

.acciones table {
    width: 100%;
    border-collapse: collapse;
    font-family: "Poppins", sans-serif;
    font-size: 14px;
    
}

.acciones th, .acciones td {
    padding: 10px 10px;
    text-align: left;
    border-bottom: 1px solidrgb(224, 224, 224);
    text-align: center;
}

.acciones th {
    background-color:rgb(223, 223, 223);
    font-weight: 900;
}
.acciones td {
    font-weight: 400;
}


.acciones tr:hover {
    background-color:rgba(89, 201, 149, 0.5);
}


.ventas-mensuales {
    display: flex;
    flex-direction: column;
    align-items: flex;
    padding: 20px;
}

.ventas-mensuales h3 {
    margin: 0 0 10px 0;
    font-family: "Cal Sans", sans-serif;
    color: #333;
    letter-spacing: 2px;
}

.ventas-mensuales canvas {
    width: 100% !important;
    height: 250px !important; /* más pequeño */
}
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

 <div class="dashboard">

    <div class="box productos" data-text="Productos">
        <img src="../Icons/productos.png" alt="Productos" class="icono">
        <div class="dato">5,556</div>
    </div>

    <div class="box ventas" data-text="Ventas">
        <img src="../Icons/ventas.png" alt="Ventas" class="icono">
        <div class="dato">3,454</div>
    </div>

    <div class="box ingresos" data-text="Ingresos">
        <img src="../Icons/ingresos.png" alt="Ingresos" class="icono">
        <div class="dato">$999,999</div>
    </div>

    <div class="box compras" data-text="Compras">
        <img src="../Icons/compras.png" alt="Compras" class="icono">
        <div class="dato">$8,122</div>
    </div>

    <!-- VENTAS MENSUALES (Gráfica más pequeña) -->
    <div class="box ventas-mensuales">
        <h3>Ventas Mensuales</h3>
        <canvas id="graficaVentas"></canvas>
    </div>

    <!-- ACCIONES a la derecha, ocupando dos filas -->
<div class="box acciones">
    <h3>Movimientos en la Empresa</h3>
    <table>
        <thead>
            <tr>
                <th>ACCIÓN</th>
                <th>TABLA</th>
                <th>DETALLE</th>
                <th>FECHA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("../server/conexion_bd.php");

            $consulta = "SELECT accion, tabla_afectada, detalle, fecha_hora FROM bitacora ORDER BY fecha_hora DESC LIMIT 10";
            $resultado = mysqli_query($conexion, $consulta);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['accion'] . "</td>";
                echo "<td>" . $fila['tabla_afectada'] . "</td>";
                echo "<td>" . $fila['detalle'] . "</td>";
                echo "<td>" . date("d-m-Y H:i:s", strtotime($fila['fecha_hora'])) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

    <!-- PRODUCTOS MÁS VENDIDOS debajo -->
    <div class="box productos-vendidos">
        <h3>Productos Más Vendidos</h3>
        <canvas id="graficaTopProductos"></canvas>
    </div>
</div> 
</body>
</html>
 <script src="js/script-dash.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

fetch("../server/datos_ventas.php")
.then(response => response.json())
.then(data => {
    const ctx = document.getElementById('graficaVentas').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.meses,
            datasets: [{
                label: 'Ventas ($)',
                data: data.ventas,
                borderColor: '#8B85F9',
                backgroundColor: 'rgba(139, 133, 249, 0.81)',
                fill: true,
                tension: 0.2,
                pointBackgroundColor: 'white',
                pointBorderColor: '#8B85F9',
                pointRadius: 8,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            interaction: {
          mode: 'nearest',
          intersect: true
        },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    bodyFont: {
                        size: 16
                    },
                    titleFont: {
                        size: 18
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
});

fetch("../server/datos_productos.php")
.then(response => response.json())
.then(data => {
    const ctx = document.getElementById('graficaTopProductos').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.productos,
            datasets: [{
                label: 'Unidades Vendidas',
                data: data.ventas,
                backgroundColor: ['#CAE082', '#E695F0', '#EDC15A', '#A993ED', '#8EDCED'],
                borderColor: '#ecf0f1',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleFont: {
                        size: 16,
                        family: 'Arial',
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 14,
                        family: 'Arial'
                    },
                    borderColor: '#fff',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 14,
                            family: 'Arial',
                            weight: 'bold'
                        },
                        color: '#34495e'
                    },
                    grid: {
                        color: '#eee'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50,
                        font: {
                            size: 14,
                            family: 'Arial',
                            weight: 'bold'
                        },
                        color: '#34495e'
                    },
                    grid: {
                        color: '#eee'
                    }
                }
            }
        }
    });
});

</script>