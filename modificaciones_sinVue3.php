<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <h1>Modificar Productos del Inventario</h1>
    <div class="img"><img src="img/logo_codo.png" alt="codoacodo" width="100px"></div>
    <h3>Codo a Codo 2023</h3>
    <form id="formulario">
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required><br>
        <button type="submit">Modificar Producto</button> <a href="index.php">Menu principal</a>
    </form>

    <div id="datosProducto" style="display: none;">
        <h2>Datos del Producto</h2>
        <form id="formularioModificar">
            <label for="descripcionModificar">Descripción:</label>
            <input type="text" id="descripcionModificar" name="descripcionModificar" required><br>

            <label for="cantidadModificar">Cantidad:</label>
            <input type="number" id="cantidadModificar" name="cantidadModificar" required><br>

            <label for="precioModificar">Precio:</label>
            <input type="number" step="0.01" id="precioModificar" name="precioModificar" required><br>

            <button type="submit">Guardar Cambios</button>
            <a href="modificaciones.php">Cancelar</a>
        </form>
    </div>

    <script>
        //const URL = "http://127.0.0.1:5000/"
        const URL = "jsalvado.pythonanywhere.com";

        // Capturamos el evento de envío del formulario para mostrar los datos del producto
        document.getElementById('formulario').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitamos que se recargue la página

            // Obtenemos el código del producto
            var codigo = document.getElementById('codigo').value;

            // Realizamos la solicitud GET al servidor para obtener los datos del producto
            fetch(URL + 'productos/' + codigo)
                .then(function (response) {
                    if (response.ok) {
                        return response.json(); // Parseamos la respuesta JSON
                    } else {
                        // Si hubo un error, lanzar explícitamente una excepción
                        // para ser "catcheada" más adelante
                        throw new Error('Error al obtener los datos del producto.');
                    }
                })
                .then(function (data) {
                    // Mostramos los datos del producto en el formulario de modificación
                    document.getElementById('descripcionModificar').value = data.descripcion;
                    document.getElementById('cantidadModificar').value = data.cantidad;
                    document.getElementById('precioModificar').value = data.precio;

                    // Mostramos el formulario de modificación y ocultamos el formulario de consulta
                    document.getElementById('formulario').style.display = 'none';
                    document.getElementById('datosProducto').style.display = 'block';
                })
                .catch(function (error) {
                    // Código para manejar errores
                    alert('Error al obtener los datos del producto.');
                });
        });

        // Capturamos el evento de envío del formulario de modificación
        document.getElementById('formularioModificar').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitamos que se recargue la página

            // Obtenemos los valores del formulario de modificación
            var codigo = document.getElementById('codigo').value;
            var descripcion = document.getElementById('descripcionModificar').value;
            var cantidad = document.getElementById('cantidadModificar').value;
            var precio = document.getElementById('precioModificar').value;

            // Creamos un objeto con los datos del producto actualizados
            var producto = {
                codigo: codigo,
                descripcion: descripcion,
                cantidad: cantidad,
                precio: precio
            };

            // Realizamos la solicitud PUT al servidor para guardar los cambios
            fetch(URL + 'productos/' + codigo, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(producto)
            })
                .then(function (response) {
                    if (response.ok) {
                        return response.json(); // Parseamos la respuesta JSON
                    } else {
                        // Si hubo un error, lanzar explícitamente una excepción
                        // para ser "catcheada" más adelante
                        throw new Error('Error al guardar los cambios del producto.');
                    }
                })
                .then(function (data) {
                    alert('Cambios guardados correctamente.');
                    location.reload(); // Recargamos la página para volver al formulario de consulta
                })
                .catch(function (error) {
                    // Código para manejar errores
                    alert('Error al guardar los cambios del producto.');
                })
        });
    </script>
</body>
</html>