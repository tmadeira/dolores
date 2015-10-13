"use strict";

var $ = require("jquery");

var API = require("./api");

var setup = function() {
  $("#form-tema").submit(function() {
    var title = $(this).find("input[name='title']").val();
    var text = $(this).find("textarea[name='text']").val();
    var cat = $(this).find("input[name='cat']").val();

    // TODO: tags

    var post = function() {
      var request = {
        title: title,
        text: text,
        cat: cat,
        tags: []
      };
      API.route("post").post(request).done(function(response) {
        if ("error" in response) {
          alert("Erro ao cadastrar ideia: " + response.error);
        } else if ("url" in response) {
          location.href = response.url;
        }
      }).fail(function(response) {
        console.log(response);
        if ("error" in response.responseJSON) {
          alert("Erro ao cadastrar ideia: " + response.responseJSON.error);
        }
      });
    };

    var message = "Você precisa ser cadastrado para enviar uma ideia.";
    window.DoloresAuthenticator.signIn(message, post);

    return false;
  });
};

module.exports = {
  setup: setup
};
