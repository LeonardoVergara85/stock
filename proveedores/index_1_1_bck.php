<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProveedores();
$oVoProv = new VoProveedores();
$oVoProv = $oProv->buscar();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Proveedores</title>
        <!--        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
                <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />-->

        <!--<link href="../assets/DataTables/DataTables-1.10.16/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>-->
        <!--<link href="../assets/DataTables/datatables.css" rel="stylesheet" type="text/css"/>-->
        <link href="../assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Proveedores - Productos</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Proveedor</div>
                                        <select name="proveedor" id="proveedor" class="form-control">
                                            <option value="0">Seleccione un proveedor</option>
                                            <!--<option value="T">Todos los proveedores</option>-->
                                            <?php
                                            foreach ($oVoProv as $variable) {
                                                $idProveedor = $variable->getId();
                                                $nombre = $variable->getNombre();
                                                ?>
                                                <option value="<?php echo $variable->getId(); ?>">
                                                    <?php echo $variable->getNombre(); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-default col-lg-offset-3" id="imprime" disabled>
                                <i class="fa fa-file-pdf-o"></i>
                            </button>
                        </div>
                        <br>

                        <div class="table-responsive">
                            <table id='listado1' class="table table-striped table-bordered dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
                                <thead style='background-color: darkgray;'>
                                    <tr>
                                        <th class='col col-sm-1'>Código</th>
                                        <th class='col col-sm-6'>Descripción</th>
                                        <th class='col col-sm-1'>Stock</th>
                                        <th class='col col-sm-1'>$ Costo</th>
                                        <th class='col col-sm-1'>% Incre.</th>
                                        <th class='col col-sm-1'>$ Sug.</th>
                                        <th class='col col-sm-1'>$ Venta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>codigo</th>
                                        <th>descripcion</th>
                                        <th>stock</th>
                                        <th>costo</th>
                                        <th>ganancia</th>
                                        <th>sugerido</th>
                                        <th>venta</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="pdf_form" id="pdf_form">
            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>

        <script src="../assets/DataTables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.js" type="text/javascript"></script>
        <!--<script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>-->
        <script src="js/funcionesProv_1_1.js" type="text/javascript"></script>
    </body>
</html>