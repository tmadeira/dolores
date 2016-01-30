"use strict";

var async = require("./async");

var googleAppId = window.doloresConfig.googleAppId;

var setup = function() {
  async.include(
    "google-platform",
    "https://apis.google.com/js/platform.js?onload=googleAsyncInit"
  );
};

var onGoogleSignIn = function(authResult) {
  window.DoloresAuthenticator.setAuth({
    type: "google",
    code: authResult.code
  });
};

window.googleLogin = function() {
  window.googleAuth2.grantOfflineAccess({
    redirect_uri: "postmessage" //eslint-disable-line
  }).then(onGoogleSignIn);
};

window.googleAsyncInit = function() {
  window.gapi.load("auth2", function() {
    window.googleAuth2 = window.gapi.auth2.init({
      client_id: googleAppId, //eslint-disable-line
      cookiepolicy: "single_host_origin",
      scope: "https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile"
    });
  });
};

module.exports = {
  setup: setup
};
