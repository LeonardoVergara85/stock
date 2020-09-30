<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oUsu = $oMysql->getUsuarios();
$oN = $oMysql->getNiveles();

$oVoUsu = new VoUsuarios();
$oVN = new VoNiveles();
$oVN = $oN->buscar();
$arreglo = $oUsu->buscarUsuarios();
$tip = '';
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Usuarios</title>
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
                <div class="panel-heading panel-title">Usuarios</div>
                <div class="panel-body">
                    <div id="formulariou">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">DNI</div>
                                    <input type="text" class="form-control" id="documentoUsuario">
                                </div>
                            </div>    
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <div class="input-group-addon">Nombre</div>
                                    <input type="text" class="form-control" id="nombreUsuario">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <div class="input-group-addon">Apellido</div>
                                    <input type="text" class="form-control" id="apellidoUsusario">
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">Domicilio</div>
                                    <input type="text" class="form-control" id="domicilioUsuario">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">Telefono</div>
                                    <input type="text" class="form-control" id="telefonoUsuario">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">Correo</div>
                                    <input type="text" class="form-control" id="correoUsuario">
                                </div>
                            </div>  
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-addon">Nac.</div>
                                    <input type="date" class="form-control" id="fechaNacUsuario" style="line-height: 20px;">
                                </div>
                            </div>         
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">Usuario</div>
                                    <input type="text" class="form-control" id="usuario">
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">Contrseña</div>
                                    <input type="password" class="form-control" id="passUsuario">
                                </div>
                            </div> 
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-addon">Tipo</div>
                                    <select class="form-control" id="tipoUsuario">
                                        <?php foreach ($oVN as $value) {
                                            ?><option value="<?php echo $value->getId(); ?>"><?php echo $value->getDescripcion(); ?></option><?php
                                           }
                                        ?>
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-primary" onclick="location.reload(false);"><i class="fa fa-times"></i> Cancelar</button>
                                <button type="button" class="btn btn-success" onclick="guardarU()"><i class="fa fa-check"></i> Guardar</button>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="row" id="msjguardarUsuario" style="display: none;">
                        <div class="alert alert-success alert-dismissable text-center"> Se Guardó con éxito <button class="btn btn-default" onclick="msjguardaru()"><i class="fa fa-check"></i> Aceptar</button><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed" id="datatablas">
                            <thead style="background-color: darkgray;">
                            <th style="display: none;">Cod.</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                       <!--      <th>Nacimiento</th> -->
                            <th>Tipo</th>
                            <th></th>
                            </thead>
                            <tbody>
                                <?php 
                                 foreach ($arreglo as $valor){
                                    if($valor->getBaja() != NULL){
                                       $tip = "danger";
                                    }else{
                                        $tip = "success";
                                    }
                                    ?>
                                    <tr class="<?php echo $tip?>">
                                        <td style="display: none;"><?php echo $valor->getId(); ?></td>
                                        <td><?php echo $valor->getPersona()->getDni(); ?></td>
                                        <td><?php echo $valor->getPersona()->getNombre(); ?></td>
                                        <td><?php echo $valor->getPersona()->getApellido(); ?></td>
                                        <td><?php echo $valor->getPersona()->getDireccion(); ?></td>
                                        <td><?php echo $valor->getPersona()->getTelefono(); ?></td>
                                        <td><?php echo $valor->getPersona()->getEmail(); ?></td>
                                        <td><strong><?php echo $valor->getNiveles()->getDescripcion(); ?></strong></td>
                                        <td style="width: 14%">   
                                            <?php 
                                            if($valor->getBaja() != NULL){
                                                ?>
                                                <button class="btn btn-info" disabled=""><i class="fa fa-edit"></i></button> 
                                                <button class="btn btn-success" title="habilitar" onclick="habilitarU(<?php echo $valor->getId();?>)"><i class="fa fa-refresh"></i></button>
                                                <button class="btn btn-danger" title="Bloquear"
                                                 disabled=""><i class="fa fa-minus-circle"></i></button>
                                                <?php
                                            }else{
                                                ?>  
                                                    <button class="btn btn-primary" onclick="modUsu(<?php echo $valor->getId();?>)"><i class="fa fa-edit"></i></button> 
                                                    <button class="btn btn-success" disabled=""><i class="fa fa-refresh"></i></button>
                                                    <button class="btn btn-danger" title="Bloquear" onclick="bloquear(<?php echo $valor->getId();?>)"><i class="fa fa-minus-circle"></i></button>
                                                <?php
                                            }
                                            ?>
                                            
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
            <div class="modal fade" id="msjBloqueoUsuario">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title text-center">Bloquear Usuario!</h4>
                        </div>
                        <div class="modal-body text-center">
                            <p>Esta seguro de bloquear este usuario?</p>
                            <input type="hidden" name="idU" id="idU" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                            <button type="button" class="btn btn-default" onclick="bloquearUsuario()"><i class="fa fa-check"></i> Aceptar</button>
                        </div>
                    </div>

                </div>
            </div> 

            <div class="modal fade" id="msjHabilitaUsuario">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title text-center">Habilitar Usuario!</h4>
                        </div>
                        <div class="modal-body text-center">
                            <p>Esta seguro de habilitar este usuario?</p>
                            <input type="hidden" name="idUsu" id="idUsu" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                            <button type="button" class="btn btn-default" onclick="habilitarUsuario()"><i class="fa fa-check"></i> Aceptar</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="modificarU">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title text-center">Modificar datos de Usuario</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="idUsum" id="idUsum" value="">
                                <input type="hidden" name="idPerm" id="idPerm" value="">
                                <div class="col-sm-3"><div class="input-group"><label class="label label-default">Dni</label><input type="text" class="form-control" name="dni" id="dni"></div></div>
                                <div class="col-sm-4"><div class="input-group"><label class="label label-default">Nombre</label><input type="text" class="form-control" name="nombre" id="nombre"></div></div>
                                <div class="col-sm-4"><div class="input-group"><label class="label label-default">Apellido</label><input type="text" class="form-control" name="apellido" id="apellido"></div></div>
                            </div>
                            <br>
                            <div class="row">
                                 <div class="col-sm-3"><div class="input-group"><label class="label label-default">Domicilio</label><input type="text" class="form-control" name="domicilio" id="domicilio"></div></div>
                                 <div class="col-sm-3"><div class="input-group"><label class="label label-default">Telefono</label><input type="text" class="form-control" name="telefono" id="telefono"></div></div>
                                 <div class="col-sm-3"><div class="input-group"><label class="label label-default">Correo</label><input type="text" class="form-control" name="correo" id="correo"></div></div>
                                 <div class="col-sm-3"><div class="input-group"><label class="label label-default">Nacimiento</label><input type="date" class="form-control" name="nac" id="nac" style="line-height: 20px;"></div></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3"><div class="input-group"><label class="label label-default">Usuario</label><input type="text" class="form-control" name="usuariom" id="usuariom"></div></div>
                                <div class="col-sm-3"><div class="input-group"><label class="label label-default">Contrseña</label><input type="text" class="form-control" name="passw" id="passw"></div></div>
                                <div class="col-sm-3"><div class="input-group"><label class="label label-default">Nivel</label>
                                    <select class="form-control" id="nive">
                                        <?php foreach ($oVN as $value) {
                                            ?><option value="<?php echo $value->getId();?>" selected=""><?php echo $value->getDescripcion(); ?></option><?php
                                         }
                                        ?>
                                    </select>
                                </div></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="salir"><i class="fa fa-times"></i> Cancelar</button>
                            <button type="button" class="btn btn-success" onclick="modificarUsuario()"><i class="fa fa-check"></i> Modificar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--<script src="../assets/datatable/jquery-1.11.2.min.js" type="text/javascript"></script>-->
        <?php include_once '../assets/php/footer.php'; ?>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
        <script src="js/funcionesUsu.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#salir').click(function() {
            // Recargo la página
            location.reload(); 
        });
    });
</script>
    </body>
</html>