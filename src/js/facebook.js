"use strict";

var $ = require("jquery");

var async = require("./async");
var facebookAppID = require("./config").facebookAppID;

var onFacebookStatusChange = function(response) {
  /* TODO */
  console.log(response);
};

window.fbCheckLoginState = function() {
  window.FB.getLoginStatus(function(response) {
    onFacebookStatusChange(response);
  });
};

window.fbAsyncInit = function() {
  window.FB.init({
    appId: facebookAppID,
    cookies: true,
    xfbml: true,
    version: "v2.4"
  });

  window.fbCheckLoginState();
};

var setup = function() {
  $("body").prepend("<div id='fb-root'></div>");
  async.include("facebook-jssdk", "//connect.facebook.net/pt_BR/sdk.js");
};

module.exports = {
  setup: setup
};
