$(document).ready(function () {
    if ($('#estado').val() == 1) {
        $('#msj').modal('show');
        $('#estado').val(0);
    }
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
                        message: 'Se permiten mínimo 8 caracteres.',
//                        max: 8,
                        min: 8
                    },
                    callback: {
                        callback: function (value, validator) {
                            if ($('#codigoCorrecto').val() == 0) {
                                return true;
                            } else {
                                return {
                                    message: "El producto se encuentra duplicado",
                                    value: false
                                };
                            }
                        }
                    }


                }
            },
            nombre: {
                validators: {
                    notEmpty: {message: 'Ingrese el nombre del Producto'},
                    regexp: {
                        regexp: /^[\D\d]+$/i,
                        message: 'Solo se permiten letras de la a-z y n&uacute;meros'
                    },
                    callback: {
                        callback: function (value, validator) {
                            if ($('#nombreCorrecto').val() == 0) {
                                return true;
                            } else {
                                return {
                                    message: "El nombre del producto se encuentra duplicado",
                                    value: false
                                };
                            }
                        }
                    }

                }
            },
            categoria: {
                validators: {
                    notEmpty: {message: 'Seleccione una categoría de Productos'},
                    regexp: {
                        regexp: /^[\d]+$/i,
                        message: 'Solo se permiten n&uacute;meros'
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
            },
            precio: {
                validators: {
                    notEmpty: {message: 'Ingrese la cantidad de Productos'},
                    regexp: {
                        regexp: /^[\d+(?:\.\d{1,2})]+$/i,
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

    $('#codigo').change(function () {
        var data = '';
        $.post("buscarCodigo.php", {cod_barra: $('#codigo').val()}, function (data) {
            if (data == 'Exito') {
                $('#codigoCorrecto').val(1);
            } else {
                $('#codigoCorrecto').val(0);
            }
            $('#frm_productos').bootstrapValidator('revalidateField', 'codigo');
        });
    });

    $('#nombre').change(function () {
        var data = '';
        $.post("buscarNombre.php", {nombre: $('#nombre').val()}, function (data) {
            if (data == 'Exito') {
                $('#nombreCorrecto').val(1);
            } else {
                $('#nombreCorrecto').val(0);
            }
            $('#frm_productos').bootstrapValidator('revalidateField', 'nombre');
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