var mongoose = require('mongoose');
var app = require('./app');
var port = 5000;

//Conexion DB
mongoose.Promise = global.Promise;
mongoose.connect('mongodb://localhost:27017/IngSoftware').then(()=>{
		console.log("La conexion a la base de datos SportsPuzzleDB se ha realizado correctamente.");
		//Crear servidor
		app.listen(port, ()=>{
			console.log("Servidor creado correctamente en http://localhost:" + port);
		})
	}).catch(err=> console.log(err));