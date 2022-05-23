var mongoose = require('mongoose');
var Schema = mongoose.Schema;

var UserSchema = Schema({
    nickName: String,
    fullName: String,
    email: String,
    password: String, 
    role: String, 
    image: String,
    active: Boolean
});

module.exports = mongoose.model("User", UserSchema);