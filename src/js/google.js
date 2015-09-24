"use strict";

var async = require("./async");

var setup = function() {
  async.include("google-platform", "https://apis.google.com/js/platform.js");
};

window.onGoogleSignIn = function(googleUser) {
  console.log("signed in");
  var profile = googleUser.getBasicProfile();
  console.log(profile);
};

module.exports = {
  setup: setup
};
