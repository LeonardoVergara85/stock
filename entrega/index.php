<?php
session_name('stock');
session_start();

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
    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel panel-heading panel-title">Productos</div>
                    <div class="panel-body">
                        <form action="#" name="frm_productos" id="frm_productos" autocomplete="off" method="post">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Código</div>
                                            <input type="text" class="form-control" 
                                                   id="codigo"
                                                   name="codigo"
                                                   placeholder="Código del Producto">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Descripción</div>
                                            <input type="text" class="form-control" id="nombre"
                                                   name="nombre" placeholder="Descripción del Producto">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Cantidad</div>
                                            <input type="number" class="form-control" id="cantidad"
                                                   name="cantidad" placeholder="Cantidad de Productos"
                                                   min="1" value="1" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <button class="btn btn-success" onclick="eliminar()" title="Agregar">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-1">
                                    <button class="btn btn-success" type="submit">Guardar</button>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-primary" type="reset">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>
        <script src="./js/funciones.js" type="text/javascript"></script>
    </body>
</html>
