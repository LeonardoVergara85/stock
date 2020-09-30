$(document).ready(function () {
    $('#producto').change(function () {
        $('#descuento_producto').val('');
        $('#precio_producto').val('');
        $('#porcentaje_producto').val('');
        $.post("buscar.php", {data: $('#producto').val()},
                function (data) {
                    var obj = jQuery.parseJSON(data);
                    $('#id_producto').val($('#producto').val());
                    $('#id_producto_img').val($('#producto').val());
                    $('#precio_producto').val(obj.precio);
                });
    });
    
    $('#descuento_producto').change(function () {
        $('#porcentaje_producto').val(
                100 - ((($('#descuento_producto').val()*100)/($('#precio_producto').val())).toFixed(2))
        );
    });
    $('#porcentaje_producto').change(function () {
        $('#descuento_producto').val(($('#precio_producto').val()-($('#precio_producto').val() * $('#porcentaje_producto').val() / 100)).toFixed(2));
    });
//=100-(AO277/AO276*AP276)
    $('#producto').focus();


    $('#frm_oferta_productos').bootstrapValidator({
        framework: 'bootstrap',
        excluded: ':disabled',
        message: 'Valor incorrecto',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
//            porcentaje_producto: {
//                validators: {
//                    notEmpty: {message: 'Ingrese el porcentaje de descuento.'},
//                    regexp: {
//                        regexp: /^[\d+\.\d+]+$/i,
//                        message: 'Solo se permiten dígitos.'
//                    },
//                    stringLength: {
//                        message: 'Se permiten máximo 3 dígitos.',
//                        max: 3
//                    }
//                }
//            },
            descuento_producto: {
                validators: {
                    notEmpty: {message: 'Ingrese el precio del producto con el descuento.'},
                    regexp: {
                        regexp: /^[\d+\.\d+]+$/i,
                        message: 'Solo se permiten dígitos.'
                    },
                    stringLength: {
                        message: 'Se permiten máximo 8 dígitos.',
                        max: 8
                    }
                }
            }
            , fin_oferta: {
                validators: {
                    notEmpty: {message: 'Ingrese el nombre del Producto'},
                    regexp: {
                        regexp: /^\d{4}(\-)(((0)[0-9])|((1)[0-2]))(\-)([0-2][0-9]|(3)[0-1])$/i,
                        message: 'Solo se permiten letras de la a-z y n&uacute;meros'
                    }

                }
            }
        }

    }).on('success.form.bv', function (e) {
        $('#verMensaje').modal('toggle');
        e.preventDefault();
        
        if($("#img").val().length > 0){

            $("#imagen").val(1);

         } 

        var $form = $(e.target),
                validator = $form.data('bootstrapValidator'),
                submitButton = validator.getSubmitButton();
        var datos = $('#frm_oferta_productos').serialize();
        var data = "";

        

        $.post("procesar_oferta.php", datos, function (data) {
            if (data == 'Exito') {

               if($("#img").val().length > 0){

                 $("#frm_oferta_img").submit();

             }else{

               location.href = 'ofertas.php';

             }                

                // if (image == 'ok') {

                //       alertify.alert("La oferta del producto se realizó exitosamente.", function (e) {
                //     if (e) {
                //         location.href = 'ofertas.php';
                //     }
                // });

                // }
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