var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var StorageSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    type: String,
    /* DiscoDuro solido */
    typ2: String,
    /* m2 o sata */
    size: String,
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("Storage", StorageSchema);