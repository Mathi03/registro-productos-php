<?php
class BaseDeDatos {
    private $host = "db"; // El nombre del servicio de la base de datos
    private $nombre_bd;
    private $usuario;
    private $contrasena;
    public $conexion;

    public function __construct() {
        $this->nombre_bd = getenv('POSTGRES_DB');
        $this->usuario = getenv('POSTGRES_USER');
        $this->contrasena = getenv('POSTGRES_PASSWORD');
    }

    public function obtenerConexion() {
        $this->conexion = null;

        try {
            $this->conexion = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->nombre_bd, $this->usuario, $this->contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conexion;
    }
}
?>
