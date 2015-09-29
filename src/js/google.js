"use strict";

var async = require("./async");
var googleAppId = require("./config").googleAppId;

var setup = function() {
  async.include(
    "google-platform",
    "https://apis.google.com/js/platform.js?onload=googleAsyncInit"
  );
};

window.onGoogleSignIn = function(googleUser) {
  window.DoloresAuthenticator.setAuth({
    type: "google",
    token: googleUser.getAuthResponse().id_token
  });
};

window.googleAsyncInit = function() {
  window.gapi.load("auth2", function() {
    window.googleAuth2 = window.gapi.auth2.init({
      client_id: googleAppId, //eslint-disable-line
      cookiepolicy: "single_host_origin"
    });
  });
};

module.exports = {
  setup: setup
};
