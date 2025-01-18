const { DataTypes } = require('sequelize');
const sequelize = require('../config/db');

const Factura = sequelize.define('Factura', {
  pedido_id: {
    type: DataTypes.INTEGER,
    allowNull: false,  
    references: {
      model: 'Pedidos',  
      key: 'id',  
    },
  },
  fecha_emision: {
    type: DataTypes.DATE,
    defaultValue: DataTypes.NOW,  
  },
  total: {
    type: DataTypes.DECIMAL(10, 2),
    allowNull: false,  
  },
  metodo_pago: {
    type: DataTypes.STRING,
    allowNull: false,  
  },
  direccion_envio: {
    type: DataTypes.STRING,
    allowNull: false, 
  },
  estado: {
    type: DataTypes.STRING,
    defaultValue: 'Pendiente',  
  },
}, {
  tableName: 'facturas',  
  timestamps: true,  
});

Factura.associate = function(models){
    Factura.belongsTo(models.Pedido, {
        foreignKey: 'pedido_id',
        as: 'pedido',
    });
};

module.exports = Factura;