$(document).ready(function () {

 $("#cont").val(1);

});

function openDivs(){
	var contador = $("#cont").val(); 
	if(contador < 5){
		contador++;
        $("#cont").val(contador);
        if(contador > 1){
        	$('#close').show();
        	switch (contador) {
        		case 2:
        		$('#div'+contador).show();
        		$('#dniCliente').prop( "disabled", true );
        		$('#nombreCliente').prop( "disabled", true );
        		$('#apellidoCliente').prop( "disabled", true );
        		break;
        		case 3:
        		$('#div'+contador).show();
        		$('#domicilioCliente').prop( "disabled", true );
        		$('#telefonoCliente').prop( "disabled", true );
        		$('#fechaNacCliente').prop( "disabled", true );
        		break;
        		case 4:
        		$('#div'+contador).show();
        		$('#correoCliente').prop( "disabled", true );
        		break;
        		case 5:
        		$('#div'+contador).show();
        		$('#provinciaCliente').prop( "disabled", true );
        		$('#localidadCliente').prop( "disabled", true );
        		break;
        	}	
        }else{
        	$('#close').hide();
        }
	}
	
}

function closeDivs(){
	var contador = $("#cont").val();
	if(contador > 1){
        if(contador > 1){
        	// $('#close').show();
        	switch (contador) {
        		case 2:
        		alert(2);
        		$('#div'+contador).hide();
        		$('#dniCliente').prop( "disabled", false );
        		$('#nombreCliente').prop( "disabled", false );
        		$('#apellidoCliente').prop( "disabled", false );
        		break;
        		case 3:
        		alert(3);
        		$('#div'+contador).hide();
        		$('#domicilioCliente').prop( "disabled", false );
        		$('#telefonoCliente').prop( "disabled", false );
        		$('#fechaNacCliente').prop( "disabled", false );
        		break;
        		case 4:
        		alert(4);
        		$('#div'+contador).hide();
        		$('#correoCliente').prop( "disabled", false );
        		break;
        		case 5:
        		alert(5);
        		$('#div'+contador).hide();
        		$('#provinciaCliente').prop( "disabled", false );
        		$('#localidadCliente').prop( "disabled", false );
        		break;
        	}
        }else{
        	$('#close').hide();
        }
      contador--;  
     $("#cont").val(contador);   
	}
}
