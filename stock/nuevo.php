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
                                <div class="col-sm-4">
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
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Descripción</div>
                                            <input type="text" class="form-control" id="nombre"
                                                   name="nombre" placeholder="Descripción del Producto">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Unidad de medida</div>
                                            <select name="umedida" id="umedida" class="form-control">
                                                <option value="1">Centimetros</option>
                                                <option value="2">Metros</option>
                                                <option value="3">Toneladas</option>
                                                <option value="4">Unidades</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input id="paquete" name="paquete"type="checkbox"> Paquete
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Cantidad</div>
                                            <input type="number" class="form-control" id="cantidad"
                                                   name="cantidad" placeholder="Cantidad de Productos"
                                                   min="1" value="1" disabled="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Punto Reposición</div>
                                            <input type="number" class="form-control" id="reposicion"
                                                   name="reposicion" placeholder="Cantidad de mínima"
                                                   min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Stock Inicial</div>
                                            <input type="number" class="form-control" id="inicial"
                                                   name="inicial" placeholder="Cantidad de inicial"
                                                   min="1">
                                        </div>
                                    </div>
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
