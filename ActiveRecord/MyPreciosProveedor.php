<?php

include_once '../ValueObject/VoPreciosProveedor.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyPreciosProveedor
 *
 * @author ssrolanr
 */
class MyPreciosProveedor implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    public function borrar($oValueObject) {
        
    }

    /**
     * 
     * @param VoPreciosProveedor $oPrecioProv
     */
    public function buscar($oPrecioProv) {
        $sentence = "SELECT * FROM `precios_prod_prov` WHERE vigente = 'S' "
                . "AND idProdProv = " . $oPrecioProv->getIdPP() . ";";
//        echo $sentence;
        $result = mysqli_query($_SESSION['con'], $sentence);
        $file = mysqli_fetch_object($result);
        if ($file) {
            $oPrecioProv->setId($file->id);
            $oPrecioProv->setIdPP($file->idProdProv);
            $oPrecioProv->setPrecio($file->precio);
            $oPrecioProv->setFecha($file->fecha);
            $oPrecioProv->setPorcentaje($file->porcentaje);
            $oPrecioProv->setVigente($file->vigente);

            return $oPrecioProv;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoPreciosProveedor $oPrecioProv
     * @return boolean
     */
    public function buscarPrecioMasAlto($oPrecioProv) {
        $sentence = "SELECT MAX(precio*(1+(ganancia/100))) AS precio "
                . "FROM provprod p "
                . "INNER JOIN precios_prod_prov p1 ON p1.idProdProv = p.id "
                . "WHERE producto_id = " . $oPrecioProv->getIdPP()
                . " and baja = 0 and vigente = 'S';";

        $result = mysqli_query($_SESSION['con'], $sentence);
        $file = mysqli_fetch_object($result);
        if ($file) {
            $oPrecioProv->setPrecio($file->precio);
            return $oPrecioProv;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoPreciosProveedor $oPrecioProv
     */
    public function buscar2($oPrecioProv) {
        $sentence = "SELECT * FROM `precios_prod_prov` pr 
           INNER JOIN provprod pp ON (pr.idProdProv = pp.id)
           INNER JOIN productos pro ON (pro.id = pp.producto_id)
           WHERE pro.id = 111 ";
        $result = mysqli_query($_SESSION['con'], $sentence);
        $file = mysqli_fetch_object($result);
        if ($file) {
            $aPrecioProv = array();
            do {
                $oPrecioProv = new VoPreciosProveedor();
                $oPrecioProv->setId($file->id);
                $oPrecioProv->setIdPP($file->idProdProv);
                $oPrecioProv->setPrecio($file->precio);
                $oPrecioProv->setFecha($file->fecha);
                $oPrecioProv->setPorcentaje($file->porcentaje);
                $oPrecioProv->setVigente($file->vigente);
                $aPrecioProv[] = $oPrecioProv;
                unset($oPrecioProv);
            } while ($fila = mysqli_fetch_object($result));
            return $aPrecioProv;
        }
    }

    /**
     * 
     * @param VoPreciosProveedor $oPrecioProv
     */
    public function sacarVigencia($oPrecioProv) {
        $sentence = "UPDATE `precios_prod_prov` SET `vigente`= 'N' WHERE `idProdProv` = " . $oPrecioProv->getIdPP() . " AND `vigente` = 'S'";
        $result = mysqli_query($_SESSION['con'], $sentence);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function buscarTodo() {
        $sentence = "SELECT * FROM `precios_prod_prov` WHERE vigente = 'S'";
        $result = mysqli_query($_SESSION['con'], $sentence);
        $file = mysqli_fetch_object($result);
        if ($file) {
            $aPrecioProv = array();
            do {
                $oPrecioProv = new VoPreciosProveedor();
                $oPrecioProv->setId($file->id);
                $oPrecioProv->setIdPP($file->idProdProv);
                $oPrecioProv->setPrecio($file->precio);
                $oPrecioProv->setFecha($file->fecha);
                $oPrecioProv->setPorcentaje($file->porcentaje);
                $oPrecioProv->setVigente($file->vigente);
                $aPrecioProv[] = $oPrecioProv;
                unset($oPrecioProv);
            } while ($fila = mysqli_fetch_object($result));
            return $aPrecioProv;
        }
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @param VoPreciosProveedor $oPrecioProv
     * 
     */
    public function guardar($oPrecioProv) {
        $sentence = "UPDATE `precios_prod_prov` SET vigente = 'N' WHERE idProdProv = " . $oPrecioProv->getIdPP() . ";";
        mysqli_query($_SESSION['con'], $sentence);

        $sentence = "INSERT INTO `precios_prod_prov` (`id`, `idProdProv`, "
                . "`Precio`, `fecha`, `porcentaje`, `vigente`) "
                . "VALUES (NULL, " . $oPrecioProv->getIdPP() . ", " . $oPrecioProv->getPrecio() 
                . ",NOW(), " . $oPrecioProv->getPorcentaje() . ", 'S');";
        $resultado = mysqli_query($_SESSION['con'], $sentence);
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    }

}
