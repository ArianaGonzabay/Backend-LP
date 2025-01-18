// models/Carrito.js
const { DataTypes } = require('sequelize');
const db = require('../config/db');


const Carrito = db.define('Carrito', {
  usuario_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: 'usuarios',
      key: 'id',
    },
    onDelete: 'CASCADE',
  },
  producto_id: {
    type: DataTypes.INTEGER,
    allowNull: false,
    references: {
      model: 'productos',
      key: 'id',
    },
    onDelete: 'CASCADE',
  },
  cantidad: {
    type: DataTypes.INTEGER,
    allowNull: false,
    defaultValue: 1,
  },
}, {
  timestamps: true,
});


module.exports = Carrito;