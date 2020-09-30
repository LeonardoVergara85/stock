<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
//if (!file_exists("data/datos.txt")) {
$oProv = $oMysql->getProductos();
$productos = $oVoProv = $oProv->buscarTodo();
$mPrecio = $oMysql->getPrecios();
$oPre = new VoPrecios();
$paquete = '';
$medida = '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>El Emporio - Productos</title>
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
        <!--<link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
        <link href="../assets/DataTables/datatables.min.css" rel="stylesheet" type="text/css"/>

    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <link href="../assets/css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">Precios Historicos</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="datatablas" class="display table table-hover table-condensed" style="width:100%">
                                <thead style="background-color: darkgray;">
                                    <tr>
                                        <th class="text-center">codigo</th>
                                        <th class="text-center">descripcion</th>
                                        <th class="text-center">paquete</th>
                                        <th class="text-center">medida</th>
                                        <th class="text-center">reposición</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                    foreach ($productos as $value) {
                                        if($value->getPaquete() == 1){
                                            $paquete = 'No';
                                        }else{$paquete = $value->getPaquete();}
                                        switch ($value->getUmed_id()) {
                                           case 1:
                                                 $medida = 'metros';
                                                 break;
                                           case 2:
                                                 $medida = 'centimetros';
                                                 break;
                                           case 3:
                                                 $medida = 'kilos';
                                                 break;
                                           case 4:
                                                 $medida = 'unidades';
                                                 break;
                                        }
                                        ?><tr>
                                           <td class="text-center"><?php echo $value->getCod_barra();?></td> 
                                           <td class="text-left"><?php echo $value->getDescripcion();?></td> 
                                           <td class="text-center"><?php echo $paquete;?></td>
                                           <td class="text-center"><?php echo $medida;?></td>  
                                           <td class="text-center"><?php echo $value->getPunto_reposicion();?></td> 
                                           <td class="text-right">
                                            <button class="btn btn-xl btn-primary" onclick="verhistorico(<?php echo $value->getId();?>)">$</button>
                                            <button class="btn btn-xl btn-default" onclick="verhistoricoPDF(<?php echo $value->getId();?>)"><i class="fa fa-file-pdf-o"></i></button>
                                           </td> 
                                        </tr><?php
                                    }
                                   ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    
        <div class="modal fade" id="modalHistoriPrecios" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-center" id="modal-titlePrecioHist">
                                 Precios Históricos   
                                </h3>
                            </div>
                            <div class="modal-body text-center" id="modal-body">
                                <div class="alert alert-success" id="nomprod"></div>
                                <input type="hidden" name="idx" id="idx" value="">  
                                <table class="table table-condensed table-hover">
                                    <thead style="background-color: darkorange">
                                    <th class="text-center" style="display: none;">ID</th>
                                    <th class="text-center">Proveedor</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">% inc. costo</th>
                                    <th class="text-center">Precio costo</th>
                                    <th class="text-center">Vigente</th>
                                    </thead>
                                    <tbody id="cuerpoPrecioHist">

                                    </tbody>
                                </table>  
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Aceptar</button>
                            </div>
                        </div>

                    </div>
                </div>



        <?php include_once '../assets/php/footer.php'; ?>
        <script src="js/funciones_1.js" type="text/javascript"></script>

        <!--<script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>-->
        <!--<script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>-->
        <script src="../assets/DataTables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
        <script src="js/funcionesPrecios.js" type="text/javascript"></script>
        
    </body>
</html>
