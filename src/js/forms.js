"use strict";

var _ = require("lodash");
var $ = require("jquery");
var React = require("react");

var API = require("./api");

var MultiSelect = require("./components/MultiSelect.react");

var setupFormTema = function() {
  var tagsContainer = $(".tema-tags-container");
  var availableTags = $(".available-tags");

  if (tagsContainer.length && availableTags.length) {
    var selected = [];
    var tags = availableTags.val().split("|");
    var onToggle;

    var options = [];
    var valueMap = {};
    for (var i = 0; i < tags.length; i++) {
      var parts = tags[i].split("::");
      options.push(parts[1]);
      valueMap[parts[1]] = parts[0];
    }

    var renderTags = function() {
      var multiSelect = (
        <MultiSelect
            className="tema-form-multiselect"
            name="tags"
            id="tema-form-tags"
            options={options}
            valueMap={valueMap}
            selected={selected}
            onToggle={onToggle}
            placeholder="Escolha algumas palavras-chave"
            ></MultiSelect>
      );

      React.render(multiSelect, tagsContainer[0]);
    };

    onToggle = function(_name, value) {
      var idx = _.indexOf(selected, value);
      if (idx !== -1) {
        selected.splice(idx, 1);
      } else {
        selected.push(value);
      }

      renderTags();
    };

    renderTags();
  }

  $("#form-tema").submit(function() {
    var request = $(this).serialize();
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

var setupContactForm = function() {
  $(".contact-form").submit(function() {
    var form = $(this);
    var request = form.serialize();
    var fields = form.find("input, textarea");
    var button = form.find(".tema-form-button");
    var responseContainer = form.find(".tema-form-response");

    var post = function() {
      button.prop("disabled", true);
      API.route("contact").post(request).done(function(response) {
        if ("error" in response) {
          button.prop("disabled", false);
          responseContainer.html("Erro: " + response.error);
        } else {
          button.prop("disabled", false);
          fields.val("");
          responseContainer.html("Sua mensagem foi enviada com sucesso!");
        }
      }).fail(function(response) {
        button.prop("disabled", false);
        console.log(response);
        if ("error" in response.responseJSON) {
          responseContainer.html("Erro: " + response.responseJSON.error);
        } else {
          alert("Erro ao enviar mensagem.");
        }
      });
    };

    var message = "Você precisa se autenticar para enviar.";
    window.DoloresAuthenticator.signIn(message, post);

    return false;
  });
};

var setup = function() {
  setupFormTema();
  setupContactForm();
};

module.exports = {
  setup: setup
};
