$(document).ready(function () {
    alertify.set({labels: {
            ok: "Aceptar",
            cancel: "Cancelar"
        }});
    $('#productoList').autocomplete({
        source: function (request, response) {
            var tipo = 1;
            $.ajax({
                url: './autocompleteProductos.php',
                dataType: "json",
                type: "GET",
                data: {
                    nom: request.term,
                    tipob: tipo
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
            var id = $('#productoListId').val();
            var tipoProceso = 'busp';
            $.ajax({
                type: 'POST',
                url: './procesosPresupuesto.php',
                dataType: 'json',
                async: false,
                data: {
                    tipo: tipoProceso,
                    idp: id
                },
                success: function (resp) {
                    var tot = resp[0] * $('#cantidadProducto').val();
                    $('#precio').val(resp[0]);
                    $('#precioTotal').val(Math.round(tot));
                }

            });
        },
        autoFocus: true,
        minLength: 0,
        sortResults: false
    });

    $('#codProd').autocomplete({
        source: function (request, response) {
            var tipo = 2;
            $.ajax({
                url: './autocompleteProductos.php',
                dataType: "json",
                type: "GET",
                data: {
                    nom: request.term,
                    tipob: tipo
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

    $("#cantidadProducto").change(function () {
        $('#precioTotal').val(Math.round(this.value * $('#precio').val()));
    });
    $("#cantidadProducto").keyup(function () {
        $('#precioTotal').val(Math.round(this.value * $('#precio').val()));
    });
    $("#precio").keyup(function () {
        $('#precioTotal').val(Math.round(this.value * $('#cantidadProducto').val()));
    });

})
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

function crearProdPresu() {
    var cont = $('#contador').val();
    var cantidad = $('#cantidadProducto').val();
    var producto = $('#productoListId').val();
    var nproducto = $('#productoList').val();
    var cod = $('#codProd').val();
    var precio = $('#precio').val();
    var preciototal = $('#precioTotal').val();
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
        incorrecto('#cantidadProducto', '');
        return false;
    } else {
        normal('#cantidadProducto');
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
    $('#productosRemito').append("<tr class='newProd" + cont + "'><td style='display: none';>" + producto + "</td><td>" + nproducto + "</td><td class='text-center'>" + cod + "</td><td class='text-right'>" + cantidad + "</td><td class='text-right'>" + precio + "</td><td class='text-right'>" + preciototal + "</td><td style='width:150px;'><button type='button' class='btn btn-warning btn-xs' onclick='editarProdPresu(" + producto + "," + cont + ")'><i class='fa fa-edit'></i></button>&nbsp&nbsp<button class='btn btn-danger btn-xs' onclick='removerP(" + cont + ")'><i class='fa fa-ban'></i></button></td></tr>");
    $('#contador').val(cont);
    $('#cantidadProductoList').val('');
    $('#productoListId').val('');
    $('#productoList').val('');
    $('#codProd').val('');
    $('#precio').val('');
    $('#cantidadProducto').val('1');
    $('#precioTotal').val('');
    alertify.success("Se ha cargado un producto.");
    console.log(matriculas);
}


function crearProdPresuEdit() {
    var cont = $('#contador').val();
    var cantidad = $('#cantidadProducto').val();
    var producto = $('#productoListId').val();
    var nproducto = $('#productoList').val();
    var cod = $('#codProd').val();
    var precio = $('#precio').val();
    var preciototal = $('#precioTotal').val();
    if (producto.length == 0) {
     /*   $('#textomodal').html('debe ingresar un producto');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar un producto.");
        incorrecto('#productoList', '');
        return false;
    } else {
        normal('#productoList');
    }
    if (cantidad.length == 0) {
       /* $('#textomodal').html('debe ingresar cantidad');
        $('#modalErroProd').modal('show');*/
        alertify.error("debe ingresar cantidad.");
        incorrecto('#cantidadProducto', '');
        return false;
    } else {
        normal('#cantidadProducto');
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
            alertify.alert("Este producto ya fue cargado.");
        
            return false;
        }
    }
    ////////////////////////////////////////////////////////
    // creamos el panel con los datos de los productos
    ////////////////////////////////////////////////////////
    cont++;

    // $('#cargaProd').append("<div class='newProd'><div class='col-sm-11'><div class='form-group has-success'><input type='text' class='form-control' id='producto"+(cont)+"' value='"+nproducto+' '+producto+'cantidad: '+cantidad+"' disabled=''></div></div><button class='btn btn-danger'><i class='fa fa-times-circle'></i></button><input type='hidden' id='idProducto"+(cont)+"' value='"+producto+"'><input type='hidden' id='cantProducto"+(cont)+"' value='"+cantidad+"'></div>");
    $('#productosRemito').append("<tr class='newProd" + cont + "'><td style='display: none';>" + producto + "</td><td>" + nproducto + "</td><td class='text-center'>" + cod + "</td><td class='text-right'>" + cantidad + "</td><td class='text-right'>" + precio + "</td><td class='text-right'>" + preciototal + "</td><td style='width:150px;'><button type='button' class='btn btn-warning btn-xs' onclick='editarProdPresu(" + cont + ")'><i class='fa fa-edit'></i></button>&nbsp&nbsp<button class='btn btn-danger btn-xs' onclick='removerP(" + cont + ")'><i class='fa fa-ban'></i></button></td></tr>");
    $('#numEditP').val('');
    $('#contador').val(cont);
    $('#cantidadProductoList').val('');
    $('#productoListId').val('');
    $('#productoList').val('');
    $('#codProd').val('');
    $('#precio').val('');
    $('#cantidadProducto').val('1');
    $('#precioTotal').val('');
    $('#btnEditarP').hide();
    $('#btnAgregarP').show();
    alertify.success("Se ha modificado un producto.");
}

function removerProd() {
    var cont = $('#contador').val();
    if (cont > 0) {
        cont--;
        $(".newProd:last-child").remove();
        $('#contador').val(cont);
    }

}
// remover los items de los presupuestos
function removerP(num) {
    $(".newProd" + num).remove();
    alertify.error("Se ha removido un producto.");
}

function registrarPresupuesto() {
    var tiposolicitud = 'nuevopresupuesto';
    var usuario = $('#idusuario').val();
    var solicitante = $('#solicitante').val();
    var contacto = $('#contacto').val();
    var cant = $('#tablaproductos tr').length;
    //
    if (solicitante.length < 2) {
        alertify.error("Ingrese Solicitante");
        incorrecto('#solicitante', 'ingrese');
        return false;
    } else {
        normal('#solicitante');
    }

    detalle = new Array();
    for (i = 1; i < $('#tablaproductos tr').length; i++) {
        detalle[i] = new Array();

        for (j = 0; j < 6; j++) {
            // matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            detalle[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }
    if (cant == 1) {
        /*$('#titerror').html("<h4 class='modal-title text-center success' style='color: red;''><i class='fa fa-exclamation-triangle'></i> Error</h4>");
        $('#textomodalerror').html("<h5>El presupuesto que se pretende guardar se encuentra vacío.</h5>");*/
        alertify.alert("El presupuesto que se pretende guardar se encuentra vacío.");
      /*  $('#modalerror').modal('show');*/
        return false;
    }
    // datos del presupuesto
    $.ajax({
        url: './procesosPresupuesto.php',
        dataType: "json",
        type: "POST",
        data: {
            'array': JSON.stringify(detalle),
            tipo: tiposolicitud,
            solicitante: solicitante,
            contacto: contacto,
            usu: usuario,
            cantidad: cant
        },
        success: function (resp) {
            alertify.alert("<font color='green'><strong>El presupuesto se guardó exitosamente. Para visualizarlo debe ingresar en el módulo de búsqueda.</strong></font>",function(e){
                if(e){
                 location.href = 'index.php';
                }
            })
           /* $('#modalpok').modal('show');*/

        }
    });
}

function detallePresupuesto(idp) {
    $('#cuerpoDetalleP').empty();
    var idpresu = idp;
    var tipoProceso = 'buscarDetalle';
    var n;
    var totals = 0;

    $.ajax({
        type: 'POST',
        url: './procesosPresupuesto.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idpresu
        },
        success: function (resp) {
            if (resp['vig'] == 'si') {
                $('#btnaegreso').attr("disabled", false);
                $('#btnaegreso').html("<i class='fa fa-arrow-circle-o-up'></i> Egreso");
            } else {
                $('#btnaegreso').attr("disabled", true);
                $('#btnaegreso').html("Presupuesto aceptado");
            }
            if (resp['id'] != "undefined")
            {
                n = resp['id'];
            } else {
                n = '-'
            }
            $('#modal-titleDetalleP').html('Presupuesto N°: ' + n);
            $('#fechaDetalleP').html('Fecha: ' + resp['fecha']);
            $('#usuarioDetalleP').html('cargado por: <strong>' + resp['usuarioname'] + '</strong>');
            $('#solicitanteDetalleP').html('Solicitante: <strong>' + resp['solicitante'] + '</strong>');
            $('#contactoDetalleP').html('Contacto: <strong>' + resp['contacto'] + '</strong>');

            for (var i = 0; i <= resp['rows']; i++) {
                var total = resp['precio'][i] * resp['cantidad'][i];
                totals = totals + total;
                $('#cuerpoDetalleP').append("<tr class='newDetail'><td style='display: none;'>" + resp['idd'][i] + "</td><td class='text-left'>" + resp['productoname'][i] + "</td><td>" + resp['productocod'][i] + "</td><td>$ " + resp['precio'][i] + "</td><td>" + resp['cantidad'][i] + "</td><td>$ " + total + "</td><td style='display: none';>" + resp['producto'][i] + "</td></tr>");
            }
            $('#cuerpoDetalleP').append("<tr><td></td><td></td><td></td><td class='text-right'><strong>TOTAL: </strong></td><td><strong>$" + totals + "</strong></td></tr>");
        }

    });
    $('#idpr').val(idp);
    $('#detallePresupuestoModal').modal('show');

}

function detallePresupuestoPdf(idp) {
    var url = 'presupuestosPDF.php';
    var fecha = '12/12/2017';
    var id = idp;
    $('#pdf_formp').html('<form action="presupuestosPDF.php" name="pdf" method="post" style="display:none;" target="_blank"><input type="text" name="f" value="' + fecha + '" /><input type="text" name="id" value="' + id + '" /></form>');
    document.forms['pdf'].submit();
}

function eliminarPre(idp) {
    $('#idpresu').val(idp);
 /*   $('#titeliminar').html("<h4 class='modal-title text-center success' style='color: red;''><i class='fa fa-exclamation-triangle'></i> Eliminar Presupuesto</h4>");
    $('#textomodaleliminar').html('<h5>Realmente desea eliminar el presupuesto?.</h5>');
    $('#modaleliminar').modal('show');*/
    alertify.confirm("Realmente desea eliminar el presupuesto?.",function(e){
       if(e){
        eliminarPresupuesto();
       } 
    });
}

function eliminarPresupuesto() {
    var idpresu = $('#idpresu').val();
    var tipoProceso = 'eliminar';
    $.ajax({
        type: 'POST',
        url: './procesosPresupuesto.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idpresu
        },
        success: function (resp) {
            location.href = 'presupuestos.php';
        }

    });
}

function pasoaEgresomodal() {
   /* $('#titmodalaceptarpresu').html("<h4 class='modal-title text-center success' style='color: green;''><i class='fa fa-exclamation-triangle'></i> Aceptar Presupuesto</h4>");
    $('#bodymodalaceptarpresu').html('<h5>Realmente desea aceptar el presupuesto?.</h5>');
    $('#modalaceptarpresu').modal('show');*/
    alertify.confirm("Realmente desea aceptar el presupuesto?",function(e){
        if(e){
            pasoaEgreso();
        }
    });
}

function pasoaEgreso() {
    var tiposolicitud = 'pasaraegreso';
    var usuario = $('#usua').val();
    var idpresu = $('#idpr').val();
    var cant = $('#cuerpoDetalleP tr').length;
    cant = cant - 1;
    egreso = new Array();
    for (i = 0; i < cant; i++) {
        egreso[i] = new Array();
        for (j = 0; j < 7; j++) {
            // matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            egreso[i][j] = $('#cuerpoDetalleP').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }
    /*console.log(egreso);*/
    // mandamos por ajax
    $.ajax({
        url: './procesosPresupuesto.php',
        dataType: "json",
        type: "POST",
        data: {
            'array': JSON.stringify(egreso),
            tipo: tiposolicitud,
            usuario: usuario,
            idpresupuesto: idpresu,
            cantidad: cant
        },
        success: function (resp) {
            location.href = 'presupuestos.php';
        }
    });

}

function editarProdPresu(num, pos) {
    var cantidad = $('#tablaproductos tr').length;
    //cargo la matriz con los productos cargados hasta este momento
    productoss = new Array();
    for (i = 1; i < cantidad; i++) {
        productoss[i] = new Array();
        for (j = 0; j < 6; j++) {
            // matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            productoss[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        //
    }
    /////////////////////////////////
    var arreglo = new Array();
    for (i = 1; i < cantidad; i++) {
        productoss[i] = new Array();
        for (j = 0; j < 6; j++) {
            // matriculas[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html()+'/***/';
            productoss[i][j] = $('#tablaproductos').find('tr:eq(' + i + ') td:eq(' + j + ')').html();
        }
        if (productoss[i][0] == num) {
            $('#codProd').val(productoss[i][2]);
            $('#productoList').val(productoss[i][1]);
            $('#productoListId').val(productoss[i][0]);
            $('#precio').val(productoss[i][4]);
            $('#cantidadProducto').val(productoss[i][3]);
            $('#precioTotal').val(productoss[i][5]);

            /*  $('#btnAgregarP').hide();
             $('#btnEditarP').show();*/
            removerP(pos);
            return false;
        }
        //
    }

    console.log(arreglo);
    // poncho los datos





}
