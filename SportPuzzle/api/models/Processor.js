var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var ProcessorSchema = Schema({
    name: String,
    description: String,
    image: String,
    cost: String,
    type: String,
    /* True: AMD, False: Intel */
    cores: String,
    speed: String,
    socket: String,
    chipset: [{
        type: String
    }],
    /* Compatible list */
    watts: Number,
    active: Boolean,
    productId: String
});

module.exports = mongoose.model("Processor", ProcessorSchema);