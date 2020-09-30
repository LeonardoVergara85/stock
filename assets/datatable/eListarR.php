<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if(isset($_SESSION)){
    $idRegistro = $_SESSION['registroId'];
    var_dump($_SESSION);
    var_dump($_POST);
    
    $asignador = FALSE;
    $notariado = FALSE;
    $registrador = FALSE;
    foreach ($_SESSION['permisos'] as $permiso){
        if($permiso['PERMISO_ID'] == 1){
            $asignador = TRUE;
        }
        if($permiso['PERMISO_ID'] == 2){
            header('location:./index.php'); 
        }
        if($permiso['PERMISO_ID'] == 4){
            $notariado = TRUE;
        }
    }
   
    if(isset($_POST)){
        include_once '../clases/Registros.php';
        $oRegistro = new Registros();
        $listaReg = $oRegistro->buscarTodos();
    
        include_once '../clases/MesaEntrada.php';
        $oMesa = new MesaEntrada();
        
        $fechaDesde = $_POST['fechaDesde'];
        $fechaHasta = $_POST['fechaHasta'];
        

    }else{
        header('location:tareasAsignadas.php');
    }
}else{
        header('location:../index.php'); 
}
?>

<html>
    <head>
        <title>Listar por Registros</title>
        <meta http-equiv="Content-type" content="text/html" charset="UTF-8" />
         <meta charset="ISO-8859-1">
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/funciones.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container" >
            <div class="encabezado_page">
                <br/>
                <h4 class="titulo" align='center' >Sistema de Asignaci&oacute;n de Tareas</h4>
                <br/>
            </div>
            <div class="row">
            <?php 
                if($notariado){include_once './includes/headerNotariado.php';}
            ?>
            </div>
            <br/>
            <label class="titulo">Listado Registros</label>
            <br/>
           <table class="table table-hover text-center" >
            <tr class="notariado">
                <th class="text-center">Registro</th>                
                <th class="text-center">Cantidad de tr&aacute;mites ingresados</th> 
                
                <th class="text-center">Per&iacute;odo</th> 
            </tr>
            <?php 
                foreach ($listaReg as $registro){
                    $idR = $registro->get_ID();
                    echo "<tr>";
                    echo "<td>".$registro->get_NOMBRE()."</td>";
                    $listaTramites = $oMesa->buscarPorRangoFechaRegistro($fechaDesde, $fechaHasta,$idR);
                    echo "<td>".sizeof($listaTramites)."</td>";
                    echo "<td>".$fechaDesde." al ".$fechaHasta."</td>";
                    echo "</tr>";
                }
            ?>
            
           </table>
             <div class="row">
                    <div class="col-sm-3" style="float: right;">    
                        <input class="btn btn-notario" type="button" name="imprime" id="imprime" value="Imprimir" onclick="window.open('impresionListadoRegistros.php?desde=<?php echo $fechaDesde;?>&hasta=<?php echo $fechaHasta;?>')">
                    </div>
                 <br/><br/>
            </div> 
        </div>    
    </body>
    <script src="../bootstrap/js/jquery.min.js" type="text/javascript"></script>
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</html>

