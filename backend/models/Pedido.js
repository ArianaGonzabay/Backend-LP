const { DataTypes } = require('sequelize');
const sequelize = require('../config/db');

const Pedido = sequelize.define('Pedido', {
    usuario_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
    },
    total: {
        type: DataTypes.DECIMAL(10, 2),
        allowNull: false,
    },
    metodo_pago: {
        type: DataTypes.STRING(50),
        allowNull: false,
    },
    direccion_envio: {
        type: DataTypes.STRING(255),
        allowNull: false,
    },
}, {
    timestamps: true,
});

Pedido.associate = function(models) {
    Pedido.belongsTo(models.Usuario, {
        foreignKey: 'usuario_id',
        as: 'usuario',
    });
    Pedido.hasMany(models.DetallePedido, {
        foreignKey: 'pedido_id',
        as: 'detalles',
    });
};

module.exports = Pedido;
