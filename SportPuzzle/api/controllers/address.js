const { updateOne } = require('../models/address');
var Address = require('../models/address');
var User = require('../models/user'); 

function createAddress(req, res) {

    var params = req.body;

    if(params.calle && params.numExt && params.colonia && params.codPostal) {
        
        var newAddress = Address();
        newAddress.calle = params.calle;
        newAddress.numExt = params.numExt;
        newAddress.colonia = params.colonia;
        newAddress.codPostal = params.codPostal;
        newAddress.userId = req.user.sub; 
        newAddress.default = true;

        Address.find({userId: req.user.sub}).exec((err, address) => {
            
            if(err) {
                console.log(err);
                return res.status(500).send({message: 'Error en la petición createAddress.'});
            }

            address.forEach((addr) => {
                if (addr && addr.userId == req.user.sub) newAddress.default = false;
            });

            newAddress.save((err, addressStored) => {

                if(err) {
                    console.log(err);
                    return res.status(500).send({message: 'Error al guardar la nueva dirección.'});
                }

                if(addressStored) {
                    res.status(200).send(addressStored);
                } else {
                    res.status(404).send({ message: "No se ha registrado el usuario." });
                }

            });
          
        });

    } else {
        console.log("Envia todos los datos faltantes.");
        res.status(200).send({ message: "Envia todos los datos faltantes." });
    }

}

function deleteAddress(req, res) {

    if(req.user.sub) {
        Address.find({userId: req.user.sub}).remove(err => {
            if(err) {
                console.log(err);
                return res.status(500).send({message: 'Error al borrar la dirección.'});
            }
        
            return res.status(200).send({message: 'Dirección borrado correctamente.'});
        });
    } else {
        console.log("Envia todos los datos faltantes.");
        res.status(200).send({ message: "Envia todos los datos faltantes." });
    }

}

function updateAddress(req, res) {

    var params = req.body;

    if(params.calle && params.numExt && params.colonia && params.codPostal) {

        var updateAddress = Address();
        updateAddress.calle = params.calle;
        updateAddress.numExt = params.numExt;
        updateAddress.colonia = params.colonia;
        updateAddress.codPostal = params.codPostal;
        updateAddress.userId = req.user.sub;
        updateAddress.default = true;
        console.log(updateAddress);
        Address.findOneAndUpdate(
            {$and: [ {userId: req.user.sub}, {default: true} ] },
            {$set: {calle: params.calle, numExt: params.numExt, colonia: params.colonia, codPostal: params.codPostal}},
            (err, result) => {
             
                if(err) {
                    console.log(err);
                    return res.status(500).send({message: 'Error al actualizar los datos del default.'})
                }

                if(!result) {
                    console.log('No se ha podido actualizar los datos del default.')
                    return res.status(404).send({ message: "No se ha podido actualizar los datos del default." });
                } 

                console.log(result);
                return res.status(200).send({ addressUpdate: result });

            }
        );

    } else {
        console.log("Envia todos los datos faltantes.");
        res.status(200).send({ message: "Envia todos los datos faltantes." });
    }
}

function getAddressByUserId(req, res) {

    if(req.user.sub) {
        
        Address.find({userId: req.user.sub}).exec((err, addresses) => {
            
            if (err) {
                console.log(err);
                return res.status(500).send({ message: "Error en la petición." });
            }
        
            if (!addresses) {
                console.log("Direcciones no existen");
                return res.status(404).send({ message: "Direcciones no existen" });
            }
    
            console.log(addresses);
            return res.status(200).send( addresses );

        }); 

    } else {
        console.log("Envia todos los datos faltantes.");
        res.status(200).send({ message: "Envia todos los datos faltantes." });
    }

}

module.exports = {
    createAddress,
    deleteAddress,
    updateAddress,
    getAddressByUserId
};