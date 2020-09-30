<?php

include_once '../ValueObject/VoRemitos.php';
include_once '../ValueObject/VoProveedores.php';
include_once '../ValueObject/VoUsuarios.php';

/**
 * Description of MyRemitos
 *
 * @author Usuario
 */

/**
 * 
 */
class MyRemitos {

    public function buscar() {
        $sql = "select r.id,r.proveedor_id,r.numero,DATE_FORMAT(r.fecha, '%d/%m/%Y') AS fecha,r.usuario_id,r.fecha_baja,p.nombre,p.telefono,p.domicilio,
p.correo,p.cuit,p.comentario,u.nombre as nomusu,u.nivel_id
from remitos r, proveedores p, usuarios u
where r.proveedor_id = p.id and r.usuario_id = u.id";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aRemitos = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oRemito = new VoRemitos();
                $oProv = new VoProveedores();
                $oUsu = new VoUsuarios();
                $oRemito->setId($fila->id);
                $oRemito->setProveedor_id($fila->proveedor_id);
                $oRemito->setNumero($fila->numero);
                $oRemito->setFecha($fila->fecha);
                $oRemito->setUsuario_id($fila->usuario_id);
                $oRemito->setFecha_baja($fila->fecha_baja);
                $oProv->setNombre($fila->nombre);
                $oUsu->setNombre($fila->nomusu);
                $oRemito->setProveedor($oProv);
                $oRemito->setUsuario($oUsu);
                $aRemitos[] = $oRemito;
                unset($oRemito);
                unset($oProv);
                unset($oUsu);
            }
            return $aRemitos;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoRemitos $oRemitos
     * @return VoRemitos
     */
    public function guardar($oRemitos) {
        $sql = "INSERT INTO `remitos` (`id`, `proveedor_id`, `numero`, `fecha`, `usuario_id`, `fecha_baja`) VALUES (NULL, '" . $oRemitos->getProveedor_id() . "', '" . $oRemitos->getNumero() . "', '" . $oRemitos->getFecha() . "', '" . $oRemitos->getUsuario_id() . "', '');";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $sqlid = "SELECT MAX(id) AS id FROM remitos";
            $resultadoid = mysqli_query($_SESSION['con'], $sqlid);

            if ($resultadoid) {
                $row = mysqli_fetch_assoc($resultadoid);
                $idR = $row['id'];
            }
            return $idR;
        } else {
            return FALSE;
        }
    }




    /**
     * 
     * @param VoRemitos $oRemitos
     * @return VoRemitos
     */
    public function buscarDetalle($oRemitos) {
    $sql = "select m.id,m.producto_id,m.cantidad,m.tipo_mov_id,m.remito_id,m.fecha,m.usuario_id,
                u.nombre,u.nivel_id, n.descripcion,p.descripcion,p.cod_barra,tm.descripcion 
                from movimientos m
                inner join usuarios u on (m.usuario_id = u.id)
                inner join niveles n on (u.nivel_id = n.id)
                inner join productos p on (m.producto_id = p.id)
                inner join tipo_mov tm on (m.tipo_mov_id = tm.id)
                where remito_id = ".$oRemitos->getId()." ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aRemitos = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oRemito = new VoRemitos();
                $oProv = new VoProveedores();
                $oUsu = new VoUsuarios();
                $oRemito->setId($fila->id);
                $oRemito->setProveedor_id($fila->proveedor_id);
                $oRemito->setNumero($fila->numero);
                $oRemito->setFecha($fila->fecha);
                $oRemito->setUsuario_id($fila->usuario_id);
                $oRemito->setFecha_baja($fila->fecha_baja);
                $oProv->setNombre($fila->nombre);
                $oUsu->setNombre($fila->nomusu);
                $oRemito->setProveedor($oProv);
                $oRemito->setUsuario($oUsu);
                $aRemitos[] = $oRemito;
                unset($oRemito);
                unset($oProv);
                unset($oUsu);
            }
            return $aRemitos;
        } else {
            return FALSE;
        }
    }

}
