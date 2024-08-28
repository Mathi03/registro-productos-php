<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/app.js" defer></script>
  </head>
  <body>
    <div class="container">
      <h1>Formulario de Producto</h1>
      <form id="formularioProducto">
        <div class="row">
          <div class="column">
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo">
          </div>
          <div class="column">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre">
          </div>
        </div>
        <div class="row">
          <div class="column">
            <label for="bodega">Bodega:</label>
            <select id="bodega" name="bodega_id">
              <option value="">Selecciona una bodega</option>
            </select>
          </div>
          <div class="column">
            <label for="sucursal">Sucursal:</label>
            <select id="sucursal" name="sucursal_id">
              <option value="">Selecciona una sucursal</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <label for="moneda">Moneda:</label>
            <select id="moneda" name="moneda_id">
              <option value="">Selecciona una moneda</option>
            </select>
          </div>
          <div class="column">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" min="0">
          </div>
        </div>
        <div class="row">
          <div class="column">
            <label for="material">Material del Producto:</label>
            <div class="row" id="materialesContainer"></div>
          </div>
        </div>
        <div class="row">
          <div class="column">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"></textarea>
          </div>
        </div>
        <button type="submit" id="submitButton">Guardar Producto</button>
      </form>
    </div>
  </body>
</html>
