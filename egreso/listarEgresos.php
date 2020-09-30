<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$mMovimi = $oMysql->getMovimientos();
$aMovimi = $mMovimi->buscarFactura();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>El Emporio - Egresos</title>
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
                    <div class="panel-heading">Egreso de prductos</div>
                    <div class="panel-body">
                        <?php if ($aMovimi) {
                            ?>
                            <table class="table table-hover table-condensed table-xs" id="datatablas">
                                <thead style="background-color: darkgray;">
                                    <tr>
                                        <th class="text-center" style="width: 15%;">Nº Movimiento</th>
                                        <th class="text-center" style="width: 15%;">Fecha</th>
                                        <th class="text-center" style="width: 60%;">Usuario</th>
                                        <th class="text-center" style="width: 10%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($aMovimi as $variable) {
                                        ?><tr>
                                            <td class="col-sm-2 text-center" style="width: 15%;"><?php echo $variable->getFactura_id(); ?></td>
                                            <td class="col-sm-2 text-center" style="width: 15%;"><?php echo $variable->getFecha(); ?></td>
                                            <td class="col-sm-2 text-left" style="width: 60%;"><?php echo $variable->getUsuario(); ?>
                                            </td>
                                            <td class="col-sm-2 text-center" style="width: 10%;">
                                                <button type="button" class="btn btn-sm btn-info" onclick="detalleEgreso(<?php echo $variable->getFactura_id(); ?>)"><i class="fa fa-info-circle"></i>
                                                </button>
                                                <input type="hidden" name="pdf_form" id="pdf_form">
                                                <button type="button" class="btn btn-sm btn-default" onclick="detalleEgresoPdf(<?php echo $variable->getFactura_id(); ?>)"><i class="fa fa-file-pdf-o"></i>
                                                </button>
                                            </td>
                                        </tr><?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-warning alert-dismissable text-center">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                No se encotraron datos para listar.
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal fade" id="detalleEgresoModal" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-center" id="modal-titleDetalle"></h3>
                                <!--                                <h5 class="modal-title text-center" id="fechaDetalle"></h5>
                                                                <h5 class="modal-title text-right" id="usuDetalle"></h5>-->
                            </div>
                            <div class="modal-body text-center" id="modal-body">
                                <input type="hidden" name="idx" id="idx" value="">  
                                <table class="table table-condensed table-hover">
                                    <thead style="background-color: darkorange">
                                        <tr>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Paquete</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cuerpoDetalle">

                                    </tbody>
                                </table>  
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
        <script src="js/funciones.js" type="text/javascript"></script>

        <script src="../assets/btable/src/bootstrap-table.js" type="text/javascript"></script>
        <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
    </body>
</html>