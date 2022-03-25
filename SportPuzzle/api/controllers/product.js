var path = require('path');
var fs = require('fs');

var Product = require("../models/product");
var Processor = require("../models/processor");
var Motherboard = require("../models/motherboard");
var GraphicCard = require("../models/graphicCard");
var Storage = require("../models/storage");
var Ram = require("../models/ram");
var Cabinet = require("../models/cabinet");
var Powersupply = require("../models/powersupply");

function createProduct(req, res) {
  var params = req.body;
  var product = new Product();

  if(params.name && params.description && params.image && params.cost && params.categorie) {
    product.name = params.name;
    product.description = params.description;
    product.image = 'null';
    product.cost = params.cost;
    product.categorie = params.categorie;
    product.active = true;

    product.save((err, productStored) => {
      if(err) {
        console.log(err);
        return res.status(500).send({ message: "Error al guardar el producto." });
      } 

      if(productStored) {
        console.log(productStored);

        switch (product.categorie) {
          case "CABINET":
            var cabinet = new Cabinet();
            
            cabinet.name = productStored.name;
            cabinet.description = productStored.description;
            cabinet.image = productStored.image;
            cabinet.cost = productStored.cost;
            cabinet.size = params.size;
            cabinet.color = params.color;
            cabinet.slots3_5 = params.slots3_5;
            cabinet.slots2_5 = params.slots2_5;
            cabinet.watts = params.watts;
            cabinet.active = true;
            cabinet.productId = productStored._id;

            cabinet.save((err, cabinetStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el gabinete." });
              }
              
              if(cabinetStored) {
                console.log(cabinetStored);
                res.status(200).send({ message: cabinetStored });
              } else {
                console.log("No se ha registrado el gabinete.");
                res.status(204).send({ message: "No se ha registrado el gabinete." });
              }
            });

            break;
    
          case "GRAPHICCARD":
            var graphicCard = new GraphicCard();

            graphicCard.name = productStored.name;
            graphicCard.description = productStored.description;
            graphicCard.image = productStored.image;
            graphicCard.cost = productStored.cost;
            graphicCard.vel = params.vel;
            graphicCard.type = params.type;
            graphicCard.watts = params.watts;
            graphicCard.active = true;
            graphicCard.productId = productStored._id;

            graphicCard.save((err, graphicCardStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar la tarjeta grafica." });
              }
              
              if(graphicCardStored) {
                console.log(graphicCardStored);
                res.status(200).send({ message: graphicCardStored });
              } else {
                console.log("No se ha registrado la tarjeta grafica.");
                res.status(204).send({ message: "No se ha registrado la tarjeta grafica." });
              }
            });
            
            break;
    
          case "MOTHERBOARD":
            var motherboard = new Motherboard();

            motherboard.name = productStored.name;
            motherboard.description = productStored.description;
            motherboard.image = productStored.image;
            motherboard.cost = productStored.cost;
            motherboard.socket = params.socket;
            motherboard.chipset = params.chipset;
            motherboard.m2 = params.m2;
            motherboard.velRam = params.velRam;
            motherboard.ramMax = params.ramMax;
            motherboard.size = params.size;
            motherboard.watts = params.watts;
            motherboard.active = true;
            motherboard.productId = productStored._id;

            motherboard.save((err, motherboardStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar la placa." });
              }
              
              if(motherboardStored) {
                console.log(motherboardStored);
                res.status(200).send({ message: motherboardStored });
              } else {
                console.log("No se ha registrado la placa.");
                res.status(204).send({ message: "No se ha registrado la placa." });
              }
            });

            break;
    
          case "POWERSUPPLY":
            var powersupply = new Powersupply();

            powersupply.name = productStored.name;
            powersupply.description = productStored.description;
            powersupply.image = productStored.image;
            powersupply.cost = productStored.cost;
            powersupply.certification = params.certification;
            powersupply.color = params.color;
            powersupply.wattage = params.wattage;
            powersupply.watts = params.watts;
            powersupply.active = true;
            powersupply.productId = productStored._id;

            powersupply.save((err, powersupplyStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar la fuente de poder." });
              }
              
              if(powersupplyStored) {
                console.log(powersupplyStored);
                res.status(200).send({ message: powersupplyStored });
              } else {
                console.log("No se ha registrado la fuente de poder.");
                res.status(204).send({ message: "No se ha registrado la fuente de poder." });
              }
            });

            break;
    
          case "PROCESSOR":
            var processor = new Processor();

            processor.name = productStored.name;
            processor.description = productStored.description;
            processor.image = productStored.image;
            processor.cost = productStored.cost;
            processor.type = params.type;
            processor.cores = params.cores;
            processor.speed = params.speed;
            processor.socket = params.socket;
            processor.chipset = params.chipset;
            processor.watts = params.watts;
            processor.active = true;
            processor.productId = productStored._id;

            processor.save((err, processorStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el procesador." });
              }
              
              if(processorStored) {
                console.log(processorStored);
                res.status(200).send({ message: processorStored });
              } else {
                console.log("No se ha registrado el procesador.");
                res.status(204).send({ message: "No se ha registrado el procesador." });
              }
            });

            break;
    
          case "RAM":
            var ram = new Ram();

            ram.name = productStored.name;
            ram.description = productStored.description;
            ram.image = productStored.image;
            ram.cost = productStored.cost;
            ram.type = params.type;
            ram.size = params.size;
            ram.watts = params.watts;
            ram.active = true;
            ram.productId = productStored._id;

            ram.save((err, ramStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar la ram." });
              }
              
              if(ramStored) {
                console.log(ramStored);
                res.status(200).send({ message: ramStored });
              } else {
                console.log("No se ha registrado la ram.");
                res.status(204).send({ message: "No se ha registrado la ram." });
              }
            });

            break;
    
          case "STORAGE":
            var storage = new Storage();

            storage.name = productStored.name;
            storage.description = productStored.description;
            storage.image = productStored.image;
            storage.cost = productStored.cost;
            storage.type = params.type;
            storage.typ2 = params.typ2;
            storage.size = params.size;
            storage.watts = params.watts;
            storage.active = true;
            storage.productId = productStored._id;

            storage.save((err, storageStored) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el almacenamiento." });
              }
              
              if(storageStored) {
                console.log(storageStored);
                res.status(200).send({ message: storageStored });
              } else {
                console.log("No se ha registrado el almacenamiento.");
                res.status(204).send({ message: "No se ha registrado el almacenamiento." });
              }
            });

            break;
    
          default:
            return res.status(404).send("Petición no valida.");
            break;
        }

      } else {
        console.log("No se ha registrado el producto.");
        res.status(204).send({ message: "No se ha registrado el producto." });
      }
    })
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(201).send({ message: "Envia todos los datos faltantes." });
  }
}

