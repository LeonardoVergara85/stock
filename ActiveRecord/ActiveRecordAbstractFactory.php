<?php

require_once "MysqlActiveRecordAbstractFactory.php";

abstract class ActiveRecordAbstractFactory {

    // Lista de tipos de Active Record soportados por la factoria
    const MYSQL = 1;
    const PGSQL = 2;

    public abstract function getUsuarios();

    public abstract function getProductos();

    public abstract function getProveedores();

    public abstract function getPersonas();

    public abstract function getNiveles();

    public abstract function getMovimientos();

    public abstract function getFacturas();

    public abstract function getRemitos();

    public abstract function getPrecios();

    public abstract function getPresupuestos();

    public abstract function getDetallePresupuestos();

    public abstract function getProveedorProducto();

    public abstract function getPreciosProveedor();

    public abstract function getCategorias();
    
    public abstract function getOfertas();

    /**
     * Permite obtener la factoria de un Active Record.
     * 
     * @param integer $motor Se especifica el tipo de objeto a crear
     * @return object or false
     */
    public static function getActiveRecordFactory($motor = self::MYSQL) {
        switch ($motor) {
            case self::MYSQL:
                return new MysqlActiveRecordAbstractFactory();
            case self::PGSQL:
                return new PgsqlActiveRecordAbstractFactory();
            default:
                return false;
        }
    }

}
