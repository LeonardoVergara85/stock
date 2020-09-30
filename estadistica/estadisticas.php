<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script type="text/javascript" src="https://unpkg.com/fusioncharts@3.12.0/fusioncharts.js"></script>
    <script type="text/javascript" src="https://unpkg.com/fusioncharts@3.12.0/fusioncharts.charts.js"></script>
    <script type="text/javascript" src="https://unpkg.com/fusioncharts@3.12.0/themes/fusioncharts.theme.fint.js"></script>
    <script type="text/javascript" src="https://rawgit.com/fusioncharts/fusioncharts-jquery-plugin/feature/node-commonjs-support/package/fusioncharts-jquery-plugin.js"></script>
</head>
<body>

    <div id="chart-container">FusionCharts will render here...</div>
    <br><br>
    <div id="chart-container2">FusionCharts will render here...</div>
    <br><br>
    <div id="chart-container3">FusionCharts will render here...</div>
    
    <script type="text/javascript">
        jQuery('document').ready(function () {
            $("#chart-container").insertFusionCharts({
                type: "column3d",
                width: "500",
                height: "300",
                dataFormat: "json",
                dataSource: {
                    "chart": {
                        "caption": "Productos más vendidos",
                        "xAxisName": "Productos",
                        "yAxisName": "Cantidad",
                        "theme": "fint"
                    },
                    "data": [{
                        "label": "Foco Led Phillips",
                        "value": "10.500"
                    }, {
                        "label": "Lampara Phillips 12v",
                        "value": "9.850"
                    }, {
                        "label": "Baterias DS",
                        "value": "6.200"
                    }]
                }
            });
             $("#chart-container2").insertFusionCharts({
                type: "column2d",
                width: "500",
                height: "300",
                dataFormat: "json",
                dataSource: {
                    "chart": {
                        "caption": "Yearly revenue",
                        "xAxisName": "Year",
                        "yAxisName": "Revenues",
                        "numberPrefix": "$",
                        "theme": "fint"
                    },
                    "data": [{
                        "label": "2015",
                        "value": "5548900"
                    }, {
                        "label": "2016",
                        "value": "8100000"
                    }, {
                        "label": "2017",
                        "value": "7200000"
                    }]
                }
            });

     $("#chart-container3").insertFusionCharts({
        var num = 8000;
        type: "pie3d",
        width: "400",
        height: "350",
        dataFormat: "json",
        dataSource: {
             chart: {
        caption: "Age profile of website visitors",
        subcaption: "Last Year",
        startingangle: "120",
        showlabels: "0",
        showlegend: "1",
        enablemultislicing: "0",
        slicingdistance: "15",
        showpercentvalues: "1",
        showpercentintooltip: "0",
        plottooltext: "Age group : $label Total visit : $datavalue",
        theme: "fint"
    },
    data: [
        {
            label: "Teenage",
            value: "1250400"
        },
        {
            label: "Adult",
            value: "1463300"
        },
        {
            label: "Mid-age",
            value: "1050700"
        },
        {
            label: "Senior",
            value: "491000"
        }
    ]
        }
    });   
        });     
    </script>
</body>
</html>