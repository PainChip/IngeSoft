var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var RamSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: Number,
    type: String,
    /* DDR4 */
    size: String,
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("Ram", RamSchema);