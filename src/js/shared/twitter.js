"use strict";

var async = require("./async");

var setup = function() {
  async.include("twitter-wjs", "//platform.twitter.com/widgets.js");
};

module.exports = {
  setup: setup
};
