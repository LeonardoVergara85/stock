<?php //include_once '../login/validarSesion.php';                ?>
<nav class="navbar navbar-btn navbar-collapse" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img src="../assets/php/ems.jpg" width="40px" alt=""/>
            <a class="navbar-brand" href="#">
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1" name="navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="../emergencia" class="dropdown-toggle">Emergencia</a>
                </li>

                <li>
                    <a href="../despacho" class="dropdown-toggle">Despacho</a>
                </li>

                <li><a href="../unidades/listadoUnidades.php" class="dropdown-toggle">Moviles</a></li>
                
                <li>
                    <a href="../nota" class="dropdown-toggle">Libro Guardia</a>
                </li>
                <li>
                    <a href="../agenda" class="dropdown-toggle">Agenda</a>
                </li>

                <?php if ($_SESSION['permiso'] == 'Z') { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Basica<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../unidades" class="dropdown-toggle">Unidades</a></li>
                            <li><a href="../unidades/estados.php" class="dropdown-toggle">Estados de Unidades</a></li>
                            <li><a href="../motivo">Motivo</a></li>
                            <!--                            <li><a href="../naturaleza">Naturaleza</a></li>
                                                        <li><a href="../severidad">Severidad</a></li>-->
                            <!--<li><a href="../zona">Zonas</a></li>-->
                        </ul>
                    </li>
                <?php } ?>

                <li>
                    <a href="../informes" class="dropdown-toggle">Ficha</a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Informes<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="../informes/estadistico.php" class="dropdown-toggle">Estadistico</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo $_SESSION['nombre']; ?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="../logueo/cambio_clave.php">Cambio Clave</a></li>
                        <?php if ($_SESSION['permiso'] == 'Z') { ?>
                            <li><a href="../usuarios">Administraci&oacute;n Usuarios</a></li>
                        <?php } ?>
                        <li><hr></li>
                        <li><a href="../logueo/salir.php">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>