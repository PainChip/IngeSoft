var express = require('express');

var BuildingController = require('../controllers/building');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

api.post('/getType-building', md_auth.ensureAuth, BuildingController.getType);
api.post('/getProcessor-building', md_auth.ensureAuth, BuildingController.getProcessor);
api.post('/getMotherboard-building', md_auth.ensureAuth, BuildingController.getMotherboard);
api.post('/getStorage-building', md_auth.ensureAuth, BuildingController.getStorage);
api.post('/getRam-building', md_auth.ensureAuth, BuildingController.getRam);
api.post('/getCabinet-building', md_auth.ensureAuth, BuildingController.getCabinet);
api.post('/getPowerSupply-building', md_auth.ensureAuth, BuildingController.getPowerSupply);

module.exports = api;