
<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oCli = $oMysql->getClientes();

$oVoCli = new VoClientes();
$valores = $oCli->buscarTodo();
// var_dump($valores);
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Clientes</title>
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
          <input type="hidden" id="cont" name="cont">
            <div class="panel panel-primary">
              <div class="panel-heading panel-title">Clientes</div>
                <div class="panel-body">
                <div id="formularioClientes">
                  <div class="row" id="div1">
                   <div class="col-sm-2">
                     <div class="form-group">  
                       <div class="input-group">
                         <div class="input-group-addon">Dni</div>
                         <input type="text" class="form-control" id="dniCliente" name="dniCliente" maxlength="8">
                       </div>
                     </div>   
                   </div> 
                   <div class="col-sm-5">
                     <div class="form-group">  
                       <div class="input-group">
                         <div class="input-group-addon">Nombre</div>
                         <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" maxlength="8">
                       </div>
                     </div>   
                   </div>
                   <div class="col-sm-5">
                     <div class="form-group">  
                       <div class="input-group">
                         <div class="input-group-addon">Apellido</div>
                         <input type="text" class="form-control" id="apellidoCliente" name="apellidoCliente" maxlength="8">
                       </div>
                     </div>   
                   </div>  
                 </div>  
                 <div class="row" id="div2" style="display: none;margin-bottom: 15px;">
                  <div class="col-sm-5">
                    <div class="input-group">
                      <div class="input-group-addon">Domicilio</div>
                      <input type="text" class="form-control" id="domicilioCliente">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <div class="input-group-addon">Telefono</div>
                      <input type="text" class="form-control" id="telefonoCliente">
                    </div>
                  </div> 
                  <div class="col-sm-2">
                    <div class="input-group">
                      <div class="input-group-addon">Nac.</div>
                      <input type="date" class="form-control" id="fechaNacCliente" style="line-height: 20px;">
                    </div>
                  </div>         
                </div>
              
                   <div class="row" id="div3" style="display: none;margin-bottom: 15px;">
                     <div class="col-sm-5">
                      <div class="input-group">
                        <div class="input-group-addon">Correo</div>
                        <input type="text" class="form-control" id="correoCliente">
                      </div>
                    </div> 
                   </div> 
                
                   <div class="row" id="div4" style="display: none;margin-bottom: 15px;">
                     <div class="col-sm-5">
                      <div class="input-group">
                        <div class="input-group-addon">Provincia</div>
                        <select class="form-control" id="provinciaCliente">
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="input-group">
                        <div class="input-group-addon">Localidad</div>
                        <select class="form-control" id="localidadCliente">
                        </select>
                      </div>
                    </div> 
                   </div>

                   <div class="row" id="div5" style="display: none;margin-bottom: 15px;">
                     <div class="col-sm-5">
                      <div class="input-group">
                        <div class="input-group-addon">Empresa</div>
                        <input type="text" class="form-control" id="empresaCliente">
                      </div>
                    </div> 
                    <div class="col-sm-3">
                      <select class="form-control" name="" id="">
                        <option value="">Cons. Final</option>
                        <option value="">Revendedor</option>
                        <option value="">Mayorista</option>
                      </select>
                    </div>
                    <div class="col-sm-12 text-right" style="margin-top: 15px;">
                      <button class="btn btn-primary" onclick="location.reload(false);"><i class="fa fa-times"></i> Cancelar</button>
                      <button type="button" class="btn btn-success" onclick="guardar()"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                  </div> 

                   <div class="row">
                    <div class="col-sm-4">
                      <button class="btn btn-primary btn-xs opendiv" id="open" onclick="openDivs()">
                       <i class="fa fa-plus"></i> Siguiente
                      </button>
                      <button class="btn btn-primary btn-xs opendiv" id="close" onclick="closeDivs()" style="display: none;">
                       <i class="fa fa-plus"></i> Anterior
                      </button>
                    </div>
                   </div>    
                </div>
                </div>
            </div>
        </div>
      </div>
</body>
</html>   
<!--<script src="../assets/datatable/jquery-1.11.2.min.js" type="text/javascript"></script>-->
<?php include_once '../assets/php/footer.php'; ?>
<script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/datatable/funciones.js" type="text/javascript"></script>
<script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
<script src="js/funcionesClientes.js" type="text/javascript"></script>
