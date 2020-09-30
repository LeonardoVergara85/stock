<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oCat = $oMysql->getCategorias();

$oVoCat = new VoCategorias();
$valores = $oVoCat = $oCat->buscarTodo();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Categorias</title>
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Categorias</div>
                    <div class="panel-body">
                        <div id="formulariocat">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">  
                                        <div class="input-group">
                                            <div class="input-group-addon">Categoria</div>
                                            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" placeholder="nombre categoria" maxlength="30">
                                        </div>
                                    </div>   
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">  
                                        <div class="input-group">
                                            <div class="input-group-addon">Descripción</div>
                                            <input type="text" class="form-control" id="descCategoria" name="descCategoria" placeholder="descripcion categoria" maxlength="70">
                                        </div>
                                    </div>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">  
                                        <div class="input-group">
                                            <div class="input-group-addon">Orden</div>
                                            <input type="text" class="form-control" id="ordenCategoria" name="ordenCategoria" placeholder="orden categoria" maxlength="3">
                                        </div>
                                    </div>   
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button class="btn btn-primary" onclick="location.reload(false);">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="guardarCategoria()">
                                        <i class="fa fa-check"></i> Guardar
                                    </button>
                                </div>
                            </div> 
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed" id="datatablas">
                                <thead style="background-color: darkgray;">
                                <th style="display: none;">Cod.</th>
                                <th style="width: 30%;">Categoria</th>
                                <th style="width: 50%;">Descripción</th>
                                <th style="width: 5%;">Orden</th>
                                <th></th>
                                <!--<th style="width: 10%;"></th>-->
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($valores as $values) {
                                        ?>
                                        <tr class="trTabla">
                                            <td style="display: none;"><?php echo $values->getId() ?></td>
                                            <td><?php echo $values->getNombre() ?></td>
                                            <td><?php echo $values->getDescripcion() ?></td>
                                            <td><?php echo $values->getOrden() ?></td>
                                            <td>
                                                <button class="btn btn-primary botonedit"
                                                        onclick="botonedit(<?php echo $values->getId() . ", '" . $values->getNombre() . "', '" . $values->getDescripcion() . "'"; ?>)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger botoneliminar">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <button class="btn btn-danger botonimagen" 
                                                        onclick="botonimagen(<?php echo $values->getId() . ", '" . $values->getNombre() . "'"; ?>)">
                                                    <i class="fa fa-image"></i>
                                                </button>
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
        </div>
    </body>
    <div class="modal fade" id="modalEditarCat" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Modificar Categoría</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="idcategoria" id="idcategoria" value="">
                        <div class="col-sm-4">
                            <div class="form-group">  
                                <div class="input-group">
                                    <div class="input-group-addon">Categoria</div>
                                    <input type="text" class="form-control" id="nombreCategoriaEdit" name="nombreCategoriaEdit" maxlength="30">
                                </div>
                            </div>   
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">  
                                <div class="input-group">
                                    <div class="input-group-addon">Descripción</div>
                                    <input type="text" class="form-control" id="descCategoriaEdit" name="descCategoriaEdit" maxlength="70">
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">  
                                <div class="input-group">
                                    <div class="input-group-addon">Orden</div>
                                    <input type="text" class="form-control" id="ordenCategoriaEdit" name="ordenCategoriaEdit" placeholder="orden categoria" maxlength="3">
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-primary" onclick="modificarCat()">
                            <i class="fa fa-check"></i> Modificar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="modal fade" id="cargarImagen" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Imagen de la Categoría</h4>
                </div>
                <div class="modal-body">
                    <form name="vehiculo" class="form-horizontal" action="guardarImagen.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="idcategoriai" id="idcategoriai" value="">
                            <div class="col-sm-4">
                                <div class="form-group">  
                                    <div class="input-group">
                                        <div class="input-group-addon">Categoria</div>
                                        <input type="text" class="form-control" id="nombreCategoriaImg" name="nombreCategoriaImg" maxlength="30">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="archivo1">Ingreso de archivo</label>
                                    <input type="file" class="form-control-file" id="archivo1" name="archivo1">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fa fa-times"></i>Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check"></i> Modificar
                            </button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div> 
</html>   
<!--<script src="../assets/datatable/jquery-1.11.2.min.js" type="text/javascript"></script>-->
<?php include_once '../assets/php/footer.php'; ?>
<script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/datatable/funciones.js" type="text/javascript"></script>
<script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
<script src="js/globales.js" type="text/javascript"></script>
<script src="js/funcionesCategorias.js" type="text/javascript"></script>
