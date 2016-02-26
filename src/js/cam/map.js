"use strict";

var $ = require("jquery");

var handlerIn = function() {
  var id = $(this).attr("id").replace(/-label$/, "");
  $("#" + id + " path").css("fill", "#fff");
  $("#" + id + " polygon").css("fill", "#fff");
  $("#" + id + "-label").show();
};

var handlerOut = function() {
  var id = $(this).attr("id").replace(/-label$/, "");
  $("#" + id + " path").css("fill", "");
  $("#" + id + " polygon").css("fill", "");
  $("#" + id + "-label").hide();
};

var setup = function() {
  $(".map-bairro").hover(handlerIn, handlerOut);
  $(".map-label").hover(handlerIn, handlerOut);
};

module.exports.setup = setup;
