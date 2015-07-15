"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

var HeroSignup = require("./components/HeroSignup.react");

$(function() {
  var signup = $("#react-hero-signup");
  if (signup.length === 1) {
    React.render(<HeroSignup />, signup[0]);
  }
});
