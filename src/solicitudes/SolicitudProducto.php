<?php

class SolicitudProducto
{
    private $datos;
    private $errores = [];

    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    // Método para validar los datos
    public function validar()
    {
        $this->validarCodigo();
        $this->validarNombre();
        $this->validarPrecio();
        $this->validarBodegaId();
        $this->validarSucursalId();
        $this->validarMonedaId();
        $this->validarDescripcion();
        return empty($this->errores);
    }

    // Métodos específicos para validar cada campo
    private function validarCodigo()
    {
        if (empty($this->datos["codigo"])) {
            $this->errores["codigo"] = "El código del producto es obligatorio.";
        } elseif (
            !preg_match(
                '/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{5,15}$/',
                $this->datos["codigo"]
            )
        ) {
            $this->errores["codigo"] =
                "El código del producto debe tener entre 5 y 15 caracteres, y contener letras y números.";
        }
    }

    private function validarNombre()
    {
        if (empty($this->datos["nombre"])) {
            $this->errores["nombre"] = "El nombre del producto es obligatorio.";
        }
    }

    private function validarPrecio()
    {
        if (
            empty($this->datos["precio"]) ||
            !is_numeric($this->datos["precio"])
        ) {
            $this->errores["precio"] =
                "El precio del producto es obligatorio y debe ser un número.";
        }
    }

    private function validarBodegaId()
    {
        if (empty($this->datos["bodega_id"])) {
            $this->errores["bodega_id"] = "La bodega es obligatoria.";
        }
    }

    private function validarSucursalId()
    {
        if (empty($this->datos["sucursal_id"])) {
            $this->errores["sucursal_id"] = "La sucursal es obligatoria.";
        }
    }

    private function validarMonedaId()
    {
        if (empty($this->datos["moneda_id"])) {
            $this->errores["moneda_id"] = "La moneda es obligatoria.";
        }
    }

    private function validarDescripcion()
    {
        if (empty($this->datos["descripcion"])) {
            $this->errores["descripcion"] =
                "La descripción del producto es obligatoria.";
        }
    }

    // Obtener errores
    public function obtenerErrores()
    {
        return $this->errores;
    }
}

?>
