"use strict";

var $ = require("jquery");
var _ = require("lodash");

var onScroll = _.debounce(function() {
  var html = $("html");
  var body = $("body");
  var header = $(".site-header");
  var signup = $("#react-hero-signup");

  if (signup.length !== 1) {
    return;
  }

  // Chrome scrolls body, Firefox scrolls html... we fix by adding them!
  var scrollTop = html[0].scrollTop + body[0].scrollTop;
  var headerHeight = header[0].offsetTop + header[0].offsetHeight;

  if (scrollTop + headerHeight > signup[0].offsetTop) {
    body.addClass("show-opaque-header");
  } else {
    body.removeClass("show-opaque-header");
  }
}, 50, {maxWait: 100});

module.exports = {
  onScroll: onScroll
};
