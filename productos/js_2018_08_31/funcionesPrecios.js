$(document).ready(function () {

});

function verhistorico(idprod){
 var idproducto = idprod;
 var tipoac = "preciosHistoricos";
 $('#cuerpoPrecioHist').empty();
   $.ajax({
           url: './procesoReajuste.php',
           dataType: "json",
           type: "POST",
           data: {
                  tipo : tipoac,
                  idp : idproducto
                },
           success: function (resp) {
            if(resp.length == 0){
              alertify.error("No tiene precios históricos.");
              return false;
             }
             var v = '';
              /*console.log(resp);*/
              for (var i = 1; i <= resp['cant']; i++) {
                if(resp['vig'][i] == 'S'){v = "<font color ='green'>Si</font>";}
                  else{v = "<font color ='red'>No</font>";}
                $('#nomprod').html('<h4>'+resp['codprod'][i]+' - '+resp['nomprod'][i]+'</h4>');
                $('#cuerpoPrecioHist').append("<tr><td style='display: none;'>"+resp['id'][i]+"</td><td class='text-left'><strong>"+resp['nomp'][i]+"</strong></td><td>"+resp['fechap'][i]+"</td><td>% "+resp['porc'][i]+"</td><td> $ "+resp['precio'][i]+"</td><td>"+v+"</td></tr>");
              }
              
              $('#modalHistoriPrecios').modal('show');
           }
    });
}

function verhistoricoPDF(idp){
 var id = idp;
 window.open("preciosHistoricosPDF.php?idp=" + id + "", '_blank');
}