<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito de compras</title>
  <script src="https://unpkg.com/vue@next"></script>
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
  <div id="app">
    <h1>Carrito de compras</h1>
    <div class="img"><img src="img/logo_codo.png" alt="codoacodo" width="100px"></div>
    <h3>Codo a Codo 2023</h3>
    <table>
      <thead>
        <tr>
          <th>Código</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Carrito</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="producto in productos" :key="producto.codigo">
          <td>{{ producto.codigo }}</td>
          <td>{{ producto.descripcion }}</td>
          <td align="right">{{ producto.cantidad }}</td>
          <td align="right">&nbsp; &nbsp; {{ producto.precio }}</td>
          <td>
            <button @click="agregarAlCarrito(producto)">&nbsp;&nbsp;<b>+</b>&nbsp;&nbsp;</button>
            <button @click="restarDelCarrito(producto)">&nbsp;&nbsp;<b>-</b>&nbsp;&nbsp;</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="mostrarCarrito">
      <h3>Productos en el carrito:</h3>
      <table>
        <thead>
          <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in carrito" :key="item.codigo">
            <td>{{ item.codigo }}</td>
            <td>{{ item.descripcion }}</td>
            <td align="right">{{ item.cantidad }}</td>
            <td align="right">&nbsp; &nbsp; {{ item.precio }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="!mostrarCarrito" class="contenedor-centrado">
      <button @click="obtenerCarrito">Mostrar carrito</button>
    </div>

    <div class="contenedor-centrado">
      <a href="index.php">Menu principal</a>
    </div>

  </div>

  <script>
    //const URL = "http://127.0.0.1:5000/"
    const URL = "jsalvado.pythonanywhere.com"

    const app = Vue.createApp({
      data() {
        return {
          productos: [],
          mostrarCarrito: false,
          carrito: [],
        }
      },
      created() {
        this.obtenerProductos()
      },
      methods: {
        obtenerProductos() {
          fetch(URL + 'productos')
            .then(response => response.json())
            .then(data => {
              this.productos = data
            })
            .catch(error => {
              console.error(URL + 'productos', error)
              alert('Error al obtener los productos.')
            })
        },
        agregarAlCarrito(producto) {
          fetch(URL + 'carrito', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              codigo: producto.codigo,
              cantidad: 1, // Agregamos una unidad al carrito
            }),
          })
            .then(response => response.json())
            .then(data => {
              alert(data.message)
            })
            .catch(error => {
              console.error('Error al agregar el producto al carrito:', error)
              alert('Error al agregar el producto al carrito.')
            })
        },
        restarDelCarrito(producto) {
          fetch(URL + 'carrito', {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              codigo: producto.codigo,
              cantidad: 1, // Restamos una unidad del carrito
            }),
          })
            .then(response => response.json())
            .then(data => {
              alert(data.message)
            })
            .catch(error => {
              console.error('Error al restar el producto del carrito:', error)
              alert('Error al restar el producto del carrito.')
            })
        },
        obtenerCarrito() {
          fetch(URL + 'carrito')
            .then(response => response.json())
            .then(data => {
              this.carrito = data
              this.mostrarCarrito = true
            })
            .catch(error => {
              console.error('Error al obtener el carrito:', error)
              alert('Error al obtener el carrito.')
            })
        },
      },
    })
    app.mount('#app')
  </script>
</body>

</html>