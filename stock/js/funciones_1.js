$(document).ready(function () {
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
                        message: 'Se permiten 14 caracteres.',
                        max: 8,
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

});

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