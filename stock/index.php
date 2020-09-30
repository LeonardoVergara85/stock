<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$resultado = mysqli_query($_SESSION['con'], "SELECT * FROM `stock_vw`;");
$fila = mysqli_fetch_object($resultado);
$totalc = 0;
$totalp = 0;
if ($fila) {
    $mPrecio = $oMysql->getPrecios();

    $i = 0;
    $aProducts = array();
    do {
        $oPre = new VoPrecios();
        $oPre->setProducto_id($fila->id);
        $oPre = $mPrecio->buscar($oPre);
        $totalp = $totalp+($oPre->getPrecio() * $fila->cantidad);
        $totalc = $totalc+$fila->cantidad;
        $aProducts[$i]['cod_barra'] = $fila->cod_barra;
        $aProducts[$i]['descripcion'] = $fila->descripcion;
        $aProducts[$i]['cantidad'] = $fila->cantidad;
        $aProducts[$i]['punto_reposicion'] = $fila->punto_reposicion;
        $aProducts[$i]['precio'] = '$' . $oPre->getPrecio();
        $aProducts[$i]['precio_total'] = '$' . ($oPre->getPrecio() * $fila->cantidad);
        unset($oPre);
        $i++;
    } while ($fila = mysqli_fetch_object($resultado));
} else {
    $aProducts = FALSE;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>El Emporio - Productos</title>
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/btable/src/bootstrap-table.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">Stock de Productos</div>
                    <div class="panel-body">
                        <?php if ($aProducts) {
                            ?>
                            <div class="table-responsive">
                                <div class="col-sm-1 pull-right search" style="position: relative; margin-top: 10px; margin-bottom: 10px;">
                                    <button type="button" class="btn btn-default" onclick="detalleRemitoPdf()">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </button>
                                </div>

                                <table class="table table-striped tablesorter table-no-bordered"
                                       id="grilla"
                                       name="grilla"
                                       data-toggle="table"
                                       data-pagination="true"
                                       data-search="true"
                                       data-unique-id="codigo"
                                       >
                                    <thead style="background-color: darkgray;">
                                        <tr>
                                            <th class="col-sm-2">Código</th>
                                            <th>Descripción</th>
                                            <th class="col-sm-1 text-center">Stock</th>
                                            <th class="col-sm-1 text-center">Pto. rep.</th>
                                            <th class="col-sm-1 text-center">Precio u.</th>
                                            <th class="col-sm-1 text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($aProducts as $key => $prod) {
                                            if ($prod['cantidad'] < $prod['punto_reposicion']) {
                                                $color = "danger";
                                            } else {
                                                $color = "";
                                            }
                                            ?>
                                            <tr class="<?php echo $color; ?>">
                                                <td><?php echo $prod['cod_barra']; ?></td>
                                                <td><?php echo $prod['descripcion']; ?></td>
                                                <td><?php echo $prod['cantidad']; ?></td>
                                                <td><?php echo $prod['punto_reposicion']; ?></td>
                                                <td><?php echo $prod['precio']; ?></td>
                                                <td><?php echo $prod['precio_total']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $totalc;?></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo '$'.$totalp;?></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-warning">
                                No hay productos cargados. Debe dar de alta uno nuevo.
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <input type="hidden" name="pdf_form" id="pdf_form">
            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>
        <script src="../assets/btable/src/bootstrap-table.js" type="text/javascript"></script>
        <script src="js/funciones.js" type="text/javascript"></script>
    </body>
</html>
