const express = require('express');
const app = express();
const db = require('./config/db');
const Producto = require('./models/Producto');

app.use(express.json());

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

const PORT = process.env.PORT || 3000;
app.get('/', (req, res) => {
  res.send('Servidor corriendo!');
});

app.listen(PORT, () => {
  console.log(`Servidor corriendo en el puerto ${PORT}`);
});
