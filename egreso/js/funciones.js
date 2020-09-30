var paquete, repo;
var arreglo = new Array();
var cantidad = new Array();
$(document).ready(function () {
    $('#productoList').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: 'autocompleteProd.php',
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
            $('#codigo').val(ui.item.cod);
            $('#productoListId').val(ui.item.id);
            $("#productoList").keyup();
            $('#frm_productos').bootstrapValidator('revalidateField', 'codigo');
            $('#frm_productos').bootstrapValidator('revalidateField', 'productoList');
            $('#codigo').change();
        },
        autoFocus: true,
        minLength: 0,
        sortResults: false
    });

    $('#grilla').bootstrapTable({locale: 'en-ES'});
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
                        message: 'Se permiten mínimo 8 dígitos.',
//                        max: 8,
                        min: 8
                    }

                }
            },
            productoList: {
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

        $('#grilla').bootstrapTable('insertRow', {index: arreglo.length,
            row: {
                codigo: $("#codigo").val(),
                producto: $("#productoList").val(),
                cantidad: $("#cantidad").val(),
                paquete: paquete,
                total: paquete * $("#cantidad").val(),
                option: "<button class='btn btn-danger btn-xs text-center' type='button'><li class='fa fa-minus-circle' onclick='sacar(\"" + $("#codigo").val() + "\", " + arreglo.length + ")'></li></button>"
            }
        });
        cantidad[arreglo.length] = paquete * $("#cantidad").val();
        arreglo[arreglo.length] = $("#codigo").val();
        $("#codigo").val(''), $("#productoList").val(''), $("#cantidad").val('');
        $('#frm_productos').bootstrapValidator('revalidateField', 'codigo');
        $('#frm_productos').bootstrapValidator('revalidateField', 'productoList');
        alertify.success("Se ha cargado un producto.");
    });


    $("#codigo").change(function () {
        var value = $("#codigo").val();
        if (value.length >= 8) {
            $.post("buscar.php", {valor: value}, function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.descripcion != false) {
                    $("#productoList").val(obj.descripcion);
                    paquete = obj.paquete;
                    repo = obj.repo;
                    $('#frm_productos').bootstrapValidator('revalidateField', 'codigo');
                    $('#frm_productos').bootstrapValidator('revalidateField', 'productoList');
                    return true;
                } else {

                }
            });
        }
    });

    $("#cantidad").change(function () {
        var value = $("#codigo").val();
        if (value.length >= 1) {
            $.post("buscarDatos.php", {valor: value}, function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.cantidad != false) {
                    if (obj.cantidad >= $("#cantidad").val() * paquete) {
                        return true;
                    } else {
                        alert('La cantidad de productos supera al Stock');
                    }
                } else {
                    alert('Sin Stock');
                }
            });
        }
    });

    $("#procesar").click(function () {
        var data;
        console.log(arreglo);
        console.log(cantidad);
        $.post("procesar.php", {arregle: arreglo, cantidad: cantidad}, function (data) {
            if (data == 'Exito') {
                location.href = 'index.php';
            }
        });
    });

});

function sacar(sacar, v1) {
    $('#grilla').bootstrapTable('removeByUniqueId', sacar);
    delete arreglo[v1];
    delete cantidad[v1];
    alertify.error("Se ha removido un producto.");
}

function regreso() {
    location.href = "index.php";
}

function detalleEgreso(id) {
    $('#cuerpoDetalle').empty();
    var valor = id;
    var tipoProceso = 'buscarDetalle';

    $.ajax({
        type: 'POST',
        url: './buscarDatos_1.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            valor: valor
        },
        success: function (resp) {
//    $resp['umed_id']
            $('#modal-titleDetalle').html('Egreso N°:' + valor);
            for (var i = 0; i < resp['id'].length; i++) {
                $('#cuerpoDetalle').append("<tr class='newDetail'><td>" + resp['cod_barra'][i]
                        + "</td><td class='text-left'>"
                        + resp['descripcion'][i] + "</td><td>"
                        + parseInt(resp['paquete'][i]) + "</td><td>"
                        + resp['cantidad'][i] / resp['paquete'][i] + "</td><td>"
                        + resp['cantidad'][i] + "</td></tr>");

            }
        }

    });
    $('#detalleEgresoModal').modal('show');
}

function detalleEgresoPdf(valor) {
    $('#pdf_form').html('<form action="impresionEgreso.php" name="pdf" method="post" style="display:none;" target="_blank"><input type="text" name="valor" value="' + valor + '" /></form>');
    document.forms['pdf'].submit();
}