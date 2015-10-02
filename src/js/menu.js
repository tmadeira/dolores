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

  if ($(window).width() < breakpoint.desktop) {
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

var hideActiveSubmenus = function() {
  $(".menu-item-has-children.active").each(function() {
    $(this).find(".sub-menu").slideUp(150);
    $(this).removeClass("active");
  });
};

var setup = function() {
  $(".header-menu .sub-menu").hide();

  $(".header-menu .menu-item-has-children > a").click(function(e) {
    var li = $(this).parent();
    var isActive = li.hasClass("active");

    hideActiveSubmenus();

    if (!isActive) {
      li.find(".sub-menu").slideDown(150);
      li.addClass("active");
    }

    e.stopPropagation();
    return false;
  });

  $(document).click(function() {
    hideActiveSubmenus();
  });
};

module.exports = {
  onResize: onResize,
  setup: setup
};
