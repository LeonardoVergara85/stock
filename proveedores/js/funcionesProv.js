$(document).ready(function () {
    $('#nombreProveedor').focus();
})

function incorrecto(v, texto) {
    $(v).parent().removeClass('has-success').addClass('has-error');
    $(v).parent().parent().removeClass('has-success').addClass('has-error');
    $(v).prev().prev().removeClass('label-success').addClass('label-danger');
    $(v).prev().removeClass('label-success').addClass('label-danger');
    $(v).parent().next().removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
    $(v).next().removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
    $(v).parent().next().next().html(texto);
    $(v).next().html(texto);

}

function correcto(v) {
    $(v).parent().removeClass('has-error').addClass('has-success');
    $(v).parent().parent().removeClass('has-error').addClass('has-success');
    $(v).prev().prev().removeClass('label-danger').addClass('label-success');
    $(v).prev().removeClass('label-danger').addClass('label-success');
    $(v).parent().next().removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
    $(v).next().html('');
}

function normal(v) {
    $(v).parent().removeClass('has-error').removeClass('has-success');
    $(v).parent().parent().removeClass('has-error').removeClass('has-success');
    $(v).prev().prev().removeClass('label-danger').removeClass('label-success');
    $(v).prev().removeClass('label-danger').removeClass('label-success');
    $(v).next().removeClass('glyphicon glyphicon-remove').removeClass('glyphicon glyphicon-ok');
    $(v).next().html('');
}

function guardar() {
    var nombre = $('#nombreProveedor').val();
    var domicilio = $('#domicilioProveedor').val();
    var telefono = $('#telefonoProveedor').val();
    var correo = $('#correoProveedor').val();
    var comentario = $('#comentarioProveedor').val();
    var cuit = $('#cuitProveedor').val();
    var tipoProceso = 'guardarProveedor';
    /////////////////VALIDAMOS//////////////////////
    if (nombre.length < 5) {
        incorrecto('#nombreProveedor', 'ssss');
        return false;
    } else {
        normal('#nombreProveedor');
    }
    if (cuit.length < 13) {
        incorrecto('#cuitProveedor');
        return false;
    } else {
        normal('#cuitProveedor');
    }
    if (telefono.length < 7) {
        incorrecto('#telefonoProveedor');
        return false;
    } else {
        normal('#telefonoProveedor');
    }

    $.ajax({
        type: 'POST',
        url: './procesosProveedores.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            nombrep: nombre,
            domiciliop: domicilio,
            telefonop: telefono,
            correop: correo,
            comentariop: comentario,
            cuitp: cuit
        },
        success: function (resp) {
            $('#formulariop').hide();
            $('#msjguardar').show();
            // $(location).attr('href', 'index.php');
        }

    });
}


function eliminar(id) {
    var idp = id;
    $('#idproveedor').val(idp);
    /*$('#modalDropP').modal('show');*/
    alertify.confirm("Esta seguro de Eliminar este proveedor?",function(e){
        if(e){
            eliminarProv();
        }
    });

}

function eliminarProv() {
    var idp = $('#idproveedor').val();
    var tipoProceso = 'eliminarProv';
    $.ajax({
        type: 'POST',
        url: './procesosProveedores.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            idp: idp
        },
        success: function (resp) {
            $(location).attr('href', 'index.php');
        }
    });
}

function msjguardar() {
    $(location).attr('href', 'index.php');
}

function infoProv(id) {
    var idPrv = id;
    var tipoProceso = 'buscarProveedor';
    ///////////////////////////////////////////
    $.ajax({
        type: 'POST',
        url: './procesosProveedores.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            idp: idPrv
        },
        success: function (resp) {
            $('#modal-title-prov').html(resp[0]);
            $('#modal-cuit').html('CUIT: <strong>' + resp[5] + '</strong>');
            $('#modal-tel').html('Telefono: <strong>' + resp[1] + '</strong>');
            $('#modal-dom').html('Domicilio: <strong>' + resp[2] + '</strong>');
            $('#modal-correo').html('Correo: <strong>' + resp[3] + '</strong>');
            $('#modal-coment').html(resp[4]);


        }
    });
    /////////////////////////////////////
    $('#modalInfoProd').modal('show');
}

function editarProv(id) {
    var idPrv = id;
    var tipoProceso = 'buscarProveedor';
    ///////////////////////////////////////////
    $.ajax({
        type: 'POST',
        url: './procesosProveedores.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            idp: idPrv
        },
        success: function (resp) {
            $('#idpx').val(idPrv);
            $('#nombreProveedorE').val(resp[0]);
            $('#cuitProveedorE').val(resp[5]);
            $('#telefonoProveedorE').val(resp[1]);
            $('#domicilioProveedorE').val(resp[2]);
            $('#correoProveedorE').val(resp[3]);
            $('#comentarioProveedorE').val(resp[4]);
        }
    });
    $('#modalEditProv').modal('show');

}


function editarProveedor() {
    var tipoProceso = 'editarProveedor';
    var id = $('#idpx').val();
    var nombre = $('#nombreProveedorE').val();
    var cuit = $('#cuitProveedorE').val();
    var tel = $('#telefonoProveedorE').val();
    var domi = $('#domicilioProveedorE').val();
    var correo = $('#correoProveedorE').val();
    var com = $('#comentarioProveedorE').val();
    //////////////////////////////////////////
    if (nombre.length < 5) {
        incorrecto('#nombreProveedorE', 'ssss');
        return false;
    } else {
        normal('#nombreProveedorE');
    }

    if (cuit.length < 13) {
        incorrecto('#cuitProveedorE', 'ssss');
        return false;
    } else {
        normal('#cuitProveedorE');
    }

    if (tel.length < 7) {
        incorrecto('#telefonoProveedorE', 'ssss');
        return false;
    } else {
        normal('#telefonoProveedorE');
    }

    $.ajax({
        type: 'POST',
        url: './procesosProveedores.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            idp: id,
            nombrep: nombre,
            cuitp: cuit,
            telp: tel,
            domip: domi,
            correop: correo,
            comp: com
        },
        success: function (resp) {
            $(location).attr('href', 'index.php');
        }
    });
}

function listadopdf() {
    // alert('s');
    // // var id = $('#idx').val();
    // // $('#detalleRemitoModal').modal('hide');
    // $('#pdf_list').html('<form action="listadoPDF.php" name="vote2" id="vote2" method="post" style="display:none;"><input type="text" name="idRem" value="10"></form>');
    // document.forms['vote2'].submit();

    // $('#pdf_list').html('<form action="listadoPDF.php" name="listado" method="post" style="display:none;"></form>');
    //  document.forms['pdf_list'].submit();
    window.open('listadoPDF.php', '_blank');
}
