const express = require('express');
const app = express();
const path = require('path');
const rutas = require('./rutas.js');


//configuracion
app.set("port", 3000);
app.set("views", path.join(__dirname, "views"));
app.engine("html", require("ejs").renderFile);
app.set("view engine", "ejs");

//middlewares
app.use(express.urlencoded({extended: true})); //permite mandar variables por url
app.use(express.static(path.join(__dirname, "public"))); // Archivos estaticos

//rutas
app.use('/', rutas);
app.use((req, res, next) => {
	res.status(404).render('404.html')
});

//inicia el servidor
app.listen(app.get("port"), () => {
	console.log("Server full nashe, padre", app.get("port"));
});
