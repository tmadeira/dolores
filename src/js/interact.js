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

var signInAndVote = function(data, action) {
  var message = "Você precisa ser cadastrado para curtir/descurtir.";
  window.DoloresAuthenticator.signIn(message, function() {
    vote(data, action);
  });
  return false;
};

var setup = function() {
  $(document).on("click", ".ideia-upvote", function() {
    return signInAndVote($(this).attr("data-vote"), "up");
  });

  $(document).on("click", ".ideia-downvote", function() {
    return signInAndVote($(this).attr("data-vote"), "down");
  });

  $(document).on("click", ".ideia-comment-reply", function() {
    var comment = $(this).closest(".ideia-comment");
    var split = comment.attr("id").split("-");
    var commentId = split[split.length - 1];

    if (!comment.find("> .children").length) {
      comment.append("<ul class=\"children\"></ul>");
    }

    $("#respond").detach().prependTo(comment.find("> .children"));
    $("#respond").find("input[name='parent']").val(commentId);
    $("#respond").find("textarea[name='text']").focus();

    return false;
  });

  $(".ideia-comment-form").submit(function() {
    var request = {
      postId: $(this).find("input[name='post_id']").val(),
      parent: $(this).find("input[name='parent']").val(),
      text: $(this).find("textarea[name='text']").val()
    };

    var post = function() {
      API.route("comment").post(request).done(function(response) {
        if ("error" in response) {
          alert("Erro ao publicar ideia: " + response.error);
        } else {
          console.log("do something", response); // TODO
        }
      }).fail(function(response) {
        console.log(response);
        if ("error" in response.responseJSON) {
          alert("Erro ao publicar resposta: " + response.responseJSON.error);
        }
      });
    };

    var message = "Você precisa ser cadastrado para publicar uma resposta.";
    window.DoloresAuthenticator.signIn(message, post);

    return false;
  });

  autosize($(".comment-textarea"));
  $(".comment-textarea").keypress(function(e) {
    if (e.keyCode === 13 && !e.ctrlKey && !e.shiftKey) {
      $(this.form).submit();
      return false;
    }
    return true;
  });
};

module.exports = {
  setup: setup
};
