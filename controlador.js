const controlador = {};
const pool = require("./myConexion.js");
const path = require('path');

controlador.ruta = (req, res) => {
	const data = req.params;
	res.render(data.nombre + ".html");
}

//baja un solo registro
controlador.verReceta = (req, res) => {
	const data = req.params;
	pool.query(`SELECT * FROM recetas WHERE id = ?`, data.id, (err, row) => {
			if (err) throw err;
			pool.query('SELECT * FROM imagenes', (err, imagen) => {
			if (err) throw err;
				res.render("verReceta.html", { 
				data: row[0],
				dataFoto: imagen
				 });
			});
		});
};


//baja todos los registros
controlador.list = (req, res) => {
	pool.query("SELECT * FROM recetas", (err, receta) => {
		if (err) throw err;
		res.render("index.html", {
			data: receta
		});
	});
};

//baja todos los registros
controlador.listSeg = (req, res) => {
	pool.query("SELECT * FROM recetas", (err, receta) => {
		if (err) throw err;
		pool.query('SELECT * FROM imagenes', (err, foto) => {
			if (err) throw err;
			res.render("index.html", {
			data: receta,
			dataFoto: foto
			});
		});
	});
};

controlador.api = (req, res) => {
	pool.query("SELECT * FROM recetas", (err, persona) => {
		if (err) throw err;
		res.json(persona);
		console.log(req.url);
	});
};

//sube un registro
controlador.save = (req, res) => {
	const table = req.params;
	const data = req.body;
	pool.query(`INSERT INTO ${table.table} SET ?`, req.body, (err, rows) => {
		if (err) throw err;
		console.log(rows);
		res.redirect("/");
	});
};

//borra un registro
controlador.delete = (req, res) => {
	const data = req.params;
	pool.query(`DELETE FROM ${data.table} WHERE id = ?`, data.id, (err, rows) => {
			if (err) throw err;
			res.redirect("/");
		});
};

//baja un solo registro
controlador.edit = (req, res) => {
	const data = req.params;
	pool.query(`SELECT * FROM ${data.table} WHERE id = ?`, data.id, (err, row) => {
			if (err) throw err;
			res.render("pagina.html", { data: row[0] });
		});
};

//actualiza un registro
controlador.update = (req, res) => {
	const data = req.params;
	const newData = req.body;
	pool.query(`UPDATE ${data.table} set ? WHERE id = ?`, [newData, data.id], (err, rows) => {
			res.redirect("/");
		});
};

//Sube un archivo
controlador.imagen = (req, res) => {
	const fileDir = nombreArchivo(req.file);
	const data = req.params;
	const cargar = {
		idReceta: data.id,
		direccion: fileDir
	};
	pool.query(`INSERT INTO ${data.table} SET ?`, cargar , (err, rows) => {
		if (err) throw err;
		console.log(rows);
		res.redirect("/");
	});
};

function nombreArchivo (file){
	let fullNewPath = "uploads/" + file.filename;
	return fullNewPath
}

module.exports = controlador;