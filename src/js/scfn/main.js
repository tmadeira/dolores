"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

window.doloresConfig = require("./config");

var analytics = require("../shared/analytics");
var explanation = require("../shared/explanation");
var facebook = require("../shared/facebook");
var forms = require("../shared/forms");
var google = require("../shared/google");
var hero = require("../shared/hero");
var interact = require("../shared/interact");
var maps = require("../shared/maps");
var menu = require("../shared/menu");
var pagination = require("../shared/pagination");
var twitter = require("../shared/twitter");

var Authenticator = require("../shared/components/Authenticator.react");

$(function() {
  React.render(<Authenticator />, $("#authenticator")[0]);

  $(window).resize(menu.onResize);
  $(window).trigger("resize");

  analytics.setup();
  explanation.setup();
  facebook.setup();
  forms.setup();
  google.setup();
  hero.setup();
  interact.setup();
  maps.setup();
  menu.setup();
  pagination.setup();
  twitter.setup();
});
