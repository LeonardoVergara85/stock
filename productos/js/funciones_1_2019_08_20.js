let codigo_aux = 0;
$(document).ready(function () {
    $('#refresco').click(function () {
        $('#example').DataTable().ajax.reload();
    });
    $('#example').DataTable({
        "select": true,
        "ajax": "data/datos.txt",
        "idSrc": "DT_RowId",
        "columns": [
            {"data": "orden"},
            {"data": "codigo"},
            {"data": "descripcion"},
            {"data": "paquete"},
            {"data": "repo"},
            {"data": "unitario"},
            {"data": "boton"}
        ],
        "order": [[1, "asc"]],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": " Mostrar  _MENU_  registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "No hay datos disponible",
            "sInfo": "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Filtrar: ",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "select": true

        }
    });

    if ($('#habil').val() == 1) {
        $('#msj').modal('show');
        $('#habil').val(0);
    }
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
            console.log(data);
            if (data == 'Exito') {
                var medida;
                var table = $('#example').DataTable();
                table.row('.selected').remove().draw(false);
                switch ($('#umedida_modal').val()) {
                    case 1:
                        medida = " Centimetros";
                        break;
                    case 2:
                        medida = " Metros";
                        break;
                    case 3:
                        medida = " Toneladas";
                        break;
                    case 4:
                        medida = " Unidades";
                        break;
                    default:
                        break;
                }

                table.row.add({
                    "id": "tin1",
                    "idSrc": "tin",
                    "codigo": $('#codigo_modal').val(),
                    "descripcion": $('#nombre_modal').val(),
                    "paquete": $('#cantidad_modal').val() + ' ' + medida,
                    "repo": $('#reposicion_modal').val() + ' ' + medida,
                    "unitario": '$ ' + $('#precio_modal').val(),
                    "boton": "<button class='btn btn-warning btn-sm' onclick='modificar(" + $('#id_modal').val() + ")' title='modificar'><i class='fa fa-pencil-square-o'></i></button> <button class='btn btn-success btn-sm' onclick='codigoBarra(" + $('#codigo_modal').val() + ")' title='Imprimir Código'><i class='fa fa-barcode' aria-hidden='true'></i></button> <button class='btn btn-danger btn-sm' onclick='eliminar(" + $('#id_modal').val() + ", \"Cartel Led Videomax1\")' title='eliminar'><i class='fa fa-minus-circle'></i></button>"
                }).draw(false);
                table.$('tr.selected').removeClass('selected');
                $('#modi_aceptar').prop("disabled", false);

//                $('#example').DataTable().ajax.reload(false);
//                location.href = 'index.php';
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

    var table = $('#example').DataTable();

    $('#example tbody').on('click', 'tr', function () {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
//        if ($(this).hasClass('selected')) {
//            $(this).removeClass('selected');
//            console.log($(this).id);
//        } else {
//            console.log($(this)[0]);
//            codigo_aux = $(this)[0].id;

//            table.row('.selected').remove().draw(false);
//            table.row.add({
//                "codigo": '987',
//                "descripcion": 'AAA Prueba 16/05/2018',
//                "paquete": '1 unidad',
//                "repo": '30 unidades',
//                "unitario": '1',
//                "boton": '11'
//            }).draw(false);
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

function codigoBarra(barra) {

    var codigo_ = barra.toString();
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
    $('#codigo_modal_3').html(codigo_);
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
        $('#precio_modal').val(obj.precio);
        $('#categoria_modal').val(obj.categoria);
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
    /*$('#pDeshabilitar').text(texto);*/
/*    $('#msjBloqueoProducto').modal('show');*/
   alertify.confirm("¿Esta seguro de deshabilitar el producto <strong>"+texto+"</strong>?.",function(e){
    if(e){
      $("#frm_desha_productos").submit();
      }
   });
}