
$(document).ready(function () {
  //    $(".botonedit").click(function () {
//        var id = $(this).parents("tr").find("td")[0].innerHTML;
//        var nom = $(this).parents("tr").find("td")[1].innerHTML;
//        var desc = $(this).parents("tr").find("td")[2].innerHTML;
//        $('#nombreCategoriaEdit').val(nom);
//        $('#descCategoriaEdit').val(desc);
//        $('#idcategoria').val(id);
//        $('#modalEditarCat').modal('sho id='btnEI'w');
//    });

   // $(".btnEI").click(function () {

   //     alert();

   // });

    $(".botoneliminar").click(function () {
        var id = $(this).parents("tr").find("td")[0].innerHTML;
        alertify.confirm("Esta seguro de Eliminar este proveedor?", function (e) {
            if (e) {
                deshabilitarCategoria(id);
            }
        });
    }); 
    

    // $(".boton_eliminar_imagen").click(function () {

    //     alert('dd');
    //     // var id = $(this).parents("tr").find("td")[0].innerHTML;
    //     // alertify.confirm("Esta seguro de Eliminar este proveedor?", function (e) {
    //     //     if (e) {
    //     //         eliminarImagen(id);
    //     //     }
    //     // });
    // });


});

function botonedit(id, nom, desc) {
    
    $('#nombreCategoriaEdit').val(nom);
    $('#descCategoriaEdit').val(desc);
    $('#idcategoria').val(id);

    $('#div_img').empty();

    $.ajax({
        type: 'POST',
        url: './procesosCategorias.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: 'buscar_imagenes',
            idcat: id
        },
        success: function (resp) {

           var imgs = resp;

           $.each( imgs, function( key, value ) {

                var nom = "../archivos/categorias/"+value.img; 

                $('#div_img').append("<img id='imagen' src='"+nom+"' style='width: 30%;margin-bottom: 10px;margin-top: 10px;margin-left: 10px;margin-right: 10px;'/></div>");
                $('#div_img').append("<button type='button' class='btn btn-danger' onClick='eliminarImagen("+value.id+")'> <i class='fa fa-times'></i> </button>");
                 
            });

        }

    });

    // $("#imagen").attr("src","../archivos/categorias/20190812225559_17.jpg");
    $('#modalEditarCat').modal('show');
};

function botonimagen(id, nom) {
    $('#nombreCategoriaImg').val(nom);
    $('#idcategoriai').val(id);
    $('#cargarImagen').modal('show');
}
;
function guardarCategoria() {
    var orden = $('#ordenCategoria').val();
    var categoria = $('#nombreCategoria').val();
    var desc = $('#descCategoria').val();
    var tipoProceso = 'cargarCategoria';
    var tipoProceso2 = 'verificarCat';
    var verif = 0;

    if (categoria.length < 4) {
        incorrecto('#nombreCategoria');
        alertify.error("debe ingresar un nombre");
        return false;
    } else {
        normal('#nombreCategoria');
    }

    if (desc.length < 4) {
        incorrecto('#descCategoria');
        alertify.error("debe ingresar una descripcion");
        return false;
    } else {
        normal('#descCategoria');
    }
    /////////// verificamos si existe la categoria ///////
    $.ajax({
        type: 'POST',
        url: './procesosCategorias.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso2,
            nombrec: categoria
        },
        success: function (resp) {
            if (resp > 0) {
                verif = 1;
            }
        }

    });
    if (verif > 0) {
        incorrecto('#nombreCategoria');
        alertify.error('La categoria ya existe');
        return false;
    }

    ///////////guardamos categoria///////////////////////
//     var imagen = document.getElementById("archivo1").files[0];
//    alert(imagen);
//    var form_data = new FormData();
//    form_data.append("archivo1", document.getElementById('archivo1').files[0]);
//    form_data.append('tipo', tipoProceso);
//    form_data.append('nombrec', categoria);
//    form_data.append('descc', desc);
//alert(form_data);
    $.ajax({
        type: 'POST',
        url: './procesosCategorias.php',
        dataType: 'json',
        async: false,
        data: {
            archivo1: document.getElementById('archivo1').files[0],
            tipo: tipoProceso,
            nombrec: categoria,
            descc: desc,
            orden: orden
        },
        success: function (resp) {

            alertify.alert("<font color='green'><strong>Se gurdó la Categoria con éxito.</strong></font>", function (e) {
                if (e) {
                    window.location.href = 'index.php';
                }
            });
        }

    });
}

function editarCategoria(id) {
    var nombre = 'aaaaa';
    var desc = 'aaaa' + id;
    var orden = 9999;
    $('#nombreCategoriaEdit').val(nombre);
    $('#descCategoriaEdit').val(desc);
    $('#ordenCategoriaEdit').val(orden);
    $('#modalEditarCat').modal('show');
}

function modificarCat() {
    var idc = $('#idcategoria').val();
    var nom = $('#nombreCategoriaEdit').val();
    var des = $('#descCategoriaEdit').val();
    var ord = $('#ordenCategoriaEdit').val();
    var tipoProceso = 'modificarCat';
    var tipoProceso2 = 'verificarCat';
    if (nom.length < 4) {
        incorrecto('#nombreCategoriaEdit');
        alertify.error("debe ingresar un nombre");
        return false;
    } else {
        normal('#nombreCategoriaEdit');
    }

    if (des.length < 4) {
        incorrecto('#descCategoriaEdit');
        alertify.error("debe ingresar una descripcion");
        return false;
    } else {
        normal('#descCategoriaEdit');
    }
    $.ajax({
        type: 'POST',
        url: './procesosCategorias.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            id: idc,
            nombrec: nom,
            orden: ord,
            descc: des
        },
        success: function (resp) {
            alertify.alert("<font color='green'><strong>Se modificó la Categoria con éxito.</strong></font>", function (e) {
                if (e) {
                    window.location.href = 'index.php';
                }
            });
        }

    });

}

function eliminarImagen(id) {

    var idi = id;
    var tipoProceso = 'eliminarImg';

    alertify.confirm("Esta seguro de eliminar esta imagen?", function (e) {
            if (e) {
                
               $.ajax({
                type: 'POST',
                url: './procesosCategorias.php',
                dataType: 'json',
                async: false,
                data: {
                    tipo: tipoProceso,
                    id_img : idi
                },
                success: function (resp) {

                    alertify.alert("<font color='green'><strong>Se eliminó la Imagen con éxito.</strong></font>", function (e) {
                        if (e) {
                            window.location.href = 'index.php';
                        }
                    });
                }

            });
            }
        });



}


function deshabilitarCategoria(id) {
    var idc = id;
    var tipoProceso = 'eliminarCat';

    $.ajax({
        type: 'POST',
        url: './procesosCategorias.php',
        dataType: 'json',
        async: false,
        data: {
            tipo: tipoProceso,
            idcc: idc
        },
        success: function (resp) {

            alertify.alert("<font color='green'><strong>Se eliminó la Categoria con éxito.</strong></font>", function (e) {
                if (e) {
                    window.location.href = 'index.php';
                }
            });
        }

    });
}