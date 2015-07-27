"use strict";

var _ = require("lodash");

var API = require("./api");

var isValidString = function(value) {
  return _.isString(value) && value.length > 0;
};

var isValidEmail = function(value) {
  var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return re.test(value);
};

var validators = {
  isNonEmpty: function(name, value, callback) {
    if (!isValidString(value)) {
      callback(name, "Este campo é obrigatório.");
    }
  },

  isValidEmail: function(name, value, callback) {
    if (!isValidString(value)) {
      return;
    }

    if (!isValidEmail(value)) {
      callback(name, "O e-mail digitado é inválido.");
    } else {
      API.route("validate").get({email: value}).done(function(data) {
        if (!data.isValid) {
          callback(name, "Este e-mail já está cadastrado.");
        }
      });
    }
  },

  isValidLocation: function(name, value, callback) {
    if (!isValidString(value)) {
      return;
    }

    API.route("validate").get({location: value}).done(function(data) {
      if (!data.isValid) {
        callback(name, "Escolha uma localização válida.");
      }
    });
  }
};

var validate = function(name, value, options, callback) {
  for (var i = 0; i < options.length; i++) {
    var validator = validators[options[i]];
    if (_.isFunction(validator)) {
      validator(name, value, callback);
    }
  }
};

module.exports = validate;
