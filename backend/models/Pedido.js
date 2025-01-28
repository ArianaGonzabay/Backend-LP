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
    telefono: {
        type: DataTypes.STRING(15),
        allowNull: false,
    },
    card_name: {
        type: DataTypes.STRING(255),
        allowNull: false,
    },
    card_number: {
        type: DataTypes.STRING(19),
        allowNull: false,
    },
    expiry_date: {
        type: DataTypes.STRING(7),
        allowNull: false,
    },
    cvv: {
        type: DataTypes.STRING(4),
        allowNull: false,
    },
    tipo_tarjeta: {
        type: DataTypes.STRING(20),
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
