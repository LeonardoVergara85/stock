<?php

include_once '../ValueObject/VoProvProd.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyProvProd
 *
 * @author Usuario
 */
class MyProvProd implements ActiveRecord {

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function actualizar($oPp) {
        $sentence = "UPDATE provprod SET ganancia = '" . $oPp->getGanancia()
                . "', baja = 0 WHERE proveedor_id = " . $oPp->getProveedor_id()
                . " AND producto_id = " . $oPp->getProducto_id() . ";";

        if (mysqli_query($_SESSION['con'], $sentence)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function borrar($oPp) {
        $sentence = "UPDATE provprod SET baja = 1 WHERE proveedor_id = " .
                $oPp->getProveedor_id() . " AND producto_id IN(" .
                $oPp->getProducto_id() . ");";
        if (mysqli_query($_SESSION['con'], $sentence)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function buscar($oPp) {
        $sentence = "SELECT pp.id, pp.proveedor_id, pp.producto_id, pp.ganancia, "
                . "pp.baja, p.nombre, ps.descripcion, ps.cod_barra, ps.punto_reposicion, "
                . "prepp.id as idpre, prepp.idProdProv, prepp.precio, "
                . "DATE_FORMAT(prepp.fecha, '%d/%m/%Y') AS fecha, prepp.porcentaje, "
                . "prepp.vigente FROM provprod pp "
                . "INNER JOIN proveedores p ON p.id = pp.proveedor_id "
                . "INNER JOIN productos ps ON ps.id = pp.producto_id "
                . "LEFT JOIN precios_prod_prov prepp ON pp.id = prepp.idProdProv "
                . "WHERE pp.proveedor_id = " . $oPp->getProveedor_id()
                . " AND (prepp.vigente = 'S' OR prepp.vigente is null)";
        $result = mysqli_query($_SESSION['con'], $sentence);
        if ($result) {
            $aproductos = array();
            while ($fila = mysqli_fetch_object($result)) {
                $oProvProd = new VoProvProd();
                $oProd = new VoProductos();
                $oProv = new VoProveedores();
                $oPP = new VoPreciosProveedor();
                $oProvProd->setId($fila->id);
                $oProvProd->getProveedor_id($fila->proveedor_id);
                $oProvProd->getProducto_id($fila->producto_id);
                $oProvProd->getGanancia($fila->ganancia);
                $oProd->setDescripcion($fila->descripcion);
                $oProd->setCod_barra($fila->cod_barra);
                $oProd->setPunto_reposicion($fila->punto_reposicion);
                $oProv->setNombre($fila->nombre);
                $oPP->setPrecio($fila->precio);
                $oPP->setPorcentaje($fila->porcentaje);
                $oPP->setFecha($fila->fecha);
                $oProvProd->setProducto($oProd);
                $oProvProd->setProveedor($oProv);
                $oProvProd->setPrecio($oPP);
                $aproductos[] = $oProvProd;
                unset($oProvProd);
                unset($oProd);
                unset($oProv);
                unset($oPP);
            }
            return $aproductos;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function buscarId($oPp) {
        $sentence = "SELECT * FROM provprod "
                . "WHERE id = " . $oPp->getId() . ";";
        
        $result = mysqli_query($_SESSION['con'], $sentence);
        $fila = mysqli_fetch_object($result);
        if ($fila) {
            $oPp->setId($fila->id);
            $oPp->setProducto_id($fila->producto_id);
            $oPp->setGanancia($fila->ganancia);

            return $oPp;
        } else {
            return FALSE;
        }
    }

    public function buscarTodo() {
        
    }

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function buscarPrecioHistorico($oPp) {
        $sentence = "SELECT pre.id, pre.idProdProv, pre.precio, "
                . "DATE_FORMAT(pre.fecha, '%d/%m/%Y') AS fecha, pre.porcentaje, "
                . "pre.vigente, pp.proveedor_id, pp.producto_id, pp.ganancia, "
                . "prov.nombre, prod.cod_barra, prod.descripcion "
                . "FROM precios_prod_prov pre "
                . "INNER JOIN provprod pp ON (pre.idProdProv = pp.id) "
                . "INNER JOIN proveedores prov ON (pp.proveedor_id = prov.id) "
                . "INNER JOIN productos prod ON (pp.producto_id = prod.id) "
                . "WHERE pp.producto_id = " . $oPp->getProducto_id()
                . " ORDER BY prov.nombre ASC, pre.fecha DESC";
        $result = mysqli_query($_SESSION['con'], $sentence);
        if ($result) {
            $aproductos = array();
            while ($fila = mysqli_fetch_object($result)) {
                $oProvProd = new VoProvProd();
                $oProd = new VoProductos();
                $oProv = new VoProveedores();
                $oPP = new VoPreciosProveedor();
                $oProvProd->setId($fila->id);
                $oProvProd->getProveedor_id($fila->proveedor_id);
                $oProvProd->getProducto_id($fila->producto_id);
                $oProvProd->getGanancia($fila->ganancia);
                $oProd->setDescripcion($fila->descripcion);
                $oProd->setCod_barra($fila->cod_barra);
                $oProv->setNombre($fila->nombre);
                $oPP->setPrecio($fila->precio);
                $oPP->setPorcentaje($fila->porcentaje);
                $oPP->setFecha($fila->fecha);
                $oPP->setVigente($fila->vigente);
                $oProvProd->setProducto($oProd);
                $oProvProd->setProveedor($oProv);
                $oProvProd->setPrecio($oPP);
                $aproductos[] = $oProvProd;
                unset($oProvProd);
                unset($oProd);
                unset($oProv);
                unset($oPP);
            }
            return $aproductos;
        } else {
            return FALSE;
        }
    }

    public function contar() {
        
    }

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function existe($oPp) {
        $sentence = "SELECT * FROM provprod WHERE proveedor_id = "
                . $oPp->getProveedor_id() . " AND producto_id = " . $oPp->getProducto_id() . ";";
        $result = mysqli_query($_SESSION['con'], $sentence);
        $file = mysqli_fetch_object($result);
        if ($file) {
            $oPp->setId($file->id);
            $oPp->setBaja($file->baja);
            $oPp->setGanancia($file->ganancia);
            return $oPp;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProvProd $oPp
     * @return boolean
     */
    public function guardar($oPp) {
        $sentence = "INSERT INTO provprod (proveedor_id, producto_id, ganancia) "
                . "VALUES(" . $oPp->getProveedor_id() . ", "
                . $oPp->getProducto_id() . ", '" . $oPp->getGanancia() . "')";

        if (mysqli_query($_SESSION['con'], $sentence)) {
            $result = mysqli_query($_SESSION['con'], "SELECT DISTINCT LAST_INSERT_ID() FROM provprod;");
            $id = mysqli_fetch_array($result);
            if ($id[0] <> 0) {
                $oPp->setId($id[0]);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
