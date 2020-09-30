<?php
//session_name('stock');
//session_start();

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
                <?php
                if (isset($_SESSION['estado'])) {
                    ?>
                    <input id="estado" name="estado" value="1" type="hidden" />
                    <div class="modal fade" id="msj">
                        <div class = "modal-dialog">
                            <div class = "modal-content">
                                <div class = "modal-header">
                                    <button type="button" class="close" data-dismiss = "modal">&times;</button>
                                    <h4 class = "modal-title text-center">Producto Nuevo</h4>
                                </div>
                                <div class="modal-body text-center">
                                    <?php
                                    if ($_SESSION['estado']) {
                                        ?>
                                        <div class="alert alert-success">
                                            El proceso se realizó <b>correctamente.</b>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="alert alert-danger ">
                                            El proceso se realizó <b>correctamente.</b>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    unset($_SESSION['estado']);
                } else {
                    ?>
                    <input id="estado" name="estado" value="0" type="hidden" />
                    <?php
                }
                ?>
                <div class="panel panel-primary">
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
                                <input type="hidden" id="codigoCorrecto" value="0">
                            </div>

                            <div class="row">
                                <!--El siguiente campo es un select para poder
                                indicar a qué categoria de productos pertenece. --> 
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Categoría</div>
                                            <?php
                                            $mCat = $oMysql->getCategorias();
                                            $aCat = $mCat->buscarTodo();
                                            ?>
                                            <select name="categoria" id="categoria" class="form-control">
                                                <option value="0">Seleccione una categoría</option>
                                                <?php
                                                foreach ($aCat as $categoria) {
                                                    ?>
                                                    <option value="<?php echo $categoria->getId(); ?>"><?php echo $categoria->getNombre(); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Descripción</div>
                                            <input type="text" class="form-control" id="nombre"
                                                   name="nombre" placeholder="Descripción del Producto">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="nombreCorrecto" value="0">
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
<!--                            </div>

                            <div class="row">-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Precio</div>
                                            <input type="number" class="form-control" id="precio"
                                                   name="precio" placeholder="Precio del Producto"
                                                   value="" step="0.01" pattern="^\d+(?:\.\d{1,2})?$">
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
<!--                            </div>

                            <div class="row">-->
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
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Orden</div>
                                            <input type="number" class="form-control" id="orden"
                                                   name="orden" placeholder="Cantidad de inicial"
                                                   min="0" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2" style="width:110px;">
                                    <button class="btn btn-primary" type="reset">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fa fa-check"></i> Guardar
                                    </button>
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
