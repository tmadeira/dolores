"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

var analytics = require("./analytics");
var facebook = require("./facebook");
var google = require("./google");
var header = require("./header");
var menu = require("./menu");
var twitter = require("./twitter");

var Authenticator = require("./components/Authenticator.react");
var HeroSignup = require("./components/HeroSignup.react");

$(function() {
  var v = $("body").hasClass("v2") ? 2 : 1;

  switch (v) {
    case 1:
      var signup = $("#react-hero-signup");
      if (signup.length === 1) {
        React.render(<HeroSignup />, signup[0]);
      }
      break;
    case 2:
      var authenticator = $("#authenticator");
      if (authenticator.length === 1) {
        React.render(<Authenticator />, authenticator[0]);
      }
      break;
  }

  $(window).resize(menu.onResize);
  $(window).trigger("resize");

  $(window).scroll(header.onScroll);
  $(window).trigger("scroll");

  analytics.setup();
  facebook.setup();
  google.setup();
  twitter.setup();
});
