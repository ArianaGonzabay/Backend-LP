const express = require('express');
const app = express();
const db = require('./config/db');
const Producto = require('./models/Producto');
const Reseña = require('./models/Reseña');
const Pedido = require('./models/Pedido');
const DetallePedido = require('./models/DetallePedido');

app.use(express.json());

// Endpoint: Obtener todos los productos
app.get('/productos', async (req, res) => {
  try {
    const productos = await Producto.findAll();
    res.json(productos);
  } catch (error) {
    console.error('Error al obtener los productos:', error);
    res.status(500).json({ error: 'Error al obtener los productos' });
  }
});


//Detalles de Productos
app.get('/productos/:id', async (req, res) => {
  try {
    const producto = await Producto.findByPk(req.params.id);
    if (!producto) {
      return res.status(404).json({ error: 'Producto no encontrado' });
    }
    res.json(producto);
  } catch (error) {
    console.error('Error al obtener el producto:', error);
    res.status(500).json({ error: 'Error al obtener el producto' });
  }
});

//Crear Reseña
app.post('/resenas', async (req, res) => {
  const { producto_id, usuario_id, comentario, calificacion } = req.body;
  if (!producto_id || !usuario_id || !calificacion) {
    return res.status(400).json({ error: 'Faltan datos obligatorios (producto_id, usuario_id, calificacion)' });
  }

  try {
    const nuevaReseña = await Reseña.create({
      producto_id,
      usuario_id,
      comentario,
      calificacion,
    });

    res.status(201).json({
      message: 'Reseña creada exitosamente',
      reseña: nuevaReseña,
    });
  } catch (error) {
    console.error('Error al crear la reseña:', error);
    res.status(500).json({ error: 'Error al crear la reseña', details: error.message });
  }
});

//Generar Compra
app.post('/pedidos', async (req, res) => {
  const { usuario_id, metodo_pago, direccion_envio, productos } = req.body;

  if (!usuario_id || !metodo_pago || !direccion_envio || !productos || productos.length === 0) {
    return res.status(400).json({ error: 'Faltan datos obligatorios (usuario_id, metodo_pago, direccion_envio, productos)' });
  }

  try{
    //Total del pedido
    let total = 0;
    for(let i=0; i<productos.length; i++){
      const producto = await Producto.findByPk(productos[i].producto_id);
      if(producto) {
        total += producto.precio * productos[i].cantidad;
      }
    }

    //crear pedido
    const nuevoPedido = await Pedido.create({
      usuario_id,
      metodo_pago,
      direccion_envio,
      total,
    });

    //crear los detalles del pedido
    for (let i=0; i<productos.length; i++){
      await DetallePedido.create({
        pedido_id: nuevoPedido.id,
        producto_id: productos[i].producto_id,
        cantidad: productos[i].cantidad,
      });
    }

    res.status(201).json({
      message: 'Pedido creado exitosamente',
      pedido: nuevoPedido,
      detalles: productos,
    });
  }catch(error){
    console.error("Error al generar el pedido: ", error);
    res.status(500).json({ error: 'Error al generar el pedido', details: error.message });
  }
});


const PORT = process.env.PORT || 3000;
app.get('/', (req, res) => {
  res.send('Servidor corriendo!');
});

app.listen(PORT, () => {
  console.log(`Servidor corriendo en el puerto ${PORT}`);
});
