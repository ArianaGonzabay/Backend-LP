const { DataTypes } = require('sequelize');
const sequelize = require('../config/db');
const Reseña = require('./Reseña');

const Producto = sequelize.define('Producto', {
  nombre: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  descripcion: {
    type: DataTypes.TEXT,
    allowNull: false,
  },
  precio: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: false,
  },
  stock: {
    type: DataTypes.INTEGER,
    defaultValue: 0,
    allowNull: false,
  },
  categoria: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  fecha_vencimiento: {
    type: DataTypes.DATE,
    allowNull: false,
  },
  imagen: {
    type: DataTypes.STRING,
    allowNull: true,
  },
});

// Relación entre Producto y Reseña
Producto.hasMany(Reseña, {
  foreignKey: 'producto_id',
  as: 'reseñas'
});

Reseña.belongsTo(Producto, {
  foreignKey: 'producto_id',
  as: 'producto'
});

module.exports = Producto;

