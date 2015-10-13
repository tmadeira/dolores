"use strict";

var $ = require("jquery");
var autosize = require("autosize");

var API = require("./api");

var vote = function(data, action) {
  var split = data.split("|");
  var request = {
    action: action
  };
  request[split[0]] = split[1];
  API.route("vote").post(request).done(function(response) {
    $("[data-vote='" + data + "']").each(function() {
      if ($(this).hasClass("ideia-upvote")) {
        $(this).find(".number").html(response.up);
      } else {
        $(this).find(".number").html(response.down);
      }
    });
  }).fail(function(response) {
    console.log(response.responseJSON);
    if ("error" in response.responseJSON) {
      alert("Erro: " + response.responseJSON.error);
    }
  });
};

var setup = function() {
  var message = "Você precisa ser cadastrado para votar.";

  $(document).on("click", ".ideia-upvote", function() {
    window.DoloresAuthenticator.signIn(message, function() {
      vote($(this).attr("data-vote"), "up");
    }.bind(this));
    return false;
  });

  $(document).on("click", ".ideia-downvote", function() {
    window.DoloresAuthenticator.signIn(message, function() {
      vote($(this).attr("data-vote"), "down");
    }.bind(this));
    return false;
  });

  autosize($("#comment"));
  $("#comment").keypress(function(e) {
    if (e.keyCode === 13 && !e.ctrlKey && !e.shiftKey) {
      alert("Em construção.");
      return false;
    }
    return true;
  });
};

module.exports = {
  setup: setup
};
