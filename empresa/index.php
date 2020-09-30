<!DOCTYPE html>
<html>
    <head>
        <title>Remitos</title>
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
                    <div class="panel-heading panel-title">Configuración Inicial</div>
                    <div class="panel-body">
                        <form name="frm_empresa" id="frm_empresa">    
                            <div class="row">
                                <!-- autocompletar los proveedores - utilizamos jquery-ui.min.css y jquery.dataTables.min.css -->
                                <div class="col-sm-6">
                                    <div class="autocomplete">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">Nombre</div>
                                                <input type="text" class="form-control txt-auto" id="proveedorRemito" name="proveedorRemito">
                                                <input type="hidden" class="form-control" id="nombree" name="nombree" value="0"> 
                                            </div>
                                        </div>  
                                    </div> 
                                </div>      
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Rubro</div>
                                            <input type="text" class="form-control" id="rubroe" name="rubroe">
                                        </div>
                                    </div>
                                </div>
                               
                            </div> 
                            <div class="row">
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Domicilio</div>
                                            <input type="text" class="form-control" id="Domicilioe" name="Domicilioe">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Telefono</div>
                                            <input type="text" class="form-control" id="Domicilioe" name="Domicilioe">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Correo</div>
                                            <input type="text" class="form-control" id="correoe" name="correoe">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Ubicación</div>
                                            <select class="form-control" id="ubicacione" name="ubicacione">
                                                <option value="0">Seleccionar..</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>     
                    </div>

                </div>
                <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Configuración Impositiva</div>
                    <div class="panel-body">
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Cuit</div>
                                    <input type="text" class="form-control" id="cuite" name="cuite">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Tipo</div>
                                    <select class="form-control" id="" name="">
                                        <option value="1">Monotributo</option>
                                        <option value="1">Autonomo</option>
                                        <option value="1">Responsable</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Punto de Venta</div>
                                    <input type="text" class="form-control" id="pventa" name="pventa">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Inicio de Actividades</div>
                                    <input type="text" class="form-control" id="iact" name="iact">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Imagen</div>
                    <div class="panel-body">
                       <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                  
                                    <input type="file" class="" id="imge" name="imge">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center">
                            <button class="btn btn-default"><i class="fa fa-search"></i> Guardar</button>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row text-right">
                <div class="col-sm-12">
                    <button class="btn btn-primary"><i class="fa fa-times"></i> Cancelar</button>
                    <button class="btn btn-success"><i class="fa fa-check"></i> Guardar</button>
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
    </div>

    <?php include_once '../assets/php/footer.php'; ?>

    <script src="../assets/js/bootstrapValidator.min.js" type="text/javascript"></script>
    <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

    <script src="js/funcionesRemitos.js" type="text/javascript"></script>
</body>
</html>