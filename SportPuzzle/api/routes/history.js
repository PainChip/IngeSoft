var express = require('express');

var HistoyController = require('../controllers/history');

var api = express.Router();

var md_auth = require('../middlewares/authenticated');

api.post('/saveHistory', md_auth.ensureAuth, HistoyController.saveHistory);
api.get('/history', md_auth.ensureAuth, HistoyController.getHistory);
api.get('/getReportSales', md_auth.ensureAuth, HistoyController.getReportSales);
api.get('/getTotalSales', md_auth.ensureAuth, HistoyController.getTotalSales);
api.get('/getReportTopSellingProducts', md_auth.ensureAuth, HistoyController.getReportTopSellingProducts);

module.exports = api;