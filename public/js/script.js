const menu= document.getElementById('menu');
const sidebar= document.getElementById('sidebar');
const main= document.getElementById('main');

menu.addEventListener('click',()=>{
    sidebar.classList.toggle('menu-toggle');
    menu.classList.toggle('menu-toggle');
    main.classList.toggle('menu-toggle');

    
});

function mostrarEscaner() {
    document.getElementById('escaneoCont').style.display = 'block';

    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#lector'), 
            constraints: {
                facingMode: "environment" // 
            },
        },
        decoder: {
            readers: ["code_128_reader", "ean_reader", "ean_8_reader", "upc_reader"] 
        }
    }, function(err) {
        if (err) {
            console.error(err);
            alert("Error al iniciar escáner");
            return;
        }
        Quagga.start();
    });

    Quagga.onDetected(function(result) {
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