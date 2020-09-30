

<!-- <br><br>
<div>
	<form action="restore.php" method="POST">
	<input type="file" name="ficheroDeCopia" id="ficheroDeCopia">
	<button> Importar</button>
	</form>
	
</div> -->

<!DOCTYPE html>
<html>
    <head>
        <title>Respaldo de Datos</title>
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading panel-title">Respaldo de Datos</div>
                <div class="panel-body">
                   <button class="btn btn-primary" onclick="window.location.href='backup.php'">Realizar Backup</button>	
                </div>
             </div>
            </div>
        </div>
        <!--<script src="../assets/datatable/jquery-1.11.2.min.js" type="text/javascript"></script>-->
        <?php include_once '../assets/php/footer.php'; ?>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
    </body>
</html>