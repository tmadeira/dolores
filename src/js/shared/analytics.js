"use strict";

var $ = require("jquery");

var async = require("./async");

var ganalyticsUA = window.doloresConfig.ganalyticsUA;

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

  async.include("ganalytics-js", "//www.google-analytics.com/analytics.js");

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
