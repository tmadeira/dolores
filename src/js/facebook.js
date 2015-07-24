"use strict";

var $ = require("jquery");

var async = require("./async");

window.fbAsyncInit = function() {
  window.FB.init({
    appId: "1143712942309791",
    xfbml: true,
    version: "v2.4"
  });
};

var setup = function() {
  $("body").prepend("<div id='fb-root'></div>");
  async.include("facebook-jssdk", "//connect.facebook.net/pt_BR/sdk.js");
};

module.exports = {
  setup: setup
};
