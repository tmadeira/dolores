"use strict";

var $ = require("jquery");

var API = require("./api");

var setup = function() {
  $("#form-tema").submit(function() {
    var request = {
      title: $(this).find("input[name='title']").val(),
      text: $(this).find("textarea[name='text']").val(),
      cat: $(this).find("input[name='cat']").val(),
      tags: [] // TODO
    };

    var button = $(this).find(".tema-form-button");

    var post = function() {
      button.prop("disabled", true);
      API.route("post").post(request).done(function(response) {
        if ("error" in response) {
          button.prop("disabled", false);
          alert("Erro ao publicar ideia: " + response.error);
        } else if ("url" in response) {
          location.href = response.url;
        }
      }).fail(function(response) {
        button.prop("disabled", false);
        console.log(response);
        if ("error" in response.responseJSON) {
          alert("Erro ao publicar ideia: " + response.responseJSON.error);
        }
      });
    };

    var message = "Você precisa ser cadastrado para publicar uma ideia.";
    window.DoloresAuthenticator.signIn(message, post);

    return false;
  });
};

module.exports = {
  setup: setup
};
