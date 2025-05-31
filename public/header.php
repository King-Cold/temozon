<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../server/conexion_bd.php");

if (isset($_SESSION['ID_Usuario'])) {
    $id_usuario = intval($_SESSION['ID_Usuario']);

    $sql = $conexion->prepare("SELECT avatar_url, Nombre_Usuario, Email, Rol FROM usuario WHERE ID_Usuario = ?");
    $sql->bind_param("i", $id_usuario);
    $sql->execute();
    $sql->bind_result($avatar_url, $nombre_usuario, $correo_usuario, $rol_usuario);
    $sql->fetch();

    if (!empty($avatar_url)) {
        $avatar = $avatar_url;
    } else {
        $avatar = "../Icons/avatar/prueba.jpg";
    }

    $sql->close();
} else {
    // Si no hay sesión, valores por defecto
    $avatar = "../Icons/avatar/prueba.jpg";
    $nombre_usuario = "Invitado";
    $correo_usuario = "-";
    $rol_usuario = "-";
    $id_usuario = "0";
}
?>

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
            <img src="../Icons/logo-Photoroom-removebg-preview.png" alt="icon-udemy" class="logo" >
            <span class="name">Distribuidora Veterinaria Grupo Temozón</span>
        </div>
    </div>
    <div class="right">
        <a href="#" class="icons-header" style="position: relative;" id="abrirModalNotificaciones">
            <img src="../Icons/notification-13-svgrepo-com.svg" alt="notificacion" style="width: 50px;">
            <span id="contadorNotificaciones"
                style="position: absolute; top: -5px; right: -5px; background: red; color: white; 
                 border-radius: 50%; padding: 3px 7px; font-size: 12px; display: none;">
            </span>
        </a>
        <a href="#" class="icons-header" style="position: relative;" id="abrirModalExpirados">
            <img src="../Icons/expirado.svg" alt="expirados" style="width: 50px;filter: brightness(0) invert(0)">
            <span id="contadorExpirados"
                style="position: absolute; top: -5px; right: -5px; background:rgb(255, 174, 0); color: white; 
               border-radius: 50%; padding: 3px 7px; font-size: 12px; display: none;">
            </span>
        </a>
        <a href="../server/logout.php" class="icons-header">
            <img src="../Icons/logout-2-svgrepo-com.svg " style="width: 50px;filter: brightness(0) invert(0); font-family: "Poppins", sans-serif;" alt="salida">
        </a>
        <img src="<?php echo $avatar; ?>" alt="img-user" class="user">
        <div id="userPanel" class="user-panel">
            <span id="closeUserPanel">&times;</span>
            <div class="user-image">
                <img src="<?php echo $avatar; ?>" alt="Usuario">
            </div>
            <h2><?php echo $nombre_usuario; ?></h2>
            <div class="user-info">
                <div class="user-data">
                    <span>ID</span>
                    <p><?php echo $id_usuario; ?></p>
                </div>
                <div class="user-data">
                    <span>Rol</span>
                    <p><?php echo $rol_usuario; ?></p>
                </div>
                <div class="user-data">
                    <span>Correo</span>
                    <p><?php echo $correo_usuario; ?></p>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
  // Mostrar modal expirados
  $('#abrirModalExpirados').click(function(e) {
    e.preventDefault();
    $('#modalExpirados').show();
    cargarExpiradosModal();
  });

  // Cerrar modal
  $('.cerrar').click(function() {
    $('#modalExpirados').hide();
  });

  // Cerrar al hacer clic fuera del contenido
  $(window).click(function(e) {
    if ($(e.target).is('#modalExpirados')) {
      $('#modalExpirados').hide();
    }
  });

  // Cargar contador expirados
  function cargarExpirados() {
    $.ajax({
      url: '../server/contar_expirados.php', // este archivo debe devolver solo el número de expirados
      method: 'GET',
      success: function(data) {
        if (parseInt(data) > 0) {
          $('#contadorExpirados').text(data).show();
        } else {
          $('#contadorExpirados').hide();
        }
      }
    });
  }

  // Cargar contenido de productos expirados
  function cargarExpiradosModal() {
    $.ajax({
      url: '../server/expirados.php', // este archivo debe devolver el HTML con la lista de expirados
      method: 'GET',
      success: function(html) {
        $('#listaExpirados').html(html);
      }
    });
  }

  // Llamada inicial y en intervalos
  cargarExpirados();
  setInterval(cargarExpirados, 60000);
});
            $(document).ready(function() {
                // Mostrar modal al hacer clic
                $('#abrirModalNotificaciones').click(function(e) {
                    e.preventDefault();
                    $('#modalNotificaciones').show();
                    cargarNotificacionesModal();
                });

                // Cerrar modal
                $('.cerrar').click(function() {
                    $('#modalNotificaciones').hide();
                });

                // Cerrar al hacer clic fuera del contenido
                $(window).click(function(e) {
                    if ($(e.target).is('#modalNotificaciones')) {
                        $('#modalNotificaciones').hide();
                    }
                });

                function cargarNotificaciones() {
                    $.ajax({
                        url: '../server/contar_notificaciones.php',
                        method: 'GET',
                        success: function(data) {
                            if (parseInt(data) > 0) {
                                $('#contadorNotificaciones').text(data).show();
                            } else {
                                $('#contadorNotificaciones').hide();
                            }
                        }
                    });
                }

                function cargarNotificacionesModal() {
                    $.ajax({
                        url: '../server/notificaciones.php',
                        method: 'GET',
                        success: function(html) {
                            $('#listaNotificaciones').html(html);
                        }
                    });
                }

                // Llamada inicial y en intervalos
                cargarNotificaciones();
                setInterval(cargarNotificaciones, 60000);
            });
            $(document).ready(function() {
                // Panel de usuario
                $('.user').click(function() {
                    $('#userPanel').css('right', '0');
                });

                $('#closeUserPanel').click(function() {
                    $('#userPanel').css('right', '-320px');
                });
            });
        </script>
        <div id="modalNotificaciones" class="modal">
            <div class="modal-contenido">
                <span class="cerrar">&times;</span>
                <div id="listaNotificaciones"></div>
            </div>
        </div>

        <div id="modalExpirados" class="modal">
  <div class="modal-contenido">
    <span class="cerrar">&times;</span>
    <div id="listaExpirados"></div>
  </div>
</div>
    </div>
</header>