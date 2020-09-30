<?php


// limpio la palabra que se busca
$search= trim($_GET['search']);

// la busco 
$result= search($search);

// seteo la cabecera como json
header('Content-type: application/json; charset=utf-8');

//imprimo el resultado como un json
echo json_encode($result);


/**
 *  Funcion que busca en los datos un resultado  que tenga que ver
 *  con la busqueda, si los datos vinieran de base no seria necesario esto
 *  ya que lo podriamos resolver directamente por sql
 */
function search($searchWord)
{
    $tmpArray=array();
    /**
     * Obtengo los datos almacenados en el array
     */
    $data=getData();
    
    /*
     * Recorro el array para ver si hay palabras que empiecen con lo que viene
     * por parametros
     */
    foreach($data as $word)
    {
        // obtengo el tamaño de la palabra que se busca.
        $searchWordSize=strlen($searchWord);
        // corto la palabra que viene del array y la dejo del mismo tamaño que 
        // la que se busca de manera de poder comparar.
        $tmpWord=substr($word, 0,$searchWordSize);
        // si son iguales la guardo para devolverla
        if (strtolower($tmpWord) == strtolower($searchWord))
        {
            // guardo la palabra original sin cortar.
            $tmpArray[]=$word;
        }
    }
    
    return $tmpArray;
}


/**
 * Retorna los datos, podria ser una base de datos
 * para simplificar solo hice esta funcion que devuelve
 * un array ordenado
 */
function getData()
{   require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
    $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);

    $oMysql->conectar();
    $oProv = $oMysql->getProveedores(); 
    $oVoProv = new VoProveedores();
    $oVoProv = $oProv->buscar();

    $result=array();
    foreach ($oVoProv as $value) {
        $result[]=$value->getNombre();
    }
    
    
    asort($result);
    return $result;
}