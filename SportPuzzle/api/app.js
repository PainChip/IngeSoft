var express = require('express');
var bodyParser = require('body-parser');

var app = express();

//Cargar rutas
var user_routes = require('./routes/user');
var building_routes = require('./routes/building');
var product_routes = require('./routes/product');
var address_routes = require('./routes/address');
var cart_routes = require('./routes/cart');
var history_routes = require('./routes/history');

//middlewares
app.use(bodyParser.urlencoded({extended:false}));
app.use(bodyParser.json()); //Cada una de las peticiones de convierten en un formato JSON.

//acceso cors
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Headers', 'Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Request-Method');
    res.header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
    res.header('Allow', 'GET, POST, OPTIONS, PUT, DELETE');
    next();
});

//rutas 
app.use('/api', user_routes);
app.use('/api', building_routes);
app.use('/api', product_routes);
app.use('/api', address_routes);
app.use('/api', cart_routes);
app.use('/api', history_routes);

//exportar 
module.exports = app;