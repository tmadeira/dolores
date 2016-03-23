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
        $(this).toggleClass("voted", response.voted === "up");
      } else {
        $(this).find(".number").html(response.down);
        $(this).toggleClass("voted", response.voted === "down");
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

var remove = function(data) {
  if (!window.confirm("Tem certeza que deseja excluir esse comentário?")) {
    return false;
  }

  var split = data.split("|");
  var request = {};
  request[split[0]] = split[1];

  API.route("remove").post(request).done(function() {
    $("[data-remove='" + data + "']").parents(".ideia-comment").fadeOut();
  }).fail(function(response) {
    console.log(response.responseJSON);
    if ("error" in response.responseJSON) {
      alert("Erro: " + response.responseJSON.error);
    }
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

    $(".replying").removeClass("replying");
    comment.addClass("replying");

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

    if ($(this).find("input[name='user']:checked").length) {
      request.user = $(this).find("input[name='user']:checked").val();
    }

    var form = $(this);
    var textarea = $(this).find("textarea[name='text']");

    var post = function() {
      form.addClass("posting");
      textarea.prop("disabled", true);
      window.setTimeout(function() {
      API.route("comment").post(request).done(function(response) {
        form.removeClass("posting");
        textarea.prop("disabled", false);
        if ("error" in response) {
          alert("Erro ao publicar: " + response.error);
          textarea.focus();
        } else if ("html" in response) {
          textarea.val("");

          var evt = document.createEvent("Event");
          evt.initEvent("autosize:update", true, false);
          textarea[0].dispatchEvent(evt);

          form.parent().after(response.html);
        }
      }).fail(function(response) {
        form.removeClass("posting");
        textarea.prop("disabled", false);
        textarea.focus();
        console.log(response);
        if ("error" in response.responseJSON) {
          alert("Erro ao publicar resposta: " + response.responseJSON.error);
        }
      });
      }, 1000);
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

  $(document).on("click", ".ideia-comment-remove", function() {
    return remove($(this).attr("data-remove"));
  });
};

module.exports = {
  setup: setup
};
