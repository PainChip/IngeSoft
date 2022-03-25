var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var HistorySchema = Schema({
    userId: {type: Schema.ObjectId, ref: 'User'},
    product: {type: Schema.ObjectId, ref: 'Product'},
    date: String,
});

module.exports = mongoose.model("History", HistorySchema);