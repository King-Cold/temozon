const menu = document.getElementById('menu');
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main');

menu.addEventListener('click', () => {
    sidebar.classList.toggle('menu-toggle');
    menu.classList.toggle('menu-toggle');
    main.classList.toggle('menu-toggle');
});

// Escaneo del codigo de barras con cámara
function mostrarEscaner() {
    document.getElementById('modalEscaneo').style.display = 'none';
    document.getElementById('escaneoCont').style.display = 'block';

    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#lector'),
            constraints: {
                facingMode: "environment"
            },
        },
        decoder: {
            readers: ["code_128_reader", "ean_reader", "ean_8_reader", "upc_reader"]
        }
    }, function (err) {
        if (err) {
            console.error(err);
            alert("Error al iniciar escáner");
            return;
        }
        Quagga.start();
    });

    Quagga.onDetected(function (result) {
        let codigo = result.codeResult.code;
        console.log("Código detectado:", JSON.stringify(codigo));
        if (codigo) {
            Quagga.stop();
            document.getElementById('escaneoCont').style.display = 'none';
            document.getElementById('ID_Prod').value = codigo;
            document.getElementById('modalForm').style.display = 'block';
        }
    });
}

function cerrarEscaner() {
    Quagga.stop();
    document.getElementById('escaneoCont').style.display = 'none';
}

function cerrarForm() {
    document.getElementById('modalForm').style.display = 'none';
}

// Funcion para el boton de escaneo con el lector USB
let handleKeyPress;

function ventanaEscaneo() {
    document.getElementById('modalEscaneo').style.display = 'block';

    let buffer = '';
    let lastKeyTime = Date.now();

    // Eliminar el listener anterior si existía
    if (handleKeyPress) {
        document.removeEventListener('keypress', handleKeyPress);
    }

    handleKeyPress = function (e) {
        const currentTime = Date.now();
        const timeDiff = currentTime - lastKeyTime;

        if (timeDiff > 250) buffer = '';
        lastKeyTime = currentTime;

        if (e.key !== 'Enter') {
            buffer += e.key;
        } else {
            if (buffer.length >= 6) {
                const codigo = buffer;
                console.log("Código escáner USB:", codigo);
                buffer = '';

                const input = document.getElementById('ID_Prod');
                input.value = codigo;

                document.getElementById('modalForm').style.display = 'block';
                console.log("Cerrando modalEscaneo...");
                document.getElementById('modalEscaneo').style.display = 'none';
                input.focus();

                document.removeEventListener('keypress', handleKeyPress);
            }
        }
    };

    document.addEventListener('keypress', handleKeyPress);
}

function cerrarModalEscaneo() {
    document.getElementById('modalEscaneo').style.display = 'none';

    if (handleKeyPress) {
        document.removeEventListener('keypress', handleKeyPress);
        handleKeyPress = null;
    }
}