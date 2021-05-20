const mysql = require('mysql');

const conexion = {
	host: 'localhost',
	database: 'recetasnow',
	user: 'root',
	password: 'Tallern4'
};

const pool = mysql.createPool(conexion);
module.exports = pool;
