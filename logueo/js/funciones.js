function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest !== 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function guardarDato() {
    var cactual = document.getElementById('contrasena').value,
            nueva = document.getElementById('contrasena1').value,
            duplicado = document.getElementById('contrasena2').value,
            divResultado = document.getElementById('divResultado');

    divResultado.innerHTML = "";
    
    document.getElementById('contrasena').style.borderColor = '';
    if (cactual === '') {
        document.getElementById('contrasena').style.borderColor = 'red';
        return false;
    }
    
    document.getElementById('contrasena1').style.borderColor = '';
    if (cactual === '') {
        document.getElementById('contrasena1').style.borderColor = 'red';
        return false;
    }
    
    document.getElementById('contrasena2').style.borderColor = '';
    if (cactual === '') {
        document.getElementById('contrasena2').style.borderColor = 'red';
        return false;
    }

    if (nueva !== duplicado) {
        divResultado.innerHTML = "<div class='alert alert-warning alert-dismissible' role='alert'> Las nuevas claves no coinciden </div>";
        return false;
    }
//    return false;

    var datos = "cactual=" + cactual
            + "&nueva=" + nueva
            + "&duplicado=" + duplicado;

    ajax = objetoAjax();

    ajax.open("POST", "guardarDatos.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState === 4) {
            divResultado.innerHTML = ajax.responseText;
        }
    };
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send(datos);
}