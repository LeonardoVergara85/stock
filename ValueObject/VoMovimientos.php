<?php

/**
 * Description of VOMovimientos
 *
 * @author ssrolanr
 */
class VoMovimientos {

    private $id, $producto_id, $cantidad, $tipo_mov_id, $remito_id, $factura_id,
            $fecha, $usuario_id, $producto, $remito, $usuario, $proveedor, $comentario;

    function getId() {
        return $this->id;
    }

    function getProducto_id() {
        return $this->producto_id;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getTipo_mov_id() {
        return $this->tipo_mov_id;
    }

    function getRemito_id() {
        return $this->remito_id;
    }

    function getFactura_id() {
        return $this->factura_id;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function getProducto() {
        return $this->producto;
    }

    function getRemito() {
        return $this->remito;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getProveedor() {
        return $this->proveedor;
    }

    function getComentario() {
        return $this->comentario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProducto_id($producto_id) {
        $this->producto_id = $producto_id;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setTipo_mov_id($tipo_mov_id) {
        $this->tipo_mov_id = $tipo_mov_id;
    }

    function setRemito_id($remito_id) {
        $this->remito_id = $remito_id;
    }

    function setFactura_id($factura_id) {
        $this->factura_id = $factura_id;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    function setProducto($producto) {
        $this->producto = $producto;
    }

    function setRemito($remito) {
        $this->remito = $remito;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

}
