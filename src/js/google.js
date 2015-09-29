"use strict";

var async = require("./async");

var setup = function() {
  async.include("google-platform", "https://apis.google.com/js/platform.js");
};

window.onGoogleSignIn = function(googleUser) {
  window.DoloresAuthenticator.setAuth({
    type: "google",
    token: googleUser.getAuthResponse().id_token
  });
};

module.exports = {
  setup: setup
};
