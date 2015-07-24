"use strict";

var $ = require("jquery");

var ganalyticsUA = require("./config").ganalyticsUA;

var setup = function() {
  if (typeof window.ga !== "undefined") {
    return;
  }

  if ($("body").hasClass("logged-in")) {
    // Do not setup Analytics for logged-in users
    return;
  }

  window.GoogleAnalyticsObject = "ga";

  window.ga = function() {
    if (typeof window.ga.q === "undefined") {
      window.ga.q = [];
    }
    window.ga.q.push(arguments);
  };
  window.ga.l = (new Date()).getTime();

  var gaScript = document.createElement("script");
  gaScript.async = 1;
  gaScript.src = "//www.google-analytics.com/analytics.js";

  var firstScript = document.getElementsByTagName("script")[0];
  firstScript.parentNode.insertBefore(gaScript, firstScript);

  window.ga("create", ganalyticsUA, "none");
  window.ga("send", "pageview");
};

var logPageview = function() {
  if (typeof window.ga !== "undefined") {
    window.ga("send", "pageview", location.pathname);
  }
};

module.exports = {
  setup: setup,
  logPageview: logPageview
};
