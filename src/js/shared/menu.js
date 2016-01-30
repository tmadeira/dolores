"use strict";

var $ = require("jquery");

var breakpoint = window.doloresConfig.breakpoint;

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
    if ($(this).hasClass("user-logged")) {
      $(this).find(".sub-menu").hide();
    } else {
      $(this).find(".sub-menu").slideUp(150);
    }
    $(this).removeClass("active");
  });
};

var setup = function() {
  $(".site-header .sub-menu").hide();

  $(document).on(
      "click",
      ".site-header .menu-item-has-children > a",
      function(e) {
    var li = $(this).parent();
    var isActive = li.hasClass("active");

    hideActiveSubmenus();

    if (!isActive) {
      if (li.hasClass("user-logged")) {
        li.find(".sub-menu").show();
      } else {
        li.find(".sub-menu").slideDown(150);
      }
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
