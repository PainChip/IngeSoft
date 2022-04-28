var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var ProductSchema = Schema({
    name: String,
    description: String,
    price: Number, 
    characteristics: String,
    category: {type: Schema.ObjectId, ref: 'Category'},
    image: String,
    active: Boolean
});

module.exports = mongoose.model("Product", ProductSchema); 