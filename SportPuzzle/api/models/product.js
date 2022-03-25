var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var ProductSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    categorie: String,
    active: Boolean,
});

module.exports = mongoose.model("Product", ProductSchema);