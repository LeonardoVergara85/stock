<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
session_name('stock');
session_start();
if ($_SESSION['Nivel_id'] == 2) {
    session_abort();
    header('location: ../stock/index_2.php');
}
session_abort();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php include_once '../assets/php/header.php'; ?>
        <?php include_once '../assets/php/footer.php'; ?>
    </body>
</html>
