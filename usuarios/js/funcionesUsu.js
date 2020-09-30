$(document).ready(function () {

    $('#documentoUsuario').keyup(function () {
        numeros(this, 'no');
    });

    $('#nombreUsuario').keyup(function () {
        letras(this, 'no');
    });
    $('#apellidoUsusario').keyup(function () {
        letras(this, 'no');
    });
    $('#telefonoUsuario').keyup(function () {
        telefono(this, 'no');
    });
    $('#correoUsuario').keyup(function () {
        email(this, 'no');
    });
// aca ponemos todo lo va cuando se carga la pagina

})



function incorrecto(v, texto) {
    $(v).parent().removeClass('has-success').addClass('has-error');
    $(v).parent().parent().removeClass('has-success').addClass('has-error');
    $(v).prev().prev().removeClass('label-success').addClass('label-danger');
    $(v).prev().removeClass('label-success').addClass('label-danger');
    // $(v).parent().next().removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
    // $(v).next().removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
    $(v).parent().next().next().html(texto);
    // $(v).next().html(texto);

}

function correcto(v) {
    $(v).parent().removeClass('has-error').addClass('has-success');
    $(v).parent().parent().removeClass('has-error').addClass('has-success');
    $(v).prev().prev().removeClass('label-danger').addClass('label-success');
    $(v).prev().removeClass('label-danger').addClass('label-success');
    $(v).parent().next().removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
//    $(v).next().removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
    //$(v).parent().next().next().html('');
    $(v).next().html('');
//    $('#enviar').prop('disabled', false);
}

function normal(v) {
    $(v).parent().removeClass('has-error').removeClass('has-success');
    $(v).parent().parent().removeClass('has-error').removeClass('has-success');
    $(v).prev().prev().removeClass('label-danger').removeClass('label-success');
    $(v).prev().removeClass('label-danger').removeClass('label-success');
    $(v).next().removeClass('glyphicon glyphicon-remove').removeClass('glyphicon glyphicon-ok');
    $(v).next().html('');
}

function numeros(v, ob) {
    var ex = /^[0-9.]*$/;
    if (v.value.length === 0 && ob === 'si') {
        incorrecto(v, 'Complete este campo');
    } else if (v.value.length === 0 && ob === 'no') {
        normal(v);
    } else if (ex.test(v.value) === false) {
        incorrecto(v, 'Solo numeros');
    } else {
        normal(v);
    }
}

function letras(v, ob) {
    var ex = /^[a-zA-Z ]*$/;
    if (v.value.length === 0 && ob === 'si') {
        incorrecto(v, 'Complete este campo');
    } else if (v.value.length === 0 && ob === 'no') {
        normal(v);
    } else if (ex.test(v.value) === false) {
        incorrecto(v, 'Solo letras');
    } else {
        normal(v);
    }
}

function telefono(v, ob) {
    var ex = /^[0-9. /-]*$/;
    if (v.value.length === 0 && ob === 'si') {
        incorrecto(v, 'Complete este campo');
    } else if (v.value.length === 0 && ob === 'no') {
        normal(v);
    } else if (ex.test(v.value) === false) {
        incorrecto(v, 'Solo letras');
    } else {
        normal(v);
    }
}

function email(v, ob) {
    var ex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (v.value.length === 0 && ob === 'si') {
        incorrecto(v, 'Complete este campo');
    } else if (v.value.length === 0 && ob === 'no') {
        normal(v);
    } else if (ex.test(v.value) === false) {
        incorrecto(v, 'correo incorrecto');
    } else {
        normal(v);
    }
}

function guardarU() {
    var dni = $('#documentoUsuario').val();
    var nombreu = $('#nombreUsuario').val();
    var apellidou = $('#apellidoUsusario').val();
    var domiciliou = $('#domicilioUsuario').val();
    var telefonou = $('#telefonoUsuario').val();
    var correou = $('#correoUsuario').val();
    var nacimientou = $('#fechaNacUsuario').val();
    var usuariou = $('#usuario').val();
    var passu = $('#passUsuario').val();
    var tipou = $('#tipoUsuario').val();
    var tipoProceso = 'guardarUsuario';
    /////////////////////////////////////////
    if (dni.length < 8) {
        incorrecto('#documentoUsuario', 'ssss');
        return false;
    } else {
        normal('#documentoUsuario');
    }
    if (nombreu.length < 2) {
        incorrecto('#nombreUsuario', 'ssss');
        return false;
    } else {
        normal('#nombreUsuario');
    }
    if (apellidou.length < 2) {
        incorrecto('#apellidoUsusario', 'ssss');
        return false;
    } else {
        normal('#apellidoUsusario');
    }
    if (domiciliou.length < 2) {
        incorrecto('#domicilioUsuario', 'ssss');
        return false;
    } else {
        normal('#domicilioUsuario');
    }
    if (telefonou.length < 6) {
        incorrecto('#telefonoUsuario', 'ssss');
        return false;
    } else {
        normal('#telefonoUsuario');
    }
    if (nacimientou.length < 10) {
        incorrecto('#fechaNacUsuario', 'ssss');
        return false;
    } else {
        normal('#fechaNacUsuario');
    }
    if (usuariou.length < 2 || usuariou.length > 17) {
        incorrecto('#usuario', 'ssss');
        return false;
    } else {
        normal('#usuario');
    }
    if (passu.length < 6) {
        incorrecto('#passUsuario', 'ssss');
        return false;
    } else {
        normal('#passUsuario');
    }
    if (tipou == 0) {
        incorrecto('#tipoUsuario', 'ssss');
        return false;
    } else {
        normal('#tipoUsuario');
    }

    $.ajax({
        type: 'POST',
        url: './procesosUsuarios.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            dni: dni,
            nombre: nombreu,
            apellido: apellidou,
            domicilio: domiciliou,
            telefono: telefonou,
            correo: correou,
            nacimiento: nacimientou,
            usuario: usuariou,
            pass: passu,
            tipou: tipou
        },
        success: function (resp) {
            $('#msjguardarUsuario').show();
            $('#formulariou').hide();
        }

    });
}


