<?php
extract($_POST, EXTR_OVERWRITE);

require './lib/mercadopago.php';

$mp = new MP('3734020225628843', 'YyrQHiXYOACSs5DHo2ewgIwT6lpVQNKN'); // IE

$preference_data = array(
    "items" => array(
        array(
            "title" => "Pago de insumos vía Mercado Pago",
            "quantity" => 1,
            "currency_id" => "ARS",
            "unit_price" => (float) $precioPresupuesto
//            "unit_price" => (float) str_replace('.', ',', $precioPresupuesto)
        )
    ),
    "payer" => array(
        "email" => 'elemporioelectricidad@gmail.com',
    ),
//    "back_urls" => array(
//        "success" => "http://campus-ie.com.ar/campus/pagos/edit/" . $pago['Pago']['id'] . "/mp",
//        "failure" => "http://campus-ie.com.ar/campus/",
//        "pending" => "http://campus-ie.com.ar/campus/pagos/view/" . $pago['Pago']['id']
//    ),
    // para que retorne automaticamente a la pagina del instituto, si el pago es acreditado
//    "auto_return" => "approved",
    // script que procesa las notificaciones
    // dentro de la estructura de directorios, esta dentro de app/webroot
//    "notification_url" => "http://campus-ie.com.ar/campus/ipn.php",
    // external_reference tiene el id de pago que usa nuestro sistema
//    "external_reference" => $pago['Pago']['id'],
    "payment_methods" => array(
        // bapropagos esta dentro del tipo de pago ticket, pero queremos excluirlo
        "excluded_payment_methods" => array(
            array(
                "id" => "bapropagos",
            )
        ),
        /* tipos de pago que se pueden excluir

          account_money	dinero en la cuenta de mercadopago
          ticket			pagofacil, rapipago
          bank_transfer	transferencia bancaria
          atm				cajero automatico
          credit_card		tarjeta de credito
          debit_card		tarjeta de debito
          prepaid_card	tarjeta prepago

          "excluded_payment_types" => array(
          array(
          "id" => "credit_card"
          ),
          array(
          "id" => "debit_card"
          )
          ),
         */
        "default_payment_method_id" => "rapipago",
    ),
);


$preference = $mp->create_preference($preference_data);
?>

<a class="btn btn-xs btn-primary" href="<?php echo $preference['response']['init_point']; ?>">Mercadopago</a>
