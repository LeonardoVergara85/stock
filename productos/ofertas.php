<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Productos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/bootstrap-select/dist/css/bootstrap-select.css">

        <link href="../assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Ofertas - Productos</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Categoría</div>
                                        <?php
                                        $mProd = $oMysql->getProductos();
                                        $aProd = $mProd->buscarTodo();
                                        ?>
                                        <select class="selectpicker form-control" name="producto" id="producto" 
                                                data-container="body" data-live-search="true" 
                                                title="Seleccione un producto" data-hide-disabled="true">
                                                    <?php
                                                    foreach ($aProd as $prod) {
                                                        ?>
                                                <option value="<?php echo $prod->getId(); ?>"><?php echo utf8_encode($prod->getDescripcion()); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <form action="guardarImagenOferta.php" id="frm_oferta_img" autocomplete="off" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="input-group">
                                        <div class=""><i class="fa fa-file-image-o"></i> Cargar Imagen</div>
                                        <input type="file" class="form-control-file" id="img" name="img">
                                        <input type="hidden" name="id_producto_img" id="id_producto_img">
                                        </div>
                                    </div>
                                </div>
                        </form>
                        </div>
                        
                        <br>
                        <form action="#" name="frm_oferta_productos" id="frm_oferta_productos" autocomplete="off" method="post">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">$ con descuento</div>
                                            <input class="form-control" type="text" name="descuento_producto" id="descuento_producto" value=""/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Fin Oferta</div>
                                            <input class="form-control" type="date" name="fin_oferta" id="fin_oferta" value="<?php echo date('Y-m-d'); ?>"/>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id_producto" id="id_producto" value=""/>
                                    <input type="hidden" name="precio_producto" id="precio_producto" value=""/>
                                    <input type="hidden" name="porcentaje_producto" id="porcentaje_producto" value=""/>
                                    <input type="hidden" name="imagen" id="imagen" value="0"/>
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

                        

                        <!--<div id='listado2'></div>-->
                    </div>
                </div>

                <input type="hidden" name="pdf_form" id="pdf_form">
            </div>
        </div>
        <?php // include_once '../assets/php/footer.php'; ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../assets/bootstrap-select/dist/js/bootstrap-select.js"></script>

        <script src="../assets/js/bootstrapValidator.js" type="text/javascript"></script>
        <script src="../assets/DataTables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="js/funciones_3.js" type="text/javascript"></script>
    </body>
</html>