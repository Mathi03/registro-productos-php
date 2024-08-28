<?php

require_once __DIR__ . '/../config/database.php';

class Moneda {
    private $conexion;
    private $tabla = "monedas";

    public $id;
    public $nombre;

    public function __construct() {
        $database = new BaseDeDatos();
        $this->conexion = $database->obtenerConexion();
    }

    public function obtenerTodas() {
        $query = "SELECT id, nombre FROM " . $this->tabla;
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
