var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var GraphicCardSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    vel: String,
    type: String,
    /* Gddr6 etc */
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("GraphicCard", GraphicCardSchema);