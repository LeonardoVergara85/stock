<?php
//session_name('stock');
//include_once '../logueo/verifica_logueo.php';

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProveedores();
$oVoProv = new VoProveedores();
$oVoProv = $oProv->buscar();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Proveedores</title>
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Proveedores</div>
                    <div class="panel-body">
                        <div id="formulariop">
                            <form id="frm_proveedor">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">  
                                            <div class="input-group">
                                                <div class="input-group-addon">Nombre</div>
                                                <input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor">
                                            </div>

                                        </div>   
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">  
                                            <div class="input-group">
                                                <div class="input-group-addon">Cuit</div>
                                                <input type="text" class="form-control" id="cuitProveedor" name="cuitProveedor" placeholder="##-########-#">
                                            </div>
                                        </div>	
                                    </div>	
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group"> 
                                            <div class="input-group">
                                                <div class="input-group-addon">Domicilio</div>
                                                <input type="text" class="form-control" id="domicilioProveedor" name="domicilioProveedor">
                                            </div>
                                        </div> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group"> 
                                            <div class="input-group">
                                                <div class="input-group-addon">Teléfono</div>
                                                <input type="text" class="form-control" id="telefonoProveedor" name="telefonoProveedor" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">   
                                            <div class="input-group">
                                                <div class="input-group-addon">Correo</div>
                                                <input type="text" class="form-control" id="correoProveedor" name="correoProveedor">
                                            </div>
                                        </div> 
                                    </div>        
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <div class="input-group-addon">Comentario</div>
                                            <input type="text" class="form-control" id="comentarioProveedor" >
                                        </div>
                                    </div>    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-4 text-left">  
                                        <input type="hidden" name="pdf_list" id="pdf_list">          
                                        <button type="button" class="btn btn-default" onclick="listadopdf()"><i class="fa fa-file-pdf-o"></i> PDF</button>
                                    </div>
                                    <div class="col-sm-8 text-right">
                                        <button class="btn btn-primary" onclick="location.reload(false);"><i class="fa fa-times"></i> Cancelar</button>
                                        <button type="button" class="btn btn-success" onclick="guardar()"><i class="fa fa-check"></i> Guardar</button>
                                    </div>

                                </div>
                            </form> 
                        </div>
                        <br>

                        <div class="row" id="msjguardar" style="display: none;">
                            <div class="alert alert-success alert-dismissable text-center"><i class="fa fa-check"></i> Se Guardó con éxito <button class="btn btn-default" onclick="msjguardar()"> Aceptar</button></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed" id="datatablas">
                                <thead style="background-color: darkgray;">
                                <th>Nombre</th>
                                <th>Domicilio</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Cuit</th>
                                <th></th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($oVoProv as $variable) {
                                        $idProveedor = $variable->getId();
                                        $nombre = $variable->getNombre();
                                        ?><tr>
                                            <td><?php echo $variable->getNombre(); ?></td>
                                            <td><?php echo $variable->getDomicilio(); ?></td>
                                            <td><?php echo $variable->getTelefono(); ?></td>
                                            <td><?php echo $variable->getCorreo(); ?></td>
                                            <td><?php echo $variable->getCuit(); ?></td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-info" onclick="infoProv(<?php echo $idProveedor; ?>)"><i class="fa fa-info-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary" onclick="editarProv(<?php echo $idProveedor; ?>)"><i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="eliminar(<?php echo $idProveedor; ?>)" title="eliminar"><i class="fa fa-minus-circle"></i>
                                                </button>
                                            </td>
                                        </tr><?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalInfoProd">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center" id="modal-title-prov"></h4>
                            </div>
                            <div class="modal-body" id="modal-body-prov">
                                <div class="text-center" id="modal-cuit"></div> 
                                <div class="text-center" id="modal-tel"></div> 
                                <div class="text-center" id="modal-dom"></div> 
                                <div class="text-center" id="modal-correo"></div> 
                                <div class="text-center" id="modal-coment"></div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="modal fade" id="modalEditProv">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center" id="modal-title-editprov">Modificar Proveedor</h4>
                            </div>
                            <div class="modal-body" id="modal-body-editprov">
                                <div id="formulariopedit">
                                    <form id="form-prov-edit">
                                        <input type="hidden" name="idpx" id="idpx" value="">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">  
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Nombre</div>
                                                        <input type="text" class="form-control" id="nombreProveedorE">
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">  
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Cuit</div>
                                                        <input type="text" class="form-control" id="cuitProveedorE">
                                                    </div>
                                                </div>    
                                            </div>  
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Domicilio</div>
                                                    <input type="text" class="form-control" id="domicilioProveedorE" >
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                                                    <input type="text" class="form-control" id="telefonoProveedorE" >
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Correo</div>
                                                    <input type="text" class="form-control" id="correoProveedorE" >
                                                </div>
                                            </div>        
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Comentario</div>
                                                    <input type="text" class="form-control" id="comentarioProveedorE" >
                                                </div>
                                            </div>    
                                        </div>
                                    </form> 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                                <button type="button" class="btn btn-info" onclick="editarProveedor()"><i class="fa fa-check"></i> Modificar</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal fade" id="modalDropP">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title text-center" id="modal-title">Eliminar Proveedor</h4>
                            </div>
                            <div class="modal-body text-center" id="modal-body">
                                <input type="hidden" name="idproveedor" id="idproveedor" value="">
                                Esta seguro de Eliminar este proveedor?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" onclick="eliminarProv()">Aceptar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>

        <script src="../assets/js/bootstrapValidator.min.js" type="text/javascript"></script>
        <script src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

        <script src="js/funcionesProv.js" type="text/javascript"></script>

        <script type="text/javascript">
                                    $(document).ready(function () {
                                        var validator = $('#frm_proveedor').bootstrapValidator({
                                            framework: 'bootstrap',
                                            excluded: ':disabled',
                                            message: 'Valor incorrecto',
                                            feedbackIcons: {
                                                valid: 'glyphicon glyphicon-ok',
                                                invalid: 'glyphicon glyphicon-remove',
                                                validating: 'glyphicon glyphicon-refresh'
                                            },
                                            fields: {
                                                nombreProveedor: {
                                                    message: "ingrese un nombre",
                                                    validators: {
                                                        notEmpty: {
                                                            message: "",
                                                        },
                                                        regexp: {
                                                            regexp: /^[\D]+$/i,
                                                            message: 'Solo se permiten valores alfabéticos.'
                                                        },
                                                        stringLength: {
                                                            message: "ingrese un nombre correcto",
                                                            max: 40,
                                                            min: 5
                                                        },
                                                    }
                                                },
                                                domicilioProveedor: {
                                                    message: "ingrese un domicilio correcto",
                                                    validators: {
                                                        notEmpty: {
                                                            message: "",
                                                        },
                                                        regexp: {
                                                            regexp: /^[\D \d]+$/i,
                                                            message: 'Solo se permiten valores alfanuméricos.'
                                                        },
                                                        stringLength: {
                                                            message: "ingrese un domicilio correcto",
                                                            max: 40,
                                                            min: 5
                                                        },
                                                    }
                                                },

                                                telefonoProveedor: {
                                                    message: "ingrese un telefono correcto",
                                                    validators: {
                                                        notEmpty: {
                                                            message: "",
                                                        },
                                                        stringLength: {
                                                            message: "ingrese un telefono correcto",
                                                            min: 7
                                                        },
                                                        regexp: {
                                                    regexp: /^[\d]+$/i,
                                                    message: 'El teléfono solo puede contener números',
                                                        }
                                                    }
                                                },

                                                cuitProveedor: {
                                                    message: "ingrese un cuit correcto",
                                                    validators: {
                                                        notEmpty: {
                                                            message: "",
                                                        },
                                                        stringLength: {
                                                            message: "ingrese un cuit correcto",
                                                            max: 13,
                                                            min: 13
                                                        },

                                                    }
                                                },

                                                correoProveedor: {
                                                    message: "email incorrecto",
                                                    validators: {
                                                        notEmpty: {
                                                            message: "",
                                                        },
                                                        regexp: {
                                                            regexp: /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/,
                                                            message: 'email incorrecto'
                                                        }
                                                    }
                                                }

                                            }
                                        });
                                    })
        </script>
    </body>
</html>