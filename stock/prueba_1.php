<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>autocomplete demo</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link href="../assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="../assets/js/bootstrap-select.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <label for="autocomplete">Select a programming language: </label>
        <input id="autocomplete">

        <script>
            $("#autocomplete").autocomplete({
                source: ["c++", "java", "php", "coldfusion", "javascript", "asp", "ruby"]
            });
        </script>


        <select class="selectpicker" data-live-search="true">
            <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
            <option data-tokens="mustard">Burger, Shake and a Smile</option>
            <option data-tokens="frosting">Sugar, Spice and all things nice</option>
        </select>

    </body>
</html>