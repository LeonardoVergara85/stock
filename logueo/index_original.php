<?php
// No almacenar en el cache del navegador esta pagina.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");               // Expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // Siempre p�gina modificada
header("Cache-Control: no-cache, must-revalidate");             // HTTP/1.1
header("Pragma: no-cache");                                     // HTTP/1.0
// Se inicia o reanuda una sesion
$nombre = explode("/", $_SERVER['PHP_SELF']);
session_name('stock');

session_start();
// Se genera el token para evitar ataques
$token = md5(uniqid(rand(), true));

// Se guarda el token en la sesion 
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">   <![endif]-->
        <title>El Emporio</title>

        <!-- BOOTSTRAP CORE STYLE -->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <link href="../assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body style="background-image: url(../assets/img/fondo.jpg); background-size: 100%">
        <?php // include_once '../assets/php/cabecera.php'; ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <img class="img-responsive" src="../assets/img/emporio.png" />
                    </div>
                </div>

                <!--                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="page-head-line">Acceso para usuarios registrados</h4>
                                    </div>
                                </div>-->

                <br/>
                <br/>
                <br/>
                <br/>
                <div class="col-md-6 col-lg-offset-3">
                    <form action="logue.php" method="post" name="formu" autocomplete="off" id="login">
                        <input type='hidden' name='token' value="<?php echo $token ?>" />
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">   
                                    <!--<label class="control-label" style="color: white;">Nombre de usuario: </label>-->
                                    <input type="text" class="form-control" id="username" name="user" 
                                           placeholder="usuario.." autocomplete="off" maxlength="15" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">   
                                    <!--<label  class="control-label" style="color: white;">Contrase&ntilde;a:  </label>-->
                                    <input  type="password" class="form-control" name="pass" 
                                            id="password" placeholder="contrase&ntilde;a.."/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="captchaOperation"></div>
                                        <input type="text" class="input-group form-control" name="captcha" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div> 
                                    <span id="msgbox" style="display:none"></span>
                                </div>
                                <hr />
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-info" disabled="disabled">
                                        <span class="glyphicon glyphicon-user"></span> &nbsp;Ingresar
                                    </button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="../assets/js/bootstrapValidator.js" type="text/javascript"></script>
        <script src="../assets/js/bootstrap.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('#username').focus();

                // Generate a simple captcha
                function randomNumber(min, max) {
                    return Math.floor(Math.random() * (max - min + 1) + min);
                }
                ;
                $('#captchaOperation').html([randomNumber(1, 25), '+', randomNumber(1, 25), '='].join(' '));
                $('#login').bootstrapValidator({
                    message: 'Valor incorrecto',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        user: {
                            validators: {
                                notEmpty: {message: 'Ingrese su identificaci&oacute;n'},
                                regexp: {
                                    regexp: /^[a-z]+$/i,
                                    message: 'Solo se permiten letras de la a-z y n&uacute;meros'}
                            }
                        },
                        pass: {
                            validators: {
                                regexp: {
                                    regexp: /^[a-z0-9]+$/i,
                                    message: 'Formato de contrase&ntilde;a no admitido'
                                },
                                notEmpty: {message: 'Ingrese la contrase&ntilde;a'}
                            }
                        },
                        captcha: {
                            validators: {
                                callback: {
                                    message: 'Respuesta incorrecta',
                                    callback: function (value, validator) {
                                        var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                                        return value == sum;
                                    }
                                }
                            }
                        }
                    }
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    var $form = $(e.target),
                            validator = $form.data('bootstrapValidator'),
                            submitButton = validator.getSubmitButton();

                    $("#msgbox").removeClass().addClass('messagebox').text('Validando los datos...').fadeIn(1000);

                    $.post("logueo.php", {username: $('#username').val(), password: $('#password').val(), rand: Math.random()}, function (data) {
                        if (data.trim() === "yes") { //if correct login detail
                            $("#msgbox").fadeTo(200, 0.1, function () {
                                $(this).html('Ingresando al sistema...').addClass('messageboxok').fadeTo(900, 1,
                                        function () { //redirect to secure page
                                            document.location = '../inicio';
                                        });
                            });
                        } else {
                            $("#msgbox").fadeTo(200, 0.1, function () {
                                $(this).html(data).addClass('messageboxerror').fadeTo(900, 1);
                            });
                        }
                    });

                });
            });
        </script>
    </body>
</html> 
