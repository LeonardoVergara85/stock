<?php

include_once '../ValueObject/VoCategorias.php';

/**
 * Description of MyCategorias
 *
 * @author Usuario
 */
class MyCategorias {

    public function buscarTodo() {
        $sql = "SELECT * FROM `categorias` WHERE `vigente` = 'si' ORDER BY orden;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aCategorias = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oCategorias = new VoCategorias();
                $oCategorias->setId($fila->id);
                $oCategorias->setNombre($fila->nombre);
                $oCategorias->setDescripcion($fila->descripcion);
                $oCategorias->setOrden($fila->orden);
                $oCategorias->setImagen($fila->imagen);
                $oCategorias->setOrden($fila->orden);
                $aCategorias[] = $oCategorias;
                unset($oCategorias);
            }
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoCategorias $categoria
     * @return \VoCategorias|boolean
     */
    public function buscarId($categoria) {
        $sql = "SELECT * FROM `categorias` WHERE `vigente` = 'si' AND id = ". $categoria->getId();
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aCategorias = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oCategorias = new VoCategorias();
                $oCategorias->setId($fila->id);
                $oCategorias->setNombre($fila->nombre);
                $oCategorias->setDescripcion($fila->descripcion);
                $oCategorias->setImagen($fila->imagen);
                $oCategorias->setOrden($fila->orden);
                $aCategorias[] = $oCategorias;
                unset($oCategorias);
            }
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

      /**
     * 
     * @param VoCategorias $categoria
     * @return \VoCategorias|boolean
     */
    public function buscarImagenes($categoria) {
        $sql = "SELECT * FROM `categoria_imagen` WHERE `activo` = 'S' AND id_categoria = ". $categoria->getId();
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aCategorias = array();
            $aux = 0;
            while ($fila = mysqli_fetch_object($resultado)) {

                $aCategorias[$aux][1] = $fila->id;
                $aCategorias[$aux][2] = $fila->id_categoria;
                $aCategorias[$aux][3] = $fila->imagen;
                $aCategorias[4] = $aux;
                $aux++;
                // unset($oCategorias);
            }
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

    public function buscarImagenes_($id) {
        $sql = "SELECT * FROM `categoria_imagen` WHERE `activo` = 'S' AND id_categoria = ". $id;
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aCategorias = array();
            $aux = 0;
            while ($fila = mysqli_fetch_object($resultado)) {

                $aCategorias[$aux][1] = $fila->id;
                $aCategorias[$aux][2] = $fila->id_categoria;
                $aCategorias[$aux][3] = $fila->imagen;

                $aux++;
                // unset($oCategorias);
            }
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

    public function buscarImagen($id) {
        $sql = "SELECT * FROM `categoria_imagen` WHERE `activo` = 'S' AND id = ". $id;
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($resultado) {
            $aCategorias = array();

       

                $aCategorias[1] = $fila->id;
                $aCategorias[2] = $fila->id_categoria;
                $aCategorias[3] = $fila->imagen;

 

            
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

     /**
     * 
     * @param VoCategorias $categoria
     * @return \VoCategorias|boolean
     */
    public function buscarImagenesTodo() {
        $sql = "SELECT * FROM `categoria_imagen` WHERE `activo` = 'S'";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aCategorias = array();
            $aux = 0;
            while ($fila = mysqli_fetch_object($resultado)) {

                $aCategorias[$aux][1] = $fila->id;
                $aCategorias[$aux][2] = $fila->id_categoria;
                $aCategorias[$aux][3] = $fila->imagen;
                $aCategorias[4] = $aux;
                $aux++;
                // unset($oCategorias);
            }
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

    public function buscarNombre($nombrec) {
        $sql = "SELECT `id`, `nombre`, `descripcion` FROM `categorias` "
                . "WHERE nombre = '" . $nombrec . "' AND `vigente` = 'si'  ORDER BY orden;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aCategorias = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oCategorias = new VoCategorias();
                $oCategorias->setId($fila->id);
                $oCategorias->setNombre($fila->nombre);
                $oCategorias->setDescripcion($fila->descripcion);
                $aCategorias[] = $oCategorias;
                unset($oCategorias);
            }
            return $aCategorias;
        } else {
            return FALSE;
        }
    }

    public function altaCategoria($nombre, $desc, $orden) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("INSERT INTO `categorias` (`id`, `nombre`, "
                . "`descripcion`, `vigente`, `orden`) VALUES (NULL, ?, ?, 'si', ?);");
        $sentencia->bind_param("ssi", $nombre, $desc, $orden);
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateImagen_($idc, $imgc) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("INSERT INTO categoria_imagen (id, id_categoria, imagen, activo) VALUES (NULL,?,?,'S');");
        $sentencia->bind_param("is", $idc, $imgc);
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateImagen($id, $img) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("UPDATE `categorias` SET `imagen` = ? "
                . "WHERE `categorias`.`id` = ?;");
        $sentencia->bind_param("si", $img, $id);
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function modCategoria($id, $nombre, $desc, $orden) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("UPDATE `categorias` SET `nombre` = ?, "
                . "`descripcion` = ?, orden = ? WHERE `categorias`.`id` = ?;");
        $sentencia->bind_param("ssii", $nombre, $desc, $orden, $id);
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function eliminarCategoria($id) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("UPDATE `categorias` SET `vigente` = 'no' "
                . "WHERE `categorias`.`id` = ?;");
        $sentencia->bind_param("i", $id);
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function eliminarImagen($id) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("UPDATE `categoria_imagen` SET `activo` = 'N' "
                . "WHERE `categoria_imagen`.`id` = ?;");
        $sentencia->bind_param("i", $id);
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
