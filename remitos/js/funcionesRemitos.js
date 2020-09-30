$(document).ready(function () {

    $('#proveedorRemito').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: './autocompleteProv.php',
                dataType: "json",
                type: "GET",
                data: {
                    nom: request.term
                },
                success: function (data) {
                    response($.map(data, function (item, key) {
                        return {
                            label: item, value: item, id: key
                        };
                    }));
                }
            });
        },
        select: function (event, ui) {
            console.log(ui.item);
            $('#proveedorId').val(ui.item.id);
            $("#proveedorRemito").keyup();
        },
        autoFocus: true,
        minLength: 0,
        sortResults: false
    });


    $('#productoList').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: './autocompleteProd.php',
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
            console.log(ui.item.value[1]);
            $('#productoListId').val(ui.item.id);
            $("#productoList").keyup();
            $("#codProd").val(ui.item.cod);
        },
        autoFocus: true,
        minLength: 0,
        sortResults: false
    });

    $('#productoList2').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: './autocompleteProd.php',
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
            console.log(ui.item.value[1]);
            $('#productoListId2').val(ui.item.id);
            $("#productoList2").keyup();
            $("#cod2").val(ui.item.cod);
        },
        autoFocus: true,
        minLength: 0,
        sortResults: false
    });


    $('#numeroRemito').keyup(function () {
        numeros(this, 'no');
    });
    $('#cantidadProductoList').keyup(function () {
        numeros(this, 'no');
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

function crearProd() {
    var cont = $('#contador').val();
    var cantidad = $('#cantidadProductoList').val();
    var producto = $('#productoListId').val();
    var nproducto = $('#productoList').val();
    var cod = $('#codProd').val();
    if (producto.length == 0) {
        /*$('#textomodal').html('debe ingresar un producto');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar un producto");
        incorrecto('#productoList', '');
        return false;
    } else {
        normal('#productoList');
    }
    if (cantidad.length == 0) {
        /*$('#textomodal').html('debe ingresar cantidad');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar cantidad");
        incorrecto('#cantidadProductoList', '');
        return false;
    } else {
        normal('#cantidadProductoList');
    }
    /////////////////////////////////////////////////////////
    // verificamos que el producto no fue cargado antes
    ////////////////////////////////////////////////////////
    matriculas = new Array();
    for (i = 1; i < $('#tablaproductos tr').length; i++) {
        matriculas[i] = new Array();
        for (j = 0; j < 3; j++) {
            // matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }

    for (i = 1; i < $('#tablaproductos tr').length; i++) {
        if (matriculas[i][0] == producto) {
            /*$('#textomodal').html('Este producto ya fue cargado');
            $('#modalErroProd').modal('show');*/
            alertify.alert("Este producto ya fue cargado");
            return false;
        }
    }
    ////////////////////////////////////////////////////////
    // creamos el panel con los datos de los productos
    ////////////////////////////////////////////////////////
    cont++;
    // $('#cargaProd').append("<div class='newProd'><div class='col-sm-11'><div class='form-group has-success'><input type='text' class='form-control' id='producto"+(cont)+"' value='"+nproducto+' '+producto+'cantidad: '+cantidad+"' disabled=''></div></div><button class='btn btn-danger'><i class='fa fa-times-circle'></i></button><input type='hidden' id='idProducto"+(cont)+"' value='"+producto+"'><input type='hidden' id='cantProducto"+(cont)+"' value='"+cantidad+"'></div>");
    $('#productosRemito').append("<tr class='newProd" + cont + "'><td style='display: none';>" + producto + "</td><td>" + nproducto + "</td><td>" + cod + "</td><td>" + cantidad + "</td><td><button class='btn btn-danger btn-xs' onclick='removerP(" + cont + ")'><i class='fa fa-ban'></i></button></td></tr>");
    $('#contador').val(cont);
    $('#cantidadProductoList').val('');
    $('#productoListId').val('');
    $('#productoList').val('');
    $('#codProd').val('');
    alertify.success("Se ha cargado un producto.");
}




function crearProd2() {
    var cont = $('#contador2').val();
    var cantidad = $('#cantidadProductoList2').val();
    var producto = $('#productoListId2').val();
    var nproducto = $('#productoList2').val();
    var cod = $('#cod2').val();
    if (producto == 0) {
        /*$('#textomodal2').html('debe ingresar un producto');
        $('#modalErroProd2').modal('show');*/
        alertify.error("debe ingresar un producto");
        incorrecto('#productoList2', '');
        return false;
    } else {
        normal('#productoList2');
    }
    if (cantidad.length == 0) {
       /* $('#textomodal2').html('debe ingresar cantidad');
        $('#modalErroProd2').modal('show');*/
        alertify.error("debe ingresar cantidad");
        incorrecto('#cantidadProductoList2', '');
        return false;
    } else {
        normal('#cantidadProductoList2');
    }
    /////////////////////////////////////////////////////////
    // verificamos que el producto no fue cargado antes
    ////////////////////////////////////////////////////////
    matriculas = new Array();
    for (i = 1; i < $('#tablaproductos2 tr').length; i++) {
        matriculas[i] = new Array();
        for (j = 0; j < 4; j++) {
            // matriculas[i][j] = $('#tablaproductos2').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            matriculas[i][j] = $('#tablaproductos2').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }

    matriculas2 = new Array();
    for (i = 1; i < $('#tablaproductos21 tr').length; i++) {
        matriculas2[i] = new Array();
        for (j = 0; j < 4; j++) {
            // matriculas[i][j] = $('#tablaproductos2').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            matriculas2[i][j] = $('#tablaproductos21').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }

    for (i = 1; i < $('#tablaproductos2 tr').length; i++) {
        if (matriculas[i][0] == producto) {
            /*alert('ya se cargo este producto');*/
            alertify.alert("ya se cargo este producto");
            return false;
        }
    }

    for (i = 1; i < $('#tablaproductos21 tr').length; i++) {
        if (matriculas2[i][0] == producto) {
           /* $('#textomodal2').html('El producto ya fue cargado');
            $('#modalErroProd2').modal('show');*/
            alertify.alert("El producto ya fue cargado");
            incorrecto('#productoList2');
            return false;
        }
    }
    ////////////////////////////////////////////////////////
    // creamos el panel con los datos de los productos
    ////////////////////////////////////////////////////////
    cont++;
    // $('#cargaProd').append("<div class='newProd'><div class='col-sm-11'><div class='form-group has-success'><input type='text' class='form-control' id='producto"+(cont)+"' value='"+nproducto+' '+producto+'cantidad: '+cantidad+"' disabled=''></div></div><button class='btn btn-danger'><i class='fa fa-times-circle'></i></button><input type='hidden' id='idProducto"+(cont)+"' value='"+producto+"'><input type='hidden' id='cantProducto"+(cont)+"' value='"+cantidad+"'></div>");
    $('#productosRemito2').append("<tr class='newProd" + cont + "'><td style='display:none;'>" + producto + "</td><td>" + nproducto + "</td><td>" + cod + "</td><td>" + cantidad + "</td><td><button class='btn btn-danger btn-xs' onclick='removerP(" + cont + ")'><i class='fa fa-ban'></i></button></td></tr>");
    $('#contador2').val(cont);
    $('#cantidadProductoList2').val('');
    $('#productoListId2').val('');
    $('#productoList2').val('');
}

function removerProd() {
    var cont = $('#contador').val();
    if (cont > 0) {
        cont--;
        $(".newProd:last-child").remove();
        $('#contador').val(cont);
    }

}

function removerP(num) {
    $(".newProd" + num).remove();
    alertify.error("Se ha removido un producto.");
}


// FUNCION PARA ELIMINAR LOS CAMPOS DINAMICOS    
// $('#rest').click(function() { 
//     $(".pepe:last-child").remove();
//     if(count > 1){
//         --count;
//         $('#cont').val(count);
//         $('#contS').val(count);
//     }
// });

function registrarRemito() {
    var idProv = $('#proveedorId').val();
    var fRemito = $('#fechaRemito').val();
    var numRemito = $('#numeroRemito').val();
    var usuario = 1;
    var tipoProceso = 'guardarRemito';
    var cant = $('#tablaproductos tr').length;
    if (idProv == 0) {
        /*$('#textomodal').html('debe ingresar un proveedor');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar un proveedor");
        incorrecto('#proveedorRemito');
        return false;
    } else {
        normal('#proveedorRemito');
    }
    if (numRemito < 1) {
       /* $('#textomodal').html('debe ingresar un número de remito');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar un número de remito");
        incorrecto('#numeroRemito');
        return false;
    } else {
        normal('#numeroRemito');
    }
    if (fRemito < 10) {
        /*$('#textomodal').html('debe ingresar una fecha correcta');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar una fecha correcta");
        incorrecto('#fechaRemito');
        return false;
    } else {
        normal('#fechaRemito');
    }
    ///////////////////////////////////////////////////////
    // sacamos los datos de la tabla creada con jquery
    matriculas = new Array();
    for (i = 1; i < $('#tablaproductos tr').length; i++) {
        matriculas[i] = new Array();

        for (j = 0; j < 4; j++) {
            // matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }
    ///////////////////////////////////////////////

    //////////validamos que se sumen productos////////////////////////
    if(matriculas[1] == null){
       /* $('#textomodal').html('debe ingresar al menos un producto para generar un remito');
        $('#modalErroProd').modal('show');*/
        alertify.alert("debe ingresar al menos un producto para generar un remito");
        return false;
    }
    ///////////////////////////////////////////////
    $.ajax({
        type: 'POST',
        url: './procesosRemitos.php',
        dataType: 'json',
        async: false,
        data: {
            'array': JSON.stringify(matriculas),
            tipo: tipoProceso,
            idp: idProv,
            fecha: fRemito,
            numero: numRemito,
            usuario: usuario,
            cantidad: cant
        },
        success: function (resp) {
            alertify.alert("<font color='green'><strong>Se gurdó con éxito. Para visualizar el remito debe ingresar en el módulo de búsqueda.</strong></font>",function(e){
                if (e){
                    window.location.href = 'index.php';
                }
            });
            /*$('#modalok').modal('show');*/

        }

    });

    //   $.ajax({
    //     type: 'POST',
    //     url: './procesosRemitos.php',
    //     dataType: 'json',
    //     async: false,
    //     data: {
    //       'array':JSON.stringify(matriculas),
    //        tipo : tipoProceso 
    //     },
    //     success: function (resp) {
    //        alert(resp);
    //     }

    // });
}


function registrarRemito2(idr) {
    var tipoProceso = 'guardarRemito2';
    var cant = $('#tablaproductos2 tr').length;
    var idR = idr;
    // var tabla = $("#tablaproductos2").val();
    // alert(idProv+' '+numRemito+' '+fRemito);
    ///////////////////////////////////////////////////////
    // sacamos los datos de la tabla creada con jquery
    productos = new Array();
    for (i = 1; i < $('#tablaproductos2 tr').length; i++) {
        productos[i] = new Array();

        for (j = 0; j < 4; j++) {
            // productos[i][j] = $('#tablaproductos2').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            productos[i][j] = $('#tablaproductos2').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }
    //////////validamos que se sumen productos////////////////////////
    if(productos[1] == null){
        /*$('#textomodal2').html('debe ingresar un producto. De lo contrario Cancele la modificación');
        $('#modalErroProd2').modal('show');*/
        alertify.alert("debe ingresar un producto. De lo contrario Cancele la modificación");
        return false;
    }
    ///////////////////////////////////////////////

    $.ajax({
        type: 'POST',
        url: './procesosRemitos.php',
        dataType: 'json',
        async: false,
        data: {
            'array': JSON.stringify(productos),
            tipo: tipoProceso,
            idr: idR,
            cantidad: cant
        },
        success: function (resp) {
            /*
            $('#modalokm').modal('show');*/
             alertify.alert("<font color='green'><strong>Se modificó con éxito.</strong></font>",function(e){
                if (e){
                    window.location.href='buscarRemitos.php';
                }
            });
        }

    });
}


function detalleRemito(id) {
    $('#cuerpoDetalle').empty();
    var idr = id;
    var tipoProceso = 'buscarDetalle';

    $.ajax({
        type: 'POST',
        url: './procesosRemitos.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idr
        },
        success: function (resp) {
            $('#modal-titleDetalle').html('Remito N°:' + resp[7]);
            $('#fechaDetalle').html('Fecha: ' + resp[8]);
            $('#usuDetalle').html('cargado por: <strong>' + resp[9] + '</strong>');
            for (var i = 0; i < resp[0]; i++) {
                $('#cuerpoDetalle').append("<tr class='newDetail'><td style='display: none;'>" + resp[2][i] + "</td><td class='text-left'>" + resp[5][i] + "</td><td>" + resp[6][i] + "</td><td>" + resp[3][i] + "</td></tr>");

            }
        }

    });
    $('#idx').val(idr);
    $('#detalleRemitoModal').modal('show');
}

function detalleRemitoPdf(idr) {
    var url = 'remitoPDF.php';
    var fecha = '12/12/2017';
    var id = idr;
    $('#pdf_form').html('<form action="remitoPDF.php" name="pdf" method="post" style="display:none;" target="_blank"><input type="text" name="f" value="' + fecha + '" /><input type="text" name="id" value="' + id + '" /></form>');
    document.forms['pdf'].submit();
}


function detallaRemitoEdit() {
    var id = $('#idx').val();
    $('#detalleRemitoModal').modal('hide');
    $('#inset_form').html('<form action="editarRemito.php" name="vote" method="post" style="display:none;"><input type="text" name="idRem" value="' + id + '" /></form>');
    document.forms['vote'].submit();
    // $(location).attr('href', 'editarRemito.php');
}