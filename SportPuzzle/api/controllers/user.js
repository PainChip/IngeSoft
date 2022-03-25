var path = require('path');
var fs = require('fs');

var bcrypt = require("bcrypt-nodejs");
var User = require("../models/user");
var jwt = require("../services/jwt");
var mongoosePaginate = require("mongoose-pagination");

function createUser(req, res) {
  var params = req.body;
  var user = new User();

  if (
    params.name &&
    params.surname &&
    params.nick &&
    params.email &&
    params.password &&
    params.role
  ) {
    user.name = params.name;
    user.surname = params.surname;
    user.nick = params.nick;
    user.email = params.email;
    user.role = params.role;
    user.image = "default.jpg";

    //Validamos que los datos email y nick no esten ya registrados.
    User.find({
      $or: [
        { email: user.email.toLowerCase() },
        { nick: user.nick.toLowerCase() },
        { nick: user.nick },
      ],
    }).exec((err, users) => {
      if (err) {
        console.log(err);
        return res.status(500).send({ message: "Error en la petición." }); 
      }

      if (users && users.length >= 1) {
        console.log("Esta cuenta ya existe.");
        return res.status(201).send({ message: "Esta cuenta ya existe." });
      } else {
        //Encriptamos la contraseña
        bcrypt.hash(params.password, null, null, (err, hash) => {
          user.password = hash;

          user.save((err, userStored) => {
            if (err){
              console.log(err);
              return res.status(500).send({ message: "Error al guardar el usuario." });
            }

            if (userStored) {
              console.log(userStored);
              res.status(200).send({ message: userStored });
            } else {
              console.log("No se ha registrado el usuario.");
              res.status(204).send({ message: "No se ha registrado el usuario." });
            }
          });
        });
      }
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(201).send({ message: "Envia todos los datos faltantes." });
  }
}

function loginUser(req, res) {
  var params = req.body;
  var email = params.email;
  var password = params.password;

  if(email && password) {
    User.findOne({ email: email }, (err, user) => {
      if (err) {
        console.log(err);
        return res.status(500).send({ message: "Error en la petición." });
      }
  
      if (user) {
        bcrypt.compare(password, user.password, (err, check) => {
          if (check) {
            //Para poder ver el token el los params agregamos una variable llamada gettoken = true
            if (params.gettoken) {
              //Generar y devolver un token
              return res.status(200).send({ token: jwt.createToken(user) });
            } else {
              //devolver datos de usuario
              user.password = undefined;
              return res.status(200).send({ user });
            }
          } else {
            console.log("Este usuario no se pudo identificar.");
            return res.status(204).send({ message: "Este usuario no se pudo identificar." });
          }
        });
      } else {
        console.log("Este usuario no se pudo identificar!.");
        return res.status(204).send({ message: "Este usuario no se pudo identificar!." });
      }
    });
  } else {
    console.log("Envia todos los datos faltantes.");
    res.status(201).send({ message: "Envia todos los datos faltantes." });
  }
}

function updateUser(req, res) {
  var userId = req.params.id;
  var update = req.body;
  delete update.password;

  if (userId != req.user.sub) {
    console.log("No tienes permisos para editar los datos de este perfil.");
    return res.status(500).send({message: "No tienes permisos para editar los datos de este perfil.",});
  }

  User.find({
    $or: [
      { email: update.email.toLowerCase() },
      { nick: update.nick.toLowerCase() },
      { nick: update.nick },
    ],
  }).exec((err, users) => {
    var user_isset = false;

    users.forEach((user) => {
      if (user && user._id != userId) user_isset = true;
    });

    if (user_isset) {
      console.log("Los datos ya estan en uso");
      return res.status(404).send({ message: "Los datos ya estan en uso" });
    }

    User.findByIdAndUpdate(
      userId,
      update,
      { new: true, useFindAndModify: false },
      (err, userUpdate) => {
        if (err) {
          console.log(err);
          return res.status(500).send({ message: "Error en la petición updateUser()" });
        }

        if (!userUpdate) {
          console.log("No se ha podido actualizar el usuario.");
          return res.status(404).send({ message: "No se ha podido actualizar el usuario." });
        }

        console.log(userUpdate);
        return res.status(200).send({ user: userUpdate });
      }
    );
  });
}

function getUser(req, res) {

  User.findById(req.user.sub, (err, user) => {
    if (err) {
      console.log(err);
      return res.status(500).send({ message: "Error en la peticion." });
    }
    if (!user) {
      console.log("El usuario no existe");
      return res.status(404).send({ message: "El usuario no existe" });
    }
    return res.status(200).send({ user: user });
  });
}

function getUserById(req, res) {
  var userId = req.params.id;

  User.findById(userId, (err, user) => {
    if (err) {
      console.log(err);
      return res.status(500).send({ message: "Error en la peticion." });
    }
    if (!user) {
      console.log("El usuario no existe");
      return res.status(404).send({ message: "El usuario no existe" });
    }
    return res.status(200).send({ user: user });
  });
}

function getAllUer(req, res) {
  var page = 1;
  if (req.params.page) {
    page = req.params.page;
  }

  var itemsPerPage = 5;
  User.find()
    .sort("_id")
    .paginate(page, itemsPerPage, (err, users, total) => {
      if (err) {
        console.log(err);
        return res.status(500).send({ message: "Error en la peticio getUsers()" });
      }

      if (!users) {
        console.log("No hay usuarios disponibles.");
        return res.status(404).send({ message: "No hay usuarios disponibles." });
      }

      return res.status(200).send({
        users,
        total,
        pages: Math.ceil(total / itemsPerPage),
      });
    });
}

//SUBIR IMAGENES
function uploadImage(req, res) {

	if(req.files){
		var file_path = req.files.image.path;
		var file_split = file_path.split('\\');
		var file_name = file_split[2]; //Obtenemos el nombre de la imagen.
		var ext_split = file_name.split('\.'); //Cortamos la extension del archivo.
		var file_ext = ext_split[1];

		if(file_ext == 'png' || file_ext == 'jpg' || file_ext == 'jpeg' || file_ext == 'gif'){
			
			User.findByIdAndUpdate(req.user.sub, {image: file_name}, {new:true}, (err, userUpdate)=>{
        if(err) {
          console.log(err);
          return res.status(500).send({ message: 'Error en la petición.' });
        }
      
        if(!userUpdate) {
          console.log("No se ha podido actualizar el usuario.");
          return res.status(404).send({ message: 'No se ha podido actualizar el usuario.' });
        }
        
        console.log(userUpdate);
        res.status(200).send(userUpdate);
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
	var path_file = './uploads/users/' + image_files;

	fs.exists(path_file, (exists)=>{
		return exists ? res.sendFile(path.resolve(path_file)) : res.status(200).send({ message: 'No existe la imagen...' });
	})
}

module.exports = {
  createUser,
  loginUser,
  updateUser,
  getUserById,
  getAllUer,
  getUser,
  uploadImage,
  getImageFile
};
