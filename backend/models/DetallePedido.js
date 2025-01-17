const {DataTypes} = require('sequelize');
const sequelize = require('../config/db');

const DetallePedido = sequelize.define('DetallePedido', {
    pedido_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    producto_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    cantidad: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
}, {
    timestamps: true,
    tableName: 'detalles_pedido',
});

DetallePedido.associate = function(models) {
    DetallePedido.belongsTo(models.Pedido, {
        foreignKey: 'pedido_id',
        as: 'pedido',
    });
    DetallePedido.belongsTo(models.Producto, {
        foreignKey: 'producto_id',
        as: 'producto',
    });
};

module.exports = DetallePedido;