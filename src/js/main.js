"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

var menu = require("./menu");

var HeroSignup = require("./components/HeroSignup.react");

$(function() {
  var signup = $("#react-hero-signup");
  if (signup.length === 1) {
    React.render(<HeroSignup />, signup[0]);
  }

  $(window).resize(function() {
    menu.setupMobileMenu();
  });
  $(window).trigger("resize");
});
