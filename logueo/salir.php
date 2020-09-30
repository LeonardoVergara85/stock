<?php

session_name('stock');

session_start();

unset($_SESSION['id']);

unset($_SESSION['nombre']);

unset($_SESSION['permiso']);

unset($_SESSION['idjurisdicciones']);

session_destroy();

header("location: index.php");
