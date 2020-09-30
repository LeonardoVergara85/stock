<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oVoRem = new VoRemitos();
$oVoMov = new VoMovimientos();
$oRem = $oMysql->getRemitos();
$oMov = $oMysql->getMovimientos();
$oVoRem = $oRem->buscar();
$oVoMov->setRemito_id(4);
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
                    <div class="panel-heading panel-title">Remitos</div>
                    <div class="panel-body">
                        <table class="table table-hover table-condensed" id="datatablas">
                            <thead style="background-color: darkgray;">
                            <th style="display: none;">id</th>
                            <th class="text-center">N° Remito</th>
                            <th class="text-center">Proveedor</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center"></th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($oVoRem as $variable) {
                                    ?><tr>
                                        <td style="display: none;"><?php echo $variable->getId(); ?></td>
                                        <td><?php echo $variable->getNumero(); ?></td>
                                        <td><?php echo $variable->getProveedor()->getNombre(); ?></td>

                                        <td><?php echo $variable->getFecha(); ?></td>
                                        <td><?php echo $variable->getUsuario()->getNombre(); ?></td>
                                        <td class="text-center" style="width: 10%;">
                                            <input type="hidden" name="pdf_form" id="pdf_form">
                                            <button type="button" class="btn btn-sm btn-info" onclick="detalleRemito(<?php echo $variable->getId(); ?>)">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="detalleRemitoPdf(<?php echo $variable->getId(); ?>)">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </button>
                                        </td>
                                    </tr><?php
                                }
                                ?>
                            </tbody>
                        </table>
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
        <script src="js/funcionesRemitos.js" type="text/javascript"></script>
    </body>
</html>