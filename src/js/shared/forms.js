"use strict";

var _ = require("lodash");
var $ = require("jquery");
var React = require("react");

var API = require("./api");

var BairrosForm = require("./components/BairrosForm.react");
var MultiSelect = require("./components/MultiSelect.react");

var setupTemaForm = function() {
  var tagsContainer = $(".tema-tags-container");
  var availableTags = $(".available-tags");
  var i;

  if (tagsContainer.length && availableTags.length) {
    var selected = [];
    var tags = availableTags.val().split("|");
    var onToggle;

    var options = [];
    var valueMap = {};
    for (i = 0; i < tags.length; i++) {
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

  $("#form-subscribe").submit(function() {
    var email = $(this).find("input[name='email']");
    var msg = $(this).find(".subscribe-msg");
    var button = $(this).find(".subscribe-button");
    button.prop("disabled", true);

    var request = {
      email: email.val()
    };
    API.route("subscribe").post({data: request}).done(function() {
      email.val("");
      msg.html("E-mail cadastrado com sucesso!");
      button.prop("disabled", false);
    }).fail(function(response) {
      console.log("fail", response);
      if ("error" in response.responseJSON) {
        msg.html(response.responseJSON.error);
      } else {
        msg.html("Erro inesperado. Tente novamente mais tarde.");
      }
      button.prop("disabled", false);
    });

    return false;
  });

  $("#form-tema").submit(function() {
    var button = $(this).find(".tema-form-button");

    var request = {};
    var requestArray = $(this).serializeArray();
    for (i = 0; i < requestArray.length; i++) {
      var key = requestArray[i].name;
      if (key.endsWith("[]")) {
        key = key.substr(0, key.length - 2);
        if (!(key in request)) {
          request[key] = [];
        }
        request[key].push(requestArray[i].value);
      } else {
        request[key] = requestArray[i].value;
      }
    }

    var post = function() {
      button.prop("disabled", true);
      console.log(request);
      API.route("post").post({data: request}).done(function(response) {
        if ("error" in response) {
          button.prop("disabled", false);
          alert("Erro ao publicar: " + response.error);
        } else if ("url" in response) {
          location.href = response.url + "#share";
        }
      }).fail(function(response) {
        button.prop("disabled", false);
        console.log(response);
        if ("responseJSON" in response && "error" in response.responseJSON) {
          alert("Erro ao publicar: " + response.responseJSON.error);
        }
      });
    };

    var message = "Você precisa ser cadastrado para publicar uma ideia.";
    window.DoloresAuthenticator.signIn(message, post);

    return false;
  });
};

var setupBairrosForm = function() {
  var container = document.getElementById("form-bairros");
  if (container !== null) {
    var form = <BairrosForm />;
    React.render(form, container);
  }
};

var setupContactForm = function() {
  $(".temas-form-form").submit(function() {
    var form = $(this);
    var fields = form.find("input, textarea");
    var button = form.find(".tema-form-button");
    var responseContainer = form.find(".tema-form-response");

    var request = {};
    var requestArray = form.serializeArray();
    for (var i = 0; i < requestArray.length; i++) {
      request[requestArray[i].name] = requestArray[i].value;
    }

    var post = function() {
      button.prop("disabled", true);
      API.route("contact").post({data: request}).done(function(response) {
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

    if ($(this).hasClass("contact-form")) {
      post();
    } else {
      var message = "Você precisa se autenticar para enviar.";
      window.DoloresAuthenticator.signIn(message, post);
    }

    return false;
  });
};

var setup = function() {
  setupTemaForm();
  setupBairrosForm();
  setupContactForm();
};

module.exports = {
  setup: setup
};
