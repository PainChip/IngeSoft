var path = require('path');
var fs = require('fs');
var moment = require('moment');

var Product = require("../models/productModel.js");
var Category = require("../models/categoryModel.js");

function createProduct(req, res) {
    if(req.user.role != "ADMIN") {
        return res.status(403).send({ message: "Permisos insuficientes." }); 
    }
    
    var params = req.body;
    var product = new Product();
    product.name = params.name;
    product.description = params.description;
    product.price = params.price;
    product.image = params.image;
    product.active = params.active;
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
        product.active = 1;
        product.creationDate = moment().unix();
        product.lastUpdateDate  = moment().unix();
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

function editProduct(req, res) {
    if(req.user.role != "ADMIN") {
        return res.status(403).send({ message: "Permisos insuficientes." }); 
    }

    var params = req.body;
    var productId = req.params.product;

    if(product === false || !productId) {
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
        Product.findByIdAndUpdate(productId, 
            {$set: {
                name: params.name,
                description: params.description,
                price: params.price,
                characteristics: params.characteristics,
                category: params.category,
                lastUpdateDate:moment().unix()
            }}
        , { new: true, useFindAndModify: false }, (err, productUpdate) => {
            if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al actualizar el producto." });
            }

            if(!productUpdate) {
                console.log("No se ha actualizado el producto.");
                return res.status(204).send({ message: "No se ha actualizado el producto." });
            }

            console.log(productUpdate);
            return res.status(200).send({ message: true });
        });
    }); 
}

function dropProduct(req, res) {
    var productId = req.params.product;

    Product.findByIdAndUpdate(productId,{$set:{active:0, lastUpdateDate:moment().unix()}}, (err, productUpdate) => {
        if(err) {
            console.log(err);
            return res.status(500).send({ message: "Error al actualizar el producto." });
        }

        if(!productUpdate) {
            console.log("No se ha actualizado el producto.");
            return res.status(204).send({ message: "No se ha actualizado el producto." });
        }

        console.log(productUpdate);
        return res.status(200).send({ message: true });
    });
}

function getProduct(req, res) {
    var productId = req.params.product;

    Product.findOne({_id:productId,active:1}, (err, product) => {
        if(err) {
            console.log(err);
            return res.status(500).send({message:"Error en la petición al obtener el producto."})
        }

        if(!product) {
            console.log(`No se ha encontrado el producto con el id: ${productId}`);
            return res.status(204).send({ message: "No se ha encontrado el producto." });
        }

        console.log(product);
        return res.status(200).send(product);
    });
}

function getProducts(req, res) {
    Product.find({active:1}, (err, products) => {
        if(err) {
            console.log(err);
            return res.status(500).send({message:"Error en la petición al obtener el producto."})
        }

        if(!products[0]) {
            console.log("No se encuentran productos registrados.");
            return res.status(204).send({ message: "No se encuentran productos registrados." });
        }

        console.log(products);
        return res.status(200).send(products);
    });
}

function getProductsByCat(req, res) {
    var categoryId = req.params.category;
    Product.find({category:categoryId}, (err, products) => {
        if(err) {
            console.log(err);
            return res.status(500).send({message:"Error en la petición al obtener el producto."})
        }

        if(!products[0]) {
            console.log("No se encuentran productos registrados.");
            return res.status(204).send({ message: "No se encuentran productos registrados." });
        }

        console.log(products);
        return res.status(200).send(products);
    });
}


function getTopProducts(req, res) {
    Product.find({active:1}).populate('category').sort({creationDate: -1}).limit(3).exec((err, products) => {
        if(err) {
            console.log(err);
            return res.status(500).send({message: "Error en la petición al obtener los productos."});
        }

        if(!products[0]) {
            console.log("No se encuentran productos registrados.");
            return res.status(204).send({ message: "No se encuentran productos registrados." });
        }

        console.log(products);
        return res.status(200).send(products);
    });
}
function getTopProducts2(req, res) {
    Product.find({active:1}).populate('category').sort({creationDate: 1}).limit(3).exec((err, products) => {
        if(err) {
            console.log(err);
            return res.status(500).send({message: "Error en la petición al obtener los productos."});
        }

        if(!products[0]) {
            console.log("No se encuentran productos registrados.");
            return res.status(204).send({ message: "No se encuentran productos registrados." });
        }

        console.log(products);
        return res.status(200).send(products);
    });
}

module.exports = {
    createProduct,
    editProduct,
    dropProduct,
    getProduct,
    getTopProducts,
    getTopProducts2,
    getProducts,
    getProductsByCat
};