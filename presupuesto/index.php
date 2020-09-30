<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Presupuestos</title>
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Nuevo Presupuesto</div>
                    <div class="panel-body">
                        <input type="hidden" name="idusuario" id="idusuario" value='<?php echo $_SESSION['id'] ?>'>
                        <form name="frm_remito" id="frm_remito">    
                            <div class="row">
                                <!-- autocompletar los proveedores - utilizamos jquery-ui.min.css y jquery.dataTables.min.css -->
                                <div class="col-sm-6">
                                    <div class="autocomplete">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">Solicitante</div>
                                                <input type="text" class="form-control txt-auto" id="solicitante" name="solicitante">
                                            </div>
                                        </div>  
                                    </div> 
                                </div>   
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Contacto</div>
                                            <input type="text" class="form-control txt-auto" id="contacto" name="contacto">
                                        </div>
                                    </div>  
                                </div>    
                            </div>

                            <div class="row">
                                <div class="col-sm-4" style="">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Código</div>
                                            <input type="text" class="form-control txt-auto" id="codProd" id="codProd">
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Productos</div>
                                            <input type="text" class="form-control txt-auto" id="productoList" name="productoList">
                                            <input type="hidden" class="form-control" id="productoListId" name="productoListId" value=""> 
                                        </div>
                                    </div>  
                                </div> 

                                <div class="">


                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-sm-3" style="">
                                    <div class="input-group">
                                        <div class="input-group-addon">Precio $</div>
                                        <input type="text" class="form-control" id="precio">
                                    </div>
                                </div>
                                <div class="col-sm-3" style="">
                                    <div class="input-group">
                                        <div class="input-group-addon">Cantidad</div>
                                        <input type="text" class="form-control" id="cantidadProducto" value="1">
                                    </div>
                                </div>
                                <div class="col-sm-3" style="">
                                    <div class="input-group">
                                        <div class="input-group-addon">Total $</div>
                                        <input type="text" class="form-control" id="precioTotal" disabled="">
                                    </div>
                                </div>  
                                <div class="col-sm-3" style="">
                                    <button type="button" id="btnAgregarP" class="btn btn-success" onclick="crearProdPresu()"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    <button type="button" id="btnEditarP" class="btn btn-primary" onclick="crearProdPresuEdit()" style="display: none;"><i class="fa fa-edit" aria-hidden="true" ></i></button>
                                    <input type="hidden" name="contador" id="contador" value="0">
                                </div>    
                            </div>
                            <br>    
                            <div class="row" id="cargaProd">
                                <table class="table table-hover table-condensed table-bordered" id="tablaproductos">
                                    <thead class="text-center" style="background-color: darkgray;">
                                        <tr>
                                            <th class="text-center col-sm-1" style="display: none;">#</th>
                                            <th class="text-center col-sm-6">PRODUCTO</th>
                                            <th class="text-center col-sm-2">COD.</th>
                                            <th class="text-center col-sm-1">CANTIDAD</th>
                                            <th class="text-center col-sm-1">PRECIO</th>
                                            <th class="text-center col-sm-1">TOTAL</th>
                                            <th class="text-center col-sm-1"></th>
                                        </tr>
                                    </thead>
                                    <input type="hidden" name="numEditP" id="numEditP" value="">
                                    <tbody id="productosRemito">

                                    </tbody>
                                </table>
                                <!-- aca van todos los productos que carguemos -->
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-3 col-sm-offset-9 text-right">
                                    <button type="reset" class="btn btn-primary" onclick="window.location.href=''">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="registrarPresupuesto()" >
                                        <i class="fa fa-check"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </form>     
                    </div>

                </div>
            </div>  
        </div>
        <!-- modal para los errores -->
        <div class="modal fade" id="modalErroProd" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">Error en la carga!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p id="textomodal"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal para confirmar la carga -->
        <div class="modal fade" id="modalpok" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center success" style="color: green;">Se Guardó con éxito</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p id="textomodalok">El presupuesto se guardó exitosamente. Para visualizarlo debe ingresar en el módulo de búsqueda.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.href = 'index.php'"><i class="fa fa-check"></i> Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalerror" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" id="titerror">

                    </div>
                    <div class="modal-body text-center">
                        <p id="textomodalerror"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once '../assets/php/footer.php'; ?>
    <script src="../assets/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
    <script src="js/funciones.js" type="text/javascript"></script>
</body>
</html>