const express = require('express');
const app = express();
const db = require('./config/db');
const cors = require('cors');

const Producto = require('./models/Producto');
const Reseña = require('./models/Reseña');
const Pedido = require('./models/Pedido');
const DetallePedido = require('./models/DetallePedido');
const Factura = require('./models/Factura');
const Usuario = require('./models/Usuario');

app.use(cors());

app.use(express.json());

//Crear Usuario
app.post('/usuarios', async (req, res) => {
  const { nombre, apellido, email, password } = req.body;
  if (!nombre || !apellido || !email || !password) {
    return res.status(400).json({ error: 'Faltan datos obligatorios (nombre, apellido, email, password)' });
  }
  try {
    const nuevoUsuario = await Usuario.create({
      nombre,
      apellido,
      email,
      password,
    });

    res.status(201).json({
      message: 'Usuario creado exitosamente',
      usuario: nuevoUsuario,
    });
  } catch (error) {
    console.error('Error al crear el usuario:', error);
    res.status(500).json({ error: 'Error al crear el usuario', details: error.message });
  }
});

app.get('/usuarios', async (req, res) => {
  try {
    const usuarios = await Usuario.findAll();
    res.json(usuarios);
  } catch (error) {
    console.error('Error al obtener los usuarios:', error);
    res.status(500).json({ error: 'Error al obtener los usuarios', details: error.message });
  }
});

//usuario por id
app.get('/usuarios/:id', async (req, res) => {
  try {
    const usuario = await Usuario.findByPk(req.params.id);
    if (!usuario) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }
    res.json(usuario);
  } catch (error) {
    console.error('Error al obtener el usuario:', error);
    res.status(500).json({ error: 'Error al obtener el usuario', details: error.message });
  }
});


// Endpoint: Obtener todos los productos
app.get('/productos', async (req, res) => {
  try {
    const productos = await Producto.findAll({
      include: [{
        model: Reseña,
        as: 'reseñas'
      }]
    });
    res.json(productos);
  } catch (error) {
    console.error('Error al obtener los productos:', error);
    res.status(500).json({ error: 'Error al obtener los productos' });
  }
});


