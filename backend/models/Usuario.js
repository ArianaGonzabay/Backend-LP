const { DataTypes } = require('sequelize');
const sequelize = require('../config/db');

const Usuario = sequelize.define('Usuario', {
    nombre: {
        type: DataTypes.STRING(255),
        allowNull: false,
    },
    apellido: {
        type: DataTypes.STRING(255),
        allowNull: false
    },
    email: {
        type: DataTypes.STRING(255),
        allowNull: false,
        unique: true,
    },
    password: {
        type: DataTypes.STRING(255),
        allowNull: false,
    },
}, {
    timestamps: true,
    createdAt: 'createdAt',
    updatedAt: 'updatedAt',
    tableName: 'usuarios',
});

Usuario.associate = function(models) {
    Usuario.hasMany(models.Pedido, {
        foreignKey: 'usuario_id',
        as: 'pedidos',
    });
    Usuario.hasMany(models.Reseña, {
        foreignKey: 'usuario_id',
        as: 'reseñas',
    });
};

module.exports = Usuario;
