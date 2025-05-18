const menu = document.getElementById('menu');
const sidebar = document.getElementById('sidebar');
const dashboard = document.querySelector('.dashboard');

menu.addEventListener('click', () => {
    sidebar.classList.toggle('menu-toggle');
    menu.classList.toggle('menu-toggle');
     dashboard.classList.toggle('menu-toggle');
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
function ventanaEscaneo() {
    document.getElementById('modalEscaneo').style.display = 'block';

    let buffer = '';
    let lastKeyTime = Date.now();

    function handleKeyPress(e) {
        const currentTime = Date.now();
        const timeDiff = currentTime - lastKeyTime;

        if (timeDiff > 100) buffer = '';
        lastKeyTime = currentTime;

        if (e.key !== 'Enter') {
            buffer += e.key;
        } else {
            if (buffer.length >= 6) {
                const codigo = buffer;
                console.log("Código escaner USB: ", codigo);
                buffer = '';

                const input = document.getElementById('ID_Prod');
                input.value = codigo;

                console.log("Ya se cerro la cosa esa");
                document.getElementById('modalEscaneo').style.display = 'none';
                setTimeout(() => {
                    document.getElementById('modalForm').style.display = 'block';
                    input.focus();
                }, 100);

                document.removeEventListener('keypress', handleKeyPress);
            }
        }
    }

    document.addEventListener('keypress', handleKeyPress);
}

function cerrarModalEscaneo() {
    document.getElementById('modalEscaneo').style.display = 'none';
}