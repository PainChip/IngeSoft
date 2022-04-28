var express = require('express');

var UserController = require('../controllers/userController');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

var multipart = require('connect-multiparty');
var mad_upload = multipart({uploadDir: './uploads/users'}); //Imagenes

api.post('/createUser', UserController.createUser);
api.post('/authUser', UserController.authUser);
api.put('/update-user/:id', md_auth.ensureAuth, UserController.updateUser);
api.post('/upload-image-user/:id', [md_auth.ensureAuth, mad_upload], UserController.uploadImage);
api.get('/get-image-user/:imageFile', UserController.getImageFile);

module.exports = api;