function getAllProducts(req, res) {
  var page = 1;
  if (req.params.page) {
    page = req.params.page;
  }

  var itemsPerPage = 5;
  Product.find()
    .sort("_id")
    .paginate(page, itemsPerPage, (err, products, total) => {
      if (err) return res.status(500).send({ message: "Error en la peticio" });

      if (!products)
        return res
          .status(404)
          .send({ message: "No hay productos disponibles." });

      return res.status(200).send({
        products,
        total,
        pages: Math.ceil(total / itemsPerPage),
      });
    });
}
function getProductsIndex(req, res) {
  var page = 1;
  if (req.params.page) {
    page = req.params.page;
  }

  var itemsPerPage = 8;
  Product.find()
    .sort("_id")
    .paginate(page, itemsPerPage, (err, products, total) => {
      if (err) return res.status(500).send({ message: "Error en la peticio" });

      if (!products)
        return res
          .status(404)
          .send({ message: "No hay productos disponibles." });

      return res.status(200).send({
        products,
        total,
        pages: Math.ceil(total / itemsPerPage),
      });
    });
}
function getProductsCarrousel(req, res) {
  var page = 1;
  if (req.params.page) {
    page = req.params.page;
  }

  var itemsPerPage = 3;
  Product.find()
    .sort("_id")
    .paginate(page, itemsPerPage, (err, products, total) => {
      if (err) return res.status(500).send({ message: "Error en la peticio" });

      if (!products)
        return res
          .status(404)
          .send({ message: "No hay productos disponibles." });

      return res.status(200).send({
        products,
        total,
        pages: Math.ceil(total / itemsPerPage),
      });
    });
}

