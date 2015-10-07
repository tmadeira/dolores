"use strict";

var $ = require("jquery");

var setup = function() {
  $("#form-tema").submit(function() {
    var message = "Você precisa ser cadastrado para enviar uma ideia.";
    var callback = function() {
      alert("Em construção.");
      // TODO
    };
    window.DoloresAuthenticator.signIn(message, callback);
    return false;
  });
};

module.exports = {
  setup: setup
};
