"use strict";

var $ = window.jQuery = require("jquery");
var React = require("react");

require("jquery.maskedinput");

window.doloresConfig = require("./config");

var analytics = require("../shared/analytics");
var explanation = require("../shared/explanation");
var facebook = require("../shared/facebook");
var forms = require("../shared/forms");
var google = require("../shared/google");
var hero = require("../shared/hero");
var interact = require("../shared/interact");
var menu = require("../shared/menu");
var pagination = require("../shared/pagination");
var twitter = require("../shared/twitter");

var Authenticator = require("../shared/components/Authenticator.react");
var Share = require("../shared/components/Share.react");
var StreamingLightbox = require("../shared/components/StreamingLightbox.react");

var map = require("./map");

$(function() {
  if ($("#authenticator").length) {
    React.render(<Authenticator />, $("#authenticator")[0]);
  }
  if ($("#share-container").length) {
    React.render(<Share />, $("#share-container")[0]);
  }
  if ($("#streaming-lightbox").length) {
    var title = $("#streaming-lightbox").attr("title");
    var url = $("#streaming-lightbox").attr("ref");
    React.render(
        <StreamingLightbox title={title} url={url} />,
        $("#streaming-lightbox")[0]
    );
  }

  $(window).resize(menu.onResize);
  $(window).trigger("resize");

  analytics.setup();
  explanation.setup();
  facebook.setup();
  forms.setup();
  google.setup();
  hero.setup();
  interact.setup();
  map.setup();
  menu.setup();
  pagination.setup();
  twitter.setup();

  // TODO: move this out of here
  $(".load-more").click(function() {
    $(this).hide();
    $($(this).attr("href")).show();
    return false;
  });

  $(".local-list").change(function() {
    location.href = "/local/" + $(this).val();
  });

  $("input[name='phone']").focusout(function() {
    $(this).unmask();
    var value = $(this).val().replace(/\D/g, "");
    if (value.length > 10) {
      $(this).mask("(99) 99999-999?9");
    } else {
      $(this).mask("(99) 9999-9999?9");
    }
  }).trigger("focusout");
});
