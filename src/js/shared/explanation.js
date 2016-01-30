"use strict";

var $ = require("jquery");

var togglePresentation = function() {
  var isVisible = $(".explanation").is(":visible");

  if (isVisible) {
    $("body").css("overflow", "auto");
  }

  $(".explanation").slideToggle({
    complete: function() {
      isVisible = !isVisible;
      if (isVisible) {
        $("body").css("overflow", "hidden");
      }
    }
  });
};

var setup = function() {
  $(".explanation").append(
    "<button class=\"lightbox-close toggle-explanation\">X</button>"
  );
  $(".toggle-explanation").click(function() {
    togglePresentation();
  });
};

module.exports = {
  setup: setup
};
