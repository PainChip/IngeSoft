var express = require('express');

var ProductController = require('../controllers/productController');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

api.post('/createProduct', md_auth.ensureAuth, ProductController.createProduct);

module.exports = api;