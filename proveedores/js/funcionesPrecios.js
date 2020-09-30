$(document).ready(function () {

    $('#proveedores').change(function () {

        /*$('#datatablasScroll').empty();*/
        var idproveedor = this.value;
        var tipoProceso = "buscarProductosProv";
        var tabla = $('#datatablasScroll').DataTable();
        tabla.destroy();
        $('#productosProv').empty();
        $.ajax({
            type: 'POST',
            url: './procesosProveedores.php',
            dataType: 'json',
            async: false,
            data: {
                tipo: tipoProceso,
                idp: idproveedor
            },
            success: function (resp) {
                var cant = resp['cantidad'];
                for (var i = 0; i < cant; i++) {
                    $('#productosProv').append("<tr><td style='display:none;'>" + resp['id' + i] + "</td><td style='width: 10%;'>" + resp['codbarra' + i] + "</td><td style='width: 60%;'>" + resp['desc' + i] + "</td><td class='text-center'>" + resp['fechaprecio' + i] + "</td><td class='text-center'>$ " + resp['precio' + i] + "</td><td class='text-center'><input type='checkbox' class='checkbox' name='prodp' id='prodp' value='" + resp['id' + i] + '/' + resp['precio' + i] + "'></td></tr>");
                }

            }
        });
        $('#datatablasScroll').DataTable({
            responsive: true,
            searching: true,
            iDisplayLength: 10,
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
                }

            }, "aaSorting": [],
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,

            "bAutoWidth": true,

            "scrollY": "500px",
            "scrollCollapse": true,

        });
    })

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

function modificarPrecios() {
    var proveedor = $('#proveedores').val();
    var porcentaje = $('#porc').val();
    var tipoProceso = 'actualizarprecioprov';
    if (proveedor == 0) {
        alertify.error("Seleccione un proveedor.");
        incorrecto('#proveedores', '');
        return false;
    } else {
        normal('#proveedores');
    }
    if (porcentaje.length == 0) {
        alertify.error("Debe ingresar un porcentaje de incremento.");
        incorrecto('#porc', 'sss');
        return false;
    } else {
        normal('#proveedor');
    }
    //Creamos un array que almacenará los valores de los input "checked"
    var checked = [];
    //Recorremos todos los input checkbox con name = Colores y que se encuentren "checked"
    $("input[name='prodp']:checked").each(function ()
    {
        //Mediante la función push agregamos al arreglo los values de los checkbox
        checked.push(($(this).attr("value")));
    });
    // Utilizamos console.log para ver comprobar que en realidad contiene algo el arreglo
    console.log(checked);
    if (checked.length == 0) {
        alertify.error("No hay productos seleccionados.");
        return false;
    }
    $.ajax({
        type: 'POST',
        url: './procesosProveedores.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            idp: proveedor,
            porc: porcentaje,
            productos: checked
        },
        success: function (resp) {
            $('#porc').val('');
            $("#proveedores").change();
            alertify.success("Se han modificado los precios.");
        }
    });

}

function informeProdProv() {
    var id = $('#proveedores').val();
    if (id == 0) {
        alertify.alert("<i class='fa fa-ban'></i> Debe seleccionar un proveedor.");
        return false;
    }
    window.open("productosProveedorPDF.php?idp=" + id + "", '_blank');
}

function SelectCompleto() {
    if ($("input[name='completo']").prop('checked')) {
        $(':checkbox').each(function () {
            $(this).attr('checked', true);
            $(this).prop('checked', true);
        });
    } else {
        $(':checkbox').each(function () {
            $(this).attr('checked', false);
            $(this).prop('checked', false);
        });
    }
}
;