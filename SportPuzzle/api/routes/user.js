var express = require('express');

var UserController = require('../controllers/user');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

var multipart = require('connect-multiparty');
var mad_upload = multipart({uploadDir: './uploads/users'});

api.post('/user-register', UserController.createUser);
api.post('/user-login', UserController.loginUser);
api.put('/update-user/:id', md_auth.ensureAuth, UserController.updateUser);
api.get('/getUser', md_auth.ensureAuth, UserController.getUser);
api.get('/user/:id', md_auth.ensureAuth, UserController.getUserById); //id bligatorio.
api.get('/users/:page?', md_auth.ensureAuth, UserController.getAllUer); //page no obligatorio (Se usa el ? cuando no es un dato obligatorio).
api.post('/upload-image-user/:id', [md_auth.ensureAuth, mad_upload], UserController.uploadImage);
api.get('/get-image-user/:imageFile', UserController.getImageFile);

module.exports = api;