function getSearchCategory(req, res) {
  var params = req.params;

  if (params.categorie) {
    switch (params.categorie) {
      case "CABINET":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 6;
        Cabinet.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, cabinet, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!cabinet)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              cabinet,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      case "GRAPHICCARD":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 5;
        GraphicCard.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, graphiccard, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!graphiccard)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              graphiccard,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      case "MOTHERBOARD":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 5;
        Motherboard.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, motherboard, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!motherboard)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              motherboard,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      case "POWERSUPPLY":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 5;
        Powersupply.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, powersupply, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!powersupply)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              powersupply,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      case "PROCESSOR":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 5;
        Processor.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, processor, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!processor)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              processor,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      case "RAM":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 5;
        Ram.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, ram, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!ram)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              ram,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      case "STORAGE":
        var page = 1;
        if (req.params.page) {
          page = req.params.page;
        }

        var itemsPerPage = 5;
        Storage.find()
          .sort("_id")
          .paginate(page, itemsPerPage, (err, storage, total) => {
            if (err) return res.status(500).send({ message: "Error en la peticio" });

            if (!storage)
              return res
                .status(404)
                .send({ message: "No hay productos disponibles." });

            return res.status(200).send({
              storage,
              total,
              pages: Math.ceil(total / itemsPerPage),
            });
          });
      break;

      default:
        return res.status(404).send("Petición no valida.");
        break;
    }
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}
function getSearchWord(req, res) {
  var page = 1;
  var word;
  if (req.params.page) {
    page = req.params.page;
  }
  if (req.params.word) {
    word = req.params.word;
  }

  var itemsPerPage = 6;

  Product.find({ name: {$regex: word} })
    .sort("_id")
    .paginate(page, itemsPerPage, (err, products, total) => {
      if (err) return res.status(500).send({ message: "Error en la peticio" });

      if (!products)
        return res
          .status(404)
          .send({ message: "No hay productos disponibles." });

      return res.status(200).send({
        products,
        total,
        pages: Math.ceil(total / itemsPerPage),
      });
    });
}

function getProductByIdAndCategorie(req, res) {
  var params = req.params;

  if (params.productId && params.categorie) {
    switch (params.categorie) {
      case "CABINET":
        Cabinet.find({ productId: params.productId }).exec((err, cabinet) => {
          if (err) {
            console.log(err);
            return res.status(500).send({ message: "Error en la petición." });
          }

          console.log(cabinet);
          return res.status(200).send(cabinet);
        });
        break;

      case "GRAPHICCARD":
        GraphicCard.find({ productId: params.productId }).exec(
          (err, graphicCard) => {
            if (err) {
              console.log(err);
              return res.status(500).send({ message: "Error en la petición." });
            }

            console.log(graphicCard);
            return res.status(200).send(graphicCard);
          }
        );
        break;

      case "MOTHERBOARD":
        Motherboard.find({ productId: params.productId }).exec(
          (err, motherboard) => {
            if (err) {
              console.log(err);
              return res.status(500).send({ message: "Error en la petición." });
            }

            console.log(motherboard);
            return res.status(200).send(motherboard);
          }
        );
        break;

      case "POWERSUPPLY":
        Powersupply.find({ productId: params.productId }).exec(
          (err, powersupply) => {
            if (err) {
              console.log(err);
              return res.status(500).send({ message: "Error en la petición." });
            }

            console.log(powersupply);
            return res.status(200).send(powersupply);
          }
        );
        break;

      case "PROCESSOR":
        Processor.find({ productId: params.productId }).exec(
          (err, processor) => {
            if (err) {
              console.log(err);
              return res.status(500).send({ message: "Error en la petición." });
            }

            console.log(processor);
            return res.status(200).send(processor);
          }
        );
        break;

      case "RAM":
        Ram.find({ productId: params.productId }).exec((err, ram) => {
          if (err) {
            console.log(err);
            return res.status(500).send({ message: "Error en la petición." });
          }

          console.log(ram);
          return res.status(200).send(ram);
        });
        break;

      case "STORAGE":
        console.log(params.productId);
        Storage.find({ productId: params.productId }).exec((err, storage) => {
          if (err) {
            console.log(err);
            return res.status(500).send({ message: "Error en la petición." });
          }

          console.log(storage);
          return res.status(200).send(storage);
        });
        break;

      default:
        return res.status(404).send("Petición no valida.");
        break;
    }
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
}

function getProductById(req, res) {
  if(req.params.productId) {
    Product.findById(req.params.productId, (err, product) => {
      if(err) {
        console.log(err);
        return res.status(500).send({message: 'Error al obtener el producto.'});
      }
  
      if(!product) {
        console.log("El producto no existe.")
        return res.status(404).send({message: 'El producto no existe.'});
      }
  
      console.log(product);
      return res.status(200).send(product);
    });
  } else {

  }
}

function getTotalActiveProducts(req, res) {
  Product.find({active: true}).count((err, counter) => {
    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener la cantidad de productos registrados.'});
    }

    if(!counter) {
      console.log("Sin productos registrados.")
      return res.status(404).send({message: 'Sin productos registrados.'});
    }

    console.log(counter);
    return res.status(200).send({totalActiveProducts: counter});
  });
}

