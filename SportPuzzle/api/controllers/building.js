var Processor = require("../models/processor");
var Motherboard = require("../models/motherboard");
var GraphicCard = require("../models/graphicCard");
var Storage = require("../models/storage");
var Ram = require("../models/ram");
var Cabinet = require("../models/cabinet");
var Powersupply = require("../models/powersupply");

function getType(req, res) {
  var params = req.body;

  if (params.typeProcessor) {
    Processor.find({
      $and: [{ type: params.typeProcessor }, { active: true }],
    }).exec((err, processors) => {
      if (err) {
        console.log("Error en la petición.");
        return res.status(500).send({ message: "Error en la petición." });
      }

      if (!processors) {
        console.log("El tipo de procesador no existe");
        return res
          .status(404)
          .send({ message: "El tipo de procesador no existe" });
      }

      console.log(req.user.sub);
      console.log(processors);
      return res.status(200).send({ processors: processors });
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}

function getProcessor(req, res) {
  var params = req.body;

  if (params.socket && params.chipset) {
    Motherboard.find({
      $and: [{ socket: params.socket }, { chipset: params.chipset }],
    }).exec((err, motherboards) => {
      if (err) {
        console.log("Error en la petición.");
        return res.status(500).send({ message: "Error en la petición." });
      }

      if (!motherboards) {
        console.log("El tipo de tarjeta madre no existe");
        return res
          .status(404)
          .send({ message: "El tipo de tarjeta madre no existe" });
      }

      console.log(motherboards);
      return res.status(200).send({ motherboards: motherboards });
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}

function getMotherboard(req, res) {
  var params = req.body;

  if (params.idMotherboard) {
    GraphicCard.find().exec((err, graphicCards) => {
      if (err) {
        console.log("Error en la petición.");
        return res.status(500).send({ message: "Error en la petición." });
      }

      console.log({ graphicCards, graphicCards });
      return res.status(200).send({ graphicCards, graphicCards });
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}

function getStorage(req, res) {

  Storage.find().exec((err, storages) => {
    if (err) {
      console.log("Error en la petición.");
      return res.status(500).send({ message: "Error en la petición." });
    }

    console.log(storages);
    return res.status(200).send({ storages, storages });
  });
}

function getRam(req, res) {
  Ram.find().exec((err, rams) => {
    if (err) {
      console.log("Error en la petición.");
      return res.status(500).send({ message: "Error en la petición." });
    }

    console.log(rams);
    return res.status(200).send({ rams, rams });
  });
}

function getCabinet(req, res) {
  var params = req.body;

  if (params.size) {
    Cabinet.find({ $and: [{ size: params.size }] }).exec((err, cabinets) => {
      if (err) {
        console.log("Error en la petición.");
        return res.status(500).send({ message: "Error en la petición." });
      }

      console.log(cabinets);
      return res.status(200).send({ cabinets, cabinets });
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}

function getPowerSupply(req, res) {
  var params = req.body;

  if (params.totalWatts) {
    Powersupply.find({ $and: [{ wattage: { $gt: params.totalWatts } }] }).exec(
      (err, powerSupplys) => {
        if (err) {
          console.log("Error en la petición.");
          return res.status(500).send({ message: "Error en la petición." });
        }

        console.log(powerSupplys);
        return res.status(200).send({ powerSupplys, powerSupplys });
      }
    );
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}

module.exports = {
  getType,
  getProcessor,
  getMotherboard,
  getStorage,
  getRam,
  getCabinet,
  getPowerSupply
};
