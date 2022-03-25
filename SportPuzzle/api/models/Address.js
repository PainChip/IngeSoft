var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var AddressSchema = Schema({
    default: Boolean,
    calle: String,
    numExt: String,
    colonia: String,
    codPostal: String,
    userId: String
});

module.exports = mongoose.model("Address", AddressSchema);