//SUBIR IMAGENES
function uploadImage(req, res) {
	var productId = req.params.id;

	if(req.files){
		var file_path = req.files.image.path;
		var file_split = file_path.split('\\');
		var file_name = file_split[2]; //Obtenemos el nombre de la imagen.
		var ext_split = file_name.split('\.'); //Cortamos la extension del archivo.
		var file_ext = ext_split[1];

		if(file_ext == 'png' || file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'gif'){
			
			Product.findByIdAndUpdate(productId, {image: file_name}, {new:true}, (err, productUpdate)=>{
        if(err) {
          console.log(err);
          return res.status(500).send({ message: 'Error en la petición.' });
        }
      
        if(!productUpdate) {
          console.log("No se ha podido actualizar el producto.");
          return res.status(404).send({ message: 'No se ha podido actualizar el producto.' });
        }
        
        console.log(productUpdate);

        switch (req.body.category) {
          case "CABINET":
            
            Cabinet.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });

            break;
    
          case "GRAPHICCARD":
            
            GraphicCard.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });
            
            break;
    
          case "MOTHERBOARD":
            
            Motherboard.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });

            break;
    
          case "POWERSUPPLY":
            
            Powersupply.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });

            break;
    
          case "PROCESSOR":
            
            Processor.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });

            break;
    
          case "RAM":
            
            Ram.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });

            break;
    
          case "STORAGE":
            
            Storage.updateOne({productId:productId}, {image: file_name}, {'multi': true}, (err, cabinetUpdate) => {
              if(err) {
                console.log(err);
                return res.status(500).send({ message: "Error al guardar el producto." });
              } 

              if(!cabinetUpdate) {
                console.log("No se ha podido actualizar el gabinete.");
                return res.status(404).send({ message: 'No se ha podido actualizar el gabinete.' });
              }

              console.log(cabinetUpdate);
              return res.status(200).send({ cabinet: cabinetUpdate });
            });

            break;
    
          default:
            return res.status(404).send("Petición no valida.");
            break;
        }

			});

		}else{
			return removeFilesOfUploads(res, file_path, 'Extension no es valida.');
		}

	}else{
    console.log("No se han subido imagenes.");
		res.status(200).send({ message: 'No se han subido imagenes.' });
	}
}

function getImageFile(req, res){
	var image_files = req.params.imageFile;
	var path_file = './uploads/products/' + image_files;

	fs.exists(path_file, (exists)=>{
		return exists ? res.sendFile(path.resolve(path_file)) : res.status(200).send({ message: 'No existe la imagen...' });
	})
}

module.exports = {
  getAllProducts,
  getProductByIdAndCategorie,
  createProduct,
  uploadImage,
  getImageFile,
  getProductsIndex,
  getProductsCarrousel,
  getSearchCategory,
  getSearchWord,
  getTotalActiveProducts,
  getProductById
};
