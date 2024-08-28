<?php
require_once __DIR__ . "/../modelos/Bodega.php";
require_once __DIR__ . "/../modelos/Material.php";
require_once __DIR__ . "/../modelos/Moneda.php";
require_once __DIR__ . "/../modelos/Producto.php";
require_once __DIR__ . "/../modelos/Sucursal.php";
require_once __DIR__ . '/../solicitudes/SolicitudProducto.php';

class ControladorProducto
{
    private $bodega;
    private $material;
    private $moneda;
    private $producto;
    private $sucursal;

    public function __construct()
    {
        $this->bodega = new Bodega();
        $this->material = new Material();
        $this->moneda = new Moneda();
        $this->producto = new Producto();
        $this->sucursal = new Sucursal();
    }

    public function mostrarFormulario()
    {
        include __DIR__ . "/../vistas/registro.php";
    }

    // Método para cargar los datos iniciales (bodegas, monedas, materiales)
    public function cargarDatos()
    {
        $bodegas = $this->bodega->obtenerTodas();
        $monedas = $this->moneda->obtenerTodas();
        $materiales = $this->material->obtenerTodas();

        echo json_encode([
            "bodegas" => $bodegas,
            "monedas" => $monedas,
            "materiales" => $materiales,
        ]);
    }

    // Método para obtener las sucursales según la bodega seleccionada
    public function obtenerSucursalesPorBodega()
    {
        // Verificar si el parámetro bodega_id está presente en la solicitud POST
        if (isset($_POST["bodega_id"])) {
            $bodegaId = $_POST["bodega_id"];
            // Obtener las sucursales asociadas a la bodega
            $sucursales = $this->sucursal->obtenerPorBodega($bodegaId);
            // Retornar las sucursales
            echo json_encode($sucursales);
        } else {
            // Si no se proporciona el bodega_id, devolver un error
            echo json_encode(["error" => "No se proporcionó un ID de bodega"]);
        }
    }

    public function verificarCodigo() {
        $codigo = $_POST['codigo'];
        $existe = $this->producto->verificarCodigo($codigo);
        echo json_encode(['existe' => $existe]);
    }

    public function registrarProducto() {
        $datos = $_POST;
        $productoRequest = new SolicitudProducto($datos);

        // Valida los parametros de la solicitud POST
        if ($productoRequest->validar()) {
            if ($this->producto->registrar($datos)) {
                echo json_encode(['exito' => true, 'mensaje' => 'Producto registrado exitosamente.']);
            } else {
                echo json_encode(['exito' => false, 'mensaje' => 'Error al registrar el producto.']);
            }
        } else {
            // Si encuentra uno o mas errores retornar estos
            echo json_encode(['exito' => false, 'errores' => $productoRequest->obtenerErrores()]);
        }
    }
}
?>

