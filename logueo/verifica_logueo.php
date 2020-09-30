<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
if (!isset($_SESSION['id'])) {
    header("location: ../logueo/salir.php");
}

if (!isset($_SESSION['nombre'])) {
    header("location: ../logueo/salir.php");
}

if (!isset($_SESSION['Nivel_id'])) {
    header("location: ../logueo/salir.php");
}
