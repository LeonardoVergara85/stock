<?php
include_once '../logueo/verifica_logueo.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Emergerncia</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="js/funciones.js" type="text/javascript"></script>
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        

        <!--<script type="text/javascript" src="js/ajax.js"></script>-->
    </head>
    <body>
        <div class="container">
            <header> <?php include_once "../includes/php/header.php"; ?></header>
            <form class="form-signin" id="formulario_ingreso" name="formulario_ingreso" method="post" action="#" autocomplete="off">
                <h3 class="h2 text-center">Cambio clave</h3>

                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4 form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Clave Actual</div>
                            <input type="password" class="input-group form-control" 
                                   id="contrasena" name="contrasena" value="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4 form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Clave Nueva</div>
                            <input type="password" class="input-group form-control" 
                                   id="contrasena1" name="contrasena1" value="" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4 form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Confirmar Clave</div>
                            <input type="password" class="input-group form-control" 
                                   id="contrasena2" name="contrasena2" value="" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center" id="divResultado"></div>
                </div>
                <div class="col-sm-2">
                    <input type="button" value="Aceptar" name="aceptar" id="aceptar" class="btn btn-primary btn-block" onclick="guardarDato()"/>
                </div>
                <div class="col-sm-2">
                    <input type="submit" value="Cancelar" name="cancelar" id="cancelar" class="btn btn-primary btn-block" />
                </div>
            </form>
        </div>
        <link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <script src="../bootstrap/js/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>