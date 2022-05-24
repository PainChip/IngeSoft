var express = require('express');

var CategoryController = require('../controllers/categoryController');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

api.post('/createCategory', md_auth.ensureAuth, CategoryController.createCategory);
api.get('/getAllCategories', CategoryController.getAllCategories);

module.exports = api;