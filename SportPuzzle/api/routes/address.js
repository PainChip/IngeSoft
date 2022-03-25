var express = require('express');

var AddressController = require('../controllers/address');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

api.post('/createAddress', md_auth.ensureAuth, AddressController.createAddress);
api.delete('/deleteAddress', md_auth.ensureAuth, AddressController.deleteAddress);
api.put('/updateAddress', md_auth.ensureAuth, AddressController.updateAddress);
api.get('/address', md_auth.ensureAuth, AddressController.getAddressByUserId);

module.exports = api;