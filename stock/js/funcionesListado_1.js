$(document).ready(function () {
    $('#imprime').click(function () {
        var url = 'impresion_1_2.php';
        $('#pdf_form').html('<form action="' + url + '" name="pdf" method="post" style="display:none;" target="_blank">\n\
            <input type="text" name="categoria" value="' + $('#categoria').val() + '" /></form>');
        document.forms['pdf'].submit();
    });

    $('#categoria').change(function () {
        if ($('#proveedor').val() != 0) {
            $('#imprime').attr("disabled", false);
        } else {
            $('#imprime').attr("disabled", true);
        }
        
        $.post("buscar_1_2.php", {
            categoria: $('#categoria').val()
        }, function (data) {
            $('#listado2').html(data);
        });
    });

    $('#proveedor').focus();
});