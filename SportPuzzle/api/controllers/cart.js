
var Product = require("../models/product");
var Cart = require("../models/cart");

function saveBuilding(req, res) {
    var params = req.body;
    var cart = new Cart();
  
    if (params.productsBuild) {

      Cart.find({userId: req.user.sub}).remove(err => {
  
        if(err) {
          console.log(err);
          return res.status(500).send({message: 'Error al borrar el Carrito.'});
        }

        cart.userId = req.user.sub;
        cart.products = params.productsBuild;
        cart.save((err, cartStored) => {
            if (err) {
              console.log(err);
              return res
                .status(500)
                .send({ message: "Error al guardar el Carrito." });
            }
      
            if (cartStored) {
              console.log(cartStored);
              res.status(200).send({ message: cartStored });
            } else {
              console.log("No se ha registrado el Carrito.");
              res.status(404).send({ message: "No se ha registrado el Carrito." });
            }
          });
  
        console.log("Carrito borrado correctamente.");
  
      });

    } else {
      console.log("Envia todos los datos faltantes.");
      res.status(200).send({ message: "Envia todos los datos faltantes." });
    }
}

function deleteBuilding(req, res) {
  
  Cart.find({userId: req.user.sub}).remove(err => {
  
    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al borrar el Carrito.'});
    }

    console.log("Carrito borrado correctamente.");
    return res.status(200).send({message: 'Carrito borrado correctamente.'});

  });

}

function deleteItemByUserIdAndProductId(req, res) {

  console.log(req.user.sub);
  console.log(req.params.productId);

  if(req.params.productId) {
    Cart.updateOne({userId: req.user.sub}, { $pull: {products : req.params.productId }}, (err, resp) => {
    
      if (err) {
        console.log(err);
        return res.status(500).send({ message: "Error en la petición deleteItemByUserIdAndProductId()" });
      }
  
      console.log(resp);
      return res.status(200).send({message: 'Elemento borrado correctamente.'});
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(200).send({ message: "Envia todos los datos faltantes." });
  }
  
}

function getCart(req, res) {

  Cart.find({userId: req.user.sub}).populate({path:'products'}).exec((err, cart) => {

    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener el carrito.'});
    }

    if(!cart) {
      console.log("El carrito no existe.")
      return res.status(404).send({message: 'El carrito no existe.'});
    }

    console.log(cart);
    return res.status(200).send(cart);

  });

}

function getTotalCartsActive(req, res) {
  Cart.count((err, counter) => {
    if(err) {
      console.log(err);
      return res.status(500).send({message: 'Error al obtener la cantidad de carrtios activos.'});
    }

    if(!counter) {
      console.log("Sin carritos registrados.")
      return res.status(404).send({message: 'Sin carritos registrados.'});
    }

    console.log(counter);
    return res.status(200).send({totalActiveCarts: counter});
  });
}

module.exports = {
    saveBuilding,
    deleteBuilding,
    getCart, 
    deleteItemByUserIdAndProductId,
    getTotalCartsActive
};