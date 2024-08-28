<?php

require_once __DIR__ . '/../config/database.php';

class Sucursal {
    private $conexion;
    private $tabla = "sucursales";

    public $id;
    public $nombre;
    public $bodega_id;

    public function __construct() {
        $database = new BaseDeDatos();
        $this->conexion = $database->obtenerConexion();
    }

    public function obtenerPorBodega($bodega_id) {
        $query = "SELECT id, nombre FROM " . $this->tabla . " WHERE bodega_id = :bodega_id";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(":bodega_id", $bodega_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
