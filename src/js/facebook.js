"use strict";

var $ = require("jquery");

var async = require("./async");
var facebookAppID = require("./config").facebookAppID;

var onFacebookStatusChange = function(response) {
  if (typeof window.DoloresAuthenticator === "undefined") {
    console.log("Error: window.DoloresAuthenticator is not set");
    return;
  }

  if (response.status === "connected") {
    window.FB.api("/me?fields=name,email,picture.type(large)", function(me) {
      window.DoloresAuthenticator.setToken({
        type: "facebook",
        authResponse: response.authResponse,
        info: {
          name: me.name,
          email: me.email,
          picture: me.picture.data.url
        }
      });
    });
  } else if (window.DoloresAuthenticator.hasToken("facebook")) {
    window.DoloresAuthenticator.setToken({});
  }
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
