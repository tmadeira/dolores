"use strict";

var $ = require("jquery");
var _ = require("lodash");

var onScroll = _.debounce(function() {
  var html = $("html");
  var body = $("body");
  var hero = $(".site-hero");

  if (hero.length !== 1) {
    return;
  }

  var afterHero = hero[0].offsetTop + hero[0].offsetHeight;

  // Chrome scrolls body, Firefox scrolls html... we fix by adding them!
  var scrollTop = html[0].scrollTop + body[0].scrollTop;

  if (scrollTop + 100 > afterHero) {
    body.addClass("show-opaque-header");
  } else {
    body.removeClass("show-opaque-header");
  }
}, 50, {maxWait: 100});

var setup = function() {
  $(window).scroll(onScroll);
  $(window).trigger("scroll");
};

module.exports = {
  setup: setup
};
