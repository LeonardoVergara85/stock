<?php
include_once '../ValueObject/VoNiveles.php';

/**
 * Description of MyPersonas
 *
 * @author Usuario
 */

/**
* 
*/
class MyNiveles{
	public function buscar(){
		$sql = "SELECT * from niveles";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aNivel = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oNivel = new VoNiveles();
                $oNivel->setId($fila->id);
                $oNivel->setDescripcion($fila->descripcion);
                $aNivel[] = $oNivel;
                unset($oNivel);
            }
            return $aNivel;
        } else {
            return FALSE;
        }
	}
}