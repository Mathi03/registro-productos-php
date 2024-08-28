<?php

require_once __DIR__ . '/../config/database.php';

class Producto {
    private $conexion;
    private $tabla = "productos";

    public $id;
    public $codigo;
    public $nombre;
    public $bodega_id;
    public $sucursal_id;
    public $moneda_id;
    public $precio;
    public $descripcion;

    public function __construct() {
        $database = new BaseDeDatos();
        $this->conexion = $database->obtenerConexion();
    }

    // Método para registrar un producto en la base de datos
    public function registrar($datos) {
        try {
            // Iniciar transacción
            $this->conexion->beginTransaction();

            // Insertar en la tabla productos
            $query = "INSERT INTO " . $this->tabla . " 
                      (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, descripcion) 
                      VALUES 
                      (:codigo, :nombre, :bodega_id, :sucursal_id, :moneda_id, :precio, :descripcion)";
            $stmt = $this->conexion->prepare($query);

            // Asignar los valores
            $stmt->bindParam(':codigo', $datos['codigo']);
            $stmt->bindParam(':nombre', $datos['nombre']);
            $stmt->bindParam(':bodega_id', $datos['bodega_id']);
            $stmt->bindParam(':sucursal_id', $datos['sucursal_id']);
            $stmt->bindParam(':moneda_id', $datos['moneda_id']);
            $stmt->bindParam(':precio', $datos['precio']);
            $stmt->bindParam(':descripcion', $datos['descripcion']);

            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception('Error al insertar en la tabla productos.');
            }

            // Obtener el ID del producto insertado
            $productoId = $this->conexion->lastInsertId();

            // Insertar materiales si están disponibles
            if (!empty($datos['materiales'])) {
                foreach ($datos['materiales'] as $materialId) {
                    $queryMaterial = "INSERT INTO producto_material (producto_id, material_id) VALUES (:producto_id, :material_id)";
                    $stmtMaterial = $this->conexion->prepare($queryMaterial);
                    $stmtMaterial->bindParam(':producto_id', $productoId);
                    $stmtMaterial->bindParam(':material_id', $materialId);
                    if (!$stmtMaterial->execute()) {
                        throw new Exception('Error al insertar en la tabla producto_material.');
                    }
                }
            }

            // Confirmar la transacción
            $this->conexion->commit();
            return true;

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->conexion->rollBack();
            error_log($e->getMessage()); // Opcional: Registrar el error para depuración
            return false;
        }
    }

    // Método para verificar si el código del producto ya existe
    public function verificarCodigo($codigo) {
        $query = "SELECT COUNT(*) FROM " . $this->tabla . " WHERE codigo = :codigo";
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}

?>
