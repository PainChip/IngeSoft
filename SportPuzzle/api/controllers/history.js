var Product = require("../models/product");
var User = require("../models/user");
var History = require("../models/history");

var moment = require("moment");

function saveHistory(req, res) {
    var params = req.body;
    var history = new History();
  
    if (params.product) {
      
      history.userId = req.user.sub;
      history.product = params.product;
      history.date = moment().unix();
  
      history.save((err, historyStored) => {
        if (err) {
          console.log(err);
          return res
            .status(500)
            .send({ message: "Error al guardar el Historial." });
        }
  
        if (historyStored) {
          console.log(historyStored);
          res.status(200).send({ message: historyStored });
        } else {
          console.log("No se ha registrado el Historial.");
          res.status(404).send({ message: "No se ha registrado el Historial." });
        }
      });
    } else {
      console.log("Envia todos los datos faltantes.");
      res.status(200).send({ message: "Envia todos los datos faltantes." });
    }
}

function getHistory(req, res) {

  History.find({userId: req.user.sub}).populate({path:'product'}).exec((err, histories) => {

    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener el Historial.'});
    }

    if(!histories) {
      console.log("El Historial no existe.")
      return res.status(404).send({message: 'El Historial no existe.'});
    }

    console.log(histories);
    return res.status(200).send(histories);

  });

}

function getReportSales(req, res) {

  History.find().sort('-date').populate({path:'product'}).populate({path:'userId'}).limit(6).exec((err, histories) => {

    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener el report.'});
    }

    if(!histories) {
      console.log("El report no existe.")
      return res.status(404).send({message: 'El report no existe.'});
    }

    console.log(histories);
    return res.status(200).send(histories);

  });

}

function getTotalSales(req, res) {

  History.find().sort('-date').populate({path:'product'}).exec((err, histories) => {

    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener el report.'});
    }

    if(!histories) {
      console.log("El report no existe.")
      return res.status(404).send({message: 'El report no existe.'});
    }

    var totalSales = 0;

    histories.forEach(element => {
      totalSales = totalSales + element.product.cost;
    });

    return res.status(200).send({totalSales: totalSales});

  });

}

function getReportTopSellingProducts(req, res) {

    const aggregatorOpts = [
      {
        $unwind: "$product",
      },
      {
        $group: {
          _id: "$product",
          count: { $sum: 1 },
        },
      }
    ];

  History.aggregate(aggregatorOpts).sort('-count').limit(6).exec((err, resp) => {
    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener el report.'});
    }

    if(!resp) {
      console.log("El report no existe.")
      return res.status(404).send({message: 'El report no existe.'});
    }

    console.log(resp)
    return res.status(200).send(resp);
    
  });

}


module.exports = {
    saveHistory,
    getHistory, 
    getReportSales, 
    getTotalSales,
    getReportTopSellingProducts
};