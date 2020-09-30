<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProveedores();
$oVoProv = new VoProveedores();
$oVoProv = $oProv->buscar();
?>

<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->
<link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="prueba.css" rel="stylesheet" type="text/css"/>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<br />
<div class="container">
    <div class="row">
        <div class="ui-widget">
            <?php
            $mCat = $oMysql->getCategorias();
            $aCat = $mCat->buscarTodo();
            ?>
            <select name="categoria" id="combobox" class="form-control">
                <option value=""></option>
                <option value="0">Seleccione una categoría</option>
                <option value="T">Todas las categorías</option>
                <?php
                foreach ($aCat as $categoria) {
                    ?>
                    <option value="<?php echo $categoria->getId(); ?>"><?php echo $categoria->getNombre(); ?></option>
                    <?php
                }
                ?>
            </select>
<!--            <label>Procedure: </label>
            <select id="combobox">
                <option></option>
                <option value="Ultrasound Knee Right">Ultrasound Knee Right</option>
                <option value="Ultrasound Knee Left">Ultrasound Knee Left</option>
                <option value="Ultrasound Forearm/Elbow Right">Ultrasound Forearm/  Elbow Right</option>
                <option value="Ultrasound Forearm/Elbow Left">Ultrasound Forearm/Elbow Left</option>
                <option value="MRI Knee Right">MRI Knee Right</option>
                <option value="MRI Knee Left">MRI Knee Left</option>
                <option value="MRI Forearm/Elbow Right">MRI Forearm/Elbow Right</option>
                <option value="MRI Forearm/Elbow Left">MRI Forearm/Elbow Left</option>
                <option value="CT Knee Right">CT Knee Right</option>
                <option value="CT Knee Left">CT Knee Left</option>
                <option value="CT Forearm/Elbow Right">CT Forearm/Elbow Right</option>
                <option value="CT Forearm/Elbow Left">CT Forearm/Elbow Left</option>
            </select>-->
        </div>
    </div>
</div>
<script src="js/select.js" type="text/javascript"></script>