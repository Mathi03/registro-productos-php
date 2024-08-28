$(document).ready(function() {
	const apiUrl = '../index.php'; // url del archivo expuesto

	// Función para cargar datos y rellenar los elementos del formulario
	function cargarDatos() {
		$.ajax({
			type: 'GET',
			url: apiUrl + '?action=cargarDatos',
			dataType: 'json',
			success: function(response) {
				// Rellenar el select de bodegas
				const selectBodega = $('#bodega');
				response.bodegas.forEach(bodega => {
					selectBodega.append(new Option(bodega.nombre, bodega.id));
				});

				// Rellenar el select de monedas
				const selectMoneda = $('#moneda');
				response.monedas.forEach(moneda => {
					selectMoneda.append(new Option(moneda.nombre, moneda.id));
				});

				// Rellenar los checkboxes de materiales
				const materialesContainer = $('#materialesContainer');
				response.materiales.forEach(material => {
					materialesContainer.append(
						`<div><input type="checkbox" name="materiales[]" value="${material.id}"> ${material.nombre}<br></div>`
					);
				});
			},
			error: function() {
				alert('Error al cargar los datos.');
			}
		});
	}

	// Función para obtener sucursales por bodega
	$('#bodega').change(function() {
		const bodegaId = $(this).val();
		$.ajax({
			type: 'POST',
			url: apiUrl + '?action=obtenerSucursales',
			data: {
				bodega_id: bodegaId
			},
			dataType: 'json',
			success: function(response) {
				const selectSucursal = $('#sucursal');
				selectSucursal.empty().append(new Option('Selecciona una sucursal', ''));
				response.forEach(sucursal => {
					selectSucursal.append(new Option(sucursal.nombre, sucursal.id));
				});
			},
			error: function() {
				alert('Error al cargar las sucursales.');
			}
		});
	});

	function validarCodigo(codigo) {
		if (!codigo) {
			alert("El código del producto no puede estar en blanco.");
			return false;
		}

		const formatoValido = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/.test(codigo);
		if (!formatoValido) {
			alert("El código del producto debe contener letras y números.");
			return false;
		}

		if (codigo.length < 5 || codigo.length > 15) {
			alert("El código del producto debe tener entre 5 y 15 caracteres.");
			return false;
		}

		let esUnico = false;
		$.ajax({
			type: 'POST',
			async: false,
			url: apiUrl + '?action=verificarCodigo',
			data: {
				codigo: codigo
			},
			dataType: 'json',
			success: function(response) {
				if (response.existe) {
					alert("El código del producto ya está registrado.");
				} else {
					esUnico = true;
				}
			},
			error: function() {
				alert('Error al verificar el código del producto.');
			}
		});

		return esUnico;
	}

	function validarNombre(nombre) {
		if (!nombre) {
			alert("El nombre del producto no puede estar en blanco.");
			return false;
		}

		if (nombre.length < 2 || nombre.length > 50) {
			alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
			return false;
		}

		return true;
	}

	function validarPrecio(precio) {
		if (!precio) {
			alert("El precio del producto no puede estar en blanco.");
			return false;
		}

		const formatoValido = /^\d+(\.\d{1,2})?$/.test(precio);
		if (!formatoValido) {
			alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
			return false;
		}

		return true;
	}

	function validarMateriales() {
		const materialesSeleccionados = $('input[name="materiales[]"]:checked').length;
		if (materialesSeleccionados < 2) {
			alert("Debe seleccionar al menos dos materiales para el producto.");
			return false;
		}

		return true;
	}

	function validarBodega(bodega) {
		if (!bodega) {
			alert("Debe seleccionar una bodega.");
			return false;
		}

		return true;
	}

	function validarSucursal(sucursal) {
		if (!sucursal) {
			alert("Debe seleccionar una sucursal para la bodega seleccionada.");
			return false;
		}

		return true;
	}

	function validarMoneda(moneda) {
		if (!moneda) {
			alert("Debe seleccionar una moneda para el producto.");
			return false;
		}

		return true;
	}

	function validarDescripcion(descripcion) {
		if (!descripcion) {
			alert("La descripción del producto no puede estar en blanco.");
			return false;
		}

		if (descripcion.length < 10 || descripcion.length > 1000) {
			alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
			return false;
		}

		return true;
	}

	$('#formularioProducto').on('submit', function(event) {
		event.preventDefault(); // Prevenir el envío normal del formulario

		const codigo = $('#codigo').val();
		const nombre = $('#nombre').val();
		const precio = $('#precio').val();
		const materialesValidos = validarMateriales();
		const bodega = $('#bodega').val();
		const sucursal = $('#sucursal').val();
		const moneda = $('#moneda').val();
		const descripcion = $('#descripcion').val();

		if (!validarCodigo(codigo) || !validarNombre(nombre) || !validarPrecio(precio) || !materialesValidos || !validarBodega(bodega) || !validarSucursal(sucursal) || !validarMoneda(moneda) || !validarDescripcion(descripcion)) {
			return; // Detener el envío del formulario si alguna validación falla
		}

    // Deshabilitar boton
    const $submitButton = $('#submitButton');
    $submitButton.prop('disabled', true);

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '../index.php?action=registrarProducto',
			data: formData,
			dataType: 'json',
			success: function(response) {
				if (response.exito) {
					alert(response.mensaje);
					// Limpiar el formulario o redirigir si es necesario
					$('#formularioProducto')[0].reset();
				} else {
					if (response.errores) {
            // Mostrar un alert por cada error de validacion
						for (const [campo, mensaje] of Object.entries(response.errores)) {
							alert(`${campo}: ${mensaje}`);
						}
					} else {
						alert('Error al registrar el producto.');
					}
				}
			},
			error: function() {
				alert('Error en la solicitud.');
      },
      complete: function() {
        // Habilitar el botón y restaurar el texto
        $submitButton.prop('disabled', false).html('Guardar Producto');
      }
		});
	});

	cargarDatos();
});
