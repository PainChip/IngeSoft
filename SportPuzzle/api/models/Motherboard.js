var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var MotherboardSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    socket: String,
    chipset: String,
    m2: Boolean,
    velRam: [String],
    ramMax: String,
    size: String,
    /* atx, microatx, miniatx */
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("Motherboard", MotherboardSchema);