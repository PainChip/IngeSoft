var express = require('express');

var ProductController = require('../controllers/productController');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

api.post('/createProduct', md_auth.ensureAuth, ProductController.createProduct);
api.post('/editProduct/:product', md_auth.ensureAuth, ProductController.editProduct);
api.post('/dropProduct/:product', md_auth.ensureAuth, ProductController.dropProduct);
api.get('/getProduct/:product', md_auth.ensureAuth, ProductController.getProduct);
api.post('/getProducts', md_auth.ensureAuth, ProductController.getProducts);
api.post('/getTopProducts', ProductController.getTopProducts);
api.post('/getTopProducts2', ProductController.getTopProducts2);
api.post('/getProductsByCat/:category', md_auth.ensureAuth, ProductController.getProductsByCat);

module.exports = api;