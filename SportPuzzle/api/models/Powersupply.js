var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var PowersupplySchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    certification: String,
    color: String,
    wattage: Number,
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("Powersupply", PowersupplySchema);