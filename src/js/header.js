"use strict";

var $ = require("jquery");
var _ = require("lodash");

var onScroll = _.debounce(function() {
  var body = $("body");
  var header = $(".site-header");
  var signup = $("#react-hero-signup");

  if (signup.length !== 1) {
    return;
  }

  var headerHeight = header[0].offsetTop + header[0].offsetHeight;

  if (body[0].scrollTop + headerHeight > signup[0].offsetTop) {
    body.addClass("show-opaque-header");
  } else {
    body.removeClass("show-opaque-header");
  }
}, 50, {maxWait: 100});

module.exports = {
  onScroll: onScroll
};
