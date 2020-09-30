$(document).ready(function () {
    $('#codigo').focus();
    $('#frm_productos').bootstrapValidator({
        framework: 'bootstrap',
        excluded: ':disabled',
        message: 'Valor incorrecto',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            codigo: {
                validators: {
                    notEmpty: {message: 'Ingrese el código del Producto'},
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
            nombre: {
                validators: {
                    notEmpty: {message: 'Ingrese el nombre del Producto'},
                    regexp: {
                        regexp: /^[\D\d]+$/i,
                        message: 'Solo se permiten letras de la a-z y n&uacute;meros'
                    }

                }
            },
            cantidad: {
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
        e.preventDefault();
        var $form = $(e.target),
                validator = $form.data('bootstrapValidator'),
                submitButton = validator.getSubmitButton();
        var datos = $('#frm_productos').serialize();
        var data = "";

        $.post("procesar.php", datos, function (data) {
            if (data == 'Exito') {
                location.href = 'nuevo.php';
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

function detalleRemitoPdf() {
    var url = 'impresion.php',
            fecha = '12/12/2017',
            barra = '';
    $('#pdf_form').html('<form action="' + url + '" name="pdf" method="post" style="display:none;" target="_blank"><input type="text" name="f" \n\
value="' + fecha + '" /><input type="text" name="barra" value="' + barra + '" /></form>');
    document.forms['pdf'].submit();
}
function detallePtoStock() {
    var url = 'impresion_1.php',
            fecha = '12/12/2017',
            barra = '';
    $('#pdf_form').html('<form action="' + url + '" name="pdf" method="post" style="display:none;" target="_blank"><input type="text" name="f" \n\
value="' + fecha + '" /><input type="text" name="barra" value="' + barra + '" /></form>');
    document.forms['pdf'].submit();
}