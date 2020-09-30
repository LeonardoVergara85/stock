<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oOferta = $oMysql->getOfertas();
$oVoOferta = new VoOfertas();
$oVoOferta = $oOferta->buscarTodo();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Productos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/bootstrap-select/dist/css/bootstrap-select.css">

        <!--        <link href="../assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>-->
        <link href="../assets/DataTables/datatables.min.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
             .imageContainer img {
               transition:transform 0.65s ease;
              }

             .imageContainer img:hover {
              -webkit-transform:scale(2.3); /* or some other value */
              transform:scale(2.3);
            }
        </style>
    </head>
    <body>
        <!--<img src="../assets/img/cabeceraConsulta.jpg" alt="cabecera"/>-->
        <div  style="background-color: #500005; float: top">
            <img src="../assets/img/emporio.png" alt="" style="width: 40%"/>
            <img src="../assets/img/emporio - copia.png" alt="" style="width: 40%; float: right"/>
        </div>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <!--        <div class="container">
                    <div style="height: 200px; width: 100%">
                        <img src="../archivos/ofertas.png" alt="Emporio"/>
                    </div>
                </div>-->
        <div class="content-wrapper" style="margin-top: 10px;">
            <div class="container">
                <?php if ($oVoOferta) { ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading panel-title">Ofertas - Productos</div>
                        <div class="table-responsive">
                            <div class="panel-body">
                                <table id="example" class="display table table-hover table-condensed table-striped table-no-bordered" style="width:100%">
                                    <tbody>
                                        <?php
                                        foreach ($oVoOferta as $key => $oferta) {
                                            ?>
                                            <tr>
                                                <th><?php echo $oferta->getProducto_id(); ?></th>
                                                <th><?php echo '$ ' . $oferta->getPrecio(); ?></th>
                                                <th>Válido hasta el <?php
                                                    $fecha_ = explode('-', $oferta->getFin());
                                                    echo $fecha_[2] . '/' . $fecha_[1] . '/' . $fecha_[0];
                                                    ?></th>
                                                <th>
                                                    <?php 
                                                        if($oferta->getImg()){
                                                            ?>
                                                        <div class="imageContainer">    
                                                           <img src='../archivos/ofertas/<?php echo $oferta->getImg();?>' style='width: 60px;height: 50px; margin-bottom: 10px;margin-top: 10px;'/>
                                                        </div>
                                                            <?php

                                                        }
                                                    ?>
                                                   
                                                </th>   
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Listados - Productos</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Categoría</div>
                                        <?php
                                        $mCat = $oMysql->getCategorias();
                                        $aCat = $mCat->buscarTodo();
                                        ?>
                                        <select class="selectpicker form-control" name="categoria" id="categoria" 
                                                data-container="body" data-live-search="true" 
                                                title="Seleccione una categoría" data-hide-disabled="true">
                                            <!--<option value="0">Seleccione una categoría</option>-->
                                            <option value="T">Todas las categorías</option>
                                            <?php
                                            foreach ($aCat as $categoria) {
                                                ?>
                                                <option value="<?php echo $categoria->getId(); ?>"><?php echo utf8_encode($categoria->getNombre()); ?></option>
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

                        <div id='listado2'></div>
                    </div>
                </div>

                <input type="hidden" name="pdf_form" id="pdf_form">
            </div>
        </div>
        <?php // include_once '../assets/php/footer.php';  ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../assets/bootstrap-select/dist/js/bootstrap-select.js"></script>

        <script src="../assets/DataTables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="js/funcionesListado_1.js" type="text/javascript"></script>
    </body>
</html>