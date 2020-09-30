<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oVoMov = new VoMovimientos();
$oMov = $oMysql->getMovimientos();
$rea = $oMov->buscarMovReajustes();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reajustes</title>
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
                    <div class="panel-heading panel-title">Reajustes</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-bordered" id="datatablas">
                                <thead style="background-color: darkgray;">
                                <th style="display: none;">id</th>
                                <th class="text-center" style="width: 10%;">Cod.</th>
                                <th class="text-center" style="width: 60%;">Producto</th>
                                <th class="text-center" style="width: 8%;">Cantidad</th>
                                <th class="text-center" style="width: 14%;">Fecha</th>
                                <th class="text-center" style="width: 10%;">Usuario</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($rea != null) {
                                        foreach ($rea as $variable) {
                                            ?><tr class="warning">
                                                <td style="display: none;"><?php echo $variable->getId(); ?></td>
                                                <td class="text-left"><?php echo $variable->getProducto()->getCod_barra(); ?></td>
                                                <td class="text-left"><?php echo $variable->getProducto()->getDescripcion(); ?></td>
                                                <td class="text-right"><?php echo $variable->getCantidad(); ?></td>
                                                <td class="text-left"><?php echo $variable->getFecha(); ?></td>
                                                <td class="text-left"><?php echo $variable->getUsuario()->getNombre(); ?></td>
                                            </tr><?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="modal fade" id="detalleRemitoModal" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-center" id="modal-titleDetalle"></h3>
                                <h5 class="modal-title text-center" id="fechaDetalle"></h5>
                                <h5 class="modal-title text-right" id="usuDetalle"></h5>
                            </div>
                            <div class="modal-body text-center" id="modal-body">
                                <input type="hidden" name="idx" id="idx" value="">  
                                <table class="table table-condensed table-hover">
                                    <thead style="background-color: darkorange">
                                    <th class="text-center" style="display: none;">ID</th>
                                    <th class="text-center">Producto</th>
                                    <th class="text-center">Codigo</th>
                                    <th class="text-center">Cantidad</th>
                                    </thead>
                                    <tbody id="cuerpoDetalle">

                                    </tbody>
                                </table>  
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <input type="hidden" name="inset_form" id="inset_form">  
                                        <button class="btn btn-xs" onclick="detallaRemitoEdit()"><i class="fa fa-plus-circle"></i> Agregar</button>  
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-check"></i> Aceptar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>  
        </div>
        <?php include_once '../assets/php/footer.php'; ?>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
    </body>
</html>