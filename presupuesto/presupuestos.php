<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oVoPres = new VoPresupuestos();
/* $oVoMov = new VoMovimientos(); */
$oPres = $oMysql->getPresupuestos();
/* $oMov = $oMysql->getMovimientos(); */
$presupuestosx = $oPres->buscarTodo();
/* var_dump($presupuestosx); */
?>
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
                    <div class="panel-heading panel-title">Mis Presupuestos</div>
                    <div class="panel-body">
                        <input type="hidden" name="usua" id="usua" value="<?php echo $_SESSION['id'] ?>">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed" id="datatablas">
                                <thead style="background-color: darkgray;">
                                <th style="display: none;">id</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Solicitante</th>
                                <th class="text-center">Contacto</th>
                                <th class="text-center">Vigente</th>
                                <th class="text-center"></th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($presupuestosx as $key) {
                                        ?>
                                        <tr>
                                            <td style="display: none;"><?php echo $key->getId(); ?></td>
                                            <td class="text-center"><?php echo $key->getFecha(); ?></td>
                                            <td class="text-left"><?php echo $key->getSolicitante(); ?></td>
                                            <td class="text-left"><?php echo $key->getContacto(); ?></td>
                                            <?php if ($key->getVigente() == 'si') {
                                                ?><td class="text-center"><font color="green"><?php echo $key->getVigente(); ?></font></td><?php
                                            } else {
                                                ?>
                                                <td class="text-center"><font color="blue"> Procesado </font></td>
                                            <?php }
                                            ?>

                                            <td class="text-right">
                                                <button type="button" class="btn btn-info" onclick="detallePresupuesto(<?php echo $key->getId(); ?>)" title="Detalle"><i class="fa fa-info-circle"></i>
                                                </button>
                                                <input type="hidden" name="pdf_formp" id="pdf_formp">
                                                <button type="button" class="btn btn-default" onclick="detallePresupuestoPdf(<?php echo $key->getId(); ?>)" title="Detalle en PDF"><i class="fa fa-file-pdf-o"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" onclick="eliminarPre(<?php echo $key->getId(); ?>)" title="eliminar"><i class="fa fa-ban"></i>
                                            </td> 
                                        </tr> 
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>  
            <div class="modal fade" id="detallePresupuestoModal" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title text-center" id="modal-titleDetalleP"></h3>
                            <h5 class="modal-title text-center" id="fechaDetalleP"></h5>
                            <h5 class="modal-title text-center" id="usuarioDetalleP"></h5>
                            <h5 class="modal-title text-right" id="solicitanteDetalleP"></h5>
                            <h5 class="modal-title text-right" id="contactoDetalleP"></h5>
                        </div>
                        <div class="modal-body text-center" id="modal-body">
                            <input type="hidden" name="idpr" id="idpr" value="">  
                            <table class="table table-condensed table-hover">
                                <thead style="background-color: darkorange">
                                <th class="text-center" style="display: none;">ID</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Codigo</th>
                                <th class="text-center">Precio u.</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Total</th>
                                <th class="text-center" style="display: none;"></th>
                                </thead>
                                <tbody id="cuerpoDetalleP">

                                </tbody>
                            </table>  
                        </div>

                        <div class="modal-footer">
                            <div class="col col-sm-3 col-sm-offset-6">
                                <button type="button" id="btnaegreso" 
                                        class="btn btn-block btn-primary" onclick="pasoaEgresomodal()">
                                    <i class="fa fa-arrow-circle-o-up"></i> Egreso
                                </button>
                            </div>
                            <div class="col col-sm-3">
                                <button type="button" class="btn btn-block btn-success" data-dismiss="modal">
                                    <i class="fa fa-check"></i> Aceptar
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal fade" id="modaleliminar" role="dialog" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header" id="titeliminar">

                        </div>
                        <div class="modal-body text-center">
                            <p id="textomodaleliminar"></p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idpresu" id="idpresu">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="eliminarPresupuesto()">Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalaceptarpresu" role="dialog" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header" id="titmodalaceptarpresu">

                        </div>
                        <div class="modal-body text-center">
                            <p id="bodymodalaceptarpresu"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="pasoaEgreso()">Aceptar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>
            <!-- <script src="../assets/js/jquery-1.4.2.min.js"></script> -->
            <!-- <script src="../assets/datatable/jquery-1.11.2.min.js" type="text/javascript"></script> -->
        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
        <script src="../assets/js/autocomplete.jquery.js"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
<!-- <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> -->
        <script src="js/funciones.js" type="text/javascript"></script>
       <!--  <script>
            $(document).ready(function(){
                /* Una vez que se cargo la pagina , llamo a todos los autocompletes y
                 * los inicializo */
                $('.autocomplete').autocomplete();
            });
        </script> -->
    </body>
</html>