"use strict";

var $ = require("jquery");

window.fbAsyncInit = function() {
  window.FB.init({
    appId: "1143712942309791",
    xfbml: true,
    version: "v2.4"
  });
};

var setup = function() {
  var js, fjs = document.getElementsByTagName("script")[0];
  if (document.getElementById("facebook-jssdk")) {
    return;
  }
  $("body").prepend("<div id='fb-root'></div>");
  js = document.createElement("script");
  js.id = "facebook-jssdk";
  js.src = "//connect.facebook.net/pt_BR/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
};

module.exports = {
  setup: setup
};
