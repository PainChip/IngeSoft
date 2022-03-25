var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var CabinetSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    size: String,
    /* atx, microatx, miniatx */
    color: String,
    slots3_5: String,
    slots2_5: String,
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("Cabinet", CabinetSchema);