<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="dashboard">

    <div class="box productos" data-text="Productos">
        <img src="productos.png" alt="Productos" class="icono">
        <div class="dato">5,556</div>
    </div>

    <div class="box ventas" data-text="Ventas">
        <img src="ventas.png" alt="Ventas" class="icono">
        <div class="dato">3,454</div>
    </div>

    <div class="box ingresos" data-text="Ingresos">
        <img src="ingresos.png" alt="Ingresos" class="icono">
        <div class="dato">$999,999</div>
    </div>

    <div class="box compras" data-text="Compras">
        <img src="compras.png" alt="Compras" class="icono">
        <div class="dato">$8,122</div>
    </div>

    <!-- VENTAS MENSUALES (Gráfica más pequeña) -->
    <div class="box ventas-mensuales">
        <h3>Ventas Mensuales</h3>
        <canvas id="graficaVentas"></canvas>
    </div>

    <!-- ACCIONES a la derecha, ocupando dos filas -->
    <div class="box acciones">
        <h3>Acciones en la Empresa</h3>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Pepe</td><td>Agregar Pedido</td><td>20-21-2297</td></tr>
                <tr><td>Pepe</td><td>Agregar Pedido</td><td>20-21-2297</td></tr>
                <tr><td>Pepe</td><td>Agregar Pedido</td><td>20-21-2297</td></tr>
                <tr><td>Pepe</td><td>Eliminar Producto</td><td>20-21-2297</td></tr>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
fetch("datos_ventas.php")
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
                borderColor: '#7169E5',
                backgroundColor: 'rgba(139, 137, 244, 0.49)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#7169E5',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
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

fetch("datos_ventas.php")
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
                tension: 0.4,
                pointBackgroundColor: '#8B85F9',
                pointBorderColor: '#black',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
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

fetch("datos_productos.php")
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