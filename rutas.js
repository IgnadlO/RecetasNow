const express = require('express');
const router = express.Router();
const controlador = require('./controlador.js');
const multer = require('multer');

const storage = multer.diskStorage({
	destination: './src/public/uploads/',
	filename: function(req, file, cb){
		cb("",Date.now() + ".png");
	}
})

const upload = multer({
	storage: storage
})

//rutas mysql
router.get("/", controlador.listSeg);
router.get("/api", controlador.api);
router.post('/add/:table', controlador.save);
router.get('/delete/:id/:table', controlador.delete);
router.post('/update/:id/:table', controlador.update);
router.post('/file:id/:table', upload.single('imagen'), controlador.imagen);

//rutas convencionales
router.get("/verReceta:id", controlador.verReceta);
router.get("/:nombre", controlador.ruta);


module.exports = router;