"use strict";

var $ = require("jquery");

var loadData = function(url, data, section) {
  var html = $.parseHTML(data);
  for (var i = 0; i < html.length; i++) {
    if (html[i].tagName === "SECTION") {
      var list = section.find("ul");

      var newSection = $(html[i]);
      newSection.find("ul").children().hide()
        .appendTo(list).show("normal");
      newSection.find(".grid-ideias-pagination").hide()
        .appendTo(section).show("normal");

      return;
    }
  }
  location.href = url;
};

var setup = function() {
  // TODO: ajax-load-more in home (v2_index.php)
  var spinner =
      "<i class=\"pagination-spinner fa fa-refresh fa-spin fa-lg\"></i>";
  $(document).on("click", ".ajax-load-more", function(e) {
    var container = $(this).parent();
    var section = $(this).closest("section");
    if (e.which === 1 && !e.ctrlKey && !e.shiftKey) {
      e.preventDefault();
      var url = $(this).attr("href");
      $(this).replaceWith(spinner);
      $.ajax(url, {
        data: {"ajax": 1},
        success: function(data) {
          container.remove();
          loadData(url, data, section);
        },
        error: function() {
          location.href = url;
        }
      });
    }
  });
};

module.exports = {
  setup: setup
};
