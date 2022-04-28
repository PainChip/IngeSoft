var path = require('path');
var fs = require('fs');

var validationService = require("../services/validations"); 
var Product = require("../models/productModel.js");
var Category = require("../models/categoryModel.js");

function createProduct(req, res) {
    var params = req.body;
    var product = validationService.productValidation(params);
    
    if(product === false) {
        console.log("Datos del producto no validos.");
        return res.status(200).send({ message: "Datos del producto no validos." });
    }

    Category.find({name:params.category}, (err, category) => {
        if(err) {
            console.log(err);
            return res.status(500).send({ message: "Error en la petición." });
        }

        if(!category[0]) {
            console.log("No se encontro la categoria.");
            return res.status(204).send({ message: "No se encontro la categoria." });
        }

        product.category = category[0]._id;
        product.save((err, productStored) => {
            if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
            }
    
            if(!productStored) {
                console.log("El producto no se ha guardado correctamente.");
                return res.status(204).send({ message: "El producto no se ha guardado correctamente." });
            }
    
            console.log(productStored);
            return res.status(200).send({ message: productStored });
        });
    });
}

module.exports = {
    createProduct
};