function msjguardaru() {
    $(location).attr('href', 'index.php');
}


function bloquear(id) {
    $('#idU').val(id);
    /*$('#msjBloqueoUsuario').modal('show');*/
    alertify.confirm("Realmente dese Eliminar el usuario?", function(e){
       if(e){
        bloquearUsuario();
       }     
    });
}

function habilitarU(id) {
    $('#idUsu').val(id);
   /* $('#msjHabilitaUsuario').modal('show');*/
   alertify.confirm("Realmente desea habilitar este usuario?.", function(e){
    if(e){
     habilitarUsuario();
    }
   });
}

function bloquearUsuario() {
    var idusu = $('#idU').val();
    var tipoProceso = 'bloquearusuario'
    $.ajax({
        type: 'POST',
        url: './procesosUsuarios.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idusu
        },
        success: function (resp) {
            $(location).attr('href', 'index.php');
        }

    });
}

function habilitarUsuario() {
    var idusu = $('#idUsu').val();
    var tipoProceso = 'habilitarU'
    $.ajax({
        type: 'POST',
        url: './procesosUsuarios.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idusu
        },
        success: function (resp) {
            $(location).attr('href', 'index.php');
        }

    });
}

function modUsu(id) {
    var idu = id;
    var tipoProceso = "busqueda";
    $('#idUsum').val(id);
    $.ajax({
        type: 'POST',
        url: './procesosUsuarios.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idu
        },
        success: function (resp) {
            $('#dni').val(resp[3]);
            $('#nombre').val(resp[1]);
            $('#apellido').val(resp[2]);
            $('#domicilio').val(resp[4]);
            $('#telefono').val(resp[5]);
            $('#correo').val(resp[6]);
            $('#nac').val(resp[7]);
            $('#usuariom').val(resp[8]);
            $('#passw').val(resp[9]);
            $('#nive').val(resp[10]);
            $('#idPerm').val(resp[12]);
        }

    });

    $('#modificarU').modal('show');
}


function modificarUsuario() {
    var idu = $('#idUsum').val();
    var idp = $('#idPerm').val();
    var dni = $('#dni').val();
    var nombre = $('#nombre').val();
    var apellido = $('#apellido').val();
    var domicilio = $('#domicilio').val();
    var telefono = $('#telefono').val();
    var correo = $('#correo').val();
    var nac = $('#nac').val();
    var usuario = $('#usuariom').val();
    var pass = $('#passw').val();
    var nivel = $('#nive').val();
    var tipoProceso = 'modificarUsu';

    if (dni.length < 8) {
        incorrecto('#dni', 'ssss');
        return false;
    } else {
        normal('#dni');
    }
    if (nombre.length < 2) {
        incorrecto('#nombre', 'ssss');
        return false;
    } else {
        normal('#nombre');
    }
    if (apellido.length < 2) {
        incorrecto('#apellido', 'ssss');
        return false;
    } else {
        normal('#apellido');
    }
    if (domicilio.length < 2) {
        incorrecto('#domicilio', 'ssss');
        return false;
    } else {
        normal('#domicilio');
    }
    if (telefono.length < 6) {
        incorrecto('#telefono', 'ssss');
        return false;
    } else {
        normal('#telefono');
    }
    if (nac.length < 10) {
        incorrecto('#nac', 'ssss');
        return false;
    } else {
        normal('#nac');
    }
    if (usuario.length < 2 || usuario.length > 17) {
        incorrecto('#usuariom', 'ssss');
        return false;
    } else {
        normal('#usuariom');
    }
    if (pass.length < 6) {
        incorrecto('#passw', 'ssss');
        return false;
    } else {
        normal('#passw');
    }
    if (nivel == 0) {
        incorrecto('#nive', 'ssss');
        return false;
    } else {
        normal('#nive');
    }
    $.ajax({
        type: 'POST',
        url: './procesosUsuarios.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idu,
            idper: idp,
            dniu: dni,
            nombreu: nombre,
            apellidou: apellido,
            domiciliou: domicilio,
            telefonou: telefono,
            correou: correo,
            nacu: nac,
            usuariou: usuario,
            passu: pass,
            nivelu: nivel
        },
        success: function (resp) {
            $(location).attr('href', 'index.php');
        }

    });
}