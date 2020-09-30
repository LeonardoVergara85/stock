<?php
session_name('stock');
/*session_start();*/

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oVoRem = new VoRemitos();
$oVoMov = new VoMovimientos();
$oRem = $oMysql->getRemitos();
$oMov = $oMysql->getMovimientos();
$oVoMov->setRemito_id($_POST['idRem']);
$data = $oMov->buscarMovRemitos($oVoMov);
  ?>
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
                <div class="panel-heading panel-title">Modificar Remito</div>
                <div class="panel-body">
                <form name="frm_remito" id="frm_remito">    
                <br>
                 <div class="row">
                    <div class="">
                     <div class="col-sm-5">
                          <div class="autocomplete">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Productos</div>
                                    <input type="text" class="form-control txt-auto" id="productoList2" name="productoList2">
                                    <input type="hidden" class="form-control" id="productoListId2" name="productoListId2" value="0"> 
                                </div>
                              </div>  
                        </div> 
                    </div> 
                    <div class="col-sm-2" style="">
                                <div class="input-group">
                                    <div class="input-group-addon">Código</div>
                                    <input type="text" class="form-control" id="cod2" id="cod2" disabled="">
                                </div>
                    </div>
                    <div class="col-sm-2" style="">
                                <div class="input-group">
                                    <div class="input-group-addon">Cantidad</div>
                                    <input type="text" class="form-control" id="cantidadProductoList2">
                                </div>
                    </div>   
                    <div class="col-sm-2" style="">
                        <!-- <button type="button" class="btn btn-danger" onclick="removerProd()"><i class="fa fa-minus-circle" aria-hidden="true"></i></button> -->
                        <button type="button" class="btn btn-success" onclick="crearProd2()"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        <input type="hidden" name="contador2" id="contador2" value="0">
                    </div>        
                    </div>
                </div> 
           
                <br>
                <div class="row" id="cargaProd">
                     <table class="table table-condensed table-bordered" id="tablaproductos21">
                        <thead class="text-center" style="background-color: cadetblue;">
                            <th class="text-center" style="width: 10%; display: none;">ID</th>
                            <th class="text-center" style="width: 60%;">PRODUCTO</th>
                            <th class="text-center" style="width: 10%;">COD.</th>
                            <th class="text-center" style="width: 10%;">CANTIDAD</th>
                            <th style="width: 10%;"></th>
                        </thead>
                        <tbody id="productosRemito21">
                            <?php foreach ($data as $key){
                              ?>
                              <tr style="background-color: orange;">
                                <td style="display: none;"><?php echo $key->getProducto_id()?></td>
                                <td><?php echo $key->getProducto()->getDescripcion()?></td>
                                <td><?php echo $key->getProducto()->getCod_barra()?></td>
                                <td><?php echo $key->getCantidad()?></td>
                                <td></td>
                              </tr>
                              <?php  
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="table table-hover table-condensed table-bordered" id="tablaproductos2" style="margin-top: -20px;">
                        <thead class="text-center" style="background-color: cadetblue;">
                            <th class="text-center" style="width: 10%;display: none;">ID</th>
                            <th class="text-center" style="width: 60%;">PRODUCTO</th>
                            <th class="text-center" style="width: 10%;">COD.</th>
                            <th class="text-center" style="width: 10%;">CANTIDAD</th>
                            <th style="width: 10%;"></th>
                        </thead>
                        <tbody id="productosRemito2">
                       
                        </tbody>
                    </table>
                    <!-- aca van todos los productos que carguemos -->
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4 text-right">
                        <button type="button" class="btn btn-default" onclick="window.location.href='buscarRemitos.php'"><i class="fa fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-success" onclick="registrarRemito2(<?php echo $_POST['idRem'];?>)" >
                            <i class="fa fa-check"></i> Guardar</button>
                    </div>
                    
                </div>
            </form>     
                </div>
                
            </div>
              
            <div class="modal fade" id="modalErroProd2" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title text-center">Error en la carga!</h4>
                </div>
                <div class="modal-body text-center">
                  <p id="textomodal2"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- confirmar modificar -->
          <div class="modal fade" id="modalokm" name="modalokm" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title text-center success" style="color: green;">Se Modificó con éxito</h4>
                </div>
                <div class="modal-body text-center">
                  <p id="textomodalok">El remito se modificó exitosamente.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.href='buscarRemitos.php'"><i class="fa fa-check"></i> Aceptar</button>
                </div>
              </div>
            </div>
          </div>
        </div> 
        </div> 
        <?php include_once '../assets/php/footer.php'; ?>

        <!-- <script src="../assets/js/jquery-1.4.2.min.js"></script> -->
     <!--    <script src="../assets/datatable/jquery-1.11.2.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script> -->
        <!-- <script src="../assets/js/autocomplete.jquery.js"></script> -->
        <script src="../assets/js/bootstrapValidator.min.js" type="text/javascript"></script>
        <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

        <script src="js/funcionesRemitos.js" type="text/javascript"></script>
        
    </body>
</html>