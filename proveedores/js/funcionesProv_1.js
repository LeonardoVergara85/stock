$(document).ready(function () {

    $('#proveedor').change(function () {
        //Buscar los datos que van dentro de la tabla
        // que corresponden al proveedor.

        $.post("buscarpp_1.php", {
            prov: $('#proveedor').val()
        }, function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.Fin == 'Fin') {
                $('#example').DataTable().ajax.reload();
            }
        });
    });
    $('#guardar').click(function () {
        var ids;
        var inpu = [];
        var porc = [];
        var noids = $('input[type=checkbox]:not(:checked)').map(function () {
            return $(this).attr('id').slice(3);
        }).get();

        ids = $('input[type=checkbox]:checked').map(function () {
            return $(this).attr('id').slice(3);
        }).get();

        for (var i = 0; i < ids.length; i++) {
            if ($('#precio' + ids[i]).val() == '') {
                $('#precio' + ids[i]).css("border-color", "red");
                alertify.error("Hay productos que no tienen precio cargado.");
                return false;
            } else {
                $('#precio' + ids[i]).css("border-color", "");
            }
            inpu[i] = $('#precio' + ids[i]).val();
            porc[i] = $('#porcent' + ids[i]).val();
        }

//        inpu.forEach(function (element) {
//            console.log(element);
//        });

        if (ids.length >= 1) {
            $.post("asociar.php",
                    {
                        prov: $('#proveedor').val(),
                        ids: ids.join(', '),
                        valor: inpu.join(', '),
                        noids: noids.join(', '),
                        porcentaje: porc.join(', ')
                    }, function (data) {
//                resp['id']
                var obj = jQuery.parseJSON(data);
                if (obj.c == "Exito") {
                    alertify.success("Los productos se asociaron correctamente.");
                }
//                console.log(ids.join(', '));
//                console.log(obj.c);

//                if (obj.cantidad != false) {
//                    if (obj.cantidad >= $("#cantidad").val() * paquete) {
//                        return true;
//                    } else {
//                        alert('La cantidad de productos supera al Stock');
//                    }
//                } else {
//                    alert('Sin Stock');
//                }
            });
        }
    });

    $('#nombreProveedor').focus();
    $('#example').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false,
        "ajax": "data/datos.txt",
//        "ajax": "../productos/data/datos.txt",
        "idSrc": "DT_RowId",
        "columns": [
            {"data": "checkeado"},
            {"data": "codigo"},
            {"data": "descripcion"},
            {"data": "costo"},
            {"data": "porcen"}
        ],
        "order": [[0, "asc"]],
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
                "sLast": "Ãšltimo",
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
});