const express = require('express');
const app = express();
const db = require('./config/db');
const Producto = require('./models/Producto');
const Reseña = require('./models/Reseña');

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



const PORT = process.env.PORT || 3000;
app.get('/', (req, res) => {
  res.send('Servidor corriendo!');
});

app.listen(PORT, () => {
  console.log(`Servidor corriendo en el puerto ${PORT}`);
});
