$(document).ready(function () {

    $('#imprime').click(function () {
        var url = 'impresion.php';
        $('#pdf_form').html('<form action="' + url + '" name="pdf" method="post" style="display:none;" target="_blank">\n\
            <input type="text" name="prov" value="' + $('#proveedor').val() + '" /></form>');
        document.forms['pdf'].submit();
    });

    $('#proveedor').change(function () {
        if ($('#proveedor').val() != 0) {
            $('#imprime').attr("disabled", false);
        } else {
            $('#imprime').attr("disabled", true);
        }
        
        $.post("buscar_1_1.php", {
            prov: $('#proveedor').val()
        }, function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.Fin == 'Fin') {
                $('#listado1').DataTable().ajax.reload();
            }
        });
    });

    $('#proveedor').focus();

    $('#listado1').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false,
        "searching": true,
        "ajax": "data/busqueda.json",
        "columns": [
            {"data": "codigo"},
            {"data": "descripcion"},
            {"data": "stock"},
            {"data": "costo"},
            {"data": "ganancia"},
//            {"data": "sugerido"},
            {"data": "venta"}
        ],
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
            }
        }
    });
    
    $('#listado2').DataTable({
        "paging": true,
        "searching": false,
        "ajax": "data/busqueda.json",
        "columns": [
            {"data": "codigo"},
            {"data": "descripcion"}
        ],
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
            }
        }
    });

});