// Detalles de Producto
app.get('/productos/:id', async (req, res) => {
  try {
    const producto = await Producto.findByPk(req.params.id, {
      include: [{
        model: Reseña,
        as: 'reseñas',
      }]
    });

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

app.get('/resenas', async (req, res) => {
  try {
    const reseñas = await Reseña.findAll();
    res.json(reseñas);
  } catch (error) {
    console.error('Error al obtener las reseñas:', error);
    res.status(500).json({ error: 'Error al obtener las reseñas', details: error.message });
  }
});

//Reseña por id
app.get('/resenas/:id', async (req, res) => {
  try {
    const reseña = await Reseña.findByPk(req.params.id);
    if (!reseña) {
      return res.status(404).json({ error: 'Reseña no encontrada' });
    }
    res.json(reseña);
  } catch (error) {
    console.error('Error al obtener la reseña:', error);
    res.status(500).json({ error: 'Error al obtener la reseña', details: error.message });
  }
});

//Generar Compra
app.post('/pedidos', async (req, res) => {
  const { 
    usuario_id, 
    metodo_pago, 
    direccion_envio, 
    productos, 
    telefono, 
    card_name, 
    card_number, 
    expiry_date, 
    cvv, 
    tipo_tarjeta 
  } = req.body;

  if (!usuario_id || !metodo_pago || !direccion_envio || !productos || productos.length === 0 || 
      !telefono || !card_name || !card_number || !expiry_date || !cvv || !tipo_tarjeta) {
    return res.status(400).json({ error: 'Faltan datos obligatorios (usuario_id, metodo_pago, direccion_envio, productos, telefono, card_name, card_number, expiry_date, cvv, tipo_tarjeta)' });
  }

  try {
    // Calcular el total del pedido
    let total = 0;
    for (let i = 0; i < productos.length; i++) {
      const producto = await Producto.findByPk(productos[i].producto_id);
      if (producto) {
        total += producto.precio * productos[i].cantidad;
      }
    }

    // Crear el pedido
    const nuevoPedido = await Pedido.create({
      usuario_id,
      metodo_pago,
      direccion_envio,
      telefono,
      card_name,
      card_number,
      expiry_date,
      cvv,
      tipo_tarjeta,
      total,
    });

    // Crear los detalles del pedido
    for (let i = 0; i < productos.length; i++) {
      await DetallePedido.create({
        pedido_id: nuevoPedido.id, 
        producto_id: productos[i].producto_id,
        cantidad: productos[i].cantidad,
      });
    }

    const factura = await generarFactura(nuevoPedido);

    res.status(201).json({
      message: 'Pedido y factura creados exitosamente',
      pedido: nuevoPedido,
      factura: factura,
      detalles: productos,
    });
  } catch (error) {
    console.error("Error al generar el pedido: ", error);
    res.status(500).json({ error: 'Error al generar el pedido o la factura', details: error.message });
  }
});


//ver pedidos
app.get('/pedidos', async (req, res) => {
  try {
    const pedidos = await Pedido.findAll();
    res.json(pedidos);
  } catch (error) {
    console.error('Error al obtener los pedidos:', error);
    res.status(500).json({ error: 'Error al obtener los pedidos', details: error.message });
  }
});

//ver pedido por id
app.get('/pedidos/:id', async (req, res) => {
  const pedidoId = req.params.id;

  try {
    const pedido = await Pedido.findByPk(pedidoId);

    if (pedido) {
      res.json(pedido);
    } else {
      res.status(404).json({ error: 'Pedido no encontrado' });
    }
  } catch (error) {
    console.error('Error al obtener el pedido:', error);
    res.status(500).json({ error: 'Error al obtener el pedido o los detalles', details: error.message });
  }
});

//Generar Factura
async function generarFactura(pedido) {
  try {
    const { metodo_pago, direccion_envio, total } = pedido;

    // Crear la factura usando los datos del pedido
    const factura = await Factura.create({
      pedido_id: pedido.id,
      total,
      metodo_pago,
      direccion_envio,
      estado: 'Pendiente',
    });

    return factura;
  } catch (error) {
    console.error('Error al generar la factura:', error.message);
    throw new Error('Error al generar la factura: ' + error.message);
  }
}


//Visualización de la factura
app.get('/facturas/:id', async (req, res) => {
  const facturaId = req.params.id;
  
  try {
    const factura = await Factura.findByPk(facturaId);  // Buscar por ID
    if (factura) {
      res.json(factura);  // Devuelve la factura si la encuentra
    } else {
      res.status(404).json({ error: 'Factura no encontrada' });
    }
  } catch (error) {
    console.error('Error al obtener la factura:', error);
    res.status(500).json({ error: 'Hubo un error al obtener la factura' });
  }
});

// Agregar producto al carrito
app.post('/carritos', async (req, res) => {
  console.log("Solicitud POST recibida:", req.body);

  const { usuario_id, producto_id, cantidad } = req.body;

  if (!usuario_id || !producto_id || !cantidad) {
    return res.status(400).json({ error: 'Faltan datos obligatorios (usuario_id, producto_id, cantidad)' });
  }

  try {
    // Comprobar si ya existe un carrito con el mismo usuario y producto
    const carritoExistente = await Carrito.findOne({
      where: { usuario_id, producto_id },
    });

    if (carritoExistente) {
      // Si el producto ya está en el carrito, actualizar la cantidad
      carritoExistente.cantidad += cantidad;
      await carritoExistente.save();
      return res.status(200).json({ message: 'Cantidad actualizada en el carrito', carrito: carritoExistente });
    }

    // Crear un nuevo producto en el carrito
    const nuevoCarrito = await Carrito.create({ usuario_id, producto_id, cantidad });

    res.status(201).json({
      message: 'Producto agregado al carrito exitosamente',
      carrito: nuevoCarrito,
    });
  } catch (error) {
    console.error('Error al agregar al carrito:', error);
    res.status(500).json({ error: 'Error al agregar al carrito', details: error.message });
  }
});


const PORT = process.env.PORT || 3000;
app.get('/', (req, res) => {
  res.send('Servidor corriendo!');
});

app.listen(PORT, () => {
  console.log(`Servidor corriendo en el puerto ${PORT}`);
});

