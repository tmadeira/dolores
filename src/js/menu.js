"use strict";

var $ = require("jquery");

var breakpoint = require("./config").breakpoint;

var handleToggleMobileMenu = function(e) {
  $("body").toggleClass("show-mobile-menu");
  e.preventDefault();
};

var onResize = function() {
  var selector = $(".header-toggle-menu, .header-overlay");

  selector.unbind(
      "touchend click",
      handleToggleMobileMenu
  );

  if ($(window).width() < breakpoint.tablet) {
    $(".header-toggle-menu").css("display", "table-cell");
    selector.bind(
        "touchend click",
        handleToggleMobileMenu
    );
  } else {
    $(".header-toggle-menu").css("display", "none");
    $("body").removeClass("show-mobile-menu");
  }
};

module.exports = {
  onResize: onResize
};
