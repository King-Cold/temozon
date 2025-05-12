
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
            <img src="../Icons/logo-Photoroom-removebg-preview.png" alt="icon-udemy" class="logo">
            <span class="name">DISTRIBUIDORA TEMOZÓN</span>
        </div>
    </div>
    <div class="right">
<a href="#" class="icons-header" style="position: relative;" id="abrirModalNotificaciones">
    <img src="../Icons/notification-13-svgrepo-com.svg" alt="notificacion" style="width: 30px;">
    <span id="contadorNotificaciones"
          style="position: absolute; top: -5px; right: -5px; background: red; color: white; 
                 border-radius: 50%; padding: 3px 7px; font-size: 12px; display: none;">
    </span>
</a>
        <a href="../server/logout.php" class="icons-header">
            <img src="../Icons/logout-2-svgrepo-com.svg" alt="salida">
        </a>
        <img src="../Icons/call-center_7381686.png" alt="img-user" class="user">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
</script>
<div id="modalNotificaciones" class="modal">
  <div class="modal-contenido">
    <span class="cerrar">&times;</span>
    <div id="listaNotificaciones"></div>
  </div>
</div>
</div>
</header>

