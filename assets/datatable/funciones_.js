$(document).ready(function () {
    $('tfoot').css('display', 'none');

    $('#datatablas').DataTable({
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

        }, "aaSorting": []

    });

});
