"use strict";

var $ = require("jquery");

var apiBaseURL = require("./config").apiBaseURL;

var route = function(endpoint) {
  var url = apiBaseURL + "?route=" + endpoint;

  var get = function(data) {
    return $.ajax({
      data: data,
      dataType: "json",
      method: "GET",
      url: url
    });
  };

  var post = function(data) {
    return $.ajax({
      data: data,
      dataType: "json",
      method: "POST",
      url: url
    });
  };

  return {
    get: get,
    post: post
  };
};

module.exports = {
  route: route
};
