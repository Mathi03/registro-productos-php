<?php
require_once __DIR__ . "/../src/controladores/ControladorProducto.php";

function manejarRuta($accion)
{
    // Mapeo de acciones a controladores y métodos
    $rutas = [
        "mostrarFormulario" => [
            "controlador" => "ControladorProducto",
            "metodo" => "mostrarFormulario",
        ],
        "cargarDatos" => [
            "controlador" => "ControladorProducto",
            "metodo" => "cargarDatos",
        ],
        "obtenerSucursales" => [
            "controlador" => "ControladorProducto",
            "metodo" => "obtenerSucursalesPorBodega",
        ],
        "verificarCodigo" => [
            "controlador" => "ControladorProducto",
            "metodo" => "verificarCodigo",
        ],
        "registrarProducto" => [
            "controlador" => "ControladorProducto",
            "metodo" => "registrarProducto",
        ],
    ];

    if (array_key_exists($accion, $rutas)) {
        $controlador = $rutas[$accion]["controlador"];
        $metodo = $rutas[$accion]["metodo"];

        if (class_exists($controlador)) {
            $ctrl = new $controlador();
            if (method_exists($ctrl, $metodo)) {
                $ctrl->$metodo();
            } else {
                echo "Método no encontrado.";
            }
        } else {
            echo "Controlador no encontrado.";
        }
    } else {
        echo "Acción no encontrada.";
    }
}

// Obtén la acción desde la URL o el método de la solicitud
$accion = isset($_GET["action"])
    ? $_GET["action"]
    : (isset($_POST["action"])
        ? $_POST["action"]
        : "mostrarFormulario");

// Maneja la ruta
manejarRuta($accion);
?>
