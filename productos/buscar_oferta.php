
<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);

$oCat = new VoCategorias();
$mCat = $oMysql->getCategorias();

if ($categoria == "T") {
    $aCat = $mCat->buscarTodo();
} else {
    $oCat->setId($categoria);
    $aCat = $mCat->buscarId($oCat);
}

$mostrar = "";
foreach ($aCat as $key => $cate) {
    $mostrar .= "<div class='panel panel-default'>"
            . "<div class='panel-heading text-center'><b>"
            . $cate->getNombre()
            . "</b></div>"
            . "<div class = 'panel-body'>";
    if ($cate->getImagen() != '') {
        $mostrar .= "<div class='col-sm-3'>"
                . "<img alt='El Emporio' src='../archivos/" . $cate->getImagen() . "' style='width: 100%' />"
                . "</div>"
                . "<div class='col-sm-9'>";
    } else {
        $mostrar .= "<div>";
    }
    $mostrar .= "<table class='table table-hover table-striped table-condensed'>";
    /* Acá van los productos del prveedor */

    $sql = "SELECT * FROM prod_pre_cat WHERE categoria_id = " . $cate->getId() . ";";
    $resultado = mysqli_query($_SESSION['con'], $sql);
    $fila = mysqli_fetch_object($resultado);

    if ($fila) {
        $mostrar .= "<tr>"
                . "<th class='col-sm-2 text-center' style='background-color: darkgray;'>código</th>"
                . "<th class='text-center' style='background-color: darkgray;'>Descripción</th>"
                . "<th class='col-sm-2 text-center' style='background-color: darkgray;'>Precio</th>"
                . "</tr>";
        do {
            $mostrar .= "<tr>"
                    . "<td>" . $fila->cod_barra . "</td>"
                    . "<td>" . utf8_encode(trim($fila->descripcion)) . "</td>"
                    . "<td class='text-right'>" . utf8_encode(trim($fila->precio)) . "</td>"
                    . "</tr>";
        } while ($fila = mysqli_fetch_object($resultado));
    } else {
        $mostrar .= "<tr><td>No hay datos para mostrar.</td></tr>";
    }
    $mostrar .= "</table>"
            . "</div>"
            . "</div>"
            . "</div>";
}

echo $mostrar;
