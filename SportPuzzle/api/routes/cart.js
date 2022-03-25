var express = require('express');

var CartController = require('../controllers/cart');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');


api.post('/saveBuilding', md_auth.ensureAuth, CartController.saveBuilding);
api.delete('/deleteCart', md_auth.ensureAuth, CartController.deleteBuilding);
api.get('/cart', md_auth.ensureAuth, CartController.getCart);
api.get('/totalActiveCarts', md_auth.ensureAuth, CartController.getTotalCartsActive);
api.delete('/deleteItemByUserIdAndProductId/:productId', md_auth.ensureAuth, CartController.deleteItemByUserIdAndProductId);

module.exports = api;