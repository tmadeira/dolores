"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

var analytics = require("./analytics");
var facebook = require("./facebook");
var header = require("./header");
var menu = require("./menu");

var HeroSignup = require("./components/HeroSignup.react");

$(function() {
  var signup = $("#react-hero-signup");
  if (signup.length === 1) {
    React.render(<HeroSignup />, signup[0]);
  }

  $(window).resize(menu.onResize);
  $(window).trigger("resize");

  $(window).scroll(header.onScroll);
  $(window).trigger("scroll");

  analytics.setup();
  facebook.setup();
});
