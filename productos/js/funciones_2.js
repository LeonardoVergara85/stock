$(document).ready(function () {
     $('#cantp').keyup(function () {
        numeros(this, 'no');
    });

    if ($('#habil').val() == 1) {
        $('#msj').modal('show');
        $('#habil').val(0);
    }

     $('#productoList').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: './autocompleteProd.php',
                dataType: "json",
                type: "GET",
                data: {
                    nom: request.term
                },
                success: function (data) {
                    response($.map(data, function (item, key) {
                        return {
                            label: item[1], value: item[1], id: key, cod: item[0]
                        };
                    }));
                }
            });
        },
        select: function (event, ui) {
            $('#cantp').focus();
            console.log(ui.item.value[1]);
            $('#productoListId').val(ui.item.id);
            $("#productoList").keyup();
            $("#codigo").val(ui.item.cod);
        },

        autoFocus: true,
        minLength: 0,
        sortResults: false
    });

    $('#codigo').focus();
    $('#frm_modi_productos').bootstrapValidator({
        framework: 'bootstrap',
        excluded: ':disabled',
        message: 'Valor incorrecto',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            codigo_modal: {
                validators: {
                    notEmpty: {message: 'Ingrese el código del Producto Modal'},
                    regexp: {
                        regexp: /^[\d]+$/i,
                        message: 'Solo se permiten dígitos.'
                    },
                    stringLength: {
                        message: 'Se permiten mínimo 8 caracteres.',
//                        max: 8,
                        min: 8
                    }

                }
            },
            nombre_modal: {
                validators: {
                    notEmpty: {message: 'Ingrese el nombre del Producto'},
                    regexp: {
                        regexp: /^[\D\d]+$/i,
                        message: 'Solo se permiten letras de la a-z y n&uacute;meros'
                    }

                }
            },
            cantidad_modal: {
                validators: {
                    notEmpty: {message: 'Ingrese la cantidad de Productos'},
                    regexp: {
                        regexp: /^[\d]+$/i,
                        message: 'Solo se permiten n&uacute;meros'
                    }

                }
            }
        }

    }).on('success.form.bv', function (e) {
        $('#verMensaje').modal('toggle');
        e.preventDefault();
        var $form = $(e.target),
                validator = $form.data('bootstrapValidator'),
                submitButton = validator.getSubmitButton();
        var datos = $('#frm_modi_productos').serialize();
        var data = "";

        $.post("modificar.php", datos, function (data) {
            if (data == 'Exito') {
                location.href = 'index.php';
            }
        });
    });

    $('#paquete').click(function () {
        if ($('#paquete').prop("checked")) {
            $('#cantidad').val(2);
            $('#cantidad').prop("disabled", false);
            $('#cantidad').prop("min", 2);
        } else {
            $('#cantidad').val(1);
            $('#cantidad').prop("min", 1);
            $('#cantidad').prop("disabled", true);
        }

    });

    $('#frm_desha_productos').bootstrapValidator({
        framework: 'bootstrap',
        excluded: ':disabled',
        message: 'Valor incorrecto',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
    }).on('success.form.bv', function (e) {
        $('#msjBloqueoProducto').modal('toggle');
        e.preventDefault();
        var $form = $(e.target),
                validator = $form.data('bootstrapValidator'),
                submitButton = validator.getSubmitButton();
        var datos = $('#frm_desha_productos').serialize();
        var data = "";

        $.post("deshabilitar.php", datos, function (data) {
            if (data == 'Exito') {
                location.href = 'index.php';
            }
        });
    });
});

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
function codigoBarra(barra) {

    var codigo = barra.toString().split("");

    var suma = 104;
    for (var i = 0; i < codigo.length; i++) {
        console.log(suma);
        suma += (parseInt(codigo[i]) + parseInt(16)) * parseInt(i + 1);
    }

    var reminder = suma % 103;

    if (reminder > 0 && reminder < 95) {
        reminder += 32;
    } else if (reminder > 94 && reminder < 106) {
        reminder += 100;
    } else if (reminder == 0) {
        reminder = 194;
    }

    barra = 'Ì' + barra + String.fromCharCode(reminder) + 'Î';

    $('#codigo_modal_1').html(barra);
    $('#verCodigo').modal('show');
}
;

function codigoPdf() {
    var url = 'impresion.php',
            barra = $('#codigo_modal_1').html();
    $('#pdf_form').html('<form action="' + url + '" name="pdf" method="post" style="display:none;" target="_blank"><input type="text" name="barra" value="' + barra + '" /></form>');
    document.forms['pdf'].submit();
}

function modificar(identificador) {
    $.post("buscar.php", {data: identificador}, function (respuesta) {
        var obj = jQuery.parseJSON(respuesta);
        $('#id_modal').val(identificador);
        $('#codigo_modal').val(obj.cod_barra);
        $('#nombre_modal').val(obj.descripcion);
        $('#umedida_modal').val(obj.umed_id);
        $('#cantidad_modal').val(obj.paquete);
        $('#reposicion_modal').val(obj.punto_reposicion);
        if (obj.paquete > 1) {
            $('#paquete_modal').prop("checked", true);
            $('#cantidad_modal').prop("disabled", false);
            $('#cantidad_modal').prop("min", 2);
        } else {
            $('#paquete_modal').prop("checked", false);
            $('#cantidad_modal').prop("disabled", true);
            $('#cantidad_modal').prop("min", 1);
            $('#cantidad_modal').val(1);
        }
        $('#verMensaje').modal('show');
    });
}
;
$('#paquete_modal').click(function () {
    if ($('#paquete_modal').prop("checked")) {
        $('#cantidad_modal').val(2);
        $('#cantidad_modal').prop("disabled", false);
        $('#cantidad_modal').prop("min", 2);
    } else {
        $('#cantidad_modal').val(1);
        $('#cantidad_modal').prop("min", 1);
        $('#cantidad_modal').prop("disabled", true);
    }
});

function eliminar(id, texto) {
    $('#iddesha').val(id);
    $('#pDeshabilitar').text(texto);
    $('#msjBloqueoProducto').modal('show');
}

function reajustar(){
    var id = $('#productoListId').val();
    var cod = $('#codigo').val();
    var nomp = $('#productoList').val();
    var cant = $('#cantp').val();
    var coment = $('#comentario').val();
    var tipo = "reajustar";
    ////// validamos ///////////////////
    if(id == 0){
        alertify.error("Seleccione un producto.");
        incorrecto('#productoList');
        return false;
    }else{
        normal('#productoList');
    }  
    if(cant.length < 1){
        alertify.error("Ingrese la cantidad del producto para el reajuste.");
        incorrecto('#cantp');
        return false;
    }else{
        normal('#cantp');
    }
    if(coment.length < 2){
        alertify.error("Debe ingresar un comentario.");
        incorrecto('#comentario');
        return false;
    }else{
        normal('#comentario');
    } 

    
    //////////// ajax ////////////////////
        $.ajax({
        type: 'POST',
        url: './procesoReajuste.php',
        dataType: 'json',
        async: false,
        data: {
            idp: id,
            cod: cod,
            cantidad: cant,
            comentario: coment,
            tipo: tipo
        },
        success: function (resp) {
            /*$('#avisoreajuste').modal('show');*/
            alertify.alert("El reajuste del producto <strong>"+nomp+"</strong> se realizó exitosamente.",function(e){
                if(e){
                    window.location.href = 'reajuste.php';
                }
            });
        }

    });
}