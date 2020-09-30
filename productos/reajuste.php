<?php
//session_name('stock');
//session_start();

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProductos();
$oVoProv = $oProv->buscarTodo();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>El Emporio - Productos</title>
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <link href="../assets/css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <div class="content-wrapper">
            <div class="container">

                <div class="panel panel-primary">
                    <div class="panel-heading">Reajuste - Productos</div>
                    <div class="panel-body">
                        <div class="row">  
                            <div class="col-sm-5">
                                <div class="autocomplete">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Productos</div>
                                            <input type="text" class="form-control txt-auto" id="productoList" name="productoList">
                                            <input type="hidden" class="form-control" id="productoListId" name="productoListId" value=""> 
                                        </div>
                                    </div>  
                                </div> 

                                <!-- <label class="label label-default">Productos</label>
                                <select class="form-control" id="productoList" name="productoList">
                                    <option value="1">Focos LED</option>
                                    <option value="2">Lamparas LED Legend</option>
                                    <option value="3">Caja de Luz</option>
                                    <option value="4">Porta Lampara ELG (exterior)</option>
                                </select> -->
                            </div>  
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">codigo</div>
                                        <input type="text" class="form-control txt-auto" id="codigo" name="codigo" disabled="">
                                      <!--   <input type="hidden" class="form-control" id="productoListId" name="productoListId" value="">  -->
                                    </div>
                                </div> 
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">cantidad</div>
                                        <input type="text" class="form-control txt-auto" id="cantp" name="cantp">
                                      <!--   <input type="hidden" class="form-control" id="productoListId" name="productoListId" value="">  -->
                                    </div>
                                </div> 
                            </div>
                            

                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">comentario</div>
                                        <input type="text" class="form-control txt-auto" id="comentario" name="comentario">
                                      <!--   <input type="hidden" class="form-control" id="productoListId" name="productoListId" value="">  -->
                                    </div>
                                </div> 
                            </div> 
                            
                        </div>
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" onclick="window.location.href='reajuste.php'"><i class="fa fa-times"></i> Cancelar</button>
                                <button class="btn btn-success" onclick="reajustar()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>



        <div class="modal fade" id="avisoreajuste" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center success" style="color: green;">Se guardó el reajuste</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p id="textomodalok">El reajuste del producto se guardo exitosamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.href = 'reajuste.php'"><i class="fa fa-check"></i> Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once '../assets/php/footer.php'; ?>
        <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script src="js/funciones_2.js" type="text/javascript"></script>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
    </body>
</html>
