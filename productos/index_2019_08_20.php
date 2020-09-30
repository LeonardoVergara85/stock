<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
//if (!file_exists("data/datos.txt")) {
$oProv = $oMysql->getProductos();
$oVoProv = $oProv->buscarTodo();

$sentence = "SELECT * FROM `producto_precio_venta_vw` ORDER BY orden, descripcion;";
$res = mysqli_query($_SESSION['con'], $sentence);
$file = mysqli_fetch_object($res);


$myfile = fopen("data/datos.txt", "w") or die("Unable to open file!");
$txt = "{\n\t\"data\": [";
fwrite($myfile, $txt);

$i = 0;
$mPrecio = $oMysql->getPrecios();
$oPre = new VoPrecios();

$file = mysqli_fetch_object($res);
if ($file) {
    do {
        $color = '';
        if ($i == 0) {
            $txt = "\n\t{\n";
        } else {
            $txt = ",\n\t{\n";
        }

        $i++;
        fwrite($myfile, $txt);
        $txt = "\t\"DT_RowId\": \"" . $i . "\",\n";

        fwrite($myfile, $txt);
        $txt = "\t\"codigo\": \"" . $file->cod_barra . "\",\n";
        fwrite($myfile, $txt);
        
        $txt = "\t\"orden\": \"" . $file->orden . "\",\n";
        fwrite($myfile, $txt);

        $txt = "\t\"descripcion\": \"" . (trim($file->descripcion)) . "\",\n";
        fwrite($myfile, $txt);

        $medida = "";
        switch ($file->umed_id) {
            case 1:
                $medida = " Centimetros";
                break;
            case 2:
                $medida = " Metros";
                break;
            case 3:
                $medida = " Toneladas";
                break;
            case 4:
                $medida = " Unidades";
                break;
            default:
                break;
        }
        $txt = "\t\"paquete\": \"" . $file->paquete . $medida . "\",\n";
        fwrite($myfile, $txt);

        $txt = "\t\"repo\": \"" . $file->punto_reposicion . $medida . "\",\n";
        fwrite($myfile, $txt);

        $txt = "\t\"unitario\": \"$" . $file->precio . "\",\n";
        fwrite($myfile, $txt);

        $habil = ($file->habilitado != 1) ? '' : 'disabled';
        $txt = "\t\"boton\": \"<button class='btn btn-warning btn-sm' onclick='modificar(" . $file->id . ")' title='modificar'><i class='fa fa-pencil-square-o'></i></button> ";
        $txt .= "<button class='btn btn-success btn-sm' onclick='codigoBarra(" . $file->cod_barra . ")' title='Imprimir Código'><i class='fa fa-barcode' aria-hidden='true'></i></button> ";
        $txt .= "<button class='btn btn-danger btn-sm' " . $habil . "onclick='eliminar( " . $file->id . ", \\\"" . (trim($file->descripcion)) . "\\\")'" . " title='eliminar'><i class='fa fa-minus-circle'></i></button>\"";
        fwrite($myfile, $txt);

        $txt = "\t}";
        fwrite($myfile, $txt);
    } while ($file = mysqli_fetch_object($res));
}
$txt = "\n\t]\n}";
fwrite($myfile, $txt);
fclose($myfile);
//}
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="UTF-8">-->
        <meta>
        <title>El Emporio - Productos</title>
        <!--<link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
        <link href="../assets/DataTables/datatables.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <link href="../assets/css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <div class="content-wrapper">
            <div class="container">
                <!--                <div class="row">
                                    <button id="refresco">Refrescar</button>
                                </div>-->
                <div class="panel panel-primary">
                    <div class="panel-heading">Productos</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table table-hover table-condensed" style="width:100%">
                                <thead style="background-color: darkgray;">
                                    <tr>
                                        <th>orden</th>
                                        <th>codigo</th>
                                        <th>descripcion</th>
                                        <th>paquete</th>
                                        <th>repo</th>
                                        <th>unitario</th>
                                        <th>boton</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>orden</th>
                                        <th>codigo</th>
                                        <th>descripcion</th>
                                        <th>paquete</th>
                                        <th>repo</th>
                                        <th>unitario</th>
                                        <th>boton</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
                if (isset($_SESSION['habilitado'])) {
                    ?>
                    <input id="habil" name="habil" value="1" type="hidden" />

                    <?php
                    unset($_SESSION['habilitado']);
                } else {
                    ?>
                    <input id="habil" name="habil" value="0" type="hidden" />
                    <?php
                }
                ?>

            </div>
        </div>

        <div class="modal fade" id="verMensaje">
            <form action="#" name="frm_modi_productos" id="frm_modi_productos" autocomplete="off" method="post">
                <input type="hidden" id="id_modal" name="id_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modificación Producto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Código</div>
                                            <input type="text" class="form-control" 
                                                   id="codigo_modal"
                                                   name="codigo_modal"
                                                   placeholder="Código del Producto">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--El siguiente campo es un select para poder
                                indicar a qué categoria de productos pertenece. -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Categoría</div>
                                            <?php
                                            $mCat = $oMysql->getCategorias();
                                            $aCat = $mCat->buscarTodo();
                                            ?>
                                            <select name="categoria_modal" id="categoria_modal" class="form-control">
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
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Descripción</div>
                                            <input type="text" class="form-control" id="nombre_modal"
                                                   name="nombre_modal" placeholder="Descripción del Producto">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Unidad de medida</div>
                                            <select name="umedida_modal" id="umedida_modal" class="form-control">
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input id="paquete_modal" name="paquete_modal" type="checkbox"> Paquete
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Cantidad Paquete</div>
                                            <input type="number" class="form-control" id="cantidad_modal"
                                                   name="cantidad_modal" placeholder="Cantidad de Productos"
                                                   min="1" value="1" disabled="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Punto Reposición</div>
                                            <input type="number" class="form-control" id="reposicion_modal"
                                                   name="reposicion_modal" placeholder="Cantidad de mínima"
                                                   min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Precio</div>
                                            <input type="number" class="form-control" id="precio_modal"
                                                   name="precio_modal" placeholder="Precio del Producto"
                                                   value="" step="0.01" pattern="^\d+(?:\.\d{1,2})?$">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-default" id="modi_aceptar" >Aceptar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="verCodigo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Código de Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="codigo text-center" id="codigo_modal_1" name="codigo_modal_1"></p>
                                <br>
                                <p class="text-center" id="codigo_modal_3" name="codigo_modal_3"></p>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="codigoPdf()">Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="pdf_form" id="pdf_form">
        </div>

        <form action="#" name="frm_desha_productos" id="frm_desha_productos" autocomplete="off" method="post">
            <input type="hidden" value="" id="iddesha" name="iddesha">
        </form>
        <?php include_once '../assets/php/footer.php'; ?>
        <script src="js/funciones_1.js" type="text/javascript"></script>

        <!--<script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>-->
        <!--<script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>-->
        <script src="../assets/DataTables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>

    </body>
</html>
