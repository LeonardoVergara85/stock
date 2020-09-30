<?php

include_once '../ValueObject/VoMovimientos.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyMovimientos
 *
 * @author ssrolanr
 */
class MyMovimientos implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    public function borrar($oValueObject) {
        
    }

    public function buscar($oValueObject) {
        
    }

    public function buscarTodo() {
        
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @param VoMovimientos $oMov
     * @return boolean
     */
    public function guardar($oMov) {
        $sql = "INSERT INTO movimientos (producto_id, cantidad, tipo_mov_id, "
                . "remito_id, factura_id, usuario_id, comentario) "
                . "VALUES(" . $oMov->getProducto_id() . ','
                . $oMov->getCantidad() . ',' . $oMov->getTipo_mov_id() . ','
                . $oMov->getRemito_id() . ',' . $oMov->getFactura_id() . ','
                . $oMov->getUsuario_id() . ",'" . $oMov->getComentario() . "')";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoMovimientos $oMov
     * @return VoMovimientos
     */
    public function buscarMov($oMov) {
        $sql = "SELECT m.id, m.producto_id, m.cantidad, m.tipo_mov_id, m.remito_id,"
                . " m.factura_id, m.fecha, m.usuario_id, p.cod_barra,p.descripcion, "
                . "p.umed_id, p.paquete, p.punto_reposicion FROM `movimientos` m, "
                . "`productos` p WHERE m.producto_id = p.id and m.id = " . $oMov->getId() . ";";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aMovi = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oMov = new VoMovimientos();
                $oMov->setId($fila->id);
                $aMovi[] = $oMov;
                unset($oMov);
            }
            return $aMovi;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @return VoMovimientos
     */
    public function buscarFactura() {
        $sql = "SELECT factura_id, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, CONCAT(p.nombre,' ', p.apellido) AS usuario FROM movimientos m "
                . "LEFT JOIN usuarios u ON u.id = m.usuario_id "
                . "LEFT JOIN personas p ON p.id = persona_id "
                . "WHERE tipo_mov_id = 3 GROUP BY factura_id, fecha, m.usuario_id "
                . "ORDER BY factura_id DESC;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $aMovi = array();
            do {
                $oMov = new VoMovimientos();
                $oMov->setFactura_id($fila->factura_id);
                $oMov->setFecha($fila->fecha);
                $oMov->setUsuario($fila->usuario);
                $aMovi[] = $oMov;
                unset($oMov);
            } while ($fila = mysqli_fetch_object($resultado));
            return $aMovi;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoMovimientos $oMov
     * @return VoMovimientos
     */
    public function buscarMovRemitos($oMov) {
        $sql = "select m.id, m.producto_id, m.cantidad, m.tipo_mov_id, m.remito_id, "
                . "m.fecha, m.usuario_id, u.nombre,u.nivel_id, n.descripcion as nivel, "
                . "p.descripcion as nomp, p.cod_barra, tm.descripcion, r.numero, "
                . "DATE_FORMAT(r.fecha, '%d/%m/%Y') AS fechar, r.proveedor_id, "
                . "pv.nombre as nompro,pv.cuit, pv.domicilio, pv.telefono, "
                . "pv.correo "
                . "FROM movimientos m "
                . "inner join usuarios u on (m.usuario_id = u.id) "
                . "inner join niveles n on (u.nivel_id = n.id) "
                . "inner join productos p on (m.producto_id = p.id) "
                . "inner join tipo_mov tm on (m.tipo_mov_id = tm.id) "
                . "inner join remitos r on (m.remito_id = r.id) "
                . "inner join proveedores pv on (r.proveedor_id = pv.id) "
                . "WHERE remito_id = " . $oMov->getRemito_id() . " ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aMovi = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oMov = new VoMovimientos();
                $oProd = new VoProductos();
                $oRem = new VoRemitos();
                $oUsu = new VoUsuarios();
                $oProv = new VoProveedores();
                $oMov->setId($fila->id);
                $oMov->setProducto_id($fila->producto_id);
                $oMov->setCantidad($fila->cantidad);
                $oMov->setTipo_mov_id($fila->tipo_mov_id);
                $oMov->setRemito_id($fila->remito_id);
                $oMov->setFecha($fila->fecha);
                $oMov->setUsuario_id($fila->usuario_id);
                $oProd->setDescripcion($fila->nomp);
                $oProd->setCod_barra($fila->cod_barra);
                $oMov->setProducto($oProd);
                $oRem->setNumero($fila->numero);
                $oRem->setFecha($fila->fechar);
                $oMov->setRemito($oRem);
                $oUsu->setNombre($fila->nombre);
                $oMov->setUsuario($oUsu);
                $oProv->setNombre($fila->nompro);
                $oProv->setCuit($fila->cuit);
                $oProv->setDomicilio($fila->domicilio);
                $oProv->setTelefono($fila->telefono);
                $oProv->setCorreo($fila->correo);
                $oMov->setProveedor($oProv);
                $aMovi[] = $oMov;
                unset($oMov);
                unset($oProd);
                unset($oRem);
                unset($oUsu);
            }
            return $aMovi;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoMovimientos $oMov
     * @return VoMovimientos
     */
    public function buscarMovReajustes() {
        $sql = "select m.id,m.producto_id,m.cantidad,m.tipo_mov_id,DATE_FORMAT(m.fecha, '%d/%m/%Y %H:%i:%s') AS fecha,m.usuario_id,m.comentario,
                u.nombre,u.nivel_id,p.descripcion as nomp,p.cod_barra,p.punto_reposicion,tm.descripcion
                from movimientos m
                inner join usuarios u on (m.usuario_id = u.id)
                inner join productos p on (m.producto_id = p.id)
                inner join tipo_mov tm on (m.tipo_mov_id = tm.id)
                where m.factura_id = 0 and m.remito_id = 0";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aMovi = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oMov = new VoMovimientos();
                $oProd = new VoProductos();
                $oUsu = new VoUsuarios();
                $oMov->setId($fila->id);
                $oMov->setProducto_id($fila->producto_id);
                $oMov->setCantidad($fila->cantidad);
                $oMov->setTipo_mov_id($fila->tipo_mov_id);
                $oMov->setFecha($fila->fecha);
                $oMov->setUsuario_id($fila->usuario_id);
                $oMov->setComentario($fila->comentario);
                $oProd->setDescripcion($fila->nomp);
                $oProd->setCod_barra($fila->cod_barra);
                $oMov->setProducto($oProd);
                $oUsu->setNombre($fila->nombre);
                $oMov->setUsuario($oUsu);
                $aMovi[] = $oMov;
                unset($oMov);
                unset($oProd);
                unset($oUsu);
            }
            return $aMovi;
        } else {
            return FALSE;
        }
    }

}
