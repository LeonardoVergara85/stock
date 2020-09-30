<?php
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
        <link href="../assets/btable/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel panel-heading panel-title">Egreso de prductos</div>
                    <div class="panel-body">
                        <?php
                        if (isset($_SESSION['Producto'])) {
                            if ($_SESSION['Producto']) {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    El proceso se realizó correctamente.
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    Ocurrió un error en el proceso.
                                </div>
                                <?php
                            }
                            unset($_SESSION['Producto']);
                        }
                        ?>
                        <form action="#" name="frm_productos" id="frm_productos" autocomplete="off" method="post">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" 
                                               id="codigo"
                                               name="codigo"
                                               placeholder="Código">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="autocomplete">
                                        <div class="form-group">
                                            <input type="text" class="form-control txt-auto" id="productoList" name="productoList" placeholder="Descripción del Producto">
                                            <input type="hidden" class="form-control" id="productoListId" name="productoListId" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="cantidad"
                                               name="cantidad" placeholder="Cantidad"
                                               min="1" value="1">
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit" name="sumar" id="sumar"><li class="fa fa-plus-circle"></li></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped tablesorter table-no-bordered"
                                   id="grilla"
                                   name="grilla"
                                   data-toggle="table"
                                   data-pagination="true"
                                   data-search="false"
                                   data-unique-id="codigo"
                                   >
                                <thead>
                                    <tr>
                                        <th data-field="codigo" class="col-sm-2">Código</th>
                                        <th data-field="producto" class="col-sm-6">Producto</th>
                                        <th data-field="cantidad" class="col-sm-1">Cantidad</th>
                                        <th data-field="paquete" class="col-sm-1">Paquete</th>
                                        <th data-field="total" class="col-sm-1">Total</th>
                                        <th data-field="option" class="text-center"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-3 col-sm-offset-9 text-right">
                                <button class="btn btn-primary" type="reset" onclick="regreso()"><i class="fa fa-times"></i> Cancelar</button>

                                <button id="procesar" class="btn btn-success" type="button"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>
        <script src="../assets/btable/src/bootstrap-table.js" type="text/javascript"></script>
        <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
        <script src="./js/funciones.js" type="text/javascript"></script>
    </body>
</html>
