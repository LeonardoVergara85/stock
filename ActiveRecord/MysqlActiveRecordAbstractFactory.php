<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
require_once '../ActiveRecord/MyUsuarios.php';
require_once '../ActiveRecord/MyProductos.php';
require_once '../ActiveRecord/MyProveedores.php';
require_once '../ActiveRecord/MyNiveles.php';
require_once '../ActiveRecord/MyPersonas.php';
require_once '../ActiveRecord/MyMovimientos.php';
require_once '../ActiveRecord/MyFacturas.php';
require_once '../ActiveRecord/MyRemitos.php';
require_once '../ActiveRecord/MyPrecios.php';
require_once '../ActiveRecord/MyPresupuestos.php';
require_once '../ActiveRecord/MyDetallePresupuestos.php';
require_once '../ActiveRecord/MyProvProd.php';
require_once '../ActiveRecord/MyPreciosProveedor.php';
require_once '../ActiveRecord/MyCategorias.php';
require_once '../ActiveRecord/MyOfertas.php';

class MysqlActiveRecordAbstractFactory extends ActiveRecordAbstractFactory {

    public static function getActiveRecordFactory($motor = self::MYSQL) {
        return parent::getActiveRecordFactory($motor);
    }

//    const HOST = 'mysql.hostinger.com.ar';
//    const PASS = 'St0ck_test';
//    const USER = 'u722144108_test';
//    const DB = 'u722144108_test';
    // const HOST = 'mysql.hostinger.com.ar';
    // const PASS = 'Elemporio_2018';
    // const USER = 'u722144108_stock';
    // const DB = 'u722144108_stock';
   const HOST = 'localhost';
   const PASS = '';
   const USER = 'root';
   const DB = 'stock';

    /**
     * Nos permite conectar al motor MySQL con los datos de
     * conexión especificados como constantes. Luego se hace
     * la selección de la base de datos.
     */
    public function conectar() {
        $conexion = new mysqli(self::HOST, self::USER, self::PASS, self::DB);
        $conexion->set_charset("utf8");
        if ($conexion->connect_error) {
            die("Error al conectar a la Base de Datos: " . $conexion->connect_error);
        } else {
            $_SESSION['con'] = $conexion;
        }
    }

    /**
     * 
     * @return \MyUsuarios
     */
    public function getUsuarios() {
        return new MyUsuarios();
    }

    /**
     * 
     * @return \MyProductos
     */
    public function getProductos() {
        return new MyProductos();
    }

    /**
     * 
     * @return \MyProveedores
     */
    public function getProveedores() {
        return new MyProveedores();
    }

    /**
     * 
     * @return \MyPersonas
     */
    public function getPersonas() {
        return new MyPersonas();
    }

    /**
     * 
     * @return \MyNiveles
     */
    public function getNiveles() {
        return new MyNiveles();
    }

    /**
     * 
     * @return \MyMovimientos
     */
    public function getMovimientos() {
        return new MyMovimientos();
    }

    /**
     * 
     * @return \MyFacturas
     */
    public function getFacturas() {
        return new MyFacturas();
    }

    /**
     * 
     * @return \MyRemitos
     */
    public function getRemitos() {
        return new MyRemitos();
    }

    /**
     * 
     * @return \MyPrecios
     */
    public function getPrecios() {
        return new MyPrecios();
    }

    /**
     * 
     * @return \MyPresupuestos
     */
    public function getPresupuestos() {
        return new MyPresupuestos();
    }

    /**
     * 
     * @return \MyDetallePresupuestos
     */
    public function getDetallePresupuestos() {
        return new MyDetallePresupuestos();
    }

    /**
     * 
     * @return \MyProvProd
     */
    public function getProveedorProducto() {
        return new MyProvProd();
    }

    /**
     * 
     * @return \MyPreciosProveedor
     */
    public function getPreciosProveedor() {
        return new MyPreciosProveedor();
    }

    /**
     * 
     * @return \MyCategorias
     */
    public function getCategorias() {
        return new MyCategorias();
    }

    /**
     * 
     * @return \MyOfertas
     */
    public function getOfertas() {
        return new MyOfertas();
    }

}
