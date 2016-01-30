"use strict";

var $ = require("jquery");

var async = require("./async");

var facebookAppID = window.doloresConfig.facebookAppID;

var onFacebookStatusChange = function(response) {
  if (typeof window.DoloresAuthenticator === "undefined") {
    console.log("Error: window.DoloresAuthenticator is not set");
    return;
  }

  if (response.status === "connected") {
    window.DoloresAuthenticator.setAuth({
      type: "facebook",
      code: response.authResponse.accessToken
    });
  } else if (window.DoloresAuthenticator.hasAuth("facebook")) {
    window.DoloresAuthenticator.setAuth({});
  }
};

window.fbLogin = function() {
  window.FB.login(onFacebookStatusChange, {scope: "public_profile,email"});
};

window.fbAsyncInit = function() {
  window.FB.init({
    appId: facebookAppID,
    cookies: